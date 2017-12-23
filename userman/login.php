<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <title>emp-system</title>
</head>
<body>
<?php require_once 'common.php'; ?>
<h2>emp login</h2>
<form action="loginProcess.php" method="post">
    用户名 <input type="text" name="username" value="<?php echo getCookie("username"); ?>"><br>
    密码 <input type="password" name="password"/>
    save cookie <input type="checkbox" name="cookie"><br>
    <input type="submit" value="登陆">
</form>
<?php
if (!empty($_GET['errNo'])) {
    $errNo = $_GET['errNo'];
    echo "<br><font color='red'>输入的密码或用户名不正确，请重新输入</font> " . $errNo;
}
?>
</body>
</html>