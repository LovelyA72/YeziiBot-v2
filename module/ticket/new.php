<?php
global $Queue, $Event, $Text;
if(strlen($Text)>300){
	exit();
}
if($Text==null){
	throw new \Exception("Xiaoling Ticketer v1.18g\n(c)2018 TEAM A72\n[ERROR] Missing ticket content");
}
$text64 = base64_encode($Text);
$sender = $Event['user_id'];
dbRunQuery("INSERT INTO tickets (sender,text,status) VALUES ({$sender},'{$text64}',0)");

$cid = dbRunQueryReturn("SELECT * FROM tickets ORDER BY id DESC LIMIT 1")['id'];

$Queue[]= sendBack("编号为{$cid}的工单创建成功！");