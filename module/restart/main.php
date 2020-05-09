<?php

global $CQ;
requireGlobalUserGroup(0);

$cleanCache = false;
do{
    $arg = nextArg();
    switch($arg){
        case '-cleanCache':
            $cleanCache = true;
            break;
        default:
    }
}while($arg !== NULL);

$CQ->setRestart($cleanCache);

?>