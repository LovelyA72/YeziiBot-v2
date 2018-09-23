<?
include('UnauthorizedException.php');
include("../vendor/autoload.php");
include ('../core/API.php');
include ('../core/CQCode.php');
include ('../core/CoolQ.php');

use YeziiBot\core\CoolQ;
use YeziiBot\core\CQCode;
use YeziiBot\core\API;
use YeziiBot\Framework\MessageSender;
use YeziiBot\Framework\UnauthorizedException;

include("../LocalSettings.php");
$Event = json_decode(file_get_contents('php://input'), true);
$Event['message'] = CQCode::DecodeCQCode($Event['message']);
$User_id = $Event['user_id'];
$CQ = new CoolQ(config('API', '127.0.0.1:5700'), config('token', ''));
$Queue = [];
$MsgSender = new MessageSender($CQ);
$Debug = config('DEBUG', false);
$DebugListen = config('DebugListen', config('master'));
$Command = [];
$Text = '';
$StatDB = new SQLite3('../storage/data/stat.db');
//block($Event['user_id']);