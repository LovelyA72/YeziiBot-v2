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

global $Queue,$Version;
$hash = get_current_git_commit("0.5.0-update");
if ($hash) {
    $vernume = "{$Version["num"]}-{$hash}";
}else {
    $vernume = $Version["num"];
}
$vername = $Version["name"];
$Queue[]= sendBack("YeziiBot v2\nv{$vernume} {$vername} \n项目地址：https://github.com/LovelyA72/YeziiBot-v2\n受AGPL v3开源许可证保护");