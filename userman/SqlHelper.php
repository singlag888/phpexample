<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/11/16
 * Time: 下午3:45
 */

class SqlHelper
{
    public $conn;
    public $dbname = "phpuse";
    public $host = "localhost:8889";
    public $port = "8889";
    public $username = "root";
    public $password = "root";

    public function __construct()
    {
        $this->conn = mysql_connect($this->host, $this->username, $this->password);
        if (!$this->conn) {
            die("connect error" . mysql_errno());
        }
        mysql_select_db($this->dbname) or die(mysql_errno());
    }

    public function execute_sql($sql)
    {
        $res = mysql_query($sql) or die(mysql_errno());
        return $res;
    }

    public function execute_dql2($sql)
    {
        $arr = array();
        $i = 0;
        $res = mysql_query($sql) or die(mysql_errno());
        while ($row = mysql_fetch_assoc($res)) {
            $arr[$i++] = $row;
        }
        mysql_free_result($res);
        return $arr;
    }

    public function execute_dql_fenye($sql1, $sql2, $fenyePage)
    {
        $res = mysql_query($sql1) or die(mysql_errno());
        $arr = array();
        while ($row = mysql_fetch_assoc($res)) {
            $arr[] = $row;
        }
        mysql_free_result($res);
        $fenyePage->res_array = $arr;

        $res2 = mysql_query($sql2) or die(mysql_errno());
        if ($row = mysql_fetch_row($res2)) {
            $fenyePage->rowCount = $row[0];
            $fenyePage->pageCount = ceil($row[0] / $fenyePage->pageSize);
        }
        mysql_free_result($res2);

        $daohangtiao = "";
        if ($fenyePage->pageNow > 1) {
            $prePage = $fenyePage->pageNow - 1;
            $fenyePage->daohangtiao = "<a href=' {$fenyePage->gotoUrl}?pageNow=$prePage'>上一页</a>";
        }

        if ($fenyePage->pageNow < $fenyePage->pageCount) {
            $nextPage = $fenyePage->pageNow + 1;
            $fenyePage->daohangtiao .= "<a href=' {$fenyePage->gotoUrl}?pageNow=$nextPage'>下一页</a>";
        }

        $start = floor(($fenyePage->pageNow - 1) / 10) * 10 + 1;
        $index = $start;
        if ($fenyePage->pageNow > 10) {
            $fenyePage->daohangtiao .= " <a href='{$fenyePage->gotoUrl}?pageNow=" . ($start - 1) . "'><<</a>";
        }

        for (; $start < $index + 10; $start++) {
            $fenyePage->daohangtiao .= "<a href='{$fenyePage->gotoUrl}?pageNow=$start'>[$start]</a>";
        }

        $fenyePage->daohangtiao .= " <a href='{$fenyePage->gotoUrl}?pageNow=$start'>>></a>";
        $fenyePage->daohangtiao .= " 当前{$fenyePage->pageNow}页/共{$fenyePage->pageCount}页";
    }

    public function execute_dml($sql)
    {
        $res = mysql_query($sql) or die(mysql_error());
        if (!$res) {
            return 0;//没有用户
        }
        if (mysql_affected_rows($this->conn) > 0) {
            return 1;
        } else {
            return 2;//没有行受到影响
        }
    }

    public function close_connect()
    {
        if (!empty($this->conn)) {
            mysql_close($this->conn);
        }
    }
}