<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/2/2
 * Time: 上午10:29
 * gittee　hook MeetStranger项目拉取代码
 */

//获取Push数据内容
$giteebody = file_get_contents("php://input");

file_put_contents("gitlog.log",$giteebody);

//拉取代码
shell_exec("cd ~/android/MeetStranger/ && git pull");
