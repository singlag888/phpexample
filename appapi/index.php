<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/25
 * Time: 上午9:41
 */

class Encode
{
    public static function xmlEncode($code, $message, $data = array())
    {
        if (!is_numeric($code)) {
            return "";
        }

        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );
        header("Content-Type:text/xml");
        $xml = "";

        $xml .= "<root>";
        $xml .= self::xmlToEncode($result);
        $xml .= "</root>";
        return $xml;
    }

    public static function xmlToEncode($data)
    {
        $xml = "";
        foreach ($data as $key => $value) {
            $attr = "";
            if (is_numeric($key)) {
                $attr = " id='{$key}'";
                $key = 'item';
            }
            $xml .= "<{$key}{$attr}>";
            $xml .= is_array($value) ? self::xmlToEncode($value) : $value;
            $xml .= "</{$key}>\n";
        }
        return $xml;
    }
}

$format = $_GET['format'];

$data = [
    'name'=>'world',
    'age' =>32,
    'sex'=>'fale',
    'func'=>'what',
    'ma'=>[
        'world'=>'hello',
        'this'=>'sugar',
        'coff'=>'black',
    ],
];
//echo $format."<br>";
echo Encode::xmlEncode(200,'返回东西了',$data);