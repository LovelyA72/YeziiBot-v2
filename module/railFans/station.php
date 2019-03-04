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

global $Queue,$Command;

$suffixes = Array("港","村","广场","公园","新城","新区","机场","国际机场","火车站","高铁站","中心","城南","城北","东路","城西路","城东路","西路","南站","北站","中路","桥","客运站");
$existStations = explode("\r\n",file_get_contents("../module/railFans/stations.txt"));
$wordCount = rand(2,3);
$prefix = "";
for($i=0;$i<$wordCount;$i++){
    $prefix = $prefix.mb_substr(randomString($existStations),0,1);
}
$result = $prefix.randomString($suffixes);

$Queue[] = sendBack($result);