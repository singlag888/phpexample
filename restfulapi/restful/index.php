<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/23
 * Time: 上午8:55
 */

//var_dump($_SERVER);

require_once __DIR__ . '/../lib/user.php';
require_once __DIR__ . '/../lib/Article.php';
$pdo = require_once __DIR__ . '/../lib/db.php';

class Restful
{
    /**
     * @var User
     */
    private $_user;
    /**
     * @var Article
     */
    private $_article;

    /**
     * 请求方法
     * @var string
     */
    private $_requestMethod;
    /**
     * 请求资源名称
     * @var string
     */
    private $_resourceName;

    /**
     * 请求的资源id
     * @var string
     */
    private $_id;


    /**
     * @var array 允许请求的资源列表
     */
    private $_allowResources = ['users', 'articles'];

    /**
     * @var array 允许请求的方法
     */
    private $_allowMethod = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];

    /**
     * @var array 常用的状态码
     */
    private $_statusCodes = [
        200 => 'Ok',
        204 => 'Not Content',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Server Internal Error'
    ];

    /**
     * Restful constructor.
     * @param User $_user
     * @param Article $_article
     */
    public function __construct(User $_user, Article $_article)
    {
        $this->_user = $_user;
        $this->_article = $_article;
    }

    public function run()
    {
        try {
            $this->setupRequestMethod();
            $this->setupResources();
            if ($this->_resourceName == $this->_allowResources[0]) {
                $this->_json($this->handlerUser());
            } else {
                $this->_json($this->handlerArticle());
            }
        } catch (Exception $e) {
            $this->_json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * 初始化请求方法
     */
    private function setupRequestMethod()
    {
        $this->_requestMethod = $_SERVER['REQUEST_METHOD'];
        if (!in_array($this->_requestMethod, $this->_allowMethod)) {
            throw new Exception("请求方法不被允许", 405);
        }
    }

    /**
     * 初始化请求资源
     */
    private function setupResources()
    {
        $path = $_SERVER['PATH_INFO'];
//        echo $path;
        $params = explode('/', $path);
//        print_r($params);
        $this->_resourceName = $params[1];
        //判断请求资源是否允许
        if (!in_array($this->_resourceName, $this->_allowResources)) {
            throw new Exception("请求资源不被允许", 400);
        }
        if (!empty($params[2])) {
            $this->_id = $params[2];
        }
    }

    /**
     * 输出json
     * @param $array
     */
    private function _json($array, $code)
    {
        if ($array == null && $code !== 0) {
            $code = 204;
        }
        if ($array !== null && $code === 0) {
            $code = 200;
        }
        header('HTTP/1.1 ' . $code . ' ' . $this->_statusCodes[$code]);
        header('Content-Type:application/json;charset=utf-8');
        if ($array != null) {
            echo json_encode($array, JSON_UNESCAPED_UNICODE);
        }
        exit();
    }

    /**
     * 处理用户请求
     */
    private function handlerUser()
    {
        if ($this->_requestMethod != 'POST') {
            throw new Exception("请求方法不被允许", 405);
        }
        $data = $this->_getBodyParams();
        if (empty($data['username'])) {
            throw new Exception("用户名不能为空", 400);
        }
        if (empty($data['password'])) {
            throw new Exception("密码不能为空", 400);
        }
        return $this->_user->register($data['username'], $data['password']);
    }

    /**
     * 处理文章请求
     */
    private function handlerArticle()
    {
        switch ($this->_requestMethod) {
            case 'POST':
                return $this->_handleArticleCreate();
            case 'PUT':
                return $this->_handleArticleEdit();
            case 'DELETE':
                return $this->_handleArticleDelete();
            case 'GET':
                if (empty($this->_id)) {
                    return $this->_handleArticleList();
                } else {
                    return $this->_handleArticleView();
                }
            default:
                throw new Exception("请求方法不被允许", 405);
        }
    }

    /**
     * 获取请求参数
     * @return mixed
     * @throws Exception
     */
    private function _getBodyParams()
    {
        $raw = file_get_contents('php://input');
        if (empty($raw)) {
            throw new Exception("请求参数错误", 400);
        }
        return json_decode($raw, true);
    }

    /**
     * 创建文章
     */
    private function _handleArticleCreate()
    {
        $data = $this->_getBodyParams();
        if (empty($data['title'])) {
            throw new Exception("文章标题不能为空", 400);
        }
        if (empty($data['content'])) {
            throw new Exception("文章内容不能为空", 400);
        }
        //模拟http登陆
        //添加Header  用户名密码使用base64编码 admin:admin  --> YWRtaW46YWRtaW4=
        // Authorization: Basic YWRtaW46YWRtaW4=
        $user = $this->_userLogin($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

        try {
            $article = $this->_article->create($data['title'], $data['content'], $user['user_id']);
            return $article;
        } catch (Exception $e) {
            if (in_array($e->getCode(),
                [
                    ErrorCode::ARTICLE_TITLE_EMPTY,
                    ErrorCode::ARTICLE_CONTENT_EMPTY
                ])) {
                throw new Exception($e->getMessage(), 400);
            }
            throw new Exception($e->getMessage(), 500);
        }
    }

    /**
     * 编辑文章
     */
    private function _handleArticleEdit()
    {
        $user = $this->_userLogin($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        try {
            $article = $this->_article->view($this->_id);
            if ($article['user_id'] != $user['user_id']) {
                throw new Exception("您无权编辑", 403);
            }
            $body = $this->_getBodyParams();
            return $this->_article->edit($article['article_id'], $body['title'], $body['content'], $user['user_id']);
        } catch (Exception $e) {
            if ($e->getCode() < 100) {
                if ($e->getCode() == [
                        ErrorCode::ARTICLE_NOT_EXISTS
                    ]) {
                    throw new Exception($e->getMessage(), 404);
                }
                throw new Exception($e->getMessage(), 400);
            }
            throw $e;
        }
    }

    /**
     * 删除文章
     */
    private function _handleArticleDelete()
    {
        $user = $this->_userLogin($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        try {
            $article = $this->_article->view($this->_id);
            if ($article['user_id'] != $user['user_id']) {
                throw new Exception("您无权编辑", 403);
            }
            $this->_article->delete($article['article_id'], $user['user_id']);
            return null;
        } catch (Exception $e) {
            if ($e->getCode() < 100) {
                if ($e->getCode() == [
                        ErrorCode::ARTICLE_NOT_EXISTS
                    ]) {
                    throw new Exception($e->getMessage(), 404);
                }
                throw new Exception($e->getMessage(), 400);
            }
            throw $e;
        }
    }

    /**
     * 查询文章列表
     */
    private function _handleArticleList()
    {
        $user = $this->_userLogin($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $size = isset($_GET['size']) ? $_GET['size'] : 10;
        if ($size > 100) {
            throw new Exception("分页数最大100", 400);
        }
        return $this->_article->getArtList($user['user_id'], $page, $size);
    }

    /**
     * 查询单个文章
     */
    private function _handleArticleView()
    {
        try {
            return $this->_article->view($this->_id);
        } catch (Exception $e) {
            if ($e->getCode() == ErrorCode::ARTICLE_NOT_EXISTS) {
                throw new Exception($e->getMessage(), 404);
            }
            throw new Exception($e->getMessage(), 500);
        }
    }

    /**
     * 用户登陆
     * @param $PHP_AUTH_USER
     * @param $PHP_AUTH_PW
     * @return mixed
     * @throws Exception
     */
    private function _userLogin($PHP_AUTH_USER, $PHP_AUTH_PW)
    {
        try {
            return $this->_user->login($PHP_AUTH_USER, $PHP_AUTH_PW);
        } catch (Exception $e) {
            if (in_array($e->getCode(), [
                ErrorCode::USERNAME_IS_EMPTY,
                ErrorCode::PASSWORD_IS_EMPTY,
                ErrorCode::USERNAME_OR_PASSWORD_ERROR
            ])) {
                throw new Exception($e->getMessage(), 400);
            }
            throw new Exception($e->getMessage(), 500);
        }
    }


}

$article = new Article($pdo);
$user = new User($pdo);

$restful = new Restful($user, $article);
$restful->run();