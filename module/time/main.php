<?php

global $Queue;
use kjBot\SDK\CQCode;

//The update function is no longer work for moegirl pedia:(
//$Queue[]= sendBack("XiaolingTime v1.14c\n(c)2018 TEAM A72\n[ERROR] Maintenance in progress.");
//修正时区到日本
//date_default_timezone_set('Asia/Tokyo');

$minute=(int)date('i');
$hour=(int)date('H');
if($minute>=45)$hour++;
if($hour==24)$hour=0;

$Queue[]= sendBack(CQCode::Record('base64://'.base64_encode(getData("time/{$hour}.mp3"))));
$Queue[]= sendBack(getData("time/{$hour}.txt"));
?>