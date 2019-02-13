<?php

global $Queue;

$msg="展示你的 osu! 个人资料
用法：
".config('prefix')."osu.me [...]

参数列表：
-user \"用 户 名\"    查看别人的资料
-{std|mania|ctb|taiko}    指定模式
-withMe    同时显示 me! 的内容（实验性功能）";

$Queue[]= sendBack($msg);

?>
