<?php

switch($Event['request_type']){
    case 'friend':
        if (config('autoFriendsRequest')) {
            $CQ->setFriendAddRequest($Event['flag'], config('allowFriends'));
            if (config("allowFriends")) {
                $Queue[]= sendBack(config('WelcomeMsg')); //发送欢迎消息
            }
        }
        $Queue[]= sendMaster('Recieved a friend request from '.$Event['user_id']); //通知master
        break;
    case 'group':
        switch($Event['sub_type']){
            case 'add':
                //TODO 新人加群的情况可能需要中间件来处理
                break;
            case 'invite':
            break;
                $CQ->setGroupAddRequest($Event['flag'], $Event['sub_type'], config('allowGroups'));
                if(config('allowGroups')){
                    $Queue[]= sendMaster('Join Group '.$Event['group_id'].' by '.$Event['user_id']); //通知master
                }else{
                    $Queue[]= sendMaster('Denied group request '.$Event['group_id'].' by '.$Event['user_id']); //通知master
                }
                break;
            default:
        }
        break;
    default:

}

?>
