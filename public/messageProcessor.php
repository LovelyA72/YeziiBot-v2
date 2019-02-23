<?php
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
    //是否有在叫bot名字
    if(substr($Message,0,2)==config('botName','小绫')){
        //将Message前面的东西去掉
        $Message = substr($Message,strlen(config('botName','小绫'))-1);
        require("../namedEvent/Chain.php");
    }else {
        //没有的话就进入中间件处理
        require('../middleWare/Chain.php');
    }
}

?>