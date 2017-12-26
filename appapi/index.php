<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/25
 * Time: 上午9:41
 */


require_once '../Error.php';

require_once 'CacheFile.php';
require_once 'Encode.php';
require_once 'Response.php';

$format = $_GET['format'];

$data = [
    'name' => 'world',
    'age' => 32,
    'sex' => 'fale',
    'func' => 'what',
    'ma' => [
        'world' => 'hello',
        'this' => 'sugar',
        'coff' => 'black',
    ],
];
//echo $format."<br>";
//echo Encode::xmlEncode(200,'返回东西了',$data);
//echo Encode::encoder(200, '请求成功', $data, $format);

//$cache = new CacheFile();
//$result = $cache->cacheData("test-cache", $data);
//var_dump($result);
//
//var_dump($cache->cacheData('test-cache'));
//
//var_dump($cache->cacheData('test-cache', null));

//var_dump($_SERVER);
//var_dump($_REQUEST);

$cacheFile = new CacheFile();
$cacheData = $cacheFile->cacheData($_SERVER['REQUEST_URI']);
if (!$cacheData) {
    $cacheData = Response::getArticleList();
    $cacheFile->cacheData($_SERVER['REQUEST_URI'], $cacheData, 50);
}

echo Encode::encoder(200, "", $cacheData, $format);