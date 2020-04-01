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