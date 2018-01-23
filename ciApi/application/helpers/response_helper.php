<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/23
 * Time: 下午2:05
 */
defined('BASEPATH') OR exit('No direct script access allowed');


if (!function_exists('jsonResult')) {
    function jsonResponse($status = 200, $message = '', $data = NIL)
    {
        header("Content-Type: " . "application/json");
        $result = array('status' => $status,
            'message' => $message);
        if (!empty($data)) {
            $result['data'] = $data;
        }
        $json_encode = json_encode($result);
        echo $json_encode;
    }
}

