<?php

//-----------------------------------------------------------------------
//    Copyright (c) 2017-2020 TEAM A72
//    This file is part of YeziiBot. YeziiBot is distributed with the hope of
//    attracting more community contributions to the core ecosystem 
//    of the HeXiaoling Project.
//    YeziiBot is free software: you can redistribute it and/or modify
//    it under the terms of the Affero GNU General Public License version 3
//    as published by the Free Software Foundation.
//    YeziiBot is distributed WITHOUT ANY WARRANTY; without even the implied
//    warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//    See the GNU Affero General Public License for more details.
//    You should have received a copy of the GNU Affero General Public License
//    along with YeziiBot.  If not, see <http://www.gnu.org/licenses/>.
//-----------------------------------------------------------------------

global $Queue,$Event;
loadModule('credit.tools');


$levelName = Array("似曾相识","熟悉面孔","游戏好友","看番朋友","死宅姬友","四斋蒸鹅心");

$levelDescription = Array("好像在哪里见过你呢？你好啊！"
    ,"是你啊！今天心情怎么样啊？可以和我聊聊哦！"
    ,"今晚继续开黑吧！和你玩游戏超开心的！"
    ,"嗨~ Kalikali上的新番看了吗？没有吗？那一起看吧！"
    ,"（勾肩搭背）哟，今天要不要一起打游戏？我有大把时间哦！（笑嘻嘻）"
    ,"啊哈，今天又想给我我讲什么有趣的东西啊？小綾会争取保~密~哦~"
    ,"-1"
);

$qid = $Event['user_id'];

generalCheck($qid);

$credit = getCredit($qid);
$exp = getEXP($qid);
$badges = explode(",",dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$qid}")[0]['badge']);
$badgeCQCode="";

if(getGlobalUserGroup($qid)==0){
    $badgeCQCode .= "\n根用户 - 有什么问题都找我吧！";
}
if(getGlobalUserGroup($qid)<=5){
    $badgeCQCode .= "\n管理员 - 大家都要守规矩哦！";
}
if(getGlobalUserGroup($qid)<=10){
    $badgeCQCode .= "\n全局操作员 - 权限就是比普通用户高！";
}

if($badgeCQCode==""){
    $badgeCQCode .= "\n没有获得任何头衔哦~继续加油吧！";
}
$ex1 = getEX1($qid);
$lv = calcLevel($exp);
$energy = getENG($qid);
if (config("enableEXP","true")=="true") {
    $message = "玩家ID: {$qid}
    金币: {$credit}G
    好感：{$ex1}
    体力：{$energy}
    经验(deprecated): {$exp}XP
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
        $nextlv = 20;
    }
    if($lv>19){
        $level++;
        $nextlv = 29;
    }
    if($lv>28){
        $level++;
        $nextlv = -1;
    }
    $message .=$levelName[$level]."\n";

    $message .=$levelDescription[$level];

    if ($nextlv!=-1) {
        $message .="\n下一个称号会在Lv.{$nextlv}解锁";
    }else{
        $message .="\n祝贺一下！你是最高等级了！";
    }
}else{
    $message = "玩家ID: {$qid}\n金币: {$credit}G\n好感：{$ex1}]\n体力：{$energy}";
}

$message .= "\n头衔：".$badgeCQCode;

$Queue[]= sendBack($message);
?>