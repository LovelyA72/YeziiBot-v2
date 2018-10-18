<?php
global $Queue, $Command, $Event;


$tid = (int)$Command[1];
if($tid==null){
	throw new \Exception("Xiaoling Ticketer v1.18g\n(c)2018 TEAM A72\n[ERROR] Missing ticket ID");
}
$content = dbRunQueryReturn("SELECT * FROM tickets WHERE id = {$tid}");
$post = base64_decode($content['text']);
$Queue[]= sendBack("工单编号：{$content['id']}
创建者：{$content['sender']}
内容：{$post}");