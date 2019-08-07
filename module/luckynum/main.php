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

global $Event, $Queue;

$qid = $Event['user_id'];//获取qq号
$date = date('ymd');//获取今天的日期
//用qq号减去日期后计算MD5，删除字母后取前两个数字
$luckynum = substr(preg_replace('/\D/','',md5($qid-$date)),0,2);
//回复消息
$Queue[]= sendBack("你今天的幸运数字是{$luckynum}!");
