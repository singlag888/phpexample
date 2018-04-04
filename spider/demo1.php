<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/3/24
 * Time: 下午2:44
 */

require_once '../Error.php';
require_once 'bmobDb.php';

function getUrlContent($url)
{
    $handler = fopen($url, 'r');
    if ($handler) {
        $content = stream_get_contents($handler, -1);
        return $content;
    } else {
        return false;
    }
}


/**
 * curl使用cookie 获取内容
 * 参考：PHP的curl实现get，post 和 cookie（几个实例）　http://justcoding.iteye.com/blog/842371
 * @param $filename string url地址
 * @return mixed
 */
function curlContent($filename)
{
    $cookie_jar = 'cookie.txt';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $filename);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //设置文件读取并提交的cookie路径
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
    $filecontent = curl_exec($ch);
    curl_close($ch);

    $ch = curl_init();
    $referer = "http://www.google.com/";
    curl_setopt($ch, CURLOPT_URL, $filename);
    curl_setopt($ch, CURLOPT_REFERER, $referer); // 看这里，你也可以说你从google来
    curl_setopt($ch, CURLOPT_USERAGENT, $referer);

    //$request = "JSESSIONID=abc6szw15ozvZ_PU9b-8r"; //设置POST参数
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    // 上面这句，当然你可以说你是baidu，改掉这里的值就ok了，可以实现小偷的功能，$_SERVER['HTTP_USER_AGENT']
    //你也可以自己做个 spider 了，那么就伪装这里的 CURLOPT_USERAGENT 吧
    //如果你要把这个程序放到linux上用php -q执行那也要写出具体的$_SERVER['HTTP_USER_AGENT']，伪造的也可以
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
    curl_setopt($ch, CURLOPT_HEADER, false);//设定是否输出页面内容
    curl_setopt($ch, CURLOPT_GET, 1); // post,get 过去

    $filecontent = curl_exec($ch);

//    preg_match_all("/charset=(.+?)[NULL\"\']/is", $filecontent, $charsetarray);
//    if (strtolower($charsetarray[1][0]) == "utf-8")
//        $filecontent = iconv('utf-8', 'gb18030//IGNORE', $filecontent);
    curl_close($ch);
    return $filecontent;
}

/**
 * @param string $rootUrl 域名
 * @param array $array 参数列表　
 * @return string 编码后的url
 */
function encodeUrl($rootUrl, $array)
{
    if (empty($array)) {
        return $rootUrl;
    }

    $rootUrl = $rootUrl . '?';
    foreach ($array as $key => $value) {
        $urlencode = urlencode($value);
        $rootUrl = $rootUrl . $key . '=' . $urlencode . '&';
    }
    return rtrim($rootUrl, '&');
}

/**
 * 新闻文章数据获取
 * @param $category
 * @param $pageSize
 */
function news($category, $pageSize)
{
    $rootUrl = "https://m.qmcai.com/support/cmsv2/information/queryContent";

    $param = array(
        'command' => 'queryContent',
        'categoryId' => $category,
        'offset' => 0,
        'size' => $pageSize,
//        'platform' => 'html',
//        'version' => '5.2.50',
//        'imei' => '862107033239906',
//        'userNo' => '',
//        'channel' => '980',
//        'clientPlatform' => 'android',
//        'productName' => 'gmcp',
    );
    $param = json_encode($param);
    $url = encodeUrl($rootUrl, array('parameter' => $param));
    //添加jsonp回调
    $url = $url . '&callback=jsonp';

    $content = getUrlContent($url);
    if ($content) {

        $content = ltrim($content, 'jsonp(');
        $content = rtrim($content, ')');

        $content = json_decode($content);

        $errorCode = $content->errorCode;
        $data = $content->data->dataConfig;
        $message = $content->message;

        if ($errorCode == '0000') {
            $total = $data->total;
            $offset = $data->offset;
            $size = $data->size;

            foreach ($data->data as $object) {
                $id = $object->id;
                $title = $object->title;
                $publishTime = $object->publishTime;
                $category = $object->category;
                $tag = $object->tag;
                $imageList = $object->imageList;

                $oneRow = array(
                    'id' => $id,
                    'title' => $title,
                    'publishTime' => $publishTime,
                    'category' => $category,
                    'tag' => $tag,
                    'imageList' => implode(',', $imageList),
                );

//                $join = join(',', $oneRow);
//                echo $join . '<br/>';
                $content = newsHtmlContent($id);

                newsAdd($oneRow, $imageList, $content);
            }
        } else {
            echo "接口返回错误！code:" . $errorCode . ' message: ' . $message;
        }
    } else {
        echo "<h2>接口连接错误!</h2>";
        var_dump($content);
    }

}

