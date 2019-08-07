<?php
//-----------------------------------------------------------------------

//    Copyright (c) 2017-2019 TEAM A72

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


$tid = (int)$Command[1];
if($tid==null){
	throw new \Exception("Xiaoling Ticketer v1.18g\n(c)2018 TEAM A72\n[ERROR] Missing ticket ID");
}
$content = dbRunQueryReturn("SELECT * FROM tickets WHERE id = {$tid}");
$post = base64_decode($content[0]['text']);
$Queue[]= sendBack("工单编号：{$content[0]['id']}
创建者：{$content[0]['sender']}
内容：{$post}");