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

global $Queue, $Command, $Event, $Text;


$countArg = count($Command)-1;
$min = 1;
$max = 100;

switch($countArg){
    case 1:
        $max = (int)nextArg();
        break;
    case 2:
        $min = (int)nextArg();
        $max = (int)nextArg();
        break;
    default:
}

if($Text!=null){
	$uid=$Event['user_id'];
	$rep = "因为{$Text},[CQ:at,qq={$uid}]掷出了";
	$message = $rep.rand($min, $max)."!";
}else{
	$message = rand($min, $max);
}
$Queue[]= sendBack($message);

?>