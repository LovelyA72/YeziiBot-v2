<?php

global $Event, $Queue;
loadModule('credit.tools');

$qid = $Event['user_id'];
$income = rand(10, 25);
$xpincome = rand(200, 450);
$content = dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$qid}");
$lastCheckinTime=$content['lastcheck'];
if($lastCheckinTime>=date('ymd')){
    $Queue[]= sendBack('你今天签到过了');
}else{
	$incomex = $income/2;
	$xpincomex = $xpincome/2;
	$today = date('ymd');
    dbRunQueryReturn("UPDATE credits SET lastcheck = {$today},coin = coin+{$incomex},xp = xp+{$xpincomex} WHERE qid = {$qid}");
    $Queue[]= sendBack('签到成功，获得 '.$income.' 个金币，奖励'.$xpincome.'经验值！');
}
?>