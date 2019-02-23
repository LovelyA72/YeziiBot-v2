<?php
global $Queue;

//启用的模组应该放在这里，需添加.php后缀
$procedure = Array(
    "hello.php"
);

$prevQueue = sizeof($Queue);
foreach ($procedure as $file) {
    if((sizeof($Queue)<=$prevQueue)&&(mb_strlen($file)>0)){
        require($file);
    }
}