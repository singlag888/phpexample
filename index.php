<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/11/16
 * Time: 上午9:23
 */

//ini_set("error_reporting", true);
//error_reporting(E_ALL);
//error_reporting(E_STRICT);
require_once 'Error.php';
/*
$input = <<<'EOD'
1;PHP;Likes dollar signs
2;Python;Likes whitespace
3;Ruby;Likes blocks
EOD;

function input_parser($input)
{
    foreach (explode("\n", $input) as $line) {
        $fields = explode(";", $line);
        $id = array_shift($fields);
        yield $id => $fields;
    }
}

foreach (input_parser($input) as $id => $fields) {
    echo "$id:<br/>";
    echo "    $fields[0]<br/>";
    echo "    $fields[1]<br/>";
}*/

/*
function gen_three_nulls()
{
    foreach (range(1, 3) as $i) {
        yield;
    }
}

var_dump(iterator_to_array(gen_three_nulls()));*/
/*
function &gen_reference()
{
    $value = 3;
    while ($value > 0) {
        yield $value;
    }
}

foreach (gen_reference() as &$number) {
    echo (--$number) . '... ';
}*/
/*
function foo(&$var)
{

}

foo($a);

$b = array();
foo($b['b']);

var_dump(array_key_exists('b', $b));

$c = new stdClass();
foo($c->d);
var_dump(property_exists($c, 'd'));*/

/*
$var1 = "Example variable";
$var2 = "";

function global_references($use_globals)
{
    global $var1, $var2;
    if (!$use_globals) {
        $var2 = &$var1;
    } else {
        $GLOBALS["var2"] = &$var1;
    }
}

global_references(true);
echo "var2 is set to'$var2'<br/>";
global_references(false);
echo "var2 is set to '$var2'<br/>";
*/
/*
$ref = 0;
$row = &$ref;
foreach (array(1,2,3) as $row){
    echo $row."<br/>";
}
echo $ref;*/
/*
function foo(&$var)
{
    $var++;
}

$a = 5;
echo foo($a);
echo $a;*/
/*
function foo(&$var)
{
//    $var = &$GLOBALS['baz'];
    $var++;
}

//foo($bar);

function bar()
{
    $a = 5;
    return $a;
}

foo(bar());

foo($a = 5);
foo(5);

echo $a;*/
/*
class foo{
    public $value = 42;

    public function &getValue(){
        return $this->value;
    }
}


$obj = new foo();
$myValue  = &$obj->getValue();
$obj->value = 2;
echo $myValue;

*/

/*
function test()
{
    $foo = "local variable";
    echo "$foo in global scope: " . $GLOBALS['foo'] . "\n";
    echo "$foo in current scope: " . $foo . "\n";
}
$foo = "Example content";
test();

echo $_SERVER['PHP_SELF'];
echo $_SERVER['SERVER_ADDR'];
echo $_SERVER['SERVER_NAME']."<br/>";
echo $_SERVER['DOCUMENT_ROOT']."<br/>";
echo $_SERVER['HTTP_ACCEPT']."<br/>";
echo $_SERVER['REMOTE_ADDR']."<br/>";
echo $_SERVER['REMOTE_HOST']."<br/>";
echo $_SERVER['REMOTE_PORT']."<br/>";*/

/*迭代器
class myIterator implements Iterator
{
    private $position = 0;
    private $array = array(
        "firstelement",
        "secondelement",
        "thirdelement",
    );

    public function __construct()
    {
        $this->position = 0;
    }

    public function rewind()
    {
        var_dump(__METHOD__);
        $this->position = 0;
    }

    public function current()
    {
        var_dump(__METHOD__);
        return $this->array[$this->position];
    }

    public function key()
    {
        var_dump(__METHOD__);
        return $this->position;
    }

    public function next()
    {
        var_dump(__METHOD__);
        ++$this->position;
    }

    public function valid()
    {
        var_dump(__METHOD__);
        return isset($this->array[$this->position]);
    }
}

$it = new myIterator();
foreach ($it as $key => $value) {
    var_dump($key, $value);
    echo "<br/>";
}*/

