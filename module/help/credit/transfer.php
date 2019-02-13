<?php

global $Queue;
$msg="向目标转账
用法：
".config('prefix')."credit.transfer {目标} {金额}

目标可以使用 @";

$Queue[]= sendBack($msg);

?>
