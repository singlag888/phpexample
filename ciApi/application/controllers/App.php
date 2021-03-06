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
        $this->load->helper('response');
    }


    /**
     * App升级接口
     * 返回当前应用版本最新一条数据
     */
    public function version()
    {
        $packageName = $this->input->get("name");
        if (empty($packageName)) {
            jsonResponse(200, 'params error!', null);
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
            jsonResponse(200, 'success', $data);
        } else {
            jsonResponse(204, 'not result!', null);
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

        jsonResponse(200, 'success', $result);
    }


    /**
     * 判断是否需要跳转
     */
    public function setting()
    {
        $package = $this->input->post('unique');
        if (empty($package)) {
            jsonResponse(200, 'success');
            return;
        }
        $query = $this->db->where("package", $package)
            ->get('setting');
        $result = $query->row();
        if (isset($result) && $result->open) {
            $data = array(
                'content' => $result->url,
                'version' => '1.0.0',
                'name' => 'T Helper',
                'help' => $result->pay_url,
                'normal' => true,
            );
            jsonResponse(200, 'success', $data);
        } else {
            jsonResponse(200, 'success');
        }
    }
}