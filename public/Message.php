<?php
class Message{
    private $text;
    private $id;
    private $isGroup;

    /*
    * @param string $text 消息的内容
    * @param string|int $id 群号/用户qq号
    * @param bool $isGroup 若为true（默认）则发到对应群中，否则发到用户
    */
    public function __construct(string $text,$id,bool $isGroup=true){
        $this->$text = $text;
        $this->$id = $id;
        $this->$isGroup = $isGroup;
    }
    public function getText(){
        return $text;
    }
    public function getID(){
        return $id;
    }
    public function isGroup(){
        return $isGroup;
    }

}