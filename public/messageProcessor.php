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
function isIgnoreGroup($groupID,$ignoreList){
    foreach ($ignoreList as $iid) {
        if($iid==$groupID){
            return true;
        }
    }
    return false;
}
//$ignList=json_decode(file_get_contents("../storage/data/ignorelist.json"),true)["ignore"];
$ignList = array("0");
if(isIgnoreGroup($Event["group_id"],$ignList)){
    throw new \Exception();
}
if(preg_match('/^(['.config('prefix', '!').'])/', $Event['message'], $prefix)){
    $length = strpos($Event['message'], "\r");
    if(false===$length)$length=strlen($Event['message']);
    $Command = parseCommand(substr($Event['message'], strlen($prefix[1])-1, $length));
    $Text = substr($Event['message'], $length+2);
    try{
        if($Event["user_id"]==80000000){
            throw new \Exception("请不要使用匿名帐号！");
        };
		generalCheck($Event['user_id']);
        loadModule(substr(nextArg(), strlen($prefix[1])));
    }catch(\Exception $e){
        throw $e;
    }
}else{ //不是命令
    $Message = $Event['message'];
    $botName = "小绫";
    //是否有在叫bot名字
    if(mb_substr($Message,0,2)==$botName){
        //将Message前面的东西去掉
        $Message = mb_substr($Message,mb_strlen($botName));
        $Message = str_replace(" ","",$Message);
        require("../namedEvent/Chain.php");
    }else {
        //没有的话就进入中间件处理
        require('../middleWare/Chain.php');
    }
}

?>