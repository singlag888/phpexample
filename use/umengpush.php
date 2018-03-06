<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/3/6
 * Time: 下午2:10
 */


$appkey = '??';
$app_master_secret = '??';
$title = "本地推送";
$content = "恭喜用户";

$timestamp = $_SERVER['REQUEST_TIME'];
$method = 'POST';
$url = 'https://msgapi.umeng.com/api/send';

$message = array(
    'appkey' => '',
    'timestamp' => $timestamp,
    'type' => 'broadcast',
    //'production_mode'=>true,
    'payload' => array(
        'display_type' => 'notification',
        'body' => array(
            'ticker' => $title,
            'title' => $title,
            'text' => $content,
            'play_vibrate' => true,
            'play_lights' => true,
            'play_sound' => true,
            'after_open' => 'go_app',
        )),
);

//推送至安卓
$message['appkey'] = $appkey;
$json_message = json_encode($message, JSON_UNESCAPED_UNICODE);
$sign_ad = md5($method . $url . $json_message . $app_master_secret);//生成签名
$a = send_post('https://msgapi.umeng.com/api/send?sign=' . $sign_ad, $json_message);//推送到安卓
//wlog(APPPATH . 'logs/push_message.log', 'ad-' . $appkey . '-' . $a);
echo $appkey.'-'.$a;


//post推送
function send_post($url, $post_data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // https跳过证书检查
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);// 10s to timeout.
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
