<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/27
 * Time: 上午8:31
 */

class PdoMySql
{
    /***
     * 设置连接参数，配置信息
     * @var array
     */
    public static $config = array();
    /**
     * 保存连接标识符
     * @var  PDO
     */
    public static $link = null;
    /**
     * 是否开启长连接
     * @var bool
     */
    private static $pconnect = false;
    /**
     * 数据库版本
     * @var mixed
     */
    private static $dbVersion = null;
    /**
     * 是否连接成功
     * @var bool
     */
    private static $connected = false;
    /**
     * @var PDOStatement
     */
    private static $PDOStatement = null;
    /**
     * 保存最后执行的sql语句
     * @var null
     */
    private static $queryStr = null;
    /**
     * 错误信息
     * @var null
     */
    private static $error = null;
    /**
     * 最后插入的记录行号
     * @var int
     */
    private static $lastInsertId = null;
    /**
     * 上一步操作受影响的条数
     * @var
     */
    private static $numRows;


    /**
     * PdoMySql constructor.
     * @param string $dbConfig
     */
    public function __construct($dbConfig = '')
    {
        if (!class_exists("PDO")) {
            self::throwException('不支持PDO,请先开启');
        }
        if (!is_array($dbConfig)) {
            $dbConfig = array(
                'hostname' => DB_HOST,
                'username' => DB_USER,
                'password' => DB_PWD,
                'database' => DB_NAME,
                'hostport' => DB_PORT,
                'dbms' => DB_TYPE,
                'dsn' => DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME
            );
        }
        if (empty($dbConfig['hostname'])) {
            self::throwException("没有定义数据库配置，请先定义");
        }
        self::$config = $dbConfig;
        if (empty(self::$config['params'])) {
            self::$config['params'] = array();
        }
        if (!isset(self::$link)) {
            $configs = self::$config;
            if (self::$pconnect) {
                //开启长连接，添加到配置数组中
                $configs['params'][constant('PDO::ATTR_PERSISTENT')] = true;
            }
            try {
                self::$link = new PDO($configs['dsn'], $configs['username'], $configs['password'], $configs['params']);
            } catch (PDOException $e) {
                self::throwException($e->getMessage());
            }
            if (!self::$link) {
                self::throwException("PDO连接错误");
                return false;
            }
            self::$link->exec('SET NAMES ' . DB_CHARSET);

            self::$dbVersion = self::$link->getAttribute(constant('PDO::ATTR_SERVER_VERSION'));
            self::$connected = true;
            unset($configs);

        }
    }

    /**
     * 查询所有记录
     * @param null $sql
     * @return array
     */
    public static function getAll($sql = null)
    {
        if ($sql != null) {
            self::query($sql);
        }
        $result = self::$PDOStatement->fetchAll(constant('PDO::FETCH_ASSOC'));
        return $result;
    }

