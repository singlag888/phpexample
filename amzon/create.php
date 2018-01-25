<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/25
 * Time: 上午9:33
 */

$source = '/Users/hello/PhpstormProjects/example/amzon/source.txt';

$file = fopen($source, 'r') or exit('can not open file!');

while (!feof($file)) {
    $line = fgets($file);
//    echo $line .'<br/>';
    $preg_split = preg_split("/#/", $line);
//    print_r($preg_split);
    if (!$preg_split) {
        echo "data error: " . $line;
        continue;
    }
    $title = $preg_split[0];
    $price = $preg_split[1];
    $imgUrl = $preg_split[2];



}

fclose($file);

