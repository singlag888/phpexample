<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/3/24
 * Time: 下午6:32
 */

include_once 'bmob/lib/BmobObject.class.php';
include_once 'bmob/lib/BmobUser.class.php';
include_once 'bmob/lib/BmobBatch.class.php';
include_once 'bmob/lib/BmobFile.class.php';
include_once 'bmob/lib/BmobImage.class.php';
include_once 'bmob/lib/BmobRole.class.php';
include_once 'bmob/lib/BmobPush.class.php';
include_once 'bmob/lib/BmobPay.class.php';
include_once 'bmob/lib/BmobSms.class.php';
include_once 'bmob/lib/BmobApp.class.php';
include_once 'bmob/lib/BmobSchemas.class.php';
include_once 'bmob/lib/BmobTimestamp.class.php';
include_once 'bmob/lib/BmobCloudCode.class.php';
include_once 'bmob/lib/BmobBql.class.php';


/**
 * @param array $data 资讯信息
 * @param array $images 图片列表
 */
function newsAdd($data = array(), $images = array(), $content)
{
    //1.查询是否保存过数据
    $bmobObject = new BmobObject("News");
    $isExits = $bmobObject->get('', array('where={"id":' . $data['id'] . '}', 'limit=5'));
//    var_dump($isExits);

    if (!empty($isExits->results)) {
        echo "news信息已保存过 id " . $data['id'] . ' title: ' . $data['title'] . '<br/>';
        return;
    }

    //2.保存照片到文件库中
    foreach ($images as $image) {
        $imageUrl = uploadFile($image);
        if ($imageUrl) {
            $imageUrls[] = array(
                'oldUrl' => $image,
                'newUrl' => $imageUrl,
            );
        }
    }
//3.替换html中图片地址
    $htmlContent = $content->htmlContent;
//    echo $htmlContent . '<br/>';
    foreach ($imageUrls as $value) {
        $str_replace = str_replace($value['oldUrl'], $value['newUrl'], $htmlContent);
    }

    //4.保存数据
    $data['htmlContent'] = isset($str_replace) ? $str_replace : $htmlContent;
    $data['imageList'] = empty($imageUrls) ? array() : array_column($imageUrls, 'newUrl');
    $data['creator'] = $content->creator;
//    var_dump($data);


    $res = $bmobObject->create($data);
//    var_dump($res);
//    object(stdClass)[10]
//  public 'createdAt' => string '2018-03-24 19:44:11' (length=19)
//  public 'objectId' => string '3ca159070c' (length=10)
    if (!$res->objectId) {
        echo '<h2>保存news信息错误</h2>' . $data['id'] . ' ' . $data['title'];
        var_dump($res);
    } else {
        echo 'Add news :' . $data['id'] . ' ' . $data['title'] . '<br/>';
    }
}

/**
 * @param string $url 文件表保存文件
 * @return bool|string 成功返回上传成功的url,失败返回false
 */
function uploadFile($url)
{
    if (empty($url)) return false;

    $bmobFile = new BmobFile();
    $resImg = $bmobFile->uploadFile2(basename($url), $url);

    $fileArray = array("__type" => "File", "group" => $resImg->group, "filename" => $resImg->filename, "url" => $resImg->url);
    $bmobObject = new BmobObject("file");
    $resImg = $bmobObject->create(array("file" => $fileArray));

    $var = $bmobObject->get($resImg->objectId);

    $imageUrl = $var->file->url;
    if (empty($imageUrl)) {
        echo "<h2>upload File error!</h2> " . $url;
        print_r($resImg);
        print_r($var);
    }

    return $imageUrl;
}

/**
 * 返回最近添加的news数据表记录
 */
function newsRecently()
{
    $bmobObject = new BmobObject('News');
    $newsRecently = $bmobObject->get('', array('order=-createdAt', 'limit=1'));
//    var_dump($newsRecently);
    $results = $newsRecently->results;
    if (empty($results)) {
        echo '还未添加数据';
    } else {
        $new = $results[0];
        echo '最后添加的记录为: title ' . $new->title . ' createdAt: ' . $new->createdAt . '<br/>';
    }
}

/**
 * @param array $data 技巧表保存数据
 */
function jiQiaoArticleAdd($data = array())
{
    //1.根据文章id查找是否保存过
    $bmobObject = new BmobObject("JiQiaoArticle");
    $isExits = $bmobObject->get('', array('where={"id":' . $data['id'] . '}', 'limit=5'));
    if (!empty($isExits->results)) {
        echo "jiQiaoArticle 已保存过 id " . $data['id'] . ' title: ' . $data['title'] . '<br/>';
        return;
    }

    //2.保存
    $res = $bmobObject->create($data);
    if (!$res->objectId) {
        echo '<h2>保存 jiQiaoArticle 错误</h2>' . $data['id'] . ' ' . $data['title'] . '<br/>';
        var_dump($res);
    } else {
        echo 'Add jiQiaoArticle :' . $data['id'] . ' ' . $data['title'] . '<br/>';
    }
}
