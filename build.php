<?php
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
CREATE TABLE `credits` (
	`qid`	INTEGER NOT NULL,
	`coin`	INTEGER NOT NULL DEFAULT 0,
	`xp`	INTEGER NOT NULL DEFAULT 0,
	`lastcheck`	INTEGER NOT NULL DEFAULT 0,
	`sc1`	INTEGER DEFAULT 0,
	`sc2`	INTEGER DEFAULT 0,
	PRIMARY KEY(`qid`)
);
CREATE TABLE `tickets` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`sender`	INTEGER NOT NULL,
	`text`	TEXT NOT NULL,
	`status`	INTEGER NOT NULL
);
COMMIT;
EOF;
$dbx->query($sqlx);
$dbx->close();
?>