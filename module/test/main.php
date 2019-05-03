<?php

global $Queue, $Command;
requireMaster();

$Queue[]= sendBack(sendRec(getData("whistle.mp3")));