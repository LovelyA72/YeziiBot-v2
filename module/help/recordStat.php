<?php

$msg="kjBot 用户使用情况记录
用法：
".{config('prefix')}."recordStat 阅读用户协议
".{config('prefix')}."recordStat.verify 同意
".{config('prefix')}."recordStat.cancel 取消同意
".{config('prefix')}."recordStat.me 查看自己的使用情况";

leave($msg);

?>
