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
        $this->load->database();
    }

    /**
     * 验证码
     */
    public function captcha()
    {
        $this->load->helper('captcha');

        //获取访问全路径。判断是否是https
        $httpType = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $HTTP_HOST = $_SERVER['HTTP_HOST'];
        $REQUEST_URI = $_SERVER['REQUEST_URI'];

//        $fullUrl = $httpType . $HTTP_HOST . $REQUEST_URI;
//        echo $fullUrl;

        $imgPath = "img/captcha/";
        if (!is_dir($imgPath)) mkdir($imgPath);

        $imgUrl = $httpType . $HTTP_HOST . '/ciApi/img/captcha';

        $data = array(
            'img_path' => $imgPath,
            'img_url' => $imgUrl
        );
        $create_captcha = create_captcha($data);
//        print_r($create_captcha);

        $data = array(
            'captcha_time' => $create_captcha['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $create_captcha['word']
        );
        $query = $this->db->insert_string('captcha', $data);
        $query1 = $this->db->query($query);
        if ($query1) {
            echo 'Submit the word you see below:<br/>';
            echo $create_captcha['image'] . '<br/>';
            echo '<form action="/ciApi/index.php/HelperFunction/checkCaptcha" method="post">';
            echo '<input type="text" name="captcha" value=""/><br/>';
            echo '<input type="submit"/>';
            echo '</form>';
        } else {
            echo 'captcha error';
        }
    }

    public function checkCaptcha()
    {
        $expiration = time() - 300;
        $this->db->where('captcha_time' < $expiration)
            ->delete('captcha');

        $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word=? AND ip_address =? AND captcha_time > ?';
        $binds = array($this->input->get_post('captcha', true), $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();
        if ($row->count == 0) {
            echo 'You must submit the word that appears in the image.';
        } else {
            echo 'check captcha correct';
        }
    }


}