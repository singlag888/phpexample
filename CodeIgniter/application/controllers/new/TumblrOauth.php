<?php
//require_once 'oauth/oauth.php';

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/1/4
 * Time: 下午9:11
 *
 * php使用oauth
 * 1. php.ini文件中开启 extension=oauth.so
 * 2. 官方示例 http://php.net/manual/zh/oauth.examples.fireeagle.php
 */
class TumblrOauth
{

    public function index()
    {
        //tumblr后台回调地址需要改为:http://phpexample.com/CodeIgniter/index.php/new/TumblrOauth
        session_start();

        $requestTokenUrl = 'https://www.tumblr.com/oauth/request_token';
        $authorizeUrl = 'https://www.tumblr.com/oauth/authorize';
        $accessTokenUrl = 'https://www.tumblr.com/oauth/access_token';

        $consumerKey = 'mPPCftibXqwvo8jynEZEdnMDplJSe4UrHd6oehQdlQvU3RQNoo';
        $consumerSecret = 'OBhrdDviRurcA53fTzSrVlVXkMoVckGRXUA34I73x6kowY1hwH';

        $apiUrl = 'https://api.tumblr.com/v2/blog/david.tumblr.com/info';

        if (!isset($_GET['oauth_token']) && $_SESSION['state'] == 1) {
            $_SESSION['state'] = 0;
        }

        $oauth = new OAuth($consumerKey, $consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION);
        $oauth->enableDebug();

        if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
            $requestToken = $oauth->getRequestToken($requestTokenUrl);
            $_SESSION['secret'] = $requestToken['oauth_token_secret'];
            $_SESSION['state'] = 1;
            header('Location: ' . $authorizeUrl . '?oauth_token=' . $requestToken['oauth_token']);
            exit();
        } elseif ($_SESSION['state'] == 1) {
            $oauth->setToken($_GET['oauth_token'], $_SESSION['secret']);
            $accessToken = $oauth->getAccessToken($accessTokenUrl);
            $_SESSION['state'] = 2;
            $_SESSION['token'] = $accessToken['oauth_token'];
            $_SESSION['secret'] = $accessToken['oauth_token_secret'];
        }

        $oauth->setToken($_SESSION['token'], $_SESSION['secret']);
        $oauth->fetch($apiUrl);
        $lastResponse = $oauth->getLastResponse();
        print_r($lastResponse);

    }
}