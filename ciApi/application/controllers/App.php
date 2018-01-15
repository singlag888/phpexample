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
        $query = $this->db->query('select * from version limit 1');
        $row = $query->row();

        $data = array('versionName' => $row->version_name,
            'url' => $row->url,
            'forceUpdate' => $row->force_update + 0,
            'updateContent' => $row->update_content,
            'publishDate' => $row->publish_date);

        $jsonResult = $this->jsonResult(200, 'success', $data);
        echo $jsonResult;
    }

    public function jsonResult($status = 200, $message = '', $data)
    {
        $result = array('status' => $status,
            'message' => $message,
            'data' => $data);
        return json_encode($result);
    }

}