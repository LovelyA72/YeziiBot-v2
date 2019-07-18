<?php

global $Queue, $Event;
use kjBot\SDK\CQCode;
requireMaster();
include('tools.php');

$QQ = parseQQ(nextArg());
$Queue[]= sendBack(CQCode::At($QQ).' 的余额为 '.getCredit($QQ));