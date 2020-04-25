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

function getEnergy($QQ){
	return dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$QQ}")[0]['energy'];
}

function setEnergy($QQ,int $energy){
	dbRunQueryReturn("UPDATE credits SET energy = {$energy} WHERE qid = {$QQ}");
}

function addEnergy($QQ,int $income){
    if((int)getEnergy($QQ)+$income>(int)config("MaxEnergy","200")){
        setEnergy($QQ,200);
    }else{
        $grandTotal = getEnergy($QQ)+$income;
        setEnergy($QQ,$grandTotal);
    }
}

function decEnergy($QQ,int $energy){
    $myEnergy = getEnergy($QQ);
    if((int)$myEnergy >= $energy){
        setEnergy($QQ, (int)($myEnergy-$energy));
    }else{
        throw new \Exception('你的体力不够呢...休息一下吧！');
    }
}
