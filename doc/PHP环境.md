PHP环境
=======

## MAMP 
Mac下使用集成环境[MAMP免费版](https://www.mamp.info/en/)  

免费版更改php版本
在`/Applications/MAMP/bin/php`路径下将`php7.1.8`文件夹名称改下，默认会显示最新的两个版本。

`apache`配置文件路径 
`/Applications/MAMP/conf/apache/httpd.conf`

`apache`log文件路径
`/Applications/MAMP/bin/apache2/logs`



## Redis安装
[Redis安装](https://redis.io/download)  


### PHP安装redis扩展

下载phpredis，并编译so文件
```
#cd /Applications/MAMP/bin/php/php5.6.31
#git clone git@github.com:phpredis/phpredis.git
#cd phpredis
#/Applicatioins/MAMP/bin/php/php5.6.31/bin/phpize
#./configure --width-php-config=/Applications/MAMP/bin/php/php5.6.31/bin/php-config
#make
#cp -p modules/redis.so /Applications/MAMP/bin/php/php5.6.31/lib/php/extensions/no-debug-non-zts-20131226
```

更改php.ini
打开`/Applications/MAMP/bin/php/php5.6.31/conf/php.ini`，在文件最后添加

```
[Redis]
extension=redis.so
```

php操作redis

```
<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$redis->set('hello', 'world321');

echo 'key:hello value:' . $redis->get('hello').'<br>';
echo 'key:what? value:' . $redis->get('what?').'<br>';
echo $redis->delete('hello').'<br>';
echo 'key:hello value:' . $redis->get('hello');

```


