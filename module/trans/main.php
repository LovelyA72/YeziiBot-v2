<?php

global $Queue, $Text;
requireGlobalUserGroup(0);

use \Statickidz\GoogleTranslate;

$source = nextArg();
$target = nextArg();
$trans = new GoogleTranslate();

$b64nonoWords = "546L,5rGf,5ZGo,6bih,6IOh,5YiY,5p2O,5ZC0,5q+b,5rip,5Lmg,6LS6,6LS+,5b2t,5Luk,6YeR,5ZSQ,6JKL,5r2t,5pK4,5p6q,5YWa,5p2A,6ZGr,5LiJ,6IOW,5oCn,5rer,5pil,6aa/,6L2t,6Juk,5YWx,6K2m,5Yab,5a6Y,54us,5rO9,5pON,6Im5,6Iac";

$Text = wordFilter($Text,$b64nonoWords);
//if($source==$target){
//    throw new \Exception("");
//}
if($source==$target){
    leave("翻译的结果：\n".$Text);
}

$result = $trans->translate($source, $target, $Text);
//if($result==$Text){
//    throw new \Exception("");
//}
$result = wordFilter($result,$b64nonoWords);
$Queue[]= sendBack("翻译的结果：\n".$result);

?>
