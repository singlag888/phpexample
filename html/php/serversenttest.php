<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/9/5
 * Time: 上午9:14
 */
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$time = date('r');
echo "data: The server time is : {$time}\n\n";
echo "event: foo\n
data: a foo event\n\n";


flush();

