<?php

global $Queue;
$msg="查看余额
用法：
".config('prefix')."credit.check";

$Queue[]= sendBack($msg);

?>
