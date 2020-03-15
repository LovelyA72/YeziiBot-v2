<?php
//-----------------------------------------------------------------------

//    Copyright (c) 2017-2019 TEAM A72

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
    while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
        $rowx[]=$row;
     }
	//$row = $ret->fetchArray(SQLITE3_ASSOC);
	$db->close();
	return $rowx;
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
            $result = $row["coin"];
            return(array($row["coin"],$row["xp"],$row["lastcheck"]));
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
    INSERT INTO credits (qid,coin,xp,lastCheck,sc1,sc2) VALUES ($qid,0,0,0,0,0);
EOF;
    $ret = $db->exec($sql);
    return true;
}

