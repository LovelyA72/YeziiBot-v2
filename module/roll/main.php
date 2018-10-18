<?php

global $Queue, $Command, $Event, $Text;
$countArg = count($Command)-1;
$min = 1;
$max = 100;

switch($countArg){
    case 1:
        $max = (int)nextArg();
        break;
    case 2:
        $min = (int)nextArg();
        $max = (int)nextArg();
        break;
    default:
}

if($Text!=null){
	$uid=$Event['user_id'];
	$rep = "因为{$Text},[CQ:at,qq={$uid}]掷出了";
	$message = $rep.rand($min, $max)."!";
}else{
	$message = rand($min, $max);
}
$Queue[]= sendBack($message);

?>