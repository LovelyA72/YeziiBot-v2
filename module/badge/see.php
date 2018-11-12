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


global $Queue, $Command, $Event;
if($Event['group_id']!=570766502){
	throw new \Exception("This function is not available in this group!");
}
$content = dbRunQueryReturn("SELECT * FROM tickets WHERE status = 2");
foreach ($content as $value) {
	$post = base64_decode($value['text']);
	$message.="头衔名:".$post."\n申请者:".$value["sender"]."\n----\n";
}
$Queue[]= sendBack($message);