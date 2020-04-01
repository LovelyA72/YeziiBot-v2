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

global $Message, $Queue, $Text, $Command;

requireGlobalUserGroup(5);

$date = date("ymd");
$to = nextArg();
$td = date('ymd', strtotime($date. " + {$to} days"));

$upcoming = dbRunQueryReturn("SELECT * FROM checkin_motd WHERE date BETWEEN {$date} AND {$td}");
$reply="在{$td}之前将会发生的活动有:";
foreach($upcoming as $item){
	$reply.="\n".$item['date']." ".$item['multi']." ".$item['message'];
}
$Queue[] = sendBack($reply);