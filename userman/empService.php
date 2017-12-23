<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/11/17
 * Time: 下午1:59
 */
require_once 'SqlHelper.php';

class empService
{
    //计算pageCount
    public function getPageCount($pageSize)
    {
        $sqlHelper = new SqlHelper();
        $sql = "select count(id) from user";
        $res = $sqlHelper->execute_sql($sql);
        if ($row = mysql_fetch_row($res)) {
            $rowCount = $row[0];
        }
        $pageCount = ceil($rowCount / $pageSize);
        mysql_free_result($res);
        $sqlHelper->close_connect();
        return $pageCount;
    }

    //取出结果集
    public function getRes($pageNow, $pageSize)
    {
        $sqlHelper = new SqlHelper();
        $sql = "select id,name,grade,email,salary from user limit " . ($pageNow - 1) * $pageSize . ",$pageSize";
        $res = $sqlHelper->execute_dql2($sql);
        $sqlHelper->close_connect();
        return $res;
    }

    //分页
    public function getFenyePage($fenyePage)
    {
        $sqlHelper = new SqlHelper();
        $sql1 = "select id,name,grade,email,salary from user limit " . ($fenyePage->pageNow - 1) * $fenyePage->pageSize . ",$fenyePage->pageSize";
        $sql2 = "select count(id) from user";
        $sqlHelper->execute_dql_fenye($sql1, $sql2, $fenyePage);
        $sqlHelper->close_connect();
    }

    //删除用户
    public function deleteById($id)
    {
        $sqlHelper = new SqlHelper();
        $sql = "delete from user where id=$id";
        return $sqlHelper->execute_dml($sql) or die(mysql_errno());
        $sqlHelper->close_connect();
    }

    //添加用户
    public function addEmp($name, $grade, $email, $salary)
    {
        $sqlHelper = new SqlHelper();
        $sql = "insert into user(name,grade,email,salary) values ('$name','$grade','$email','$salary')";
        return $sqlHelper->execute_dml($sql) or die(mysql_errno());
        $sqlHelper->close_connect();
    }

    //查询用户
    public function selectEmp($name)
    {
        $sqlHelper = new SqlHelper();
        $sql = "select * from user where name like '%$name'";
        $res = $sqlHelper->execute_dql2($sql) or die(mysql_errno());
        $sqlHelper->close_connect();
        return $res;
    }

    //修改用户
    public function updateEmp($id, $name, $grade, $email, $salary)
    {
        $sqlHelper = new SqlHelper();
        $sql = "update user set name='$name',grade='$grade',email='$email',salary='$salary' where id=$id";
        return $sqlHelper->execute_dml($sql) or die(mysql_errno());
        $sqlHelper->close_connect();
    }


}