/*
class MyData implements IteratorAggregate
{

    public $property1 = "Public property one";
    public $property2 = "Public property two";
    public $property3 = "Public property three";

    public function __construct()
    {
        $this->property4 = "last property";
    }

    public function getIterator()
    {
        return new ArrayIterator($this);
    }
}


$obj = new MyData();
foreach ($obj as $key => $value) {
    var_dump($key, $value);
    echo "<br/>";
}
*/

/*
class obj implements ArrayAccess
{
    private $container = array();

    public function __construct()
    {
        $this->container = array(
            "one" => 1,
            "two" => 2,
            "three" => 3,
        );
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

}

$obj = new obj();

var_dump(isset($obj['two']));
var_dump($obj['two']);

unset($obj['two']);

var_dump(isset($obj['two']));

$obj['two'] = "A value";
var_dump($obj['two']);

$obj[] = "Append 1";
$obj[] = "Append 2";
$obj[] = "Append 3";
print_r($obj);*/
/*
class  obj implements Serializable
{

    private $data;

    public function __construct()
    {
        $this->data = "My private data";
    }

    public function serialize()
    {
        return serialize($this->data);
    }

    public function unserialize($serialized)
    {
        $this->data = unserialize($serialized);
    }

    public function getData()
    {
        return $this->data;
    }
}

$obj = new obj();
$ser = serialize($obj);
var_dump($ser);

echo "<br/>";

$newobj = unserialize($ser);
var_dump($newobj->getData());*/
/*
$opts = array(
    'socket' => array(
        'bindto' => '192.168.0.100:0',
    )
);

$context = stream_context_create($opts);

echo file_get_contents('http://www.example.com', false, $context);*/

/*
$postdata = http_build_query(
    array(
        'var1' => 'some content',
        'var2' => 'doh',
    )
);
$opts = array('http' =>
    array(
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    ));

$context = stream_context_create($opts);

var_dump($context);

$result = file_get_contents('http://example.com/submit.php', false, $context);

echo $result;*/
/*
if(!isset($_SERVER['PHP_AUTH_USER'])){
    header('WWW-Authenticate:Basic realm="My realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Text to send if user hits Cancel button";
    exit;
}else{
echo "<p>Hello ${$_SERVER['PHP_AUTH_USER']}.</p>";
echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password </p>";
}*/
/*
function authenticate(){
    header('WWW-Authenticate: Basic realm="Test Authentication System"');
    header('HTTP/1.0 401 Unauthorized');
    echo "You must enter a valid login ID and password to access this resources\n";
    exit;
}

if(!isset($_SERVER['PHP_AUTH_USER']) || ($_POST['SeenBefore']==1 && $_POST['OldAuth']==$_SERVER['PHP_AUTH_USER'])){
    authenticate();
}else{
    echo "<p>Welcome: {$_SERVER['PHP_AUTH_USER']}<br/>";
    echo "Old: {$_REQUEST['OldAuth']}";
    echo "<form action='{$_SERVER['PHP_SELF']}' METHOD='post'>";
    echo "<input type='hidden' name='SeenBefore' value='1' /><br/>";
    echo "<input type='hidden' name='OldAuth' value='{$_SERVER['PHP_AUTH_USER']}'/><br/>";
    echo "<input type='submit' value='Re Authenticate'/><br/>";
    echo "</form></p>";
}
*/

//$a = "new string";
//
//xdebug_debug_zval($a);
//
//log("hello world");
/*
$defined = defined("world");

echo $defined . "<br/>";
var_dump($defined);

define("world", __DIR__);

$defined = defined("world");

echo $defined;
var_dump($defined);

class Test
{
    public static function readMe()
    {
        for ($i = 0; $i < 10; $i++) {

        }

    }
}

echo "<br/>";

interface Video{
    public function getVideos();
    public function getCount();
}

class Movie implements Video{

    public function __construct()
    {
        echo __FILE__.__LINE__;
    }

    public function getVideos()
    {
        return "videos";
    }

    public function getCount()
    {
        return 32;
    }
}*/

//echo Movie::getVideos();

//$movie = new Movie();

#[PHP中使用静态方式调用非静态方法的问题](http://www.chanxiaoxi.me/2015/11/18/static-call-non-static-method-in-php/)

