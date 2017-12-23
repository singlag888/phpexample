<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/21
 * Time: 上午9:12
 */
function alertMes($mes,$url){
    echo "<script type='text/javascript'>alert('{$mes}');location.href='{$url}'</script>";
}

function getExt($filename){
    return strtolower(pathinfo($filename,PATHINFO_EXTENSION));
}

function getUniqidName($length = 10){
    return substr(md5(uniqid(microtime(true),true)),0,$length);
}