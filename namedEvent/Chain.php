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
global $Queue;

//启用的模组应该放在这里，需添加.php后缀
$procedure = Array(
    "hello.php",
    "checkin.php",
    "me.php",
    "drawcard.php",
    //实在不行了就进commonReplies.php获得一个固定的回答
    "commonReplies.php"
);

$prevQueue = sizeof($Queue);
foreach ($procedure as $file) {
    if((sizeof($Queue)<=$prevQueue)&&(mb_strlen($file)>0)){
        require($file);
    }
}