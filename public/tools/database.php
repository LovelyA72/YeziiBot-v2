<?php
class MyDB extends SQLite3{
    function __construct()
    {
        $this->open('../storage/data/kjbot.db');
    }
}

function dbRunQuery($query){
	$db = new MyDB();
	$db->query($query);
	$db->close();
}
function dbRunQueryReturn($query){
	$db = new MyDB();
	$ret = $db->query($query);
	if($ret==null){
		return;
	}
	$row = $ret->fetchArray(SQLITE3_ASSOC);
	$db->close();
	return $row;
}
function directCredit($gqid){//will return int indicate which row that ID on.
    $db = new MyDB();
    if(!$db){
        echo $db->lastErrorMsg();
    }
    $sql =<<<EOF
      SELECT * from credits;
EOF;
    $ret = $db->query($sql);
    while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
        if($row["qid"]==$gqid){
            $result = $row["credit"];
            return(array($row["coin"],$row["xp"],$row["lastCheck"]));
        }
    }
    return -1;
}
function haveUser($qid){
    if (directCredit($qid) == "-1") {
        return false;
    }
    return true;
}
function generalCheck($qid){
	if(!haveUser($qid)){
		createUser($qid);
	}
}

function createUser($qid){
    $db = new MyDB();
    if(!$db){
        echo $db->lastErrorMsg();
    }
    if(haveUser($qid)){
        die();
    }
    $sql =<<<EOF
      INSERT INTO credits (qid,coin,xp,lastCheck)
      VALUES ($qid,0,0,0);
EOF;
    $ret = $db->exec($sql);
    return true;
}