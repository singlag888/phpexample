<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/24
 * Time: 下午6:39
 */
class Goods extends CI_Controller
{

    /**
     * Goods constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('response');
        $this->load->database();
    }

    public function types()
    {
        $result = $this->db->where('enable', 1)
            ->order_by('sort', 'asc')
            ->get('type');

        $types = $result->result_array();
        if (!$types) {
            jsonResponse(211, 'empty data!');
            return;
        }

        foreach ($types as $val) {
            $data[] = array(
                'name' => $val['name'],
                'id' => $val['id'] + 0
            );
        }
        jsonResponse(200, 'success', $data);
    }

    public function goodsByType($type = 0)
    {
        $this->db->where('enable', 1);
        if ($type) {
            $this->db->where('type_id', $type);
        }
        $result = $this->db->get('goods');
        $goods = $result->result_array();
        if (!$goods) {
            jsonResponse(211, 'empty data!');
            return;
        }

        foreach ($goods as $val) {

            $imgData = $this->db->where('goods_id', $val['id'])
                ->limit(1)
                ->get('img')
                ->row();
            $imgUrl = $imgData->url;

            $data[] = array(
                'id' => $val['id'] + 0,
                'name' => $val['name'],
                'price' => $val['price'] + 0,
                'salePrice' => $val['sale_price'] + 0,
                'typeId' => $val['type_id'] + 0,
//                'desc' => $val['desc'],
                'img' => $imgUrl,
            );
        }
        jsonResponse(200, 'success', $data);
    }

}