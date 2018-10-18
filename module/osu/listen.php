<?php

global $Queue, $Event;
loadModule('credit.tools');

$beatmapSetID = (int)nextArg();

$temp = getData($beatmapSetID.".mp3");
if($temp !== false){
    $Queue[]= sendBack(sendRec($temp));
    $Queue[]= sendBack('试听成功! 由于缓存，不扣金币');
    leave();
}
decCredit($Event['user_id'], 1);


file_put_contents("C:/BotQQ/kjbot/storage/data/".$beatmapSetID.".mp3", fopen('https://b.ppy.sh/preview/'.$beatmapSetID.".mp3", 'r'));


$tempx = getData($beatmapSetID.".mp3");

$Queue[]= sendBack(sendRec($tempx));
$Queue[]= sendBack('试听成功，你现在的余额为 '.getCredit($Event['user_id']));

?>