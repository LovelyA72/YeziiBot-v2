<?php

global $Event, $Queue, $osu_api_key;
loadModule('osu.tools');

do{
    $arg = nextArg();
    if(preg_match('/-(\d{1,3})/', $arg, $result)){
        $x = $result[1];
        coutinue;
    }
	$x = 1;
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
        throw new \Exception('未绑定 osu!，且未指定用户');
    }else{
        $u = $user;
    }
}
$osuMode = rtrim(getData("osu/mode/{$Event['user_id']}"));
$m = $mode??$osuMode;

$recent = get_user_best($osu_api_key, $u, $x, $m);
//$map = get_map($bp['beatmap_id'], $bp['enabled_mods']);
//$map['beatmap_id'] = $bp['beatmap_id'];
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
		'diff' => 'CS:'.$beatmap['diff_size'].' OD:'.$beatmap['diff_overall'].' HP:'.$beatmap['diff_drain'].' AR:'.$beatmap['diff_approach'].' Stars:'. round($beatmap['difficultyrating'], 1),
    ));
write_ini_file($sampleData,dirname(__FILE__)."/../../storage/data/oig/{$Event['message_id']}.ini", true);
//$ret = shell_exec("dotnet ".dirname(__FILE__)."/../../storage/oig/osuImageGenerator.dll ./{$Event['message_id']}.ini ../../cache/{$Event['message_id']}.jpg");
exec("cd /d {$oigDir} && dotnet ./osuImageGenerator.dll ../data/oig/{$Event['message_id']}.ini ../cache/{$Event['message_id']}.jpg");

$Queue[]= sendBack(sendImg(getCache("{$Event['message_id']}.jpg")));
//$img = drawScore($bp, $map, $u);
//$img->save('../storage/cache/'.$Event['message_id']);
//$Queue[]= sendBack(sendImg(getCache($Event['message_id'])));

?>