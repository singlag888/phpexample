<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2017/11/17
 * Time: 下午1:58
 */

require_once 'empService.php';

$empService = new empService();
if (!empty($_REQUEST['flag'])) {
    if ($_REQUEST['flag'] == "del") {
        $id = $_REQUEST['id'];
        if ($empService->deleteById($id) == 1) {
            header("Location: ok.php");
            exit();
        } else {
            header("Location: err.php");
            exit();
        }
    } else if ($_REQUEST['flag'] == 'addEmp') {
        $name = $_REQUEST['name'];
        $grade = $_REQUEST['grade'];
        $email = $_REQUEST['email'];
        $salary = $_REQUEST['salary'];
        if ($empService->addEmp($name, $grade, $email, $salary) == 1) {
            header("Location: ok.php");
            exit();
        } else {
            header("Location: err.php");
            exit();
        }
    } else if ($_REQUEST['flag'] == "selectEmp") {
        $id = $_REQUEST['id'];
        if ($res = $empService->selectEmp($id)) {
            echo "id{$res[0]['id']} name{$res[0]['name']} grade{$res[0]['grade']} email{$res[0]['email']} salary {$res[0]['salary']}";
        }
    } else if ($_REQUEST['flag'] == 'updateEmp') {
        $id = $_REQUEST['id'];
        $name = $_REQUEST['name'];
        $grade = $_REQUEST['grade'];
        $email = $_REQUEST['email'];
        $salary = $_REQUEST['salary'];
        if ($empService->updateEmp($id, $name, $grade, $email, $salary)) {
            header("Location: ok.php");
            exit();
        } else {
            header("Location: err.php");
            exit();
        }
    }
}