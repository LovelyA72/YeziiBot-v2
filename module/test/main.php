<?php

global $Queue, $Command;
requireGlobalUserGroup(0);

$Queue[]= sendBack(sendRec(getData("whistle.mp3")));