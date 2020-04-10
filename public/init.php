<?php

include('../vendor/autoload.php'); //避免没有vendor的用户出错
use kjBot\SDK\CoolQ;
use kjBot\SDK\CQCode;
use kjBot\Frame\MessageSender;

if (config('master_switch', 'false')=="true") {
    exit();
}
//全局变量区
$Version = Array("num"=>"0.5.0 beta","name"=>"Kindly Kashouryo");

$Config = parse_ini_file('../config.ini', false, INI_SCANNER_RAW);
$Event = json_decode(file_get_contents('php://input'), true);
$Event['message'] = CQCode::DecodeCQCode($Event['message']);
$User_id = $Event['user_id'];
$CQ = new CoolQ(config('API', '127.0.0.1:5700'), config('token', ''));
$Queue = [];
$MsgSender = new MessageSender($CQ);
$Debug = ('true'===config('DEBUG', 'false'))?true:false;
$DebugListen = config('DebugListen', config('master'));
$Command = [];
$Text = '';
$StatDB = new SQLite3('../storage/data/stat.db');

block($Event['user_id']);