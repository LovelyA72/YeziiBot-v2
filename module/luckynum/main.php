<?php
global $Event, $Queue;

$qid = $Event['user_id'];//获取qq号
$date = date('ymd');//获取今天的日期
//用qq号减去日期后计算MD5，删除字母后取前两个数字
$luckynum = substr(preg_replace('/\D/','',md5($qid-$date)),0,2);
//回复消息
$Queue[]= sendBack("你今天的幸运数字是{$luckynum}!");
