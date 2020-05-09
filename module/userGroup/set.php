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

global $Queue;

requireMaster();

$qid = parseQQ(nextArg());
$gid = (int)nextArg();

if ($gid==0) {
    //禁止从php设置任何用户为超级管理员
    $Queue[]= sendBack("因为安全顾虑，禁止通过指令设置0级权限用户");
    return;
}

dbRunQuery("INSERT OR IGNORE INTO global_special_users (qid,gid) VALUES ({$qid},{$gid})");
dbRunQuery("UPDATE global_special_users SET gid = {$gid} WHERE qid = {$qid}");

$Queue[]= sendBack("已设置{$qid}的用户组为{$gid}！");