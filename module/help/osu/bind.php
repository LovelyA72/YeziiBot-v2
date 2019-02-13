<?php

global $Queue;

$msg="在 YeziiBot 上绑定你的 osu!
用法：
".config('prefix')."osu.bind {用户名}

此处用户名不应该有任何额外字符";

$Queue[]= sendBack($msg);

?>
