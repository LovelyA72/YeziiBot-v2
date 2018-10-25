<?php
function isIgnoreGroup($groupID,$ignoreList){
    foreach ($ignoreList as $iid) {
        if($iid==$groupID){
            return true;
        }
    }
    return false;
}
$ignList=Array("0");
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
    require('../middleWare/Chain.php');
}

?>