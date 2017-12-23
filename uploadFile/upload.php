<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/11/16
 * Time: 下午1:27
 */

$uploaddir = 'uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';

echo $uploadfile . "<br/>";

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.<br/>";


} else {
    echo "Possible file upload attack!" . "<br/>";
    echo "Error: " . $_FILES['userfile']['error'] . "<br/>";
}

echo "Here is some more debugging info:" . "<br/>";

print_r($_FILES);


echo '</pre>';