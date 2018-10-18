<?php

global $Queue;
$msg="kjBot金币 系列命令
用法：
".config('prefix')."credit
".config('prefix')."credit.{check|transfer} [参数列表]

不指定下级模块时是 credit.check 模块的别名
具体用法请查看下一级 help";

$Queue[]= sendBack($msg);

?>
