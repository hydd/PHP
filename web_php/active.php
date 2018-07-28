<?php

$verify = stripslashes(trim($_GET['verify']));
$type = stripslashes(trim($_GET['type']));
// echo $type;
// $nowtime = time();
if ($type == "signup") {
    newAccount($verify);
} else {
    changePwd($verify);
}

function newAccount($verify = '')
{
    include_once "connect.php"; //连接数据库
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select id from user where status='0' and token='$verify'"; //检测数据库是否有对应的username和password的sql
    $result = $con->query($sql);
    // while ($row = mysqli_fetch_array($result)) {
    //     echo $row['id'];
    // }

    $row = mysqli_fetch_array($result); //返回一个数值

    if ($row) {
        $row_id = $row['id'];
        // echo "18".$row['id'];
        $sql = "update user set status=1 where id='$row_id'";
        $result = $con->query($sql);
        // echo "21" . $result;
        // mysqli_query("update user set status=1 where id=" . $row['id']);
        if (!$result) {
            die(mysqli_error($con)); //如果sql执行失败输出错误
        } else {
            $msg = '激活成功！';
            header("refresh:1;url=login.html"); //如果成功跳转至登陆页面
        }
    } else {
        $msg = 'error.';
    }
    echo $msg;

}

function changePwd($verify = '')
{
    include_once "connect.php"; //连接数据库
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select id from user where status='1' and token='$verify'"; //检测数据库是否有对应的username和password的sql
    $result = $con->query($sql);
    // while ($row = mysqli_fetch_array($result)) {
    //     echo $row['id'];
    // }

    $row = mysqli_fetch_array($result); //返回一个数值
    // echo $row;
    if ($row != '') {
        $msg = '账户验证成功。';
        showPwd($verify);
    } else {
        $msg = '账户尚未激活，请先进入邮箱激活账户。';
        header("refresh:1;url=login.html"); //如果成功跳转至登陆页面
    }
    echo $msg;

}

function showPwd($verify = '')
{
    include "connect.php"; //连接数据库
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select password from user where status='1' and token='$verify'"; //检测数据库是否有对应的username和password的sql
    $result = $con->query($sql);
    // while ($row = mysqli_fetch_array($result)) {
    //     echo $row['id'];
    // }

    $row = mysqli_fetch_array($result); //返回一个数值
    // echo $row;
    echo "请牢记您的密码：" . $row['password'];
    echo "<br>";
    echo "界面将在5秒后跳转.";
    header("refresh:5;url=login.html"); //如果成功跳转至登陆页面
}
