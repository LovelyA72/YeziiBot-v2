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
global $Message;
if(!preg_match('/^\[CQ:(bface|image|face|emoji|sface)\,(|.+)\]$/', $Message)){
    $MsgProc = $Message;
    //Remove repeated chars if appears more/equal than 3 times
    $MsgProc = preg_replace('/(.)\1{2,}/',"",$MsgProc);
    //This is for emoji removal
    $MsgProc = preg_replace('/[\\pP+~$`^=|<>～｀＄＾＋＝｜＜＞[\]{}【】￥×]/',"",$MsgProc);
    //More string process codes
    //If detect fails, just clear $MsgProc
    if (mb_strlen($MsgProc)>2) {
        loadModule("activity.tools");
        addAct($Event["user_id"],8); 
    }
    
}
