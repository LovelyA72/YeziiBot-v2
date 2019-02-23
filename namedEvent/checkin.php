<?php

global $Message, $Queue;

if(preg_match('/^签到$/', $Message)){
    loadModule('checkin');
}