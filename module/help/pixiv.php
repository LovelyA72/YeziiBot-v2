<?php

global $Queue;
$msg="Pixiv !
用法：
".config('prefix')."pixiv.{search|IID}

具体用法请查看下一级 help";

$Queue[]= sendBack($msg);

?>
