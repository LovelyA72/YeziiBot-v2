<?php

global $Queue, $Event, $Command, $Text;
use kjBot\SDK\CQCode;
requireGlobalUserGroup(5);
loadModule('osu.tools');

$username = $Text;

$qid = nextArg();
adminSetOsuID($qid, $username);

$Queue[]= sendBack($qid.' 成功绑定 '.$username);

?>