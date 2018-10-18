<?php

function getCredit($QQ){
	return dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$QQ}")['coin'];
    //return (int)getData("credit/{$QQ}");
}

function setCredit($QQ, $credit){
	return  dbRunQueryReturn("UPDATE credits SET coin = {$credit} WHERE qid = {$QQ}");
    //return setData("credit/{$QQ}", (int)$credit);
}

function addCredit($QQ, $income){
	return  dbRunQueryReturn("UPDATE credits SET coin = coin+{$credit} WHERE qid = {$QQ}");
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

function transferCredit($from, $to, $transfer){
    decCredit($from, $transfer);
    addCredit($to, $transfer);
}

?>