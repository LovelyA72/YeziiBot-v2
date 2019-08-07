<?php

global $Queue, $Command, $Text;
requireGlobalUserGroup(10);

$Queue[]= sendBack(sendRec(getData("{$Text}.mp3")));