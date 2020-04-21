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

global $Queue, $Command;

$dsplit = explode("d",nextArg(),2);
$dice = (int)preg_replace("/[^0-9]/", "", $dsplit[0] );
$sides = (int)preg_replace("/[^0-9]/", "", $dsplit[1] );
$message = "";
if ($dice>10||$sides>100) {
    $Queue[] = sendBack("骰子面超过了100面或骰子数量超过了10个");
}elseif ($dice==0||$sides==0) {
    loadModule("help.dice");
}else{
    for ($i=0; $i < $dice; $i++) { 
        $message.=mt_rand(1,$sides)." ";
    }
    $Queue[] = sendBack($message);
}

