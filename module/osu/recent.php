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

global $Queue, $Text;

global $Event, $Queue, $osu_api_key;
loadModule('osu.tools');

do{
    $arg = nextArg();
    switch($arg){
        case '-user':
            $user = nextArg();
            break;
        case '-std':
            $mode = OsuMode::std;
            break;
        case '-taiko':
            $mode = OsuMode::taiko;
            break;
        case '-ctb':
            $mode = OsuMode::ctb;
            break;
        case '-mania':
            $mode = OsuMode::mania;
            break;
        default:

    }
}while($arg !== NULL);

$osuUser = getOsuID($Event['user_id']);
if($osuUser !== ''){
    $u = $user??$osuUser;
}else{
    if($user == NULL){
        throw new \Exception('诶诶？小绫不知道Producer桑的名字呢...
使用%osu.bind 你的用户名 做个自我介绍吧！
小绫想和P桑一起玩的说！
如果还不想绑定... 也没关系哦！
在指令后面加上-user 用户名 就可以查看指定用户了。
小绫不会让P桑失望的！desu！');
    }else{
        $u = $user;
    }
}
$osuMode = rtrim(getData("osu/mode/{$Event['user_id']}"));
$m = $mode??$osuMode;

$recent = get_user_recent($osu_api_key, $u, $m);
//$map = get_map($recent['beatmap_id'], $recent['enabled_mods']);
$beatmap = get_beatmap($osu_api_key,$recent['beatmap_id']);
//$map['beatmap_id'] = $recent['beatmap_id'];

$oigDir = config("oig_dir");

$charSprite = "./chars/".randomString(explode(",",config("oig_chars"))).".png";
//$img = drawScore($recent, $map, $u);
$sampleData = array(
    'yeziiImageCfg_v1' => array(
        'bgImage' => "./background17.png",
        'fgImage' => "./fg1.png",
        'charImage' => $charSprite,
		'charSize' => "80",
		'charX' => "-110",
		'charY' => "-130",
        'template' => "0",
        'gameMode' => "0",
        'playerName' => $u,
        'songName' => $beatmap['title'],
        'score' => $recent['score'],
        'great' => $recent['count300'],
        'good' => $recent['count100'],
        'meh' => $recent['count50'],
        'miss' => $recent['countmiss'],
        'combo' => $recent['maxcombo'].'x',
        'pp' => "--",
        'acc' => ACCof($recent),
        'date' => $recent['date'],
		'rank' => $recent['rank'],
		'level' => $beatmap['version'],
		'author' => $beatmap['creator'],
		'diff' => 'CS:'.$beatmap['diff_size'].' OD:'.$beatmap['diff_overall'].' HP:'.$beatmap['diff_drain'].' AR:'.$beatmap['diff_approach'].' Stars:'. $beatmap['difficultyrating'],
    ));
write_ini_file($sampleData,dirname(__FILE__)."/../../storage/data/oig/{$Event['message_id']}.ini", true);
//$ret = shell_exec("dotnet ".dirname(__FILE__)."/../../storage/oig/osuImageGenerator.dll ./{$Event['message_id']}.ini ../../cache/{$Event['message_id']}.jpg");
exec("cd /d {$oigDir} && dotnet ./osuImageGenerator.dll ../data/oig/{$Event['message_id']}.ini ../cache/{$Event['message_id']}.jpg");

$Queue[]= sendBack(sendImg(getCache("{$Event['message_id']}.jpg")));


?>