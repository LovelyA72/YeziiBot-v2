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

global $Event, $Queue;
loadModule('credit.tools');
loadModule('energy.tools');

$qid = $Event['user_id'];
$income = rand(15, 45);
$xpincome = rand(150, 500);
$content = dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$qid}");
$lastCheckinTime=$content[0]['lastcheck'];
$today = date('ymd');
$haveMotd = false;
$multi = 1;
//修改这个数值来更改成功几率(0-100)，数值越大，成功率越高
$motd = dbRunQueryReturn("SELECT * FROM checkin_motd WHERE date = {$today}");
if (sizeof($motd)==0) {
    $successRate = 94;
}else{
    $successRate = 100;
    $multi = $motd[0]["multi"];
    if($motd[0]["message"]!=""){
        $haveMotd = true;
    }
}

if($lastCheckinTime>=$today){
    $Queue[]= sendBack(randomString(
        array(
        "你今天签到过了！",
        "是小绫记错了吗？不不不，你今天真的签到过了！",
        "小绫我的记性都比你要好啾~你今天签到过啦！",
        "你今天签到过了，小绫没有更多的金币了哦~",
        "签过啦~明天再来吧~",
        "呜～签到失败了....人家该如何是好啊...（慌慌张张）明天再来吧！",
        "诶嘿～★您呼叫的签到不在服务区～请明天再签唷～")));
}else{
	if(rand(1,100)<=$successRate){
        addEnergy($qid,80);
        $incomex = $income*$multi;
	    $xpincomex = $xpincome;
        if(config('enableEXP','false')=='true'){
            dbRunQueryReturn("UPDATE credits SET lastcheck = {$today},coin = coin+{$incomex},xp = xp+{$xpincomex} WHERE qid = {$qid}");
            if ($haveMotd) {
                $Queue[]= sendBack('签到成功，获得 '.$incomex.' 个金币，奖励'.$xpincome."经验值，体力回复80EP\n".$motd[0]["message"]);
            }else{
                $Queue[]= sendBack('签到成功，获得 '.$income.' 个金币，奖励'.$xpincome.'经验值，体力回复80EP');
            }
        }else{
            dbRunQueryReturn("UPDATE credits SET lastcheck = {$today},coin = coin+{$incomex} WHERE qid = {$qid}");
            if ($haveMotd) {
                $Queue[]= sendBack("签到成功，获得 ".$incomex." 个金币，体力回复80EP\n".$motd[0]["message"]);
            }else{
                $Queue[]= sendBack('签到成功，获得 '.$income.' 个金币，体力回复80EP');
            }
        }
    }else{
        switch (rand(1,4)) {
            case 1:
                $Queue[]= sendBack('签到成... 诶呀！clipboard掉地上了');
                break;
            case 2:
                $Queue[]= sendBack('请先让我去喝口水！果然人气太旺也不全是好事啊啾~');
                break;
            case 3:
                $Queue[]= sendBack('今天风好大！你刚才在说什么啾？');
                break;
            default:
                dbRunQueryReturn("UPDATE credits SET lastcheck = {$today} WHERE qid = {$qid}");
                $Queue[]= sendBack('签到成功~ 可惜找不到金币和经验值了... 那就这样吧！（逃）');
                break;
        }
    }
}
