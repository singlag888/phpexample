<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $this->load->view('welcome_message');
    }

    /**
     * 返回项目中所有model下文件
     */
    public function listModelFile()
    {
        //* @property film_model1      $film_model1
        $arr = $this->get_dir('application/models/');
        $str = '';
        foreach ($arr as $k => $v) {
            unset($arr_x);
            $arr_x = explode('.', $v);
            $str .= '* @property ' . $arr_x[0] . '      $' . $arr_x[0] . '' . "<br/>";

        }
        echo $str;
    }

    function get_dir($dir)
    {
        if (!is_dir($dir)) {
            return false;
//            exit;
        }
        $file = array();
        $hand = opendir($dir);
        while (($files = readdir($hand)) !== false) {
            if ($files != '.' & $files != '..') {
                $files = stristr($files, ".php") ? $files : $dir . '/' . $files;
                if (is_dir($files)) {
                    $result = $this->get_dir($files);
                    if ($result) {
                        $file = array_merge($file, $result);
                    }
//                    $file[$files] = $this->get_dir($files);
                } else {
                    if (stristr($files, '.php')) {
                        $file[] = $files;
                    }
                }
            }
        }
        closedir($hand);
        return $file;
    }

}
