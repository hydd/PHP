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
    if(checkname()){
        findinfo($name);
    }else{
        echo "<script>alert('用户名已存在，请重新输入！'); history.go(-1);</script>";       
    }
} else {
    header("refresh:1;url=login.html");
    exit("请先登录");
}

function checkname()
{
    $newname = $_POST['name'];

    include 'connect.php';
    mysqli_query($con, 'set names utf8');
    $sql = "select id from user where username = '$newname'";
    $result = $con->query($sql);
    $row = mysqli_fetch_array($result);

    if ($row[id] != "") {
        return false;
    } else {
        return true;
    }
}

function findinfo($name)
{
    include "connect.php";
    mysqli_query($con, 'set names utf8');
    $sql = "select id from user where username = '$name'";
    $result = $con->query($sql);
    $row = mysqli_fetch_array($result);

    if ($row != "") {
        updateusername($row['id']);
    } else {
        echo "null";
    }
}

function updateusername($id)
{
    $newname = $_POST['name'];

    include "connect.php";
    mysqli_query($con, 'set names utf8');
    $sql = "update user set username = '$newname' where id = '$id'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die(mysqli_error($con));
    }else{
        $_SESSION['name'] = $newname;        
        header("refresh:0;url=personalinfo.php");
        echo "用户名修改成功呢";
        exit();
    }
    mysqli_close($con);
}
