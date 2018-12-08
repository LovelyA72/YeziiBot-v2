<?php

global $Queue;

$msg="
生成随机数
用法：
".config('prefix', '!')."roll
".config('prefix', '!')."roll\n[动作] 注：很适合语C！
".config('prefix', '!')."roll [最小值]
".config('prefix', '!')."roll [最小值] [最大值]";

$Queue[]= sendBack($msg);

?>