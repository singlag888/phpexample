<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/11/16
 * Time: 下午5:21
 */


echo $_GET['param'];

//var_dump($_GET);
var_dump($_POST);

echo $_POST['params']."<br/>";

echo $_POST['dou']."<br/>";
echo $_POST['douhao']."<br/>";

echo urldecode($_POST['dou']);

echo urldecode(urldecode($_POST['douhao']));

echo "end";