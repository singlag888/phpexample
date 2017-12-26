<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/25
 * Time: 下午5:42
 */

require_once 'SingleDb.php';

class Response
{
    public static function getArticleList()
    {
        $page = $_GET['page'] != null ? $_GET['page'] : 1;
        $size = $_GET['size'] != null ? $_GET['size'] : 10;
        $page = ($page - 1) * $size;
        if ($page < 0) $page = 0;
        $sql = 'select * from `article` LIMIT :page,:size';
        $PDO = SingleDb::getPdoInstance();
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':page', $page);
        $stmt->bindParam(':size', $size);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}