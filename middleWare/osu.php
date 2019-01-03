<?php

global $CQ, $Event, $Queue;

date_default_timezone_set('Asia/Shanghai');

if(preg_match('/see you next time/', $Event['message'])){
    try{
        if(file_exists("../storage/data/seeya.mp3")){
            $Queue[]= sendBack(sendRec(getData("seeya.mp3")));
        }
        $CQ->setGroupBan($Event['group_id'], $Event['user_id'], strtotime(((date('H')>=0&&date('H')<=7)?'':'next day').' 7 am')-time());
    }catch(\Exception $e){}
    
}

?>