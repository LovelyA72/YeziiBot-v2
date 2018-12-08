<?php

global $Queue;
$msg="
查看 YeziiBot(kjBot) 当前版本及更新日志
用法：
".config('prefix', '!')."version";

$Queue[]= sendBack($msg);

?>
