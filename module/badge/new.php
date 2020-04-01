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


global $Queue, $Event, $Text;
if($Event['group_id']!=570766502){
	throw new \Exception("This function is not available in this group!");
}
if(strlen($Text)>25){
	throw new \Exception("头衔太长啦~");
}
if($Text==null){
	throw new \Exception("Xiaoling Ticketer v1.18g\n(c)2018 TEAM A72\n[ERROR] Missing ticket content");
}
$text64 = base64_encode($Text);
$sender = $Event['user_id'];
if(sizeof(dbRunQueryReturn("SELECT * FROM tickets WHERE sender={$sender} AND status=2"))>0){
	throw new \Exception("你已经有在等待状态的头衔了！如果长时间没处理，请联系群主");
}
dbRunQuery("INSERT INTO tickets (sender,text,status) VALUES ({$sender},'{$text64}',2)");

$cid = dbRunQueryReturn("SELECT * FROM tickets ORDER BY id DESC LIMIT 1")[0]['id'];

$Queue[]= sendBack("头衔申请提交成功！工单编号为{$cid}！");