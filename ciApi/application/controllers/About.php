<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/29
 * Time: 下午1:41
 */
class About extends CI_Controller
{

    /**
     * About constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 关于我们界面
     */
    public function info()
    {
        $this->load->view("About/about");
    }

}