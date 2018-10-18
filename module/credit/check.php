<?php

global $Queue, $Event;
use kjBot\SDK\CQCode;
include('tools.php');

$QQ=$Event['user_id'];
$Queue[]= sendBack(CQCode::At($QQ).' 的余额为 '.getCredit($QQ));