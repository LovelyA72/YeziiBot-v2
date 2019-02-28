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

function getAPIKey(int $qid):string{
    return dbRunQueryReturn("SELECT * FROM credits WHERE qid = {$qid}")[0]['api_key'];
}

function newAPIKey(int $qid):string{
    $key = hash("haval128,3",microtime().rand(1000, 9999));
    try {
        dbRunQueryReturn("UPDATE credits SET api_key = \"{$key}\" WHERE qid = {$qid}");
    } catch (\Exception $ex) {
        throw $ex;
    }
    return $key;
}