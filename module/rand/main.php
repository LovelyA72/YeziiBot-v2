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
loadModule('credit.tools');

$qid = $Event['user_id'];

$events = array(
    //array("事件标题","对事件恰当的描述","credit",-50),
    //第三个参数是加减的金币
    array("小心路滑！","雨天路滑跌了一跤，好像丢了50金币呢...","credit",-50),
    array("感冒了！","你的嗓子决定罢工1分钟，多喝热水哦","mute",1),
    array("今天小绫很开心呢！","[CQ:at,qq={$qid}]抱抱哦~","text",0),
);