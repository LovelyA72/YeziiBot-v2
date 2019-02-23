<?php

global $Message, $Queue;

if($Message=="签到"){
    loadModule('checkin');
}