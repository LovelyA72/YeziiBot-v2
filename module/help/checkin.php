<?php

global $Queue;
$msg="每日签到随机获得 10~25 个 kjBot金币
用法：
".config('prefix')."checkin";

$Queue[]= sendBack($msg);

?>
