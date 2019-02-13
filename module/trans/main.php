<?php
global $Queue, $Text;
use \Statickidz\GoogleTranslate;

$source = nextArg();
$target = nextArg();
$trans = new GoogleTranslate();

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
$Queue[]= sendBack("翻译的结果：\n".$result);

?>
