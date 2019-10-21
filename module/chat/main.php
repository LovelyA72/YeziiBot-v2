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

global $Message, $Queue, $Command;
$question = $Command[1];
$answers = dbRunQueryReturn("SELECT * FROM replies WHERE question = \"{$question}\" AND status = 0");
$anss = Array();
foreach($answers as $ansstr){
	$anss[] = $ansstr["answer"];
}
$answer = randomString($anss);
   if($answer!=""){
       $Queue[] = sendBack($answer);
   }else{
       return;
       $Queue[]=sendBack(randomString(Array(
           "诶呀，我没主意了，怎么办呢...",
           "我还不知道怎么回答呢..."
       )));
   }