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

global $Queue, $Text;

requireGlobalUserGroup(10);
$pText = preg_replace("/[^0-9a-zA-Z\+\-\*\/]/", "", $Text );
$ret = shell_exec(dirname(__FILE__)."/../../native/calc.exe {$pText}");

$Queue[]= sendBack(mb_substr($ret,0,-1));