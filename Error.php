<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/25
 * Time: 下午5:23
 */

ini_set("error_reporting", true);
error_reporting(E_ALL);
error_reporting(E_STRICT);

register_shutdown_function('fatalError');

set_error_handler('appError');

set_exception_handler('appException');


function fatalError()
{
    $e = error_get_last();
    switch ($e['type']) {
        case E_USER_ERROR:
            ob_end_clean();
            header('Content-Type:text/text');
            var_dump($e);
            break;
    }
}

function appError($e)
{
    switch ($e['type']) {
        case E_USER_ERROR:
            header('Content-Type:text/text');
            echo 'appError:';
            var_dump($e);
            break;
    }
}


function appException($e)
{
    header('Content-Type:text/text');
    echo 'appException:';
    var_dump($e);
}