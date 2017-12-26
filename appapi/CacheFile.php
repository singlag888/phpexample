<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/25
 * Time: 下午12:44
 */
class CacheFile
{
    private $dir;
    private $EXT = '-log';

    /**
     * CacheFile constructor.
     */
    public function __construct()
    {
        $this->dir = dirname(__FILE__) . '/files/';
    }

    public function cacheData($key, $value = '', $cacheTime = 0, $path = '')
    {
        $filename = $this->dir . $path . $key . $this->EXT;
        if ($value !== '') {
            if ($value === null) {
                return unlink($filename);
            }
            $dir = dirname($filename);
            if (!is_dir($dir)) {
                mkdir($dir, 0777);
            }

            $cacheTime = sprintf('%011d', $cacheTime);

            return file_put_contents($filename, $cacheTime . json_encode($value));
        }
        if (is_file($filename)) {
            $content = file_get_contents($filename);
            $cacheTime = substr($content, 0, 11);
            $content = substr($content, 11);
            //缓存失效删除文件
            if ($cacheTime != 0 && ($cacheTime + filectime($filename) < time())) {
                unlink($filename);
                return false;
            }
            return json_decode($content, true);
        }
    }
}

$cacheFile = new CacheFile();
//$cacheFile->cacheData('ehllo', 'what the wrong with you?', 15);
echo $cacheFile->cacheData('ehllo');