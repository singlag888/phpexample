<?php
require_once 'User.php';
require_once 'BaseController.php';

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/31
 * Time: 上午9:33
 */
class Carts extends BaseController
{
    private $user;

    /**
     * Carts constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->user = $this->user();
    }

    /**
     * 当前用户购物车
     */
    public function index()
    {
        $query = $this->db->get_where('carts', array(
            'user_id' => $this->user['id'],
        ));
        $data = $query->result_array();
        $result[] = null;
        foreach ($data as $item) {
            $goodQuery = $this->db->get_where('goods', array(
                'id' => $item->goods_id,
                'enable' => true,
            ));
            $goods = $goodQuery->result_object();



            $result[] = array(
                'id' => $item->id,
                'goods' => array(
                    'id' => $goods['id'],
                    'name' => $goods['name'],
                    'price' => $goods['price'],
                    'salePrice' => $goods['sale_price'],
                    'typeId' => $goods['type_id'],
                ),
                'num' => $item->num,
                'createTime' => $item->create_time,
            );
        }
        jsonResponse(200, 'success', $result);
    }

    /**
     * 添加到购物车
     */
    public function addGood()
    {
        $goodsId = $this->input->post('goodsId');
        if (!isset($goodsId)) {
            jsonResponse(204, 'params error');
            return;
        }
        $number = $this->input->post('number');
        $num = isset($number) ? $number : 1;

        $exitsQuery = $this->db->get_where('carts', array(
            'goods_id' => $goodsId,
        ));
        $row = $exitsQuery->row();
        if (empty($row)) {
            //不存在，插入记录
            $data = array(
                'goods_id' => $goodsId,
                'user_id' => $this->user['id'],
                'num' => $num,
                'create_time' => mdate('%Y-%m-%d %H:%m:%s'),
                'update_time' => mdate('%Y-%m-%d %H:%m:%s'),
            );
            $query = $this->db->insert('carts', $data);
            if (!$query) {
                jsonResponse(211, 'create data error');
                return;
            }
            $insert_id = $query->insert_id();
            $data['id'] = $insert_id;

            jsonResponse(200, 'success', $data);
        } else {
            //存在，更新记录。数量添加一个
            $query = $this->db->update('carts', array(
                'num' => $row->num + 1,
                'update_time' => mdate('%Y-%m-%d %H:%m:%s'),
            ));
            if (!$query) {
                jsonResponse(211, 'create data error');
                return;
            }

            jsonResponse(200, 'success');
        }
    }

    /**
     * 更新购物车指定商品数量
     */
    public function updateGood()
    {
        $goodsId = $this->input->post('goodsId');
        $num = $this->input->post('num');
        if (!isset($goodsId) && !isset($num)) {
            jsonResponse(204, 'params error');
            return;
        }
        $query = $this->db->update('carts',
            array('num' => $num),
            array(
                'goods_id' => $goodsId,
                'user_id' => $this->user['id']
            ));
        if (!$query) {
            jsonResponse(211, 'update data error');
            return;
        }
        jsonResponse(200, 'success');
    }

    /**
     * 删除指定商品
     */
    public function delGood()
    {
        $goodsId = $this->input->post('goodsId');
        if (!isset($goodsId)) {
            jsonResponse(204, 'params error');
            return;
        }

        $query = $this->db->delete('carts', array(
            'goods_id' => $goodsId,
            'user_id' => $this->user['id']));
        if (!$query) {
            jsonResponse(211, 'delete data error');
            return;
        }
        jsonResponse(200, 'delete success');
    }


}