<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">

</head>

<body>
<h1>添加用户</h1>

<form action="empProcess.php" method="post">
    <table>
        <tr>
            <td>name</td>
            <td>
                <input type="text" name="name">
            </td>
        </tr>
        <tr>
            <td>grade(tinyint)</td>
            <td>
                <input type="text" name="grade">
            </td>
        </tr>
        <tr>
            <td>email</td>
            <td>
                <input type="text" name="email">
            </td>
        </tr>
        <tr>
            <td>salary(int)</td>
            <td>
                <input type="text" name="salary">
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
            <input type="hidden" name="flag" value="addEmp">
        </tr>
    </table>
</form>
</body>
</html>