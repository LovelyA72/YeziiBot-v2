<?php

global $Event, $Queue;
loadModule('osu.tools');
use Intervention\Image\ImageManagerStatic as Image;

Image::configure(array('driver' => 'imagick'));

$withMeText = false;

do{
    $arg = nextArg();
    switch($arg){
        case '-withMe':
            $withMeText = true;
            break;
        case '-osu':
        case '-std':
            $mode = 'osu';
            break;
        case '-taiko':
            $mode = 'taiko';
            break;
        case '-ctb':
        case '-fruit':
        case '-fruits':
            $mode = 'fruits';
            break;
        case '-mania':
            $mode = 'mania';
            break;
        case '-user':
            $osuid = nextArg();
            break;
        default:

    }
}while($arg !== NULL);

$osuid = $osuid??getOsuID($Event['user_id']);

if($osuid == ''){
    throw new \Exception('未绑定 osu!');
}

$osuid = OsuUsernameEscape($osuid);

$web = file_get_contents('https://osu.ppy.sh/users/'.$osuid.'/'.$mode);

$target = '<script id="json-user" type="application/json">';

$start = strpos($web, $target);

$end = strpos(substr($web, $start), '</script>');

$userJson = substr($web, $start+strlen($target), $end-strlen($target));

$user = json_decode($userJson);

$mode = $mode??$user->playmode;
$badges = $user->badges;
$badge = $badges[rand(0, count($badges)-1)];
$flag = file_exists($here."flags/{$user->country->code}.png")?($here."flags/{$user->country->code}.png"):($here.'flags/__.png');
$stats_key = imageFont($yahei, 12, $white);
$statics = $user->statistics;
$playtime = [
    'hours' => sprintf('%d', $statics->play_time/3600),
    'minutes' => sprintf('%d', ($statics->play_time%3600)/60),
    'seconds' => sprintf('%d', $statics->play_time%60),
];
$stat = [
    'Ranked 谱面总分' => number_format($statics->ranked_score),
    '准确率' => sprintf('%.2f%%', $statics->hit_accuracy),
    '游戏次数' => number_format($statics->play_count),
    '总分' => number_format($statics->total_score),
    '总命中次数' => number_format($statics->total_hits),
    '最大连击' => number_format($statics->maximum_combo),
    '回放被观看次数' => number_format($statics->replays_watched_by_others),
];
$grade = [
    'XH' => $statics->grade_counts->ssh,
    'X' => $statics->grade_counts->ss,
    'SH' => $statics->grade_counts->sh,
    'S' => $statics->grade_counts->s,
    'A' => $statics->grade_counts->a,
];
$reply = "";
$reply.= "玩家名：{$user->username}\n";
if($user->is_supporter){
    $reply.= "这位玩家是supporter!\n";
        //->insert(Image::make($here."modes/{$mode}.png")->resize(28, 28), 'top-left', 210, 223) //插入模式标志
        //;
}else{
    $reply.= "这位玩家还不是supporter!\n";
    //$img->insert(Image::make($here."modes/{$mode}.png")->resize(28, 28), 'top-left', 170, 223); //插入模式标志
}
$reply.= "已经玩了{$playtime['hours']}小时 {$playtime['minutes']}分钟 {$playtime['seconds']}秒\n等级：{$statics->level->current}\n";
foreach($stat as $key => $value){
    $reply.= $key." ";
    $reply.= $value."\n";
}
$reply.= $statics->pp."PP";
$Queue[]= sendBack($reply);


?>