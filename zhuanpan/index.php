<?php
ini_set("display_errors", true);
error_reporting(E_ALL);


function myErrorHandler($errno, $errstr, $errfile, $errline, $errcontext)
{
    if (!(error_reporting() & $errno)) {
        return false;
    }

    switch ($errno) {
        case E_USER_ERROR:
            echo "<b>My ERROR</b>[$errno] $errstr<br/>";
            echo "Fatal error on line $errline in file $errfile <br/>";
            echo ",PHP " . PHP_VERSION . " ( " . PHP_OS . " ) <br/>";
            echo "Aborting... <br/>";
            exit(1);
            break;
        case E_USER_WARNING:
            echo "<b>My WARNING </b>[$errno] $errstr<br/>";
            break;
        case E_USER_NOTICE:
            echo "<b>MY NOTICE</b>[$errno] $errstr<br/>";
            break;
        default:
            echo "Unknown error type: [$errno' $errstr'] <br/>";
            break;

    }
    return true;
}

set_error_handler("myErrorHandler");
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/11/15
 * Time: 下午6:23
 */
$category = 3;//奖品种类数
$lucknum = 0;//幸运数字

//每个奖品中奖的概率
$probability = array(
    10,//三等奖
    20,//二等奖
    30,//一等奖
);

//奖品名称
$prizename = array(
    'third prize',
    'second prize',
    'first prize',
);


//奖品在页面上的序号
$prizecode = array(
    3,
    2,
    1,
);

//随机选择对哪个奖品进行抽奖
$caterandom = mt_rand(0, $category - 1);

//对之前随机选择的奖品各类进行抽奖
$random = mt_rand(0, $probability[$caterandom]);

if ($random == $lucknum) {
    //如果抽中，返回奖品名称和奖品图片在页面上的序号
    $data = array(
        $prizename[$caterandom],
        $prizecode[$caterandom],
    );
    echo json_encode($data);
} else {
    //未抽中，返回谢谢参与文件和图片的序号
    $data = array(
        'Thank you!',
        5,
    );
    echo json_encode($data);
}

class MyClass
{
    public static $var = "helllo world";
    public $helo = "world";
}

$myClass = new MyClass();
//echo $myClass->helo;
echo $myClass->var;

//echo $myClass::$var;

trait MyTraitt
{
    public function test($arr)
    {
        echo $arr->helo;
        echo $arr::$var;
    }
}

class TwoClas
{
    use MyTraitt;
}

$two = new TwoClas();
$two->test(new MyClass());