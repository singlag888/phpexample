<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/26
 * Time: 上午10:10
 */


//$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
//1.通过参数形式连接数据库
try {
    $dsn = 'mysql:host=localhost;dbname=api';
    $name = 'root';
    $pwd = 'root';
    $pdo = new PDO($dsn, $name, $pwd);
//    var_dump($pdo);
//    echo 'autoCommit: '.$pdo->getAttribute(PDO::ATTR_AUTOCOMMIT);
//    echo 'DEFAULT_FETCH_MODE:'.$pdo->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE);
//    echo 'errmode:'.$pdo->getAttribute(PDO::ATTR_ERRMODE);

    //exec() 对于select没有作用
    //创建表
//    $sql = 'CREATE TABLE IF NOT EXISTS company(
//id INT UNSIGNED AUTO_INCREMENT KEY,
//name VARCHAR(30) NOT  NULL  UNIQUE ,
//email VARCHAR(30) NOT NULL
//)';
//    $exec = $pdo->exec($sql);
//    var_dump($exec);

    //插入数据
//    $sql = 'INSERT INTO company (name,email) VALUES ("dahua6","hua6@gmail.com");';
//    $exec1 = $pdo->exec($sql);
//    echo 'lastId:'.$pdo->lastInsertId();
//    var_dump($exec1);

    //更新数据 删除数据
//    $sql = 'UPDATE company set name="google2" where id=1';
//    $sql = 'delete from company where id=1;';
//    $sql = 'delete from compasdfa where id=1;';
//    $sql = 'select * from company where id<3';
//    $exec = $pdo->exec($sql);
//    var_dump($exec);
//    if ($exec===false) {
//        var_dump($pdo->errorCode());
//        $errorInfo = $pdo->errorInfo();
//        var_dump($errorInfo);
//        print_r($pdo->errorInfo());
//    }
//    echo "<br/>";
//    var_dump($pdo->lastInsertId());

    //query
//    $sql = 'select * from company WHERE id>3;';
//    $stmt = $pdo->query($sql);
//    var_dump($stmt);
//    foreach ($stmt as $key => $row) {
//        print_r($row);
//        echo '<br>';
//    }
//    stmtError($stmt, $pdo);

    //prepare
//    $sql = 'select * from company ;';
//    $stmt = $pdo->prepare($sql);
////    var_dump($stmt);
//    $stmt->execute();
//    $res = $stmt->fetch(PDO::FETCH_OBJ);
    //设置获取数据模式
//    $stmt->setFetchMode(PDO::FETCH_ASSOC);
//    $res = $stmt->fetchAll();
//    var_dump($res);
//    stmtError($stmt, $pdo);


    $username = $_POST['username'];
//    //quote  预防sql注入
//    $username = $pdo->quote($username);
//    $sql = "select * from company where name={$username}";
//    var_dump($sql);
//    $stmt = $pdo->query($sql);
//    var_dump($stmt);
//    $rowCount = $stmt->rowCount();
//    var_dump($rowCount);

    //prepare防止 sql注入 占位符 方式1
//    $sql = 'select * from company where name=:name';
//    $stmt = $pdo->prepare($sql);
//    $stmt->execute(array(":name" => $username));
//    var_dump($stmt);
//    echo $stmt->rowCount();
    //方式2 占位符
//    $sql = 'select * from company where name=?';
//    $stmt = $pdo->prepare($sql);
//    $stmt->execute(array($username));
//    var_dump($stmt->rowCount());

    //bindParam 方式1
//    $sql = 'insert into company (name,email) VALUES (:name,:email);';
//    $stmt = $pdo->prepare($sql);
//    $stmt->bindParam(':name',$name);
//    $stmt->bindParam(':email',$email);
//
//    $name = 'apple1';
//    $email = 'apple@goo.com';
//    $execute1 = $stmt->execute();
//    var_dump($execute1);
//
//    $name = 'apple2';
//    $email = 'apple2@goo.com';
//    $execute = $stmt->execute();
//    var_dump($execute);
    //方式2
//    $sql = 'insert into company (name,email) VALUES (?,?)';
//    $stmt = $pdo->prepare($sql);
//    $stmt->bindParam(1,$name,PDO::PARAM_STR);
//    $stmt->bindParam(2,$email);
//
//    $name='apple5';
//    $email='apple5@akj.com';
//    $execute = $stmt->execute();
//    var_dump($execute);

    //bindValue
//    $sql = 'insert into company (name,email) VALUES (?,?);';
//    $stmt = $pdo->prepare($sql);
//    $stmt->bindValue(2,"hello@gmail.com");
//    $stmt->bindParam(1,$name);
//    $name = 'hello1';
//    $execute = $stmt->execute();
//    var_dump($execute);
//
//    $name='hello2';
//    $execute1 = $stmt->execute();
//    var_dump($execute1);
//
//    $name='hello3';
//    $execute2 = $stmt->execute();
//    var_dump($execute2);


    //bindColumn
//    $sql = 'select * from company;';
//    $stmt = $pdo->prepare($sql);
//    $execute = $stmt->execute();
//    var_dump($execute);
//    $stmt->bindColumn(2,$name);
//    $stmt->bindColumn(3,$email);
//    while ($stmt->fetch(PDO::FETCH_BOUND)){
//        echo 'name:'.$name.' email:'.$email."<br>";
//    }

    //fetchColumn
//    $sql = 'select * from company';
//    $stmt = $pdo->prepare($sql);
//    $execute = $stmt->execute();
//    var_dump($execute);
//    echo $stmt->fetchColumn(0);
//    echo "<br>";
//    echo $stmt->fetchColumn(1);

    //debugDumpParams
//    $sql = 'insert into company (name,email) VALUES (?,?)';
//    $stmt = $pdo->prepare($sql);
//    $stmt->bindParam(1, $name);
//    $stmt->bindParam(2, $email);
//
//    $name = "google10";
//    $email = "google10@gmai.com";
//    $execute = $stmt->execute();
//    var_dump($execute);
//    echo $stmt->debugDumpParams();

//    $sql = 'call test1();';
//    $stmt = $pdo->prepare($sql);
//    $execute = $stmt->execute();
//    var_dump($execute);
//    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
//    print_r($res);
//
//    echo '<hr color="red"/>';
//
//    $nextRowset = $stmt->nextRowset();
//    var_dump($nextRowset);
//    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
//    print_r($res);

    //错误模式
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $sql = 'select * from whereuser;';
//    $stmt = $pdo->query($sql);
//    var_dump($stmt);
//    echo $pdo->errorInfo();


    //事务操作
//    $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
//    $pdo->beginTransaction();
//
//    $sql = 'update company set name="update" where id=10';
//    $exec = $pdo->exec($sql);
//    var_dump($exec);
//    if($exec==0){
//        throw new PDOException("操作失败");
//    }
//
//    $sql = 'update company set name="update2" where id=110';
//    $exec1 = $pdo->exec($sql);
//    var_dump($exec1);
//    if($exec1==0){
//        throw new PDOException("操作失败");
//    }
//
//    $pdo->commit();
} catch (PDOException $e) {
    $pdo->rollBack();
    echo var_dump($e);
}
/**
 * @param PDOStatement $stmt
 * @param PDO $pdo
 */
function stmtError($stmt, $pdo)
{
    if ($stmt === false) {
        var_dump($pdo->errorCode());
        var_dump($pdo->errorInfo());
    }
}

require_once '../vendor/autoload.php';

$log = new \Monolog\Logger('name');
$log->pushHandler(new \Monolog\Handler\StreamHandler(''))