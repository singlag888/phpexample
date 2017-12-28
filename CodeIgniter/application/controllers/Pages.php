<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/28
 * Time: 上午8:18
 */
class Pages extends CI_Controller
{

    public function view($page = 'home')
    {
        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
            show_404();
        }
        $data['title']  = ucfirst($page);

        $this->load->view('templates/header',$data);
        $this->load->view('pages/'.$page,$data);
        $this->load->view('templates/footer',$data);

    }
}