<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/9/6
 * Time: 下午5:09
 */
$key = $_POST['key'];
$text = $_POST['text'];


$data = array('key' => $key, 'text' => $text);

$data = date('Ymd_H:i:s') . ": " . $text . "\r\n";

//保存到本地文件
$dir = __DIR__ . '/log';
if (!is_dir($dir)) {
    mkdir($dir);
}
$file = $dir . '/' . date('Ymd') . '.log';
//echo $file;
$logfile = fopen($file, 'a+');
fwrite($logfile, $data);
fclose($logfile);

echo 'SUCCEED';