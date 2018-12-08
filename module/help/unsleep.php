<?php

global $Queue;
$msg="
解除禁言
用法：
".config('prefix', '!')."unsleep {群号}

冷却时间为一天";

$Queue[]= sendBack($msg);

?>
