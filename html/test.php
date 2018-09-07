<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/9/3
 * Time: 下午1:47
 */

$param1 = $_POST['param1'];
$param2 = $_POST['param2'];

if(empty($param1) || empty($param2)){
    echo json_encode(array('status'=>'error','msg'=>'please input parmas !'));
    return;
}

$json = json_encode(array('param1' => $param1, 'param2' => $param2));

echo $json;