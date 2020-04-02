<?php

global $Queue, $Event, $CQ;

if(!fromGroup())throw new \Exception();

date_default_timezone_set('Asia/Shanghai');

$time='';
while(true){
    $x=nextArg();
    if($x !== NULL){
        $time.=$x.' ';
    }else{
        break;
    }
}
$myTime = strtotime($time)-time();
if(strtotime($time)==time()||strtotime($time)>strtotime('+29 day')){
    $myTime = strtotime('+8 hour')-time();
    $Queue[] = sendBack("owo");
}
try{
    $CQ->setGroupBan($Event['group_id'], $Event['user_id'],$myTime) ;
}catch(\Exception $e){}

?>