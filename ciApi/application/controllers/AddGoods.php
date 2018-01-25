<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/25
 * Time: 上午9:58
 */
class AddGoods extends CI_Controller
{

    /**
     * AddGoods constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addGood($type)
    {

        if (!isset($type)) {
            echo 'not type params';
            return;
        }

        $source = '/Users/hello/PhpstormProjects/example/amzon/source.txt';

        $file = fopen($source, 'r') or exit('can not open file!');

        while (!feof($file)) {
            $line = fgets($file);
//    echo $line .'<br/>';
            $preg_split = preg_split("/#/", $line);
//    print_r($preg_split);
            if (!$preg_split) {
                echo "data error: " . $line;
                continue;
            }
            $title = $preg_split[0];
            $price = $preg_split[1];
            $imgUrl = $preg_split[2];

            $this->db->trans_start();

            $data = array(
                'name' => $title,
                'price' => $price,
                'type_id' => $type,
                'desc' => ' desc ',
            );
            $resutl = $this->db->insert('goods', $data);
            $insert_id = $this->db->insert_id();
//            $insert_id = $resutl->insert_id();

            $imgData = array(
                'url' => $imgUrl,
                'goods_id' => $insert_id,
            );
            $insertImg = $this->db->insert('img', $imgData);

            $this->db->trans_complete();
            if ($this->db->trans_status() === false) {
                echo 'insert error: ' . $line;
            }
        }

        fclose($file);

        echo 'success';
    }
}