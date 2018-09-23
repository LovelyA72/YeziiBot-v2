<?php
namespace YeziiBot\Framework;


class MessageSender{
    public $CQ;

    function __construct(\YeziiBot\core\CoolQ $CoolQ){
        $this->CQ = $CoolQ;
    }

    function sendMsg(Message $msg){
        if($msg->isGroup){
            $this->CQ->sendGroupMsg($msg->id,$msg->text);
        }else{
            $this->CQ->sendPrivateMsg($msg->id,$msg->text);
        }
    }
}