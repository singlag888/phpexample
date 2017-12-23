<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/20
 * Time: 下午5:52
 */

function readDiectory($path)
{
    $handler = opendir($path);
    while (($item = readdir($handler)) !== false) {
        //过滤.和 ..目录
        if ($item != "." && $item != "..") {
            if (is_file($path . "/" . $item)) {
                $arr['file'][] = $item;
            }
            if (is_dir($path . "/" . $item)) {
                $arr['dir'][] = $item;
            }
        }
    }
    closedir($handler);
    return $arr;
}

//$path = 'file';
//print_r(readDiectory($path));

function createFolder($folderName)
{
    //验证文件名合法性，是否包含/,*,<>,?,|
    $pattern = "/[\/,\*,<>,\?,\|]/";
    if (!preg_match($pattern, basename($folderName))) {
        //检测是否存在同名文件
        if (!file_exists($folderName)) {
            if (mkdir($folderName)) {
                return "文件夹创建成功";
            } else {
                return "文件夹创建失败";
            }
        } else {
            return "文件夹已存在，请重命名后创建;";
        }
    } else {
        return "请输入正确的文件夹名";
    }
}

function dirSize($path)
{
    $sum = 0;
    global $sum;
    $handle = opendir($path);
    while (($item = readdir($handle)) !== false) {
        if ($item != "." && $item != "..") {
//            echo $item;
            if (is_file($path . "/" . $item)) {
                $sum += filesize($path . "/" . $item);
            }
            if (is_dir($path . "/" . $item)) {
                dirSize($path . "/" . $item);
            }
        }
    }
    closedir($handle);
    return $sum;
}

//echo "hello";
//$path = "file";
//echo dirSize($path);

function copyFolder($src, $dst)
{
//    echo $src."   ".$dst;
    //file/imooc1 file/world/hello/imooc1
    if (!file_exists($dst)) {
        mkdir($dst, 0777, true);
    }
    $handle = opendir($src);
    while (($item = readdir($handle)) !== false) {
        if ($item != "." && $item != "..") {
            if (is_file($src . "/" . $item)) {
                copy($src . "/" . $item, $dst . "/" . $item);
            }
            if (is_dir($src . "/" . $item)) {
                copyFolder($src . "/" . $item, $dst . "/" . $item);
            }
        }
    }
    closedir($handle);
    return "复制成功";
}

function renameFolder($oldName, $newName)
{
    if (checkFileName(basename($newName))) {
        //是否有同名文件夹
        if (!file_exists($newName)) {
            if (rename($oldName, $newName)) {
                $msg = "重命名成功";
            } else {
                $msg = "重命名失败";
            }
        } else {
            $msg = "存在同名文件夹";
        }
    } else {
        $msg = "非法文件夹名称";
    }
    return $msg;
}

function cutFolder($src, $dst)
{
    echo $src . "---" . $dst;
    if (file_exists($dst)) {
        if (is_dir($dst)) {
            if (!file_exists($dst . "/" . basename($src))) {
                if (rename($src, $dst . "/" . basename($src))) {
                    $msg = "剪切成功";
                } else {
                    $msg = "剪切失败";
                }
            } else {
                $msg = "存在同名文件夹";
            }
        } else {
            $msg = "目标是文件";
        }
    } else {
        $msg = "目标文件夹不存在”";
    }
    return $msg;
}

function delFolder($path)
{
    $handler = opendir($path);
    while (($item = readdir($handler)) !== false) {
        if ($item != "." && $item != "..") {
            if (is_file($path . "/" . $item)) {
                unlink($path . "/" . $item);
            }
            if (is_dir($path . "/" . $item)) {
                delFolder($path . "/" . $item);
            }
        }
    }
//    md5(uniqid(microtime(true),true));
    closedir($handler);
    rmdir($path);
    return "删除成功“”";
}