<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
</head>
<body>
<h1>修改用户</h1>
<?php

if ($_REQUEST['flag'] == "updateEmp") {
    $id = $_REQUEST['id'];
    $name = $_REQUEST['name'];
    $grade = $_REQUEST['grade'];
    $email = $_REQUEST['email'];
    $salary = $_REQUEST['salary'];
}

?>

<form action="empProcess.php" method="post">
    <table>
        <tr>
            <td>
                id
            </td>
            <td>
                <input type="text" readonly="readonly" name="id" value="<?php echo $id;?>">
            </td>
        </tr>
        <tr>
            <td>
                name
            </td>
            <td>
                <input type="text"  name="name" value="<?php echo $name;?>">
            </td>
        </tr>
        <tr>
            <td>
                grade(tinyint)
            </td>
            <td>
                <input type="text" name="grade" value="<?php echo $grade;?>">
            </td>
        </tr>
        <tr>
            <td>
                email
            </td>
            <td>
                <input type="text"  name="email" value="<?php echo $email;?>">
            </td>
        </tr>
        <tr>
            <td>
                salary
            </td>
            <td>
                <input type="text"  name="salary" value="<?php echo $salary;?>">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="go">
            </td>
            <td>
                <input type="reset" value="reset">
            </td>
        </tr>
        <tr>
            <input type="hidden" name="flag" value="updateEmp">
        </tr>
    </table>
</form>

</body>
</html>