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

function getAct($QQ){
	return dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$QQ}")[0]['activity'];
}

function setAct($QQ,int $activity){
	dbRunQueryReturn("UPDATE credits SET activity = {$activity} WHERE qid = {$QQ}");
}

function addAct($QQ,int $income){
    if((int)getAct($QQ)+$income>100){
        setAct($QQ,100);
    }else{
        $grandTotal = getAct($QQ)+$income;
        setAct($QQ,$grandTotal);
    }
}

function decAct($QQ,int $activity){
    $myAct = getAct($QQ);
    if((int)$myAct >= $activity){
        setAct($QQ, (int)($myAct-$activity));
    }else{
        throw new \Exception('再继续和我玩之前，请多和群里大家交流一下呢！');
    }
}