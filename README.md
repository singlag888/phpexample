PHP 练习
=======


### [简单的雇员管理系统](http://blog.51cto.com/xxlixin1993/1581996)  
userman/index.php

### [WEB在线文件管理器](https://www.imooc.com/learn/94)
fileManager/index.php
在线版文件管理器，PHP对文件的操作和PHP对文件夹的操作。

### [Restful API](/restfulapi/README.md) 
restfulapi/index.php

### [PHP开发APP接口](https://www.imooc.com/learn/163)
appapi/index.php  

### PDO
pdo/app/index.php
[PDO—数据库抽象层](https://www.imooc.com/learn/164)  
[PHP 数据对象 PHP Data Object--官方文档](http://php.net/manual/zh/book.pdo.php#book.pdo)  


### 参考资源

[我想问一下PHP的学习路线图？](https://www.zhihu.com/question/27170424)  

[php-the-right-way](https://laravel-china.github.io/php-the-right-way/)  

[PHP 标准规范](https://psr.phphub.org/)  
1	基础编码规范  	
2	编码风格规范  	
3	日志接口规范  	
4	自动加载规范  	
6	缓存接口规范  	
7	HTTP 消息接口规范  	  


[用PHP写一个论坛](http://phpbook.phpxy.com/34745) 



## [composer](http://docs.phpcomposer.com/00-intro.html)  

安装依赖示例  
`composer require monolog/monolog`

将会更新`composer.json`和`composer.lock`文件，并将依赖库下载至`vendor`目录中。

使用指定版本PHP版本下载依赖  
`/usr/local/php5.6/bin/php composer.phar update`


## 使用Swiftmailer和Gmail发送邮件

需要在Google中`开启` [允许不够安全的应用](https://myaccount.google.com/security?utm_source=OGB&utm_medium=act&pli=1#signin)

```php
require_once 'vendor/autoload.php';

$transport = new Swift_SmtpTransport('smtp.gmail.com', 465);
$transport->setUsername("name@gmail.com")->setPassword("password")
->setAuthMode('login')->setEncryption('ssl');

$mailer = new Swift_Mailer($transport);

$message = (new Swift_Message('Wonderful Subject'))
    ->setFrom(['john@doe.com'=>"johon Doe"])
    ->setTo(['name@gmail.com'])
    ->setBody('Here is the message itself');

$result = $mailer->send($message);
var_dump($result);
```

参考：
[如何使用Gmail来发送邮件](http://www.symfonychina.com/doc/current/email/gmail.html)  