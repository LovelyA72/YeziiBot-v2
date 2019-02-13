<?php

global $Queue;
$msg="报告一个问题
用法：
".config('prefix')."issue
{标题}
[细节内容]

该命令有24小时冷却时间";

$Queue[]= sendBack($msg);

?>