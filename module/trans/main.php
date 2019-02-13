<?php

global $Queue, $Text;
requireMaster();

use \Statickidz\GoogleTranslate;

$source = nextArg();
$target = nextArg();
$trans = new GoogleTranslate();

$nonoWords = "";
function wordFliter($input,$words){
    $list = explode(",",words);
    foreach ($list as $value) {
        $input = str_replace($value,"*",$input);
    }
    return $input;
}
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
