<?php

global $Queue, $Command, $Text;
requireMaster();

$Queue[]= sendBack(sendRec(getData("{$Text}.mp3")));