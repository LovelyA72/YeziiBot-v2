<?php

global $Queue;

$lines = explode("\n",file_get_contents("../module/roll/str.txt"));

$Queue[] = sendBack(randomString($lines));