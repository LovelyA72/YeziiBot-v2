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
//file_put_contents("composer-installer", fopen("https://getcomposer.org/installer", 'r'));
//exec("php composer-installer");
//exec("php composer.phar install");

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
	"sc1"	INTEGER DEFAULT 0,
	"sc2"	INTEGER DEFAULT 0,
	"api_key"	TEXT UNIQUE,
	"badge"	TEXT,
	PRIMARY KEY("qid")
);
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
COMMIT;
EOF;
$dbx->query($sqlx);
$dbx->close();
?>