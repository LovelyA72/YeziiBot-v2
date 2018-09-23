<?php
ob_start();
if(function_exists('fastcgi_finish_request'))fastcgi_finish_request();

include('UnauthorizedException.php');
include ('../core/API.php');
include ('../core/CQCode.php');
include ('../core/CoolQ.php');
include('initialize.php');
include("tools/frame.php");
$MsgSender->sendMsg(new Message("it works",2927103357,false));

use \YeziiBot\Framework\Message;
use \YeziiBot\core\CoolQ;

try{
    $listen = config('Listen');
    if($listen !== NULL && ($Event['group_id'] == $listen || $listen == $Event['user_id'])){
        $Queue[]= sendMaster('['.date('Y-m-d H:i:s', $Event['time']-86400)."] {$Event['user_id']} say:\n{$Event['message']}", false, true);
    }
    print_r($Event);
    switch($Event['post_type']){
        
        case 'message':
        case 'notice':
        case 'request':
            require($Event['post_type'].'Processor.php');
            break;
        default:
            $Queue[]= sendMaster('Unknown post type, Event:'."\n".var_export($_SERVER, true));
    }

    //调试
    if($Debug && $Event['user_id'] == $DebugListen){
        $Queue[]= sendMaster(var_export($Event, true)."\n\n".var_export($Queue, true));
    }

}catch(\Exception $e){
    $Queue[]= sendBack($e->getMessage(), true, true);
}

try{
    //将队列中的消息发出
    foreach($Queue as $msg){
        //$MsgSender->sendMsg($msg);
    }
}catch(\Exception $e){
    setData('error.log', var_dump($Event).$e.$e->getCode()."\n", true);
}



?>
