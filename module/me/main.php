<?php

global $Queue,$Event;
loadModule('credit.tools');

function levelCalc($score)
{
    $toNextLevel = array(0, 30, 80, 150, 300, 490, 1050,
        1360, 1710, 2100, 2530, 3000, 3510, 4060,
        4650, 5280, 5950, 6660, 7410, 8200, 9030,
        9900, 10810, 11760, 12750, 13780, 14850,
        15960, 17110, 18300, 22100, 26900, 29310, 35000, 40000, 
		45000, 50000, 60000, 65000, 70000,75250, 84910, 99850, 100000);
    $i = 1;
    $addedScore = 0;
    while ($addedScore + $toNextLevel[$i] < $score) {
        $addedScore += $toNextLevel[$i];
        $i++;
    }
    return $i;
}

$levelName = Array("似曾相识","熟悉面孔","游戏好友","看番朋友","死宅姬友","四斋蒸鹅心");

$levelDescription = Array("","","","","","");

$qid = $Event['user_id'];
$credit = getCredit($qid);
$exp = dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$qid}")['xp'];
$lv = levelCalc($exp);
$message = "玩家ID: {$qid}
金币: {$credit}G
经验: {$exp}XP
等级: Lv.{$lv}
等级头衔: ";

$level = 0;
$nextlv = 6;
if($lv>5){
	$level++;
	$nextlv = 9;
}
if($lv>8){
	$level++;
	$nextlv = 13;
}
if($lv>12){
	$level++;
	$nextlv = 19;
}
if($lv>18){
	$level++;
	$nextlv = 26;
}
if($lv>25){
	$level++;
	$nextlv = -1;
}
$message .=$levelName[$level]."\n";

$message .=$levelDescription[$level];

$message .="\n下一个称号会在Lv.{$nextlv}解锁";

$Queue[]= sendBack($message);
?>