<?php

global $Event, $Queue;
use YeziiBot\core\CQCode;

switch($Event['notice_type']){
    case 'group_increase':
        if($Event['user_id'] != config('bot')){
            $Queue[]= sendBack(CQCode::At($Event['user_id']).' 欢迎加入本群，希望在这里玩的开心~');
        }else{
            $Queue[]= sendBack('大家好~这里是何小绫！大家可以发送 '.config('prefix', '!').'help 查看帮助'."\n本Bot用户协议基于kjBot用户协议：https://github.com/kjBot-Dev/TOS/blob/master/README.md");
        }
        break;
    case 'group_decrease':
        if($Event['sub_type']=='kick_me'){
            $Queue[]= sendMaster('Being kicked from group '.$Event['group_id'].' by '.$Event['operator_id']);
        }
        break;
    case 'group_admin':
        if($Event['user_id'] == config('bot')){
            if($Event['sub_type']=='set'){
                $prefix = 'Get ';
            }elseif($Event['sub_type']=='unset'){
                $prefix = 'Lost ';
            }
            $Queue[]= sendMaster($prefix.'admin in group '.$Event['group_id']);
        }
        break;
    default:
        
}

?>