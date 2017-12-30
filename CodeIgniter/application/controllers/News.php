<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/28
 * Time: 下午7:18
 */
class News extends CI_Controller
{

    /**
     * News constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('NewsModel');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        $data['news'] = $this->NewsModel->get_news();
        $data['title'] = 'News archive';

        $this->load->view('templates/header', $data);
        $this->load->view('news/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = null)
    {
        if (empty($slug)) $slug = $_GET['slug'];
        $data['news_item'] = $this->NewsModel->get_news($slug);

        if (empty($data['news_item'])) {
            show_404();
        }

        $data['title'] = $data['news_item']['title'];

        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === false) {
            $this->load->view('templates/header', $data);
            $this->load->view('news/create', $data);
            $this->load->view('templates/footer');
        } else {
            $this->NewsModel->set_news();
            $this->load->view('news/success');
        }
    }
}