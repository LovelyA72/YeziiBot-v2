<?php
//-----------------------------------------------------------------------

//    Copyright (c) 2017-2018 TEAM A72

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

$qid = $Event['user_id'];
$income = rand(10, 25);
$xpincome = rand(200, 450);
$content = dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$qid}");
$lastCheckinTime=$content[0]['lastcheck'];
$today = date('ymd');
if($lastCheckinTime>=$today){
    $Queue[]= sendBack(randomString(array(
        "你今天签到过了！",
        "是小绫记错了吗？不不不，你今天真的签到过了！",
        "小绫我的记性都比你要好啾~你今天签到过啦！",
        "你今天签到过了，小绫没有更多的金币了哦~",
        "签过啦~明天再来吧~",
        "呜～签到失败了....人家该如何是好啊...（慌慌张张）明天再来吧！",
        "诶嘿～★您呼叫的签到不在服务区～请明天再签唷～")));
}else{
	if(rand(1,20)<17){
        $incomex = $income/2;
	    $xpincomex = $xpincome/2;
        dbRunQueryReturn("UPDATE credits SET lastcheck = {$today},coin = coin+{$incomex},xp = xp+{$xpincomex} WHERE qid = {$qid}");
        $Queue[]= sendBack('签到成功，获得 '.$income.' 个金币，奖励'.$xpincome.'经验值！');
    }else{
        switch (rand(1,5)) {
            case 1:
            $Queue[]= sendBack('签到成... 诶呀！clipboard掉地上了');
                break;
            case 2:
            $Queue[]= sendBack('签到成... 诶呀！clipboard掉地上了');
                break;
            case 3:
            $Queue[]= sendBack('来，给小綾唱段歌，就给你签到~（坏笑）');
                break;
            default:
            dbRunQueryReturn("UPDATE credits SET lastcheck = {$today} WHERE qid = {$qid}");
            $Queue[]= sendBack('签到成功~ 可惜找不到金币和经验值了... 那就这样吧！（逃）');
                break;
        }
    }
}
?>