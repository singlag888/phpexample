<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/25
 * Time: 下午5:11
 */
class Encode
{

    public static function encoder($code, $message, $data = array(), $type = 'json')
    {
        if (!is_numeric($code)) {
            return "";
        }

        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );
        if ($type == 'xml') {
            return self::xmlEncode($code, $message, $data);
        } else {
            return self::jsonEncode($code, $message, $data);
        }
    }

    public static function jsonEncode($code, $message, $data = array())
    {
        if (!is_numeric($code)) {
            return "";
        }

        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );
        header('Content-Type:text/json');
        return json_encode($result, JSON_NUMERIC_CHECK);
    }


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

    protected static function xmlToEncode($data)
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