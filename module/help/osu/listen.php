<?php

global $Queue;

$msg="享受音乐
用法：
".config('prefix')."osu.listen {谱面集ID}";

$Queue[]= sendBack($msg);

?>
