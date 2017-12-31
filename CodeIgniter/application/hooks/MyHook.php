<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/30
 * Time: 下午6:34
 */

class MyHook
{

    /**
     * MyHook constructor.
     */
    public function __construct()
    {
        log_message('info', 'MyHook class init installition');
    }


    public function PreSystem($first)
    {
        log_message('info', 'MyHook class PreSystem. param one:' . print_r($first, true));
    }

    public function CacheOverride($first)
    {
        log_message('info', 'MyHook class CacheOverride. param one:' . print_r($first, true));
        return true;
    }


    public function PreController($first)
    {
        log_message('info', 'MyHook class PreController. param one:' . print_r($first, true));
    }


    public function PostControllerConstructor($first)
    {
        log_message('info', 'MyHook class PostControllerConstructor. param one:' . print_r($first, true));
    }


    public function PostController($first)
    {
        log_message('info', 'MyHook class PostController. param one:' . print_r($first, true));
    }


    public function DisplayOverride($first)
    {
        log_message('info', 'MyHook class DisplayOverride. param one:' . print_r($first, true));

        echo 'MyHook class DisplayOverride';
    }

    public function PostSystem($first)
    {
        log_message('info', 'MyHook class PostSystem. param one:' . print_r($first, true));
    }


}