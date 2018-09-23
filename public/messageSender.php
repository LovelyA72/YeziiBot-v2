<?php
namespace YeziiBot\Framework;


class MessageSender{
    public $CQ;

    function __construct(\YeziiBot\core\CoolQ $CoolQ){
        $this->CQ = $CoolQ;
    }

    function sendMsg(Message $msg){
        if($msg->isGroup()){
            $this->CQ->sendGroupMsg($msg->getID(),$msg->getText());
        }else{
            $this->CQ->sendPrivateMsg($msg->getID(),$msg->getText());
        }
    }
}
