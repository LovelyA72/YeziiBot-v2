<?php

global $Queue, $Command;
requireMaster();

$temp=getData("380545.mp3");
$Queue[]= sendBack(sendRec($temp));

?>