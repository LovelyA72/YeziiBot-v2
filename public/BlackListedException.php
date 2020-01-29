<?php
namespace kjBot\Frame;

class BlackListedException extends \Exception{
    function __construct(){
        $this->message='黑名单用户拒绝访问';
        $this->code=403;
    }
}