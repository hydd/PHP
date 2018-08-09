<?php
session_start();
if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
    // echo ("验证通过");
} else {
    header("refresh:1;url=login.html");
    exit();
}
$name = $_SESSION['name'];

if (isset($_POST['submit'])) {
    // updateusername($name);
    if (checkname()) {
        findinfo($name);
    } else {
        echo "<script>alert('用户名已存在，请重新输入！'); history.go(-1);</script>";
    }
} else {
    header("refresh:1;url=login.html");
    exit("请先登录");
}

function checkname()
{
    include 'connect.php';
    $newname = $_POST['name'];
    mysqli_query($con, 'set names utf8');
    $sql = "select id from user where username = ?";
    $stmt = $con->stmt_init();

    if ($stmt->prepare($sql)) {
        $stmt->bind_param("s", $newname);
        $stmt->execute();

        $stmt->bind_result($id);
        if ($stmt->fetch() == "") {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
}

function findinfo($name)
{
    // echo $name;
    include "connect.php";
    mysqli_query($con, 'set names utf8');
    $sql = "select id from user where username = ?";
    $stmt = $con->stmt_init();

    if ($stmt->prepare($sql)) {
        $stmt->bind_param("s", $name);
        $stmt->execute();

        $stmt->bind_result($id);
        if ($stmt->fetch() != "") {
            // echo $id;
            updateusername($id);
        } else {
            // echo "false";
            return false;
        }
        $stmt->close();
    }
}

function updateusername($id)
{
    $newname = $_POST['name'];
    include "connect.php";
    mysqli_query($con, 'set names utf8');
    $sql = "update user set username = ? where id = ?";
    $stmt = $con->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("ss", $newname, $id);
        $stmt->execute();
        if ($stmt->execute()) {
            $_SESSION['name'] = $newname;
            header("refresh:0;url=personalInfo.php");
            echo "用户名修改成功呢";
            exit();
        } else {
            die(mysqli_error($con));
        }
        mysqli_close($con);
    }
}
