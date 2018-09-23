<?
include("../vendor/autoload.php");

use \YeziiBot\core\CoolQ;
use \YeziiBot\core\CQCode;
use \YeziiBot\Framework\MessageSender;

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
block($Event['user_id']);