    /**
     * 查询一条记录
     * @param null $sql
     * @return mixed
     */
    public static function getRow($sql = null)
    {
        if ($sql != null) {
            self::query($sql);
        }
        $res = self::$PDOStatement->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    /**
     * 根据id查找某个记录
     * @param $tableName
     * @param $printId
     * @param string $fields
     * @return mixed
     */
    public static function findById($tableName, $printId, $fields = "*")
    {
        $sql = 'select %s from %s where id=%d';
        return self::getRow(sprintf($sql, self::parseFields($fields), $tableName, $printId));
    }


    /**
     * @param $table
     * @param string $fields
     * @param string $where
     * @param string $group
     * @param string $having
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function find($table, $fields = '*', $where = null, $group = null, $having = null, $order = null, $limit = null)
    {
        $sql = 'select ' . self::parseFields($fields) . ' from ' . $table
            . self::parseWhere($where)
            . self::parseGroup($group)
            . self::parseHaving($having)
            . self::parseOrder($order)
            . self::parseLimit($limit);
        $data = self::getAll($sql);
        return count($data) == 1 ? $data[0] : $data;
    }

    /**
     * 增加数据
     * @param $table
     * @param $data
     * @return bool|int
     */
    public static function add($table, $data)
    {
        $keys = array_keys($data);
        array_walk($keys, array('PdoMySql', 'addSpecialChar'));
        $fieldsStr = join(',', $keys);
        $values = "'" . join("','", array_values($data)) . "'";
        $sql = "insert into {$table} ({$fieldsStr}) VALUES ({$values})";
        return self::execute($sql);
    }

    /**
     * 更新记录
     * @param $table
     * @param $data
     * @param null $where
     * @param null $order
     * @param string $limit
     * @return string
     */
    public static function update($table, $data, $where = null, $order = null, $limit = null)
    {
        $sets = '';
        foreach ($data as $key => $val) {
            $sets .= $key . "='" . $val . "', ";
        }
        $sets = rtrim($sets, ', ');
        $sql = "update {$table} set {$sets} "
            . self::parseWhere($where)
            . self::parseOrder($order)
            . self::parseLimit($limit);
        return self::execute($sql);
    }

    /**
     * 删除操作
     * @param $table
     * @param null $where
     * @param null $order
     * @param null $limit
     * @return bool|int
     */
    public static function delete($table, $where = null, $order = null, $limit = null)
    {
        $sql = "delete from {$table} "
            . self::parseWhere($where)
            . self::parseOrder($order)
            . self::parseLimit($limit)
            . ';';
        return self::execute($sql);
    }

    /**
     * 返回最后执行的sql语句
     * @return bool|string
     */
    public static function getLastSql()
    {
        $link = self::$link;
        if (!$link) return false;
        return self::$queryStr;
    }

    /**
     * 返回 上一步操作产生的AUTO_INCREMENT
     * @return bool|int
     */
    public static function getLastInsertId()
    {
        $link = self::$link;
        if (!$link) return false;
        return self::$lastInsertId;
    }


    /**
     * 返回数据库版本
     * @return bool|mixed
     */
    public static function getDbVersion()
    {
        $link = self::$link;
        if (!$link) return false;
        return self::$dbVersion;
    }

    public static function showTables()
    {
        $tables = array();
        if (self::query('show tables')) {
            $result = self::getAll();
//            var_dump($result);
            foreach ($result as $key => $val) {
                $tables[$key] = current($val);
            }
        }
        return $tables;
    }


    /**
     * 解析字段
     * @param $fields
     * @return string
     */
    private static function parseFields($fields)
    {
        if (is_array($fields)) {
            array_walk($fields, array('PdoMySql', 'addSpecialChar'));
            $fieldStr = implode(',', $fields);
        } elseif (is_string($fields) && !empty($fields)) {
            if (strpos($fields, '`') === false) {
                $fields = explode(',', $fields);
                array_walk($fields, array('PdoMySql', 'addSpecialChar'));
                $fieldStr = implode(',', $fields);
            } else {
                $fieldStr = $fields;
            }
        } else {
            $fieldStr = "*";
        }
        return $fieldStr;
    }

    /**
     * 解析where 字段
     * @param $where
     * @return string
     */
    private static function parseWhere($where)
    {
        if (is_string($where) && !empty($where)) {
            $whereStr = $where;
        }
        return empty($whereStr) ? '' : ' where ' . $whereStr;
    }

    /**
     * 解析分组
     * @param $group
     * @return string
     */
    private static function parseGroup($group)
    {
        if (is_array($group)) {
            $groupStr = ' group by ' . implode(',', $group);
        } elseif (is_string($group) && !empty($group)) {
            $groupStr = ' group by ' . $group;
        }
        return empty($groupStr) ? '' : $groupStr;
    }

    /**
     * 对分组结果通过having子句进行二次筛选
     * @param $having
     * @return string
     */
    private static function parseHaving($having)
    {
        if (is_string($having) && !empty($having)) {
            $havingStr = ' having ' . $having;
        }
        return empty($havingStr) ? '' : $havingStr;
    }

    /**
     * 解析 order by
     * @param $order
     * @return string
     */
    private static function parseOrder($order)
    {
        if (is_array($order)) {
            $orderStr = ' order by ' . join(',', $order);
        } elseif (is_string($order) && !empty($order)) {
            $orderStr = ' order by ' . $order;
        }
        return empty($orderStr) ? '' : $orderStr;
    }

    /**
     * 解析限制显示条数 Limit
     * limit 3
     * limit 0,3
     * @param $limit
     * @return string
     */
    private static function parseLimit($limit)
    {
        if (is_array($limit)) {
            if (count($limit) > 1) {
                $limitStr = ' limit ' . $limit[0] . ',' . $limit[1];
            } else {
                $limitStr = ' limit ' . $limit[0] . ' ';
            }
        } elseif (is_string($limit) && !empty($limit)) {
            $limitStr = ' limit ' . $limit;
        }
        return $limitStr;
    }


    public function addSpecialChar(&$value)
    {
        if ($value === '*' || strpos($value, '.') !== false || strpos($value, '`') !== false) {
            //不用处理
        } elseif (strpos($value, '`') === false) {
            $value = '`' . trim($value) . '`';
        }
        return $value;
    }


    /**
     * 执行 增，删，改操作，返回 受影响条数
     * @param null $sql
     * @return bool|int
     */
    public static function execute($sql = null)
    {
        $link = self::$link;
        if (!$link) return false;
        self::$queryStr = $sql;
        if (!empty(self::$PDOStatement)) self::free();
        $result = $link->exec(self::$queryStr);
        self::haveErrorThrowException();
        if ($result) {
            self::$lastInsertId = $link->lastInsertId();
            self::$numRows = $result;
            return self::$numRows;
        } else {
            return false;
        }
    }

    public static function query($sql = '')
    {
        $link = self::$link;
        if (!$link) return false;
        //判断之前是否有结果集，如果有的话，释放结果集
        if (!empty(self::$PDOStatement)) self::free();
        self::$queryStr = $sql;
        self::$PDOStatement = $link->prepare($sql);
        $res = self::$PDOStatement->execute();
        self::haveErrorThrowException();
        return $res;
    }

    /**
     * 释放结果集
     */
    public static function free()
    {
        self::$PDOStatement = null;
    }

    public static function haveErrorThrowException()
    {
        $obj = empty(self::$PDOStatement) ? self::$link : self::$PDOStatement;
        $errorInfo = $obj->errorInfo();
//        print_r($errorInfo);
        if ($errorInfo[0] != '00000') {
            self::$error = 'SQLSTATE ' . $errorInfo[0] . ' SQL ERROR ' . $errorInfo[2] .
                '<br/>ERROR SQL: ' . self::$queryStr;
            self::throwException(self::$error);
            return false;
        }
    }


    /**
     * 自定义错误处理
     * @param $msg
     */
    public function throwException($msg)
    {
        echo '<div style="width:80%;background-color:#ABCDEF;color:black;font-size:20px;padding:20px 0px;">'
            . $msg . '</div>';
    }

    /**
     * 关闭数据库
     */
    public static function close()
    {
        self::$link = null;
    }
}

//测试
//require_once '../Error.php';
//
//require_once 'dbConfig.php';
//$pdoMySql = new PdoMySql();
//var_dump($pdoMySql);
//$sql = 'select * from user where user_id=2';
//$all = $pdoMySql::getAll($sql);
//print_r($all);
//$sql = 'insert into company (name,email) VALUES
//("google11","google11@gmail.com"),
//("google12","google12@gmail.com"),
//("google13","google13@gmail.com")';
//$execute = $pdoMySql::execute($sql);
//var_dump($execute);

//$sql = 'update company set name="googleworld" where id=27';
//$execute1 = $pdoMySql::execute($sql);
//var_dump($execute1);
//$sql = 'select * from company where id>20';
//$execute = $pdoMySql::execute($sql);
//var_dump($execute);
//$tabName = 'company';
//$prid = '23';
////$fields = 'email';
//$fields = array('email');
//print_r($pdoMySql::findById($tabName, $prid, $fields));

//$table = 'company';
//$arr = $pdoMySql::find($table);
//print_r($arr);
//print_r($pdoMySql::find($table,'*','id>20'));
//print_r($pdoMySql::find($table,'email','id>20'));
//print_r($pdoMySql::find($table,'*','id>5','email'));
//print_r($pdoMySql::find($table,'*','id>0','email',"count(*)>2"));
//print_r($pdoMySql::find($table,'*','id>0','email',null,'id desc'));
//print_r($pdoMySql::find($table,'*','id>0','email',null,'id desc','3,5'));
//print_r($pdoMySql::add($table, array("name" => "sunny", "email" => "sunny@gmaile.com")));
//$data = array(
//    'name' => 'repeadt?',
//    'email' => 'google@gmail.com'
//);
//print_r($pdoMySql::update($table, $data, 'id>=20', 'id desc',"1"));
//print_r($pdoMySql::delete($table, 'id>=15', 'id desc', '1'));

//print_r($pdoMySql::showTables());
