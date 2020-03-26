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

$year = date('Y');

$totalDraw=(int)$Command[1];
if($totalDraw<=0){
	$Queue[]= sendBack("Xiaoling CDrawX V0.59a\n(c){$year} TEAM A72\n[Error] Command missing param: totalNumber");
	return;
}
if($totalDraw>100){
	$Queue[]= sendBack("Xiaoling CDrawX V0.59a\n(c){$year} TEAM A72\n[Error] totalNumber: Value too big.");
	return;
}

if(fromGroup()&&$totalDraw>11){
    $Queue[]= sendBack("为防止刷屏，超过11连请私聊抽哦！");
    return;
}

$prize_arr = array(
    0=>array( 'id'=>1,'prize'=>'UR','v'=>50 ),
    1=>array( 'id'=>2,'prize'=>'SSR','v'=>250 ),  
    2=>array( 'id'=>3,'prize'=>'SSR','v'=>300 ),
    3=>array( 'id'=>4,'prize'=>'SR','v'=>1400 ),
    //4=>array( 'id'=>5,'prize'=>'N','v'=>1000 ),
    4=>array( 'id'=>6,'prize'=>'R','v'=>2000 )
);


/*
 * 对数组进行处�?
 */

foreach( $prize_arr as $k => $v ){
    $item[$v['id']] = $v['v']; 
}

function get_rand($item){

    $num = array_sum($item);//计算出分�?00

    foreach( $item as $k => $v ){
     
      $rand = mt_rand(1, $num);//概率区间(整数) 包括1�?00
      if( $rand <= $v ){
          //循环遍历,当下�?k = 1的时候，只有$rand = 1 才能中奖 
          $result = $k;
          //echo $rand.'--'.$v;
          break;
      }else{
          //当下�?k=6的时候，如果$rand>100 必须$rand < = 100 才能中奖 ，那么前�?次循环之�?rand的概率区�? 200-1-5-10-24-60 �?,100�?必中1块钱
          $num-=$v;
          //echo '*'.$rand.'*'."&ensp;"."&ensp;"."&ensp;";
      }
    }

    return $result;
}

$message="模拟{$totalDraw}连抽！\n";

for($i=0;$i<$totalDraw;$i++){
	$res = get_rand($item);
	$message .= $prize_arr[$res-1]['prize']." ";
}

$Queue[]= sendBack($message);
