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

global $Queue,$Event,$Command;
loadModule('credit.tools');

$year = date('Y');

$totalDraw=(int)$Command[1];
if($totalDraw<=0){
	$Queue[]= sendBack("Xiaoling CDrawX V0.58a\n(c){$year} TEAM A72\n[Error] Command missing param: totalNumber");
	return;
}
if($totalDraw>100){
	$Queue[]= sendBack("Xiaoling CDrawX V0.58a\n(c){$year} TEAM A72\n[Error] totalNumber: Value too big.");
	return;
}
$costMoney = (int)(5+$totalDraw/8);

$prize_arr = array(
    0=>array( 'id'=>1,'prize'=>'UR','v'=>50 ),
    1=>array( 'id'=>2,'prize'=>'SSR','v'=>250 ),  
    2=>array( 'id'=>3,'prize'=>'SSR','v'=>300 ),
    3=>array( 'id'=>4,'prize'=>'SR','v'=>1400 ),
    4=>array( 'id'=>5,'prize'=>'N','v'=>1000 ),
    5=>array( 'id'=>6,'prize'=>'R','v'=>2000 )
);


/*
 * 对数组进行处�?
 */

foreach( $prize_arr as $k => $v ){
    $item[$v['id']] = $v['v']; 
}

function get_rand($item){

    $num = array_sum($item);

    foreach( $item as $k => $v ){
     
      $rand = mt_rand(1, $num);
      if( $rand <= $v ){
          $result = $k;
          break;
      }else{
          $num-=$v;
      }
    }

    return $result;
}

decCredit($Event["user_id"], $costMoney);

$message="模拟{$totalDraw}连抽！扣取{$costMoney}金币\n";

for($i=0;$i<$totalDraw;$i++){
	$res = get_rand($item);
	$message .= $prize_arr[$res-1]['prize']." ";
}

$Queue[]= sendBack($message);
