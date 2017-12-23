<?php


require_once __DIR__ . "/ErrorCode.php";

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/22
 * Time: 下午1:47
 */
class User
{
    /**
     *  PDO 数据库连接句柄
     */
    private $_db;

    /**
     * User constructor.
     * @param $_db PDO
     */
    public function __construct($_db)
    {
        $this->_db = $_db;
    }


    /**
     * 登陆
     * @param $username
     * @param $pwd
     * @return mixed
     * @throws Exception
     */
    public function login($username, $pwd)
    {
        if (empty($username)) {
            throw new Exception("用户名不能为空", ErrorCode::USERNAME_IS_EMPTY);
        }
        if (empty($pwd)) {
            throw new Exception("密码不能为空", ErrorCode::PASSWORD_IS_EMPTY);
        }

        $sql = 'select * from USER WHERE `username`=:username AND `password`=:password';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $this->md5($pwd));
        if(!$stmt->execute()){
            throw new Exception("服务器内部错误",ErrorCode::SERVER_INTERNAL_ERROR);
        }
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($user)) {
            throw new Exception("用户名或密码不正确", ErrorCode::USERNAME_OR_PASSWORD_ERROR);
        }
        unset($user['password']);
        return $user;
    }

    /**注册*/
    public function register($username, $password)
    {
        if (empty($username)) {
            throw new Exception("用户名不能为空", ErrorCode::USERNAME_IS_EMPTY);
        }
        if (empty($password)) {
            throw new Exception("密码不能为空", ErrorCode::PASSWORD_IS_EMPTY);
        }

        if ($this->isUserExists($username)) {
            throw new Exception("用户名已存在", ErrorCode::USERNAME_EXISTS);
        }

        //保存到数据库
        $sql = 'insert into `user` (`username`,`password`,`create_time`) VALUES (:username,:password,:createTime)';
        $createTime = time();
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $this->md5($password));
        $stmt->bindParam(':createTime', $createTime);

        if (!$stmt->execute()) {
            throw new Exception("用户注册失败", ErrorCode::REGISTER_FAIL);
        }
        return [
            'userId' => $this->_db->lastInsertId(),
            'username' => $username,
            'createTime' => $createTime
        ];
    }

    /**
     * md5加密
     * @param $string
     * @param string $key
     * @return string
     */
    private function md5($string, $key = 'sunny')
    {
        return md5($string . $key);
    }


    /**
     * 检测用户名是否存在
     * @param $username
     * @return bool
     */
    private function isUserExists($username)
    {
        $sql = 'select * from `user` where `username` = :username';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
//        var_dump($result);
        return !empty($result);
    }
}