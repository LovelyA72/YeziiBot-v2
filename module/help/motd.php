<?php

global $Queue;
$msg="[Admin only] Utility for checkin module's motd feature. The date code is a 6 digits int in YYMMDD format.
syntax:
".config('prefix')."motd.add (int)multiplier (int)dateCode
(string)motdMessage";

$Queue[]= sendBack($msg);

?>
