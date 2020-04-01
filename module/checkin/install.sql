CREATE TABLE "checkin_motd" (
	"date"	INTEGER NOT NULL UNIQUE,
	"multi"	INTEGER NOT NULL DEFAULT 1,
	"message"	TEXT,
	PRIMARY KEY("date")
);