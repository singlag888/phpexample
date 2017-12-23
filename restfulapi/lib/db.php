<?php
/**
 * 连接数据库
 * User: hello
 * Date: 2017/12/22
 * Time: 下午1:47
 */

$servername = "localhost";
$username = "root";
$password = "root";
$db = new PDO("mysql:host=$servername;dbname=api",$username,$password);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
return $db;