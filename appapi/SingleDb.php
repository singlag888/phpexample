<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/25
 * Time: 下午3:30
 */

class SingleDb
{

    /**
     * @var SingleDb
     */
    private static $instance;

    /**
     * SingleDb constructor.
     */
    private function __construct()
    {
        echo "SingleDb construct";
    }

    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    private static $pdoInstance;

    /**
     * @return PDO
     */
    public static function getPdoInstance()
    {
        if (self::$pdoInstance == null) {
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $db = new PDO("mysql:host=$servername;dbname=api", $username, $password);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            self::$pdoInstance = $db;
        }
        return self::$pdoInstance;
    }

}
/*
try {
    echo 'hello';

//    $singleDb = new SingleDb();

    $db = SingleDb::getInstance();
    var_dump($db);
    $db = SingleDb::getInstance();
    var_dump($db);
    $db = SingleDb::getInstance();
    var_dump($db);
    $db = SingleDb::getInstance();
    var_dump($db);

} catch (Throwable $e) {
    var_dump($e);
}*/