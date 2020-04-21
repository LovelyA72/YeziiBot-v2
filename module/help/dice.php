<?php

global $Queue;
$msg="桌游风格的掷骰子
用法：
".config('prefix')."dice [骰子数量]d[每个骰子的面]

用例：
".config('prefix')."dice 2d6";

$Queue[]= sendBack($msg);

?>
