<?php

global $Queue;
$msg=<<<EOT
如果你发现了bug或者希望有新的功能，请在YeziiBot的论坛发帖，让我听到你的声音！\n
官方：https://qq.acgn.pro/forum\n
粉丝：https://bbs.yuezhengling.cc/forumdisplay.php?fid=11
EOT;

$Queue[]= sendBack($msg);

?>
