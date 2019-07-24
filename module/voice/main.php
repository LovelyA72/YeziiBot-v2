<?php
//-----------------------------------------------------------------------

//    Copyright (c) 2017-2018 TEAM A72

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
global $Event, $Queue, $Text;

require_once 'AipSpeech.php';
loadModule('credit.tools');

if(strlen($Text)==0){
	throw new \Exception("错误：缺少合成文字");
}

$aid = config('bd_app_id');
$akey = config('bd_api_key');
$atok = config('bd_api_token');
$credit = strlen($Text);
$creditTime = 3;

if(getCredit($Event['user_id'])-($credit*$creditTime)<=0){
	$Queue[]= sendBack("金币不足！请使用%checkin签到获取金币");
}else{

$client = new AipSpeech($aid, $akey, $atok);


$hash = $Event['message_id'];
setCache($hash.'.txt', removeCQCode(removeEmoji($Text)));
$result = $client->synthesis(file_get_contents("../storage/cache/{$hash}.txt"), 'zh', 1, array(
    'vol' => 5,
	'pit' => 6,
	'spd' => 6,
));
if(!is_array($result)){
    file_put_contents("../storage/cache/{$hash}.mp3", $result);
}


clearstatcache();
decCredit($Event['user_id'],floor(($credit)*$creditTime));
$Queue[]= sendBack(sendRec(getCache($hash.'.mp3')));
$Queue[]= sendBack('合成成功！长度'.$credit.'字节，扣取'.floor(($credit)*$creditTime) .'金币. 你还有'.getCredit($Event['user_id']).'金币');

}
?>