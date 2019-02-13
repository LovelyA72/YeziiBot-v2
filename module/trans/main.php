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
    throw new \Exception($Text);
}

$result = $trans->translate($source, $target, $Text);
//if($result==$Text){
//    throw new \Exception("");
//}
$Queue[]= sendBack($result);

?>
