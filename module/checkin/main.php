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
if($lastCheckinTime>=date('ymd')){
    $Queue[]= sendBack(randomString(array(
        "你今天签到过了！",
        "是小绫记错了吗？不不不，你今天真的签到过了！",
        "小绫我的记性都比你要好啾~你今天签到过啦！")));
}else{
	$incomex = $income/2;
	$xpincomex = $xpincome/2;
	$today = date('ymd');
    dbRunQueryReturn("UPDATE credits SET lastcheck = {$today},coin = coin+{$incomex},xp = xp+{$xpincomex} WHERE qid = {$qid}");
    $Queue[]= sendBack('签到成功，获得 '.$income.' 个金币，奖励'.$xpincome.'经验值！');
}
?>