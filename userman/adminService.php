<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/11/16
 * Time: 下午3:44
 */
require_once 'SqlHelper.php';

class adminService
{
    //验证用户名是否合法
    public function checkUser($username, $password)
    {
        $sqlHelper = new SqlHelper();

        $sql = "select password,id from login where name='" . $username . "'";

        $res = $sqlHelper->execute_sql($sql);

        if ($row = mysql_fetch_assoc($res)) {
            if ($row['password'] == md5($password)) {
                $id = $row['id'];
                return $id;
            } else {
                return null;
            }
        } else {
            return null;
        }
        mysql_free_result($res);
        $sqlHelper->close_connect();
    }
}