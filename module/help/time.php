<?php

global $Queue;
$msg="
让何小绫cos舰娘来报告当前时间
用法：
".config('prefix', '!')."time

（默认台词为那珂）";

$Queue[]= sendBack($msg);

?>
