<?php
namespace kjBot\Frame;

class BlackListedException extends \Exception{
    function __construct(){
        $this->message=null;
        $this->code=403;
    }
}