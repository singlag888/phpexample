<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/11/17
 * Time: 下午5:40
 */

class FenyePage
{
    public $pageNow = 1;//默认打开第一页
    public $pageSize;
    public $pageCount;
    public $rowCount;
    public $res_array;
    public $daohangtiao;//导航条
    public $gotoUrl;//要跳转的页面
}