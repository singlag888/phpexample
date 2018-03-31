<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/3/24
 * Time: 下午2:44
 */


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


newsRecently();

echo 'Please change the file to start collect data:<br/>';

//return;

//获取news新闻数据.每次拉取数据量
$newsCategory = array('csxw' => 20, 'lq' => 20, 'zq' => 30, 'jc' => 20);

foreach ($newsCategory as $category => $value) {

    set_time_limit(3600 * 2);//设置执行时间2个小时

    $startTime = microtime(true);

    news($category, $value);

    $endTime = microtime(true);

    $useTime = (($endTime - $startTime)) . '秒';
    echo '<h3>Use Time: ' . $useTime . '</h3>';

}


//newsHtmlContent();
//main();


