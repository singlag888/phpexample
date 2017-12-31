<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['pre_system'] = array(
    'class' => 'MyHook',
    'function' => 'PreSystem',
    'filename' => 'MyHook.php',
    'filepath' => 'hooks',
    'params' => array('first param', 'second param')
);

$hook['cache_override'] = array(
    'class' => 'MyHook',
    'function' => 'CacheOverride',
    'filename' => 'MyHook.php',
    'filepath' => 'hooks',
    'params' => array('first param', 'second param')
);

$hook['pre_controller'] = array(
    'class' => 'MyHook',
    'function' => 'PreController',
    'filename' => 'MyHook.php',
    'filepath' => 'hooks',
    'params' => array('first param', 'second param')
);

$hook['post_controller_constructor'] = array(
    'class' => 'MyHook',
    'function' => 'PostControllerConstructor',
    'filename' => 'MyHook.php',
    'filepath' => 'hooks',
    'params' => array('first param', 'second param')
);

$hook['post_controller'] = array(
    'class' => 'MyHook',
    'function' => 'PostController',
    'filename' => 'MyHook.php',
    'filepath' => 'hooks',
    'params' => array('first param', 'second param')
);


$hook['display_override'] = array(
    'class' => 'MyHook',
    'function' => 'DisplayOverride',
    'filename' => 'MyHook.php',
    'filepath' => 'hooks',
    'params' => array('first param', 'second param')
);

$hook['post_system'] = array(
    'class' => 'MyHook',
    'function' => 'PostSystem',
    'filename' => 'MyHook.php',
    'filepath' => 'hooks',
    'params' => array('first param', 'second param')
);
