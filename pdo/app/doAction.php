<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/28
 * Time: 下午3:30
 */

//1.包含所需要文件
require_once '../dbConfig.php';
require_once '../PdoMySql.php';
require_once '../../vendor/autoload.php';

//2.处理请求
$act = $_GET['act'];

$pdoMySql = new PdoMySql();
$username = $_POST['username'];
$password = md5($_POST['password']);

$table = 'usertwo';
if ($act == 'reg') {

    $email = $_POST['email'];

    $regtime = time();

    $token = md5($username . $password . $regtime);
    $token_exptime = $regtime + 24 * 3600;
    $data = compact('username', 'password', 'email', 'token', 'token_exptime', 'regtime');

    $res = $pdoMySql::add($table, $data);
    $lastInsertId = $pdoMySql::getLastInsertId();
    if ($res) {

        //生成信息
        $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?act=active&token={$token}";
        $urlencode = urlencode($url);

        $str = <<<EDF
    亲爱的{$username}你好，感谢您注册Login网站<br/>
    请点击此链接激活帐号后即可登陆<br>
    <a href="{$url}">{$urlencode}</a> <br>
    如果点击此链接无反应，请将此链接复制到浏览地址栏中来执行 <br>
    此链接有效期为24小时！
EDF;

        //发送邮件: Gmail
        $transport = new Swift_SmtpTransport('smtp.gmail.com', 465);
        $transport->setUsername("name@gmail.com")->setPassword("password")
            ->setAuthMode('login')->setEncryption('ssl');

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('激活邮件'))
            ->setFrom(['john@passer.com' => "johon Doe"])
            ->setTo([$email])
            ->setBody("{$str}", 'text/html', 'utf-8');

        try {
            $result = $mailer->send($message);
            if ($result) {
                echo "恭喜您{$username}注册成功，请到邮箱激活后登陆<br>";
                echo "3秒后跳转到登陆页面";
                echo "<meta http-equiv='refresh' content='3;url=index.php#tologin' />";
            } else {
                $pdoMySql::delete($table, 'id=' . $lastInsertId);
                echo '用户注册失败，请重新注册! <br/> 3秒后跳转到注册页面';
                echo '<meta http-equiv="refresh" content="3;url=index.php#toregister"/>';
            }

        } catch (Exception $e) {
            echo "邮件发送失败！" . $e->getMessage();
        }

    } else {
        echo '用户注册失败，3秒后跳转到注册页面';
        echo '<meta http-equiv="refresh" content="3;url=index.php#toregister"/>';
    }

} elseif ($act == 'active') {
    $token1 = addslashes($_GET['token']);
//    addslashes()
//    echo $token1;

    $res = $pdoMySql::find($table, array("id", "token_exptime"), "token='{$token1}' and status=0 ");
    $time = time();
    if ($time > $res['token_exptime']) {
        echo "激活过期，请重新激活!";
        $pdoMySql::delete($table, 'id=' . $res['id']);
    } else {
        $result = $pdoMySql::update($table, array("status" => 1), "id={$res['id']}");
        if ($result) {
            echo "激活成功<br>";
            echo "3秒后跳转到登陆页面";
            echo "<meta http-equiv='refresh' content='3;url=index.php#tologin' />";
        } else {
            echo "激活失败，请重新激活<br>";
            echo "<meta http-equiv='refresh' content='3;url=index.php' />";
        }
    }
} elseif ($act == 'login') {

    $res = $pdoMySql::find($table, null, "username='{$username}' and password='{$password}'");
    if (!$res) {
        echo "用户名或密码不正确，请重新输入";
        echo "<meta http-equiv='refresh' content='3;url=index.php#tologin' />";
    } else {
        if ($res['status'] == 0) {
            echo "请先激活后再登陆";
            echo "<meta http-equiv='refresh' content='3;url=index.php#tologin' />";
        } else {
            echo "登陆成功";
            echo "<meta http-equiv='refresh' content='3,url=http://www.imooc.com' />";
        }
    }
}