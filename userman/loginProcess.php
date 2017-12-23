<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/11/16
 * Time: 下午3:43
 */
require_once 'adminService.php';

if (!empty($_POST['cookie'])) {
    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
        setcookie("username", "$username", time() + 300);
    }
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
        setcookie("password", "$password", time() + 300);
    }
} else {
    if (!empty($_POST['username'])) {
        $username = $_POST['username'];
    }
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
    }
}

$adminService = new adminService();
if ($id = $adminService->checkUser($username, $password)) {
    //合法
    session_start();
    $_SESSION['id'] = $id;
    header("Location:Main.php?id=$id");
    exit();
} else {
    //非法
    header("Location:login.php?errNo=2");
    exit();
}