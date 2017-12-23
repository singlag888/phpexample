<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/22
 * Time: 下午1:47
 */
require_once __DIR__ . '/ErrorCode.php';

class Article
{

    private $_db;

    /**
     * Article constructor.
     * @param PDO $_db
     */
    public function __construct($_db)
    {
        $this->_db = $_db;
    }


    /**
     * 创建文章
     * @param $title
     * @param $content
     * @param $userId
     * @return array
     * @throws Exception
     */
    public function create($title, $content, $userId)
    {
        if (empty($title)) {
            throw new Exception("文章标题不能为空", ErrorCode::ARTICLE_TITLE_EMPTY);
        }
        if (empty($content)) {
            throw new Exception("文章内容不能为空", ErrorCode::ARTICLE_CONTENT_EMPTY);
        }

        $sql = 'insert into `article` (`title`,`content`,`user_id`,`createAt`) VALUES (:title,:content,:userId,:createAt)';
        $craetAt = time();
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':createAt', $craetAt);
        if (!$stmt->execute()) {
            throw new Exception("文章插入失败", ErrorCode::ARTICLE_INSERT_ERROR);
        }
        return [
            'articleId' => $this->_db->lastInsertId(),
            'title' => $title,
            'content' => $content,
            'createAt' => $craetAt,
            'userId' => $userId
        ];
    }


    public function view($articleId)
    {
        if (empty($articleId)) {
            throw new Exception("文章ID不能为空", ErrorCode::ARTICLE_ID_IS_EMPTY);
        }
        $sql = 'select * from `article` WHERE `article_id`=:id';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':id', $articleId);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($article)) {
            throw new Exception("文章不存在", ErrorCode::ARTICLE_NOT_EXISTS);
        }
        return $article;
    }

    /**
     * 编辑文章
     * @param $articleId
     * @param $title
     * @param $content
     * @param $userId
     * @return mixed
     * @throws Exception
     */
    public function edit($articleId, $title, $content, $userId)
    {
        if (empty($articleId)) {
            throw new Exception("文章ID不能为空", ErrorCode::ARTICLE_ID_IS_EMPTY);
        }
        $article = $this->view($articleId);

        if ($userId != $article['user_id']) {
            throw new Exception("用户无权限编辑", ErrorCode::PREMISSION_ERROR);
        }

        $title = empty($title) ? $article['title'] : $title;
        $content = empty($content) ? $article['content'] : $content;
        if ($title == $article['title'] && $content == $article['content']) {
            return $article;
        }
        $sql = 'update `article` set `title`=:title,`content`=:content WHERE `article_id`=:articleId';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':articleId', $articleId);
        if (!$stmt->execute()) {
            throw new Exception("文章编辑失败", ErrorCode::ARTICLE_EDIT_ERROR);
        }
        return [
            'articleId' => $articleId,
            'title' => $title,
            'content' => $content
        ];
    }

    /**
     * 删除文章
     * @param $articleId
     * @param $userId
     * @return bool
     * @throws Exception
     */
    public function delete($articleId, $userId)
    {
        if (empty($articleId)) {
            throw new Exception("文章ID不能为空", ErrorCode::ARTICLE_ID_IS_EMPTY);
        }
        if (empty($userId)) {
            throw new Exception("用户ID不能为空", ErrorCode::USER_ID_IS_EMPTY);
        }
        $article = $this->view($articleId);
        if ($article['user_id'] != $userId) {
            throw new Exception("用户无权限编辑", ErrorCode::PREMISSION_ERROR);
        }


        $sql = 'delete from `article` WHERE `article_id`=:articleId and `user_id`=:userId';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':articleId', $articleId);
        $stmt->bindParam(':userId', $userId);
        if (false === $stmt->execute()) {
            throw new Exception("删除文章失败", ErrorCode::ARTICLE_DELETE_ERROR);
        }
        return true;
    }

    /**
     * 查询文章列表
     * @param $userId
     * @param int $page
     * @param int $size
     * @return array
     * @throws Exception
     */
    public function getArtList($userId, $page = 1, $size = 10)
    {
        if (empty($userId)) {
            throw new Exception("用户ID不能为空", ErrorCode::USER_ID_IS_EMPTY);
        }
        $sql = 'select * from `article` WHERE `user_id`=:userId  LIMIT  :limiter , :offseter ';
        $limit = ($page - 1) * $size;
        $limit = $limit <= 0 ? 0 : $limit;
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        //绑定这两个参数 查询不出数据，原因未知
        $stmt->bindParam(':limiter', $limit);
        $stmt->bindParam(':offseter', $size);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}