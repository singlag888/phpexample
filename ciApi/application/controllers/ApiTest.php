<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/16
 * Time: 下午8:56
 */
class ApiTest extends CI_Controller
{


    /**
     * ApiTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function postString()
    {
        $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
        if ($REQUEST_METHOD == "GET") {
            echo $this->jsonResult(400, "Request method not allowed", NIL);
            exit(1);
//            throw new Exception("hello exception");
        }
        $file_get_contents = file_get_contents("php://input");
        echo $this->jsonResult(200, "success", $file_get_contents);
    }

    public function postJson()
    {
        echo "postJson";
    }

    public function postFile()
    {
        $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
        if ($REQUEST_METHOD == "GET") {
            echo $this->jsonResult(400, "Request method not allowed", NIL);
            exit(1);
//            throw new Exception("hello exception");
        }
        $CONTENT_TYPE = $_SERVER['CONTENT_TYPE'];
        if ($CONTENT_TYPE == "application/octet-stream") {
            $file_get_contents = file_get_contents("php://input");

            $dir = "upload";
            if (!is_dir($dir)) mkdir($dir);
            $md5 = md5(uniqid(mt_rand()));
            $destFile = $dir . "/" . $md5 . "img1.jpg";

            $file_put_contents = file_put_contents($destFile, $file_get_contents, true);
//            $copy = copy($file_get_contents, $destFile);
            if ($file_put_contents) {
                echo $this->jsonResult(200, "Success", NIL);
            } else {
                echo $this->jsonResult(400, "Upload Failure", NIL);
            }

        } else {
            echo $this->jsonResult(400, "Request contentType not allowed", NIL);
            exit(1);
        }
    }

    public function jsonResult($status = 200, $message = '', $data)
    {
        header("Content-Type: " . "application/json");
        $result = array('status' => $status,
            'message' => $message);
        if (!empty($data)) {
            $result['data'] = $data;
        }
        $json_encode = json_encode($result);
        return $json_encode;
    }
}