<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/15
 * Time: 下午1:18
 * App相关接口
 */
class App extends CI_Controller
{
    /**
     * App constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    /**
     * App升级接口
     * 返回当前应用版本最新一条数据
     */
    public function version()
    {
        $packageName = $this->input->get("name");
        if (empty($packageName)) {
            echo $this->jsonResult(200, 'params error!', null);
            return;
        }


        $query = $this->db->query('select * from version WHERE app_package_name=? ORDER BY version_name DESC limit 1', $packageName);
        $row = $query->row();

        if (isset($row)) {
            $data = array('versionName' => $row->version_name,
                'url' => $row->url,
                'forceUpdate' => $row->force_update + 0,
                'updateContent' => $row->update_content,
                'publishDate' => $row->publish_date);
            $jsonResult = $this->jsonResult(200, 'success', $data);
            echo $jsonResult;
        } else {
            echo $this->jsonResult(204, 'not result!', null);
            return;
        }
    }

    /**
     * test list json return
     */
    public function versionList()
    {
        $query = $this->db->query('select * from version limit 1');
        $row = $query->row();

        $data = array('versionName' => $row->version_name,
            'url' => $row->url,
            'forceUpdate' => $row->force_update + 0,
            'updateContent' => $row->update_content,
            'publishDate' => $row->publish_date);

        for ($i = 0; $i < 10; $i++) {
            $result[] = $data;
        }

        $jsonResult = $this->jsonResult(200, 'success', $result);
        echo $jsonResult;
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