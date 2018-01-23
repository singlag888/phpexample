<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/23
 * Time: 下午2:20
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('response');
    }

    public function register()
    {
        $this->load->helper('date');

        $name = $this->input->post("name", true);
        $pwd = $this->input->post("pwd", true);
        $email = $this->input->post("email", true);
        if (empty($name) || empty($pwd) || empty($email)) {
            jsonResponse(204, "params error!");
            return;
        }
        if (strlen($name) > 12) {
            jsonResponse(211, "user name is too long!");
            return;
        }

        $preg_match = preg_match('/^[a-zA-Z0-9]{32}$/', $pwd);
        if (!$preg_match) {
            jsonResponse(212, 'password error!');
            return;
        }

        //检测用户是否注册过
        $exitUser = $this->db->or_where(array("name" => $name, "email" => $email))
            ->get('user');
        if ($exitUser->row()) {
            jsonResponse(213, 'user existed!');
            return;
        }

        $data = array(
            'name' => $name,
            'pwd' => $pwd,
            'email' => $email,
            'create_time' => mdate('%Y-%m-%d %H:%m:%s')
        );
        $result = $this->db->insert('user', $data);
        if (!$result) {
            jsonResponse(215, 'create user error! Please do it later ');
            return;
        }

        jsonResponse(200, 'success');
    }

    public function login()
    {
        $name = $this->input->post("name", true);
        $pwd = $this->input->post("pwd", true);

        if (empty($name) || empty($pwd)) {
            jsonResponse(204, "params error!");
            return;
        }
        if (strlen($name) > 12) {
            jsonResponse(211, "user name is too long!");
            return;
        }

        $preg_match = preg_match('/^[a-zA-Z0-9]{32}$/', $pwd);
        if (!$preg_match) {
            jsonResponse(212, 'password error!');
            return;
        }

        //条件分组查询
//SELECT *
//FROM `user`
//WHERE   (
//    `name` = 'hello@'
//    OR `email` = 'hello@'
//)
//AND `pwd` = '58F9C633A109D2EE2DB1735C1D5B2D50'

        $exitUser = $this->db
            ->group_start()
            ->or_where(array('name' => $name, 'email' => $name))
            ->group_end()
            ->where('pwd', $pwd)
            ->get('user');
        $row = $exitUser->row();
        if (!$row) {
            jsonResponse(216, 'name or password error!');
            return;
        }
        jsonResponse(200, 'success');
    }

    public function changePwd()
    {

    }
}