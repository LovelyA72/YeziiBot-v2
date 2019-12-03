<?php

global $Queue, $Command, $Text;
requireGlobalUserGroup(10);

if(dataExists("{$Text}.mp3")){
	$Queue[]= sendBack(sendRec(getData("{$Text}.mp3")));
}else{
	$Queue[]= sendBack("没有这个声音呢...");
}