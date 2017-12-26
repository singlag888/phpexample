<?php


try {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);

    $redis->set('hello', 'world321');


    echo 'key:hello value:' . $redis->get('hello') . '<br>';
    echo 'key:what? value:' . $redis->get('what?') . '<br>';
    echo $redis->delete('hello') . '<br>';
    echo 'key:hello value:' . $redis->get('hello');
} catch (Exception $e) {
    var_dump($e);
}