<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/31
 * Time: 上午10:57
 */

class BaseController extends CI_Controller
{

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('response');
    }

    /**
     * 当前登陆用户信息
     */
    public function user()
    {
        static $user;
        if (isset($user)) {
            return $user;
        }
        $userdata = $this->session->get_userdata();
        if (isset($userdata) && isset($userdata['userId'])) {
            $result = $this->db->get_where('user', array('id' => $userdata['userId']));
            $row = $result->row();
            $user = array(
                'id' => $row->id,
                'name' => $row->name,
                'email' => $row->email
            );
        } else {
            jsonResponse(204, "user not login!");
            exit();
        }
    }
}