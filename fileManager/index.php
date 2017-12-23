<?php
require_once 'dir.func.php';
require_once 'file.func.php';
require_once 'common.func.php';
$path = "file";
$path = $_REQUEST['path'] ? $_REQUEST['path'] : $path;
$redirect = "index.php?path={$path}";
$info = readDiectory($path);
//print_r($info);



$act = $_REQUEST['act'];
$filename = $_REQUEST['filename'];
$dirname = $_REQUEST['dirname'];

if ($act == "createFile") {
    $msg = createFile($path . "/" . $filename);
    alertMes($msg, $redirect);
} elseif ($act == "createFolder") {
    $foldername = $_REQUEST['foldername'];
    $msg = createFolder($path . "/" . $foldername);
    alertMes($msg, $redirect);
} elseif ($act == "showContent") {
    $content = file_get_contents($filename);
//    echo $content;
//    echo "<textarea readonly='readonly' rows='10' cols='100'>{$content}</textarea>";
//    highlight_string($content);
//    highlight_file($filename);
    if (strlen($content)) {
        //高亮显示php内容
        $newContent = highlight_string($content, true);

        $str = <<<EOF
        <table width="80%" bgcolor="#add8e6" cellpadding="5" cellspacing="0">
            <tr>
                <td>
                {$newContent}
                </td>
            </tr>
        </table>
EOF;

        echo $str;
    } else {
        alertMes("文件没有内容，请编辑后再查看!", $redirect);
    }
} elseif ($act == "editContent") {
    //编辑文件内容
    $content = file_get_contents($filename);

    $str = <<<EOF
    <form action="index.php?act=doEdit" method="post">
        <textarea name="content"   cols="80%" rows="10">
            {$content}
        </textarea> <br>
        <input type="hidden" name="filename" value="{$filename}">
        <input type="submit" value="修改文件内容">
    </form>
EOF;
    echo $str;
} elseif ($act == "doEdit") {
// echo "doedit";

    $content = $_REQUEST['content'];
//echo $content;
    if (file_put_contents($filename, $content)) {
        $msg = "文件修改成功";
    } else {
        $msg = "文件修改失败";
    }
    alertMes($msg, $redirect);
} elseif ($act == "renameFile") {
    $basename = basename($filename);
    $str = <<<EOF
    <form action="index.php?act=doRename" method="post">
    请填写新文件名:<input type="text" name="newname" placeholder="{$basename}">
    <br>
    <input type="hidden" name="filename" value="{$filename}">
    <input type="submit" value="重命名">
    </form>
EOF;
    echo $str;
} elseif ($act == "doRename") {
//    echo $filename;
    $newname = $_REQUEST['newname'];
//    echo $newname;
    $dirname = dirname($filename);
    $msg = renameFile($filename, $dirname . "/" . $newname);
    alertMes($msg, $redirect);
} elseif ($act == "delFile") {
    $msg = delFile($filename);
    alertMes($msg, $redirect);
} elseif ($act == "downloadFile") {
    downloadFile($filename);
} elseif ($act == "copyFolder") {
    $str = <<<EOF
    <form action="index.php?act=doCopyFolder" method="post">
    将文件夹复制到:<input type="text" name="dstname" placeholder="请输入文件夹名">
    <br>
    <input type="hidden" name="path" value="{$path}">
    <input type="hidden" name="dirname" value="{$dirname}">
    <input type="submit" value="复制文件夹">
    </form>
EOF;
    echo $str;
} elseif ($act == "doCopyFolder") {
    $dstname = $_REQUEST['dstname'];
    $msg = copyFolder($dirname, $path . "/" . $dstname . "/" . basename($dirname));
    alertMes($msg, $redirect);
//    echo $redirect;
} elseif ($act == "renameFolder") {
    $str = <<<EOF
     <form action="index.php?act=doRenameFolder" method="post">
    请填写新文件夹名:<input type="text" name="newname" placeholder="{$dirname}">
    <br>
    <input type="hidden" name="dirname" value="{$dirname}">
    <input type="hidden" name="path" value="{$path}">
    <input type="submit" value="重命名">
    </form>
EOF;
    echo $str;
} elseif ($act == "doRenameFolder") {
    $newName = $_REQUEST['newname'];
//    echo $newName."--".$dirname."--".$path;
    $msg = renameFolder($dirname, $path . "/" . $newName);
    alertMes($msg, $redirect);
} elseif ($act == "cutFolder") {
    $str = <<<EOF
     <form action="index.php?act=doCutFolder" method="post">
    将文件夹剪切到:<input type="text" name="dstname" placeholder="dest folder name">
    <br>
    <input type="hidden" name="dirname" value="{$dirname}">
    <input type="hidden" name="path" value="{$path}">
    <input type="submit" value="剪切文件夹">
    </form>
EOF;
    echo $str;
} elseif ($act == "doCutFolder") {
//    echo "cut folder";

    $dstname = $_REQUEST['dstname'];
    $msg = cutFolder($dirname, $path . "/" . $dstname);
    alertMes($msg, $redirect);
} elseif ($act == "delFolder") {
    echo "del folder";
    $msg = delFolder($dirname);
    alertMes($msg, $redirect);
} elseif ($act == "copyFile") {
    $str = <<<EOF
    <form action="index.php?act=doCopyFile" method="post">
    将文件复制到:<input type="text" name="dstname" placeholder="请输入文件名">
    <br>
    <input type="hidden" name="path" value="{$path}">
    <input type="hidden" name="filename" value="{$filename}">
    <input type="submit" value="复制文件">
    </form>
EOF;
    echo $str;
} elseif ($act == "doCopyFile") {
    $dstname = $_REQUEST['dstname'];
    $msg = copyFile($filename, $path . "/" . $dstname);
    alertMes($msg, $redirect);
} elseif ($act == "cutFile") {
    $str = <<<EOF
     <form action="index.php?act=doCutFile" method="post">
    将文件剪切到:<input type="text" name="dstname" placeholder="dest file name">
    <br>
    <input type="hidden" name="filename" value="{$filename}">
    <input type="hidden" name="path" value="{$path}">
    <input type="submit" value="剪切文件">
    </form>
EOF;
    echo $str;
} elseif ($act == "doCutFile") {
    $dstname = $_REQUEST['dstname'];
    $msg = cutFile($filename, $path . "/" . $dstname);
    alertMes($msg, $redirect);
} elseif ($act == "uploadFile") {
//    echo "uploadFile";
    $myFile = $_FILES['myFile'];
    $msg = uploadFile($path, $myFile);
    alertMes($msg, $redirect);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Web File Manager</title>
    <link rel="stylesheet" href="cikonss.css">
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/jquery-ui.js"></script>
    <style type="text/css">
        body, p, div, ul, ol, table, dl, dd, dt {
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
        }

        ul, li {
            list-style: none;
            float: left;
        }

        #top {
            width: 100%;
            height: 48px;
            margin: 0 auto;
            background: #E2E2E2;
        }

        #navi a {
            display: block;
            width: 48px;
            height: 48px;
        }

        .small {
            width: 25px;
            height: 25px;
            border: 0;
        }

    </style>
    <script>
        function show(dis) {
            document.getElementById(dis).style.display = "block";
        }

        function showDetail(fileName, filePath) {
            $("#showImg").attr("src", filePath);
            $("#showDetail").dialog({
                height: "auto",
                width: "auto",
                position: {my: "center", at: "center", collision: "fit"},
                resizable: true,
                draggable: true,
                modal: false,
                title: fileName,
                show: "slide",
                hide: "explode"
            });
        }

        function delFile(fileName) {

            console.error(fileName);
            if (window.confirm("确定要删除文件!")) {
                location.href = "index.php?act=delFile&filename=" + fileName;
            }
        }

        function goBack($back) {
            location.href = "index.php?path=" + $back;
        }

        function delFolder($filename, $path) {
            if (window.confirm("确定要删除文件夹吗?”")) {
                location.href = "index.php?act=delFolder&dirname=" + $filename + "&path=" + $path;
            }
        }

    </script>
