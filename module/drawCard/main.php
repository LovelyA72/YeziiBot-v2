<?php

global $Queue,$Event,$Command;

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

$prize_arr = array(
    0=>array( 'id'=>1,'prize'=>'UR','v'=>50 ),
    1=>array( 'id'=>2,'prize'=>'SSR','v'=>250 ),  
    2=>array( 'id'=>3,'prize'=>'SSR','v'=>300 ),
    3=>array( 'id'=>4,'prize'=>'SR','v'=>1400 ),
    4=>array( 'id'=>5,'prize'=>'N','v'=>1000 ),
    5=>array( 'id'=>6,'prize'=>'R','v'=>2000 )
);


/*
 * 对数组进行处理
 */

foreach( $prize_arr as $k => $v ){
    $item[$v['id']] = $v['v']; 
}

function get_rand($item){

    $num = array_sum($item);//计算出分母200

    foreach( $item as $k => $v ){
     
      $rand = mt_rand(1, $num);//概率区间(整数) 包括1和200
      if( $rand <= $v ){
          //循环遍历,当下标$k = 1的时候，只有$rand = 1 才能中奖 
          $result = $k;
          //echo $rand.'--'.$v;
          break;
      }else{
          //当下标$k=6的时候，如果$rand>100 必须$rand < = 100 才能中奖 ，那么前面5次循环之后$rand的概率区间= 200-1-5-10-24-60 （1,100） 必中1块钱
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