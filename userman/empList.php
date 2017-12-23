<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
</head>
<body>

<?php


require_once 'empService.php';
require_once 'FenyePage.php';
require_once 'common.php';

checkUserLegal();

$fenyePage = new FenyePage();

//分布
$fenyePage->pageNow = 1;
if (!empty($_GET['pageNow'])) {
    $fenyePage->pageNow = $_GET['pageNow'];
}

$fenyePage->pageCount = 0;//共几页，需要$rowCount计算
$fenyePage->pageSize = 5;//一页显示多少条记录
$fenyePage->rowCount = 0;//数据库中获取，共有几条记录
$fenyePage->gotoUrl = "empList.php";

$empService = new empService();
$empService->getFenyePage($fenyePage);
echo "<table border='1px' >";

echo "<tr><th>id</th><th>name</th><th>grade</th><th>email</th><th>salary</th><th><a href='#'>删除用户</a></th><th><a href='#'>修改用户</a></th></tr>";
for ($i = 0; $i < count($fenyePage->res_array); $i++) {
    $row = $fenyePage->res_array[$i];
    echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['grade']}</td><td>{$row['email']}</td><td>{$row['salary']}</td><td><a href='empProcess.php?flag=del&id={$row['id']}'>删除用户</a></td><td><a href='updataEmp.php?flag=updateEmp&id={$row['id']}&name={$row['name']}&grade={$row['grade']}&email={$row['email']}&salary={$row['salary']}'>修改用户</a></td></tr>";
}
echo "</table>";

echo $fenyePage->daohangtiao;
?>

</body>
</html>