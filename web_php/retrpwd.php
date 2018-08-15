<?php
header("Content-Type: text/html; charset=utf8");

// if(!isset($_POST['submit'])||!isset($_POST['submit1'])){
//     exit("错误执行");
// }//判断是否有submit操作
if (isset($_POST['submit'])) {
    // retrpwd();
    checkPer();
} else {
    exit("错误执行");
}
include "humanmachineverification.php";
if (!checkperson()) {
    echo "<script>alert('请进行人机验证！'); history.go(-1);</script>";
    // echo "123";
    exit();
}
include "checkinfo.php";
if (!checkemail($_POST['email']) || !checkname($_POST['name'])) {
    echo "<script>alert('请根据提示输入正确格式的信息！'); history.go(-1);</script>";
    // echo "123";
    exit();
}

function checkPer()
{
    $name = $_POST['name']; //post获取表单里的name
    // $token = md5($name . time());
    $email = trim($_POST['email']);

    include 'connect.php'; //链接数据库
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    // $sql = "select * from user where username = '$name' and email='$email'"; //检测数据库是否有对应的username和password的sql
    $sql = "select id,token from user where username = ? and email = ?";
    $stmt = $con->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $stmt->bind_result($id, $token);
    }
    if ($stmt->fetch()) {
        retrpwd($token);
    } else {
        echo "<script>alert('用户名或邮箱输入错误！'); history.go(-1);</script>";
    }
    $stmt->close();
}

function retrpwd($token)
{
    include 'connect.php'; //链接数据库
    include 'sendMail.php'; //发送激活邮件
    $name = $_POST['name']; //post获取表单里的name
    $email = trim($_POST['email']);
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $nowtime = time();
    $respwd = 1;
    $sql = "update user set respwd=?,restime=? where username=?";
    $stmt = $con->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("sss", $respwd, $nowtime, $name);
        if ($stmt->execute()) {
            postmail($email, '密码找回', $token, $name, 'retrpwd');
            header("refresh:3;url=login.html"); //如果成功跳转至登陆页面
            echo "请点击邮箱链接重置密码！"; //成功输出注册成功
            echo "3秒后将跳转登录界面！";
        }
    }
    $stmt->close();
    mysqli_close($con); //关闭数据库
    exit;
}
