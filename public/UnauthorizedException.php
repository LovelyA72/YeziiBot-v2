<?php
namespace YeziiBot\Framework;

class UnauthorizedException extends \Exception{
    function __construct(){
        $this->message='权限不足';
        $this->code=401;
    }
}

?>