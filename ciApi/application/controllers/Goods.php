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

    /**
     * 所有商品分类
     */
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

    /**
     * 根据分类type返回商品列表　
     * @param int $type
     * @internal param int $type　分类type
     */
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
            $imgUrl = trim($imgUrl);

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

    /**
     * 根据商品id返回商品信息
     * @param $id 商品id
     */
    public function goodsById($id)
    {
        if (empty($id)) {
            jsonResponse(211, 'param error!');
            return;
        }

        $result = $this->db->where(array('enable' => 1, 'id' => $id))
            ->get('goods');
        $goods = $result->row();
        if (!$goods) {
            jsonResponse(211, 'empty data!');
            return;
        }

        $imgResult = $this->db->where('goods_id', $id)
            ->get('img');
        $imgs = $imgResult->result_array();
        foreach ($imgs as $item) {
            $imgUrls[] = trim($item['url']);
        }
        $data = array(
            'id' => $goods->id + 0,
            'name' => $goods->name,
            'price' => $goods->price,
            'salePrice' => $goods->sale_price,
            'typeId' => $goods->type_id,
            'desc' => $goods->desc,
            'imgs' => $imgUrls,
        );
        jsonResponse(200, 'success', $data);
    }



}