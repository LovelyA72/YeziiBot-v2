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



function getCredit($QQ){
	return dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$QQ}")[0]['coin'];
    //return (int)getData("credit/{$QQ}");
}

function setCredit($QQ, $credit){
	return  dbRunQueryReturn("UPDATE credits SET coin = {$credit} WHERE qid = {$QQ}");
    //return setData("credit/{$QQ}", (int)$credit);
}

function addCredit($QQ, $income){
	return  dbRunQueryReturn("UPDATE credits SET coin = coin+{$income} WHERE qid = {$QQ}");
    //return setCredit($QQ, getCredit($QQ)+(int)$income);
}

function decCredit($QQ, $pay){
    $balance = getCredit($QQ);
    if($balance >= $pay){
        return setCredit($QQ, (int)($balance-$pay));
    }else{
        throw new \Exception('余额不足,还需要 '.($pay-$balance).' 个金币');
    }
}

function forceChange($qid,$amount){
    //Force change a user's credit.
    //When the user's credit is not enough, reset to 0.
    //Ideal for random events module.
    if(($amount<0)&&(dbRunQueryReturn("SELECT coin FROM credits WHERE qid={$qid}")<abs($amount))){
        dbRunQuery("UPDATE credits SET coin=0 WHERE qid={$qid}");
    }else{
        $newCredit=dbRunQueryReturn("SELECT coin FROM credits WHERE qid={$qid}")+$amount;
        dbRunQuery("UPDATE credits SET coin={$newCredit} WHERE qid={$qid}");
    }
}

function transferCredit($from, $to, $transfer){
    decCredit($from, $transfer);
    setCredit($to,getCredit($to)+$transfer);
}