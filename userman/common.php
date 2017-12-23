<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/11/16
 * Time: 下午3:37
 */
function getLastTime()
{
    date_default_timezone_set('UTC');

    if (!empty($_COOKIE)) {
        echo "上次登陆时间：" . $_COOKIE['last_visit_time'];
        setcookie("last_visit_time", date("Y-m-d H:i:s"), time() + 24 * 3600);
    } else {
        echo "第一次登陆";
        setcookie("last_visit_time", date("Y-m-d H:i:s"), time() + 24 * 3600);
    }
}

function getCookie($key)
{
    if (!empty($_COOKIE[$key])) {
        return $_COOKIE[$key];
    } else {
        return "";
    }
}

function checkUserLegal()
{
    session_start();
    if (empty($_SESSION['id'])) {
        header("Location:login.php?errNo=1");
    }
}