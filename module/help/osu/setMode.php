<?php

global $Queue;

$msg="设置你的默认模式
用法：
".config('prefix')."osu.setMode {模式名}

模式名有彩蛋~";

$Queue[]= sendBack($msg);

?>