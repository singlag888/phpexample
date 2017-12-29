<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/28
 * Time: 下午7:05
 */
class NewsModel extends CI_Model
{

    /**
     * NewsModel constructor.
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function get_news($slug = false)
    {
        if ($slug == false) {
            $var = $this->db->get('news');
            return $var->result_array();
        }
        $query = $this->db->get_where('news', array('slug' => $slug));
        return $query->row_array();
    }

    public function set_news()
    {
        $this->load->helper('url');

        $slug = url_title($this->input->post('title'), 'dash', true);

        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $slug,
            'text' => $this->input->post('text'),
        );
        return $this->db->insert('news', $data);
    }


}