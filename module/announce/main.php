<?php

global $Queue, $Text, $CQ;
use kjBot\Frame\Message;
requireGlobalUserGroup(0);

$groupList = $CQ->getGroupList();

foreach($groupList as $group){
    $Queue[]= new Message($Text, $group->group_id, true);
}

?>