/**
 * @return bool|object 获取html内容。失败返回false
 */
function newsHtmlContent($newsId)
{

    $rootUrl = "https://m.qmcai.com/support/cmsv2/recommend/findByContentId";

    $param = array(
        'command' => 'queryContent',
        'contentId' => $newsId,
//        'platform' => 'html',
//        'version' => '5.2.50',
//        'clientPlatform' => 'android',
//        'productName' => 'gmcp',
    );
    $param = json_encode($param);
    $url = encodeUrl($rootUrl, array('parameter' => $param));
    //添加jsonp回调
    $url = $url . '&callback=jsonp';

    $content = getUrlContent($url);
    if ($content) {

        $content = ltrim($content, 'jsonp(');
        $content = rtrim($content, ')');

        $content = json_decode($content);


        $errorCode = $content->errorCode;
        $data = $content->data;
        $message = $content->message;

        if ($errorCode == '0000') {
            $creator = $data->creator;
            $htmlContent = $data->htmlContent;

            return $data;
        } else {
            echo "接口返回错误！code:" . $errorCode . ' message: ' . $message;
            return false;
        }
    } else {
        echo "<h2>接口连接错误!</h2>";
        var_dump($content);
        return false;
    }

}

/**
 * 技巧文章表数据获取
 * @param $category
 * @return bool
 */
function jiqiao($category)
{
//    https://app.66icp.com/cqssc/jiqiao?psize=100&pindex=1&PageSize=100&PageIndex=1&keyword=
//    $category = "cqssc";
    $size = 3;
    $url = "https://app.66icp.com/" . $category . "/jiqiao?psize=" . $size . "&pindex=1&PageSize=20&PageIndex=1&keyword=";

    $content = curlContent($url);
    if ($content) {
        $result = json_decode($content, true);
        $data = $result['data'];
        if (!empty($data)) {
            foreach ($data as $value) {

                $id = $value['id'];
                $title = $value['title'];
                $summary = $value['summary'];

                $jiqiaoContent = jiqiaoContent($id);
                if ($jiqiaoContent) {
                    $content = $jiqiaoContent['content'];
                    $date = $jiqiaoContent['date'];

                    $saveData = array(
                        'id' => $id,
                        'category' => $category,
                        'title' => $title,
                        'summary' => $summary,
                        'content' => $content,
                        'srcDate' => $date
                    );
                    jiQiaoArticleAdd($saveData);

//                    echo $title . $summary . $date . $content;
//                    echo "<br/>";
                }
            }
        }
    } else {
        echo '<h2>接口获取失败</h2>' . $url;
        var_dump($content);
        return false;
    }
}

function jiqiaoContent($id)
{
    $url = "https://app.66icp.com/tjssc/detail?id=" . $id;
    $content = curlContent($url);
    if ($content) {
        $result = json_decode($content, true);
        $data = $result['data'];
        if ($data) {
            return array("title" => $data['title'], "content" => $data['content'], "date" => $data['date']);
        } else {
            return false;
        }
    } else {
        echo '<h2>接口获取失败</h2>' . $url;
        var_dump($content);
        return false;
    }
}

newsRecently();

echo 'Please change the file to start collect data:<br/>';

//return;

//获取news新闻数据.每次拉取数据量
$newsCategory = array('csxw' => 10, 'lq' => 20, 'zq' => 40, 'jc' => 20);

foreach ($newsCategory as $category => $value) {

    set_time_limit(3600 * 2);//设置执行时间2个小时

    $startTime = microtime(true);

    news($category, $value);

    $endTime = microtime(true);

    $useTime = (($endTime - $startTime)) . '秒';
    echo '<h3> ' . strtoupper($category) . '　Use Time: ' . $useTime . '</h3>';

}

//技巧攫取数据
$jiqiaoCategory = array('cqssc', 'xjssc', 'tjssc', 'jx11x5', 'gd11x5', 'jsk3', 'pcdd', 'gdkl10', 'pk10');
foreach ($jiqiaoCategory as $category) {

    set_time_limit(3600 * 2);//设置执行时间2个小时

    $startTime = microtime(true);

    jiqiao($category);

    $endTime = microtime(true);

    $useTime = (($endTime - $startTime)) . '秒';
    echo '<h3> ' . strtoupper($category) . '　Use Time: ' . $useTime . '</h3>';
}



