<?php
namespace YeziiBot\Framework;

class Message{
    private $text;
    private $id;
    private $isGroup;
    private $auto_escape;
    private $async;

    /*
    * @param string $text 消息的内容
    * @param string|int $id 群号/用户qq号
    * @param bool $isGroup 若为true（默认）则发到对应群中，否则发到用户
    */
    public function __construct(string $text,$id,bool $isGroup=true, bool $auto_escape = false, bool $async = false){
        $this->$text = $text;
        $this->$id = $id;
        $this->$isGroup = $isGroup;
        $this->$auto_escape = $auto_escape;
        $this->$async = $async;
    }
    public function getText(){
        return $this->isAsync;
    }
    public function getID(){
        return $this->id;
    }
    public function isGroup(){
        return $this->isGroup;
    }
    public function isAutoEsc(){
        return $this->auto_escape;
    }
    public function isAsync(){
        return $this->async;
    }

}