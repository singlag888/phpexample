<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/22
 * Time: 上午10:37
 */

class HelperFunction extends CI_Controller
{


    /**
     * HelperFunction constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function captcha()
    {
        $this->load->helper('captcha');

        //获取访问全路径。判断是否是https
        $httpType = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $HTTP_HOST = $_SERVER['HTTP_HOST'];
        $REQUEST_URI = $_SERVER['REQUEST_URI'];

        $fullUrl = $httpType . $HTTP_HOST . $REQUEST_URI;
        echo $fullUrl;

        $imgPath = "img/captcha/";
        if (!is_dir($imgPath)) mkdir($imgPath);

        $imgUrl = $httpType . $HTTP_HOST . '/ciApi/img/captcha';

        $data = array(
            'img_path' => $imgPath,
            'img_url' => $imgUrl
        );
        $create_captcha = create_captcha($data);
        print_r($create_captcha);
    }


}