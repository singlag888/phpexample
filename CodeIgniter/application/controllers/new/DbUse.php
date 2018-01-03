<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/3
 * Time: 下午5:59
 */
class DbUse extends CI_Controller
{

    /**
     * DbUse constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->dbutil();
    }

    public function objectArray()
    {
//        echo 'Hello';
        $query = $this->db->query('select article_id,title,content,user_id,createAt from article');
        foreach ($query->result() as $row) {
            echo $row->article_id . '<br/>';
            echo $row->title . '<br/>';
            echo $row->content . '<br/>';
            echo $row->user_id . '<br/>';
            echo $row->createAt . '<br/>';
        }
        echo '<hr/>';
        echo 'Total Results: ' . $query->num_rows();

    }

    public function resultArray()
    {
        $query = $this->db->query('select article_id,title,content,user_id,createAt from article');
        foreach ($query->result_array() as $row) {
            echo $row['article_id'] . '<br/>';
            echo $row['title'] . '<br/>';
            echo $row['content'] . '<br/>';
            echo $row['user_id'] . '<br/>';
            echo $row['createAt'] . '<br/>';
            echo '<hr/>';
        }
    }


    public function singleObject()
    {
        $query = $this->db->query('select article_id,title,content,user_id,createAt from article limit 1');
        $row = $query->row();

        echo $row->article_id . '<br/>';
        echo $row->title . '<br/>';
        echo $row->content . '<br/>';
        echo $row->user_id . '<br/>';
        echo $row->createAt . '<br/>';


        echo '<hr/>';
    }

    public function singleArray()
    {
        $query = $this->db->query('select article_id,title,content,user_id,createAt from article limit 3,1');

//        $query->row(0,'User');
//        $num_rows = $query->num_rows();

        $row = $query->row_array();
        echo $row['article_id'] . '<br/>';
        echo $row['title'] . '<br/>';
        echo $row['content'] . '<br/>';
        echo $row['user_id'] . '<br/>';
        echo $row['createAt'] . '<br/>';
        echo '<hr/>';
    }

    public function insertObject()
    {
//        $this->db->escape_like_str("hello ");
        $title = 'hello sunny';
        $content = 'hwo are you? summer is comming';
        $sql = 'insert into article (title, content,user_id) VALUES (' . $this->db->escape($title) . ', ' . $this->db->escape($content) . ', 3)';
        $this->db->query($sql);
        echo $this->db->affected_rows();
    }

    public function quickQuery()
    {
        $query = $this->db->get('article');
        foreach ($query->result() as $row) {
            echo $row->title . '<br/>';
//            echo $row['title'] . '<br/>';
        }
    }

    public function other()
    {
        $count_all = $this->db->count_all('article');
        echo $count_all;
        echo '<br/>';
        echo $this->db->version();
//        $this->db->insert_string()
//        $this->db->update_string()
//        $this->db->trans_start();
//        $this->db->trans_complete();

        $list_tables = $this->db->list_tables();
        foreach ($list_tables as $table) {
            echo $table . '<br/>';
            $list_fields = $this->db->list_fields($table);
            print_r($list_fields);
            echo '<hr/>';
        }
    }
    public function dbutils(){
        $list_databases = $this->dbutil->list_databases();
        print_r($list_databases);
    }
}