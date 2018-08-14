<?php
header("Content-Type: text/html; charset=utf8");
session_start();
// if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
//     // echo "亲爱的用户：" . $_SESSION['name'];
// } else {
//     // exit("错误执行");
//     header("refresh:1;url=login.html"); //如果成功跳转至商品页面
// }
include_once "checklogin.php";
if (!isLogin()) {
    echo "<script>alert('请先登录！');setTimeout(function(){window.location.href='login.html';},100);
    </script>";
    exit();
}
$name = $_SESSION['name'];

if (isset($_POST['submit'])) {
    // checkPwd();
    if (checkpwd($name)) {
        updatePwd($_SESSION['name']);
    }
} else {
    exit("错误执行");
}

function checkpwd($name)
{
    $oldpwd = $_POST['password'];
    $newpwd = $_POST['password1'];
    if ($oldpwd && $newpwd) {
        include 'connect.php';

        $sql = "select password from user where username = ?";
        $stmt = $con->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($pwd);

        if ($stmt->fetch()) {
            if ($pwd == md5($oldpwd)) {
                return true;
            } else {
                echo "<script>alert('请检查原密码是否输入正确！'); history.go(-1);</script>";
                return false;
            }
        } else {
            echo "<script>alert('请正确登录');setTimeout(function(){window.location.href='login.html';},100);
         </script>";
            return false;
        }
    } else {
        echo "<script>alert('请正确填写所有信息！'); history.go(-1);</script>";
        return false;
    }
}

function updatePwd($name)
{
    $pwd1 = md5($_POST['password1']);

    include 'connect.php'; //链接数据库
    $q = "update user set password='$pwd1' where username = '$name'"; //向数据库插入表单传来的值的sql
    $sql = "update user set password = ? where username = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $pwd1, $name);
    // $stmt->execute();
    if ($stmt->execute()) {
        echo "<script>alert('密码更新成功！');setTimeout(function(){window.location.href='personalinfo.php';},1000);
        </script>";
    } else {
        die(mysqli_error($con)); //如果sql执行失败输出错误
    }
    $stmt->close();

    mysqli_close($con); //关闭数据库

}