//phpinfo();
/*
$defined = defined('STDIN');
var_dump($defined);

//一个php同时只能执行一个？从两个地方调用？
//获取当前文件目录
var_dump(realpath('.'));
var_dump(getcwd());

chdir("/Users/hello/");

var_dump(realpath('.'));
var_dump(getcwd());

$fopen = fopen('php://stdin', 'r');
//var_dump($fopen);
while ($line = fgets($fopen)) {
    if (!empty($line)) {
        echo $line;
    } else {
        break;
    }
}

fclose($fopen);*/


//$fout = fopen('php://stdout', 'w');
//var_dump($fout);
//
//$ferror = fopen('php://stderr', 'r');
//var_dump($ferror);


//$file_exists = file_exists(__FILE__);
//var_dump($file_exists);
//
////var_dump(class_exists('SingleDb',true));
//var_dump(class_exists('SingleDb',false));
//require_once('appapi/SingleDb.php');
//
//class MyIndex
//{
//    public function __construct()
//    {
//        echo 'construct';
//    }
//}

//[microtime 与 time 函数介绍](http://blog.csdn.net/lizixiang1993/article/details/50917693)
//phpinfo();
//ini_set('precision',18);

//$start = microtime();
//sleep(3);
//$end = microtime();
//$dump = number_format($end-$start,4);
//echo 'start:' . $start . 'end:' . $end . ' diff:'.$dump;
//
//var_dump(time());
/*$protocol;
$b = empty($protocol) && $protocol = 'REQUEST_URI';
var_dump($b);
var_dump($protocol);
var_dump(empty($protocol) && $protocol = 'REQUEST_URI');
$extension_loaded = extension_loaded('zlib');
var_dump($extension_loaded);
echo 'mbstring.func_overload : ' . ini_get('mbstring.func_overload');
var_dump(ini_get('mbstring.func_overload'));

$headers = headers_list();
var_dump($headers);
for ($i = 0; $i < count($headers); $i++) {
    $str = $headers[$i];
    echo $str.'<br/>';
    if (sscanf($str, 'Content-type: %[^;]', $content_type) === 1) {
        echo $content_type;
    }
}
echo '<br/>';

$str = "If you divide 4 by 2 you'll get 2";
$format = sscanf($str,"%s %s %s %d %s %d %s %s %c");
print_r($format);

$filepath = '/Users/hello/PhpstormProjects/example/CodeIgniter/application/cache/ae9ecdd53d95aa0a0faa8c5ba5131f05';
var_dump($fp = @fopen($filepath, 'rb'));*/

//require_once 'oauth.php';


//session_start();
//if (!isset($_SESSION['count'])) {
//    $_SESSION['count'] = 0;
//} else {
//    $_SESSION['count']++;
//}
//$session_id = session_id();
//if (!isset($_COOKIE["seCookie"])) {
//    setcookie("seCookie", $session_id);
//}
//if (!isset($_COOKIE['name'])) {
//    setcookie('name', 'hello');
//} else {
//    $str = 'world ' . $_SESSION['count'];
//    setcookie('name', $str);
//}
//session_write_close();
//
//
//function foobar($arg, $arg2)
//{
//    echo __FUNCTION__ . " got $arg and $arg2 <br/>";
//}
//
//class foo
//{
//    function bar($arg, $arg2)
//    {
//        echo __METHOD__ . " got $arg and $arg2 <br/>";
//    }
//}
//
//call_user_func_array("foobar", array("one", "two"));
////foobar got one and two
//$foo = new foo();

echo 'hello welcome to https';
//call_user_func_array(array($foo,"bar"),array("three","four"));
//foo::bar got three and four

//require 'shopImmoc/lib/string.func.php';
//var_dump(buildRandomString(1));
//var_dump(buildRandomString(2));
//var_dump(buildRandomString(3));
//
//var_dump(gd_info());
//phpinfo();

//echo '<br/>' . $_SESSION['count'] . '<br/>';

//获取Push数据内容
$giteebody = file_get_contents("php://input");

file_put_contents("gitlog.log",$giteebody);
echo $giteebody;
//拉取代码
shell_exec("cd ~/android/MeetStranger/ && git pull");

