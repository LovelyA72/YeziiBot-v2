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

if($Command[1]>30){
    throw new Exception("不能超过30站哦！");
}
$stations = explode("\r\n",file_get_contents("../module/railFans/stations.txt"));
for($i=0;$i<$Command[1];$i++){
    $index = rand(0,sizeof($stations)-1);
    $final[] = $stations[$index];
    array_splice($stations, $index, 1);
}
$result = "";
for($j=0;$j<sizeof($final);$j++){
    if($j!=0&&$j!=1&&$j!=sizeof($final)-1){
        $result = $result.$final[$j].'<->';
    }else if($j==1){
        $result = $result.'<->'.$final[$j].'<->';
    }else{
        $result = $result.$final[$j];
    }
}
$Queue[]=sendBack("已生成包含{$Command[1]}个站点的虚拟线路: \n".$result);