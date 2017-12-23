<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
</head>
<body>
<?php
require_once 'common.php';

checkUserLegal();

$id = $_REQUEST['id'];
echo "欢迎" . $id . "登陆";

getLastTime();

?>

<h1>Main View</h1>
<a href="empList.php">管理用户</a>
<a href="addEmp.php">添加用户</a>
<a href="selectEmp.php">查询用户</a>
</body>
</html>