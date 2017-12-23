<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/22
 * Time: 下午12:51
 */

//ini_set("error_reporting", true);
//error_reporting(E_ALL);

function exceptionHandlerFunc($errObj)
{
    var_dump($errObj);
}

set_exception_handler('exceptionHandlerFunc');


require_once __DIR__ . "/lib/user.php";
require_once __DIR__ . "/lib/Article.php";
$pdo = require_once __DIR__ . "/lib/db.php";


$user = new User($pdo);
$article = new Article($pdo);

//echo "aa";
//print_r($user->register("admin","admin"));
//print_r($user->login('admin','adminaa'));
//for ($i = 0; $i < 10; $i++){
//    print_r($article->create("title3", "3conhelllo wolrd", 2));
//    print_r($article->create("title3", "3conhelllo wolrd", 2));
//}
//print_r($article->view(1));
//print_r($article->edit(1,"test change","change content you",2));
//print_r($article->delete(1,2));
//print_r($article->getArtList(2));
var_dump($_SERVER);