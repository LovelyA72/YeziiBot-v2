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
//file_put_contents("composer-installer", fopen("https://getcomposer.org/installer", 'r'));
//exec("php composer-installer");
//exec("php composer.phar install");
error_reporting(E_ALL);
function countDown( $seconds ) {
	for ( $i = $seconds; $i >= 0; $i-- ) {
		if ( $i != $seconds ) {
			print( str_repeat( "\x08", strlen( $i + 1 ) ) );
		}
		print( $i );
		if ( $i ) {
			sleep( 1 );
		}
	}
	print( "\n" );
}

print("YeziiBot is licensed under the GNU AGPL v3 license.\n");
print("YeziiBot由GNU AGPL v3许可证进行许可。这意味着您必须注明本程序的来源并且将所做的任何修改开源。\n");
print("如果您希望闭源开发，请不要使用YeziiBot并立即ctrl+c退出此安装程序\nPlease wait for the countdown\n请等待倒计时结束：");
countDown(9);
print("Type 'agree' to continue\n");
print("请输入agree同意并继续安装.\n");
if(readline("Type your response:")!="agree"){
	print("Installation aborted. 安装终止。");
	return;
}
exec("mkdir storage\\");
exec("mkdir storage\\data\\");
exec("mkdir storage\\cache\\");
fopen("storage/data/black.txt","a");
$db = new SQLite3('storage/data/stat.db');

$sql=<<<EOF
PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE record(
user_id BIGINT NOT NULL,
command TEXT NOT NULL,
count NOT NULL
);
COMMIT;
EOF;
$db->query($sql);
$db->close();

$dbx = new SQLite3('storage/data/kjbot.db');

$sqlx=<<<EOF
PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE "credits" (
	"qid"	INTEGER NOT NULL,
	"coin"	INTEGER NOT NULL DEFAULT 0,
	"xp"	INTEGER NOT NULL DEFAULT 0,
	"lastcheck"	INTEGER NOT NULL DEFAULT 0,
	"ex1"	INTEGER DEFAULT 0,
	"sc1"	INTEGER DEFAULT 0,
	"sc2"	INTEGER DEFAULT 0,
	"api_key"	TEXT UNIQUE,
	"badge"	TEXT,
	"energy"	INTEGER DEFAULT 200,
	"energy_last_deduct"	INTEGER DEFAULT 0,
	"activity"	INTEGER DEFAULT 80,
	PRIMARY KEY("qid")
)
CREATE TABLE `tickets` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`sender`	INTEGER NOT NULL,
	`text`	TEXT NOT NULL,
	`status`	INTEGER NOT NULL
);
CREATE TABLE "replies" (
	"question"	TEXT NOT NULL,
	"answer"	TEXT NOT NULL,
	"status"	INTEGER NOT NULL DEFAULT 1,
	PRIMARY KEY("question")
);
CREATE TABLE `global_special_users` (
	`qid`	INTEGER NOT NULL,
	`gid`	INTEGER NOT NULL
);
COMMIT;
EOF;
$dbx->query($sqlx);
$dbx->close();
?>