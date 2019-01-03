<?php

global $Queue, $Command;
requireMaster();

$Queue[]= sendBack(sendRec(getData("380545.mp3")));

?>