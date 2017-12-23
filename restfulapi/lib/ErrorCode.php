<?php

/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/22
 * Time: 下午2:20
 */
class ErrorCode
{
    const USERNAME_EXISTS = 1;
    /**
     * 用户名不能为空
     */
    const USERNAME_IS_EMPTY = 2;
    //密码不能为空
    const PASSWORD_IS_EMPTY = 3;
    /**用户注册失败*/
    const REGISTER_FAIL = 4;
    /**用户名或密码不正确*/
    const USERNAME_OR_PASSWORD_ERROR = 5;
    /***
     * 文章标题不能为空
     */
    const ARTICLE_TITLE_EMPTY = 6;
    /**
     * 文章内容不能为空
     */
    const ARTICLE_CONTENT_EMPTY = 7;
    /**
     * 文章插入失败
     */
    const ARTICLE_INSERT_ERROR = 8;
    /**
     * 文章ID不能为空
     */
    const ARTICLE_ID_IS_EMPTY = 9;
    /**
     * 文章不存在
     */
    const ARTICLE_NOT_EXISTS = 10;
    /**
     * 文章编辑失败
     */
    const ARTICLE_EDIT_ERROR = 11;
    /**
     * 用户无权限编辑
     */
    const PREMISSION_ERROR = 12;
    /**
     * 用户ID不能为空
     */
    const USER_ID_IS_EMPTY = 13;
    /**
     * 删除文章失败
     */
    const ARTICLE_DELETE_ERROR = 14;
    /**
     * 服务器内部错误
     */
    const SERVER_INTERNAL_ERROR = 15;


}