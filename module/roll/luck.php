<?php

global $Queue;

$lines = explode("\n",file_get_contents("../modules/roll/str.txt"));

$Queue[] = sendBack(randomString($lines));