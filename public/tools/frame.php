<?php

//-----------------------------------------------------------------------
//    Copyright (c) 2017-2019 TEAM A72
//    This file is part of YeziiBot. YeziiBot is distributed with the hope of
//    attracting more community contributions to the core ecosystem 
//    of the HeXiaoling Project.
//    YeziiBot is free software: you can redistribute it and/or modify
//    it under the terms of the Affero GNU General Public License version 3
//    as published by the Free Software Foundation.
//    YeziiBot is distributed WITHOUT ANY WARRANTY; without even the implied
//    warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//    See the GNU Affero General Public License for more details.
//    You should have received a copy of the GNU Affero General Public License
//    along with YeziiBot.  If not, see <http://www.gnu.org/licenses/>.
//-----------------------------------------------------------------------

use kjBot\SDK\CQCode;
use kjBot\Frame\Message;
use kjBot\Frame\UnauthorizedException;
use kjBot\Frame\BlackListedException;

/**
 * 读取配置文件
 * @param string $kay 键值
 * @param string $defaultValue 默认值
 * @return string|null
 */
function config(string $key, string $defaultValue = NULL):?string{
    global $Config;

    if(array_key_exists($key, $Config)){
        return $Config[$key];
    }else{
        return $defaultValue;
    }
}

/**
 * 给事件产生者发送私聊
 * @param string $msg 消息内容
 * @param bool $auto_escape 是否发送纯文本
 * @param bool $async 是否异步
 * @return kjBot\Frame\Message
 */
function sendPM(string $msg, bool $auto_escape = false, bool $async = false):Message{
    global $Event;

    return new Message($msg, $Event['user_id'], false, $auto_escape, $async);
}

/**
 * 消息从哪来发到哪
 * @param string $msg 消息内容
 * @param bool $auto_escape 是否发送纯文本
 * @param bool $async 是否异步
 * @return kjBot\Frame\Message
 */
function sendBack(string $msg, bool $auto_escape = false, bool $async = false):Message{
    global $Event;

    return new Message($msg, isset($Event['group_id'])?$Event['group_id']:$Event['user_id'], isset($Event['group_id']), $auto_escape, $async);
}

/**
 * 发送给 Master
 * @param string $msg 消息内容
 * @param bool $auto_escape 是否发送纯文本
 * @param bool $async 是否异步
 * @return kjBot\Frame\Message
 */
function sendMaster(string $msg, bool $auto_escape = false, bool $async = false):Message{
    return new Message($msg, config('master'), false, $auto_escape, $async);
}

/**
 * 记录数据
 * @param string $filePath 相对于 storage/data/ 的路径
 * @param $data 要存储的数据内容
 * @param bool $pending 是否追加写入（默认不追加）
 * @return mixed string|false
 */
function setData(string $filePath, $data, bool $pending = false){
    if(!file_exists(dirname('../storage/data/'.$filePath))) if(!mkdir(dirname('../storage/data/'.$filePath), 0777, true))throw new \Exception('Failed to create data dir');
    return file_put_contents('../storage/data/'.$filePath, $data, $pending?(FILE_APPEND | LOCK_EX):LOCK_EX);
}

/**
 * 读取数据
 * @param $filePath 相对于 storage/data/ 的路径
 * @return mixed string|false
 */
function getData(string $filePath){
    return file_get_contents('../storage/data/'.$filePath);
}
/**
 * 数据存在
 * @param $filePath 相对于 storage/data/ 的路径
 * @return bool
 */
function dataExists(string $filePath){
    return file_exists('../storage/data/'.$filePath);
}

/**
 * 缓存
 * @param string $cacheFileName 缓存文件名
 * @param $cache 要缓存的数据内容
 * @return mixed string|false
 */
function setCache(string $cacheFileName, $cache){
    return file_put_contents('../storage/cache/'.$cacheFileName, $cache, LOCK_EX);
}

/**
 * 取得缓存
 * @param $cacheFileName 缓存文件名
 * @return mixed string|false
 */
function getCache($cacheFileName){
    return file_get_contents('../storage/cache/'.$cacheFileName);
}

/**
 * 清理缓存
 */
function clearCache(){
    $cacheDir = opendir('../storage/cache/');
    while (false !== ($file = readdir($cacheDir))) {
        if ($file != "." && $file != "..") {
            unlink('../storage/cache/'.$file);
        }
    }
    closedir($cacheDir);
}

/**
 * 发送图片
 * @param string $str 图片（字符串形式）
 * @return string 图片对应的 base64 格式 CQ码
 */
function sendImg($str):string{
    return CQCode::Image('base64://'.base64_encode($str));
}

/**
 * 发送录音
 * @param string $str 录音（字符串形式）
 * @return string 录音对应的 base64 格式 CQ码
 */
function sendRec($str):string{
    return CQCode::Record('base64://'.base64_encode($str));
}

/**
 * 装载模块
 * @param string $module 模块名
 */
function loadModule(string $module){
    if('.' === $module[0]){
        leave('Illegal module name');
    }
    $moduleFile = str_replace('.', '/', $module, $count);
    if(0 === $count){
        $moduleFile.='/main.php';
    }else{
        $moduleFile.='.php';
    }

    if(file_exists('../module/'.$moduleFile)){
        if(config('recordStat', 'true')=='true'){
            if(strpos($module, '.tools')===false && strpos($module, 'recordStat')===false){ //防止记录工具类模块
                global $Event;
                addCommandCount($Event['user_id'], $module);
            }
        }
        require('../module/'.$moduleFile);
    }else{
        if(strpos($module, 'help')!==0){ //防止无限尝试加载help
            try{
                loadModule('help.'.$module); //尝试加载help
            }catch(\Exception $e){
                if(!fromGroup()){
                    throw $e;
                }
            }
        }else{
            leave('没有该命令：'.substr($module, 5));
        }
    }
}

/**
 * 解析命令
 * @param string $str 命令字符串
 * @return mixed array|bool 解析结果数组 失败返回false
 */
function parseCommand(string $str){
    // 正则表达式
    $regEx = '#(?:(?<s>[\'"])?(?<v>.+?)?(?:(?<!\\\\)\k<s>)|(?<u>[^\'"\s]+))#';
    // 匹配所有
    if(!preg_match_all($regEx, $str, $exp_list)) return false;
    // 遍历所有结果
    $cmd = array();
    foreach ($exp_list['s'] as $id => $s) {
        // 判断匹配到的值
        $cmd[] = empty($s) ? $exp_list['u'][$id] : $exp_list['v'][$id];
    }
    return $cmd;
}

function isMaster(){
    global $Event;

    return $Event['user_id']==config('master');
}

function requireMaster(){
    if(!isMaster()){
        throw new UnauthorizedException();
    }
}

function nextArg(){
    global $Command;
    static $index=0;

    return $Command[$index++];
}

/**
 * 冷却
 * 不指定冷却时间时将返回与冷却完成时间的距离，大于0表示已经冷却完成
 * @param string $name 冷却文件名称，对指定用户冷却需带上Q号
 * @param int $time 冷却时间
 */
function coolDown(string $name, $time = NULL):int{
    global $Event;
    if(NULL === $time){
        clearstatcache();
        return time() - filemtime("../storage/data/coolDown/{$name}")-(int)getData("coolDown/{$name}");
    }else{
        setData("coolDown/{$name}", $time);
        return -$time;
    }
}

/**
 * 消息是否来自(指定)群
 * 指定参数时将判定是否来自该群
 * 不指定时将判定是否来自群聊
 * @param mixed $group=NULL 群号
 * @return bool
 */
function fromGroup($group = NULL):bool{
    global $Event;
    if($group == NULL){
        return isset($Event['group_id']);
    }else{
        return ($Event['group_id'] == $group);
    }
}

/**
 * 退出模块
 * @param string $msg 返回信息
 * @param int $code 指定返回码
 * @throws Exception 用于退出模块
 */
function leave($msg = '', $code = 0){
    throw new \Exception($msg, $code);
}

/**
 * 检查是否在黑名单中
 * @return bool
 */
function inBlackList($qq):bool{
    $blackList = getData('black.txt');
    if($blackList === false)leave('无法打开黑名单');
    if(strpos($blackList, ''.$qq) !== false){
        return true;
    }else{
        return false;
    }
}

function block($qq){
    if(inBlackList($qq))throw new UnauthorizedException();
}

/**
 * 随便挑一个回答
 * @return string
 */
function randomString(array $stringArr){
    return $stringArr[rand(0,sizeof($stringArr)-1)];
}

/**
 * 词语过滤
 * @return string
 */
function wordFilter($input,$words){
    $list = explode(",",$words);
    foreach ($list as $value) {
        $input = str_replace(base64_decode($value),"*",$input);
    }
    return $input;
}
/**
 * 文本伪地域化
 * @param string $input 要处理的文字
 * @return string
 */
function pseudolocalise($input){
    $dict = Array('a' => 'ȧ',
      'A' => 'Ȧ',
      'b' => 'ƀ',
      'B' => 'Ɓ',
      'c' => 'ƈ',
      'C' => 'Ƈ',
      'd' => 'ḓ',
      'D' => 'Ḓ',
      'e' => 'ḗ',
      'E' => 'Ḗ',
      'f' => 'ƒ',
      'F' => 'Ƒ',
      'g' => 'ɠ',
      'G' => 'Ɠ',
      'h' => 'ħ',
      'H' => 'Ħ',
      'i' => 'ī',
      'I' => 'Ī',
      'j' => 'ĵ',
      'J' => 'Ĵ',
      'k' => 'ķ',
      'K' => 'Ķ',
      'l' => 'ŀ',
      'L' => 'Ŀ',
      'm' => 'ḿ',
      'M' => 'Ḿ',
      'n' => 'ƞ',
      'N' => 'Ƞ',
      'o' => 'ǿ',
      'O' => 'Ǿ',
      'p' => 'ƥ',
      'P' => 'Ƥ',
      'q' => 'ɋ',
      'Q' => 'Ɋ',
      'r' => 'ř',
      'R' => 'Ř',
      's' => 'ş',
      'S' => 'Ş',
      't' => 'ŧ',
      'T' => 'Ŧ',
      'v' => 'ṽ',
      'V' => 'Ṽ',
      'u' => 'ŭ',
      'U' => 'Ŭ',
      'w' => 'ẇ',
      'W' => 'Ẇ',
      'x' => 'ẋ',
      'X' => 'Ẋ',
      'y' => 'ẏ',
      'Y' => 'Ẏ',
      'z' => 'ẑ',
      'Z' => 'Ẑ');
    
    foreach ($dict as $key => $value) {
        $input = str_replace($key,$value,$input);
    }
    return $input;
    }
/**
 * 要求特定的全局用户组
 * @param int $gid 要求的最低用户组
 */
function requireGlobalUserGroup($gid){
    global $Event;

    $QQ = $Event['user_id'];
    $userResults = dbRunQueryReturn("SELECT * FROM global_special_users WHERE qid = {$QQ}");
    if (sizeof($userResults)==0) {
        $userGroup = 20;
    }else {
        $userGroup = $userResults[0]['gid'];
    }
    if($userGroup>=100){
        throw new BlackListedException();
    }
    if($userGroup>$gid){
        throw new UnauthorizedException();
    }
}
function getGlobalUserGroup($qid){
    $userResults = dbRunQueryReturn("SELECT * FROM global_special_users WHERE qid = {$qid}");
    if (sizeof($userResults)==0) {
        $userGroup = 20;
    }else {
        $userGroup = $userResults[0]['gid'];
    }
    return $userGroup;
}

function write_ini_file($assoc_arr, $path, $has_sections=FALSE) { 
    $content = ""; 
    if ($has_sections) { 
        foreach ($assoc_arr as $key=>$elem) { 
            $content .= "[".$key."]\n"; 
            foreach ($elem as $key2=>$elem2) { 
                if(is_array($elem2)) 
                { 
                    for($i=0;$i<count($elem2);$i++) 
                    { 
                        $content .= $key2."[] = ".$elem2[$i]."\n"; 
                    } 
                } 
                else if($elem2=="") $content .= $key2." = \n"; 
                else $content .= $key2." = ".$elem2."\n"; 
            } 
        } 
    } 
    else { 
        foreach ($assoc_arr as $key=>$elem) { 
            if(is_array($elem)) 
            { 
                for($i=0;$i<count($elem);$i++) 
                { 
                    $content .= $key."[] = ".$elem[$i]."\n"; 
                } 
            } 
            else if($elem=="") $content .= $key." = \n"; 
            else $content .= $key." = ".$elem."\n"; 
        } 
    } 

    if (!$handle = fopen($path, 'w')) { 
        return false; 
    }

    $success = fwrite($handle, $content);
    fclose($handle); 

    return $success; 
}

/* function http_get_contents($url)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_TIMEOUT, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
  if(FALSE === ($retval = curl_exec($ch))) {
    error_log(curl_error($ch));
  } else {
    return $retval;
  }
} */
function http_get_contents($url)
{
	$cp = config("curlPath");
    return shell_exec("{$cp}curl.exe --fail \"{$url}\"");
}

function calcLevel($score)
{
    $toNextLevel = array(0, 30, 80, 150, 300, 490, 1050,
        1360, 1710, 2100, 2530, 3000, 3510, 4060,
        4650, 5280, 5950, 6660, 7410, 8200, 9030,
        9900, 10810, 11760, 12750, 13780, 14850,
        15960, 17110, 18300, 22100, 26900, 29310, 35000, 40000, 
        45000, 50000, 60000, 65000, 70000,75250, 84910, 99850, 100000,
        108000, 116000, 124000, 132000);
    $i = 1;
    $addedScore = 0;
    while ($addedScore + $toNextLevel[$i] < $score) {
        $addedScore += $toNextLevel[$i];
        $i++;
    }
    return $i;
}
function getEX1($QQ){
    return dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$QQ}")[0]['ex1'];
}

function getENG($QQ){
    return dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$QQ}")[0]['energy'];
}

function setENG($QQ,$value){
    dbRunQueryReturn("UPDATE credits SET energy = {$value} WHERE qid = {$QQ}");
}
function getEXP($QQ){
    return dbRunQueryReturn("SELECT * FROM credits WHERE qid = $QQ")[0]['xp'];
}
