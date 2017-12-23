<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/12/20
 * Time: 下午6:42
 */

function transByte($size)
{
    $arr = array("Byte", "KB", "MB", "GB", "TB", "EB");
    $i = 0;
    while ($size >= 1024) {
        $size /= 1024;
        $i++;
    }
    return round($size, 2) . $arr[$i];
}


function createFile($fileName)
{
    //验证文件名合法性，是否包含/,*,<>,?,|
    $pattern = "/[\/,\*,<>,\?,\|]/";
    if (!preg_match($pattern, basename($fileName))) {
        //检测是否存在同名文件
        if (!file_exists($fileName)) {
            if (touch($fileName)) {
                return "文件创建成功";
            } else {
                return "文件创建失败";
            }
        } else {
            return "文件已存在，请重命名后创建;";
        }
    } else {
        return "请输入正确的文件名";
    }
}


function renameFile($oldName, $newName)
{
    if (checkFileName($newName)) {
        //检测是否存在同名文件
        if (!file_exists($newName)) {
//            $dirname = dirname($oldName);
            if (rename($oldName, $newName)) {
                return "重命名成功";
            } else {
                return "重命名失败";
            }
        } else {
            return "文件已存在，请重命名后创建;";
        }
    } else {
        return "请输入正确的文件名";
    }
}

function checkFileName($fileName)
{
    $pattern = "/[\/,\*,<>,\?,\|]/";
    if (preg_match($pattern, basename($fileName))) {
        return false;
    }
    return true;
}


function delFile($filename)
{
    if (unlink($filename)) {
        $msg = "文件删除成功";
    } else {
        $msg = "文件删除失败";
    }
    return $msg;
}


/**
 * 下载文件：
 * 1.简单文件下载通过超链接形式下载
 * 2.下载图片,html等类型文件，浏览器会直接显示
 * 3.通过header()函数发送网页头信息实现文件下载
 *  Header("Content-Disposition:attachment;filename=filename")
 *  Header("Content-Length:fileSize")
 *  ReadFile(fileName);
 *
 */
function downloadFile($fileName)
{
    Header("Content-Disposition:attachment;filename=" . basename($fileName));
    header("Content-Length:" . filesize($fileName));
    readfile($fileName);
}

function copyFile($filename, $dsc)
{
    if (file_exists($dsc)) {
        if (!file_exists($dsc . "/" . basename($filename))) {
            if (copy($filename, $dsc . "/" . basename($filename))) {
                $msg = "复制成功";
            } else {
                $msg = "复制失败";
            }
        } else {
            $msg = "目录文件已存在";
        }
    } else {
        $msg = "目标文件夹不存在";
    }
    return $msg;
}


function cutFile($filename, $dsc)
{
    if (file_exists($dsc)) {
        if (!file_exists($dsc . "/" . basename($filename))) {
            if (rename($filename, $dsc . "/" . basename($filename))) {
                $msg = "剪切成功";
            } else {
                $msg = "剪切失败";
            }
        } else {
            $msg = "目录文件已存在";
        }
    } else {
        $msg = "目标文件夹不存在";
    }
    return $msg;
}

function uploadFile($path, $fileInfo, $allowExt = array("gif", "png", "jpg", "jpeg", "txt"), $maxSize = 10485760)
{
    if ($fileInfo['error'] == UPLOAD_ERR_OK) {
        //文件是否通过http post 方式上传
        if (is_uploaded_file($fileInfo['tmp_name'])) {
            //上传文件类型限制
            $ext = getExt($fileInfo['name']);
            if (in_array($ext, $allowExt)) {
                if ($fileInfo['size'] <= $maxSize) {
                    $uniqid = getUniqidName();
                    $destFile = $path."/".pathinfo($fileInfo['name'],PATHINFO_FILENAME)."_".$uniqid.".".$ext;
                    if(move_uploaded_file($fileInfo['tmp_name'],$destFile)){
                        $msg = "上传成功";
                    }else{
                        $msg = "上传失败";
                    }
                } else {
                    $msg = "文件过大";
                }
            } else {
                $msg = "非法文件类型";
            }

        } else {
            $msg = "文件不是通过HTTP POST方式上传上来的";
        }
    } else {
        switch ($fileInfo['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $msg = "超过了配置文件的大小";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $msg = "超过了表单允许数据的大小";
                break;
            case UPLOAD_ERR_PARTIAL:
                $msg = "文件部分被上传";
                break;
            case UPLOAD_ERR_NO_FILE:
                $msg = "没有文件被上传";
                break;

        }
    }
    return $msg;
}
