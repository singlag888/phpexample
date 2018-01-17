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
        $this->_checkPostMethod();
        $file_get_contents = file_get_contents("php://input");
        echo $this->jsonResult(200, "success", $file_get_contents);
    }

    public function postJson()
    {
        echo "postJson";
    }


    public function postFile()
    {
        $this->_checkPostMethod();
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

    /**
     * form字段测试.所有类型测试
     */
    public function postForm1()
    {
        $this->_checkPostMethod();
        $string = $_POST['string'];
        $int = $_POST['int'];
        $float = $_POST['float'];
        $double = $_POST['double'];
        $date = array(
            'msg' => 'Receive Data',
            'string' => $string,
            'int' => $int,
            'float' => $float,
            'double' => $double);
        echo $this->jsonResult(200, "success", $date);
    }

    /**
     * form单文件测试
     */
    public function postForm2()
    {
        $this->_checkPostMethod();
        $getallheaders = getallheaders();
        $postFileHeader = $getallheaders['PostFileHeader'];
        $postFile = $_POST['PostFile'];

        $image = $_FILES['image'];
        $dir = 'upload';
        $uploadFile = $this->_uploadFile($dir, $image);
        $data = array(
            'headerMsg' => $postFileHeader,
            'postParam' => $postFile,
            'uploadFileResult' => $uploadFile
        );
        echo $this->jsonResult(200, 'success', $data);
    }

    /**
     * form多文件测试
     */
    public function postForm3()
    {
        $this->_checkPostMethod();
        $dir = 'upload';
        foreach ($_FILES as $FILE) {
            $uploadFile = $this->_uploadFile($dir, $FILE);
            $result[] = array('fileName' => $FILE['name'],
                'result' => $uploadFile);
        }
        $data['result'] = $result;
        $data['count'] = count($_FILES);
        echo $this->jsonResult(200, 'success', $data);
    }

    /**
     * head请求头测试
     *
     * head请求服务器如何处理？
     *
     * 向服务器索要与GET请求相一致的响应，只不过响应体将不会被返回。这一方法可以在不必传输整个响应内容的情况下，就可以获取包含在响应消息头中的元信息。
     *
     */
    public function headTest()
    {
        $this->_checkPostMethod();
    }

    public function otherTest()
    {
        $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
        if ($REQUEST_METHOD == "PUT") {
            $data = "put success";
        } elseif ($REQUEST_METHOD == "DELETE") {
            $data = "delete success";
        } elseif ($REQUEST_METHOD == "PATCH") {
            $data = "patch success";
        } else {
            echo $this->jsonResult(400, "Request method not allowed", NIL);
            exit(1);
        }

        echo $this->jsonResult(200, "success", $data);
    }


    private function _checkPostMethod()
    {
        $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
        if ($REQUEST_METHOD == "GET") {
            echo $this->jsonResult(400, "Request method not allowed", NIL);
            exit(1);
//            throw new Exception("hello exception");
        } elseif ($REQUEST_METHOD == 'HEAD') {
            exit();
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


    public function _uploadFile($path, $fileInfo, $allowExt = array("gif", "png", "jpg", "jpeg", "txt"), $maxSize = 1048576000)
    {
        if ($fileInfo['error'] == UPLOAD_ERR_OK) {
            //文件是否通过http post 方式上传
            if (is_uploaded_file($fileInfo['tmp_name'])) {
                //上传文件类型限制
                $ext = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $allowExt)) {
                    if ($fileInfo['size'] <= $maxSize) {
                        $uniqid = substr(md5(uniqid(microtime(true), true)), 0, 10);
                        $destFile = $path . "/" . pathinfo($fileInfo['name'], PATHINFO_FILENAME) . "_" . $uniqid . "." . $ext;
                        if (move_uploaded_file($fileInfo['tmp_name'], $destFile)) {
                            $msg = "upload success";
                        } else {
                            $msg = "upload failure";
                        }
                    } else {
                        $msg = "文件过大";
                    }
                } else {
                    $msg = "非法文件类型";
                }
            } else {
                $msg = "文件不是通过HTTP POST方式上传上来的";
            }
        } else {
            switch ($fileInfo['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    $msg = "超过了配置文件的大小";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $msg = "超过了表单允许数据的大小";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $msg = "文件部分被上传";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $msg = "没有文件被上传";
                    break;

            }
        }
        return $msg;
    }
}