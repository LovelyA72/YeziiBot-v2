<?php

global $Queue;
requireGlobalUserGroup(0);

if(fromGroup()){
    $Queue[]= sendBack(getUserCommandCount(0, 10));
}else{
    $Queue[]= sendBack(getUserCommandCount(0, nextArg()));
}