<?php

global $Queue;

$msg="osu! 系列命令
用法：
".config('prefix')."osu.{bind|bp|listen|me|recent|setMode} [参数列表]

具体用法请查看下一级 help";

$Queue[]= sendBack($msg);

?>