</head>

<body>

<div id="showDetail" style="display: none;" title="Picture">
    <img src="" alt="" id="showImg">
</div>

<h1>Web file Manager</h1>

<div id="top">
    <ul id="navi">
        <li><a href="index.php" title="主目录"><span style="margin-left: 8px; margin-top: 0px; top: 4px;"
                                                  class="icon icon-small icon-square"><span
                            class="icon-home"></span></span></a></li>
        <li><a href="#" onclick="show('createFile')" title="新建文件"><span
                        style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span
                            class="icon-file"></span></span></a></li>
        <li><a href="#" onclick="show('createFolder')" title="新建文件夹"><span
                        style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span
                            class="icon-folder"></span></span></a></li>
        <li><a href="#" onclick="show('uploadFile')" title="上传文件"><span
                        style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span
                            class="icon-upload"></span></span></a></li>
        <li><a href="#" title="返回上级目录"
               onclick="goBack('<?php $back = ($path == "file") ? "file" : dirname($path);
               echo $back; ?>')"><span
                        style="margin-left: 8px; margin-top: 0px; top: 4px;"
                        class="icon icon-small icon-square"><span
                            class="icon-arrowLeft"></span></span></a></li>
    </ul>
</div>

<form action="index.php" method="post" enctype="multipart/form-data">


    <table width="100%" border="1" cellpadding="5" cellspacing="0" bgcolor="#abcdef" align="center">

        <tr id="createFile" style="display: none;">
            <td>请输入名称</td>
            <td>
                <input type="text" name="filename">
                <input type="hidden" name="path" value="<?php echo $path ?>">
                <input type="hidden" name="act" value="createFile">
                <input type="submit" value="创建文件">
            </td>
        </tr>
        <tr id="createFolder" style="display: none;">
            <td>请输入名称</td>
            <td>
                <input type="text" name="foldername">
                <input type="hidden" name="path" value="<?php echo $path ?>">
                <input type="hidden" name="act" value="createFolder">
                <input type="submit" value="创建文件夹">
            </td>
        </tr>
        <tr id="uploadFile" style="display: none;">
            <td>请选择文件</td>
            <td>
                <input type="file" name="myFile">
                <input type="hidden" name="act" value="uploadFile">
                <input type="submit" value="上传文件">
            </td>
        </tr>

        <tr>
            <td>编号</td>
            <td>名称</td>
            <td>类型</td>
            <td>大小</td>
            <td>可读</td>
            <td>可写</td>
            <td>可执行</td>
            <td>创建时间</td>
            <td>修改时间</td>
            <td>访问时间</td>
            <td>操作</td>
        </tr>

        <!--        文件夹-->
        <?php
        $i = 1;
        if ($info['dir']) {
            foreach ($info['dir'] as $val) {
                $filePath = $path . "/" . $val;
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $val ?></td>
                    <td><?php $src = filetype($filePath) == 'file' ? "file_ico.png" : "folder_ico.png" ?><img
                                src="img/<?php echo $src; ?>" alt="" title="文件"></td>
                    <td><?php $sum = 0;
                        echo transByte(dirSize($filePath)) ?></td>
                    <td><?php $src = is_readable($filePath) ? "correct.png" : "error.png" ?><img class="small"
                                                                                                 src="img/<?php echo $src; ?>"
                                                                                                 alt=""></td>
                    <td><?php $src = is_writable($filePath) ? "correct.png" : "error.png" ?><img class="small"
                                                                                                 src="img/<?php echo $src; ?>"
                                                                                                 alt=""></td>
                    <td><?php $src = is_executable($filePath) ? "correct.png" : "error.png"; ?> <img
                                src="img/<?php echo $src; ?>" class="small" alt=""></td>
                    <td><?php echo date('Y-m-d H:i:s', filectime($filePath)) ?></td>
                    <td><?php echo date('Y-m-d H:i:s', filemtime($filePath)) ?></td>
                    <td><?php echo date('Y-m-d H:i:s', fileatime($filePath)) ?></td>
                    <td>
                        <a href="index.php?path=<?php echo $filePath; ?>"><img class="small"
                                                                               src="img/show.png"
                                                                               title="查看" alt=""></a>
                        <a href="index.php?act=renameFolder&dirname=<?php echo $filePath; ?>&path=<?php echo $path; ?>"><img
                                    class="small"
                                    src="img/rename.png"
                                    title="重命名"
                                    alt=""></a>
                        <a href="index.php?act=copyFolder&path=<?php echo $path; ?>&dirname=<?php echo $filePath; ?>"><img
                                    class="small" src="img/copy.png" title="复制" alt=""></a>
                        <a href="index.php?act=cutFolder&path=<?php echo $path; ?>&dirname=<?php echo $filePath; ?>"><img
                                    class="small" src="img/cut.png" title="剪切" alt=""></a>
                        <a href="#" onclick="delFolder('<?php echo $filePath; ?>','<?php echo $path; ?>')"><img
                                    class="small" src="img/delete.png"
                                    title="删除" alt=""></a>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>

        <!--        文件-->
        <?php
        if ($info['file']) {
            foreach ($info['file'] as $val) {
                $filePath = $path . "/" . $val;
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $val ?></td>
                    <td><?php $src = filetype($filePath) == 'file' ? "file_ico.png" : "folder_ico.png" ?><img
                                src="img/<?php echo $src; ?>" alt="" title="文件"></td>
                    <td><?php echo transByte(filesize($filePath)) ?></td>
                    <td><?php $src = is_readable($filePath) ? "correct.png" : "error.png" ?><img class="small"
                                                                                                 src="img/<?php echo $src; ?>"
                                                                                                 alt=""></td>
                    <td><?php $src = is_writable($filePath) ? "correct.png" : "error.png" ?><img class="small"
                                                                                                 src="img/<?php echo $src; ?>"
                                                                                                 alt=""></td>
                    <td><?php $src = is_executable($filePath) ? "correct.png" : "error.png"; ?> <img
                                src="img/<?php echo $src; ?>" class="small" alt=""></td>
                    <td><?php echo date('Y-m-d H:i:s', filectime($filePath)) ?></td>
                    <td><?php echo date('Y-m-d H:i:s', filemtime($filePath)) ?></td>
                    <td><?php echo date('Y-m-d H:i:s', fileatime($filePath)) ?></td>
                    <td>
                        <?php
                        //获取文件扩展名
                        $ext = strtolower(end(explode(".", $val)));
                        $imageExt = array("gif", "jpg", "jpeg", "png");
                        if (in_array($ext, $imageExt)) {
                            ?>
                            <a href="#" onclick="showDetail('<?php echo $val; ?>','<?php echo $filePath; ?>')"><img
                                        class="small"
                                        src="img/show.png"
                                        title="查看" alt=""></a>
                            <?php
                        } else {
                        ?>
                        <a href="index.php?act=showContent&filename=<?php echo $filePath ?>"><img class="small"
                                                                                                  src="img/show.png"
                                                                                                  title="查看" alt=""></a>
                        <a href="index.php?act=editContent&filename=<?php echo $filePath ?>"><img class="small"
                                                                                                  src="img/edit.png"
                                                                                                  title="修改" alt=""></a>
                            <?php
                            }
                            ?>

                        <a href="index.php?act=renameFile&filename=<?php echo $filePath; ?>"><img class="small"
                                                                                                      src="img/rename.png"
                                                                                                      title="重命名"
                                                                                                      alt=""></a>
                        <a href="index.php?act=copyFile&path=<?php echo $path ?>&filename=<?php echo $filePath ?>"><img
                                    class="small" src="img/copy.png" title="复制" alt=""></a>
                        <a href="index.php?act=cutFile&path=<?php echo $path ?>&filename=<?php echo $filePath ?>"><img
                                    class="small" src="img/cut.png" title="剪切" alt=""></a>
                        <a href="#" onclick="delFile('<?php echo $filePath ?>')"><img class="small" src="img/delete.png"
                                                                                      title="删除" alt=""></a>
                        <a href="index.php?act=downloadFile&filename=<?php echo $filePath ?>"><img class="small"
                                                                                                   src="img/download.png"
                                                                                                   title="下载"
                                                                                                   alt=""></a>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>

    </table>

</form>

</body>
</html>