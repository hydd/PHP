<?php
session_start();
unset($_SESSION['search']);
// session_start();
header("Content-Type: text/html; charset=utf8");
if (!isset($_POST["submit"])) {
    exit("错误执行");
} //检测是否有submit操作
// if (isset($_REQUEST['autocode'])) {
//     // session_start();
//     if (strtolower($_POST['autocode']) != $_SESSION['authcode']) {
//         echo "<script>alert('请输入正确的验证码！'); history.go(-1);</script>";
//         exit();
//     }
// }
include "humanmachineverification.php";
if (!checkperson()) {
    echo "<script>alert('请进行人机验证！'); history.go(-1);</script>";
    // echo "123";
    exit();
}
include "checkinfo.php";
if (!checkusername($_POST['name']) || !checkpassword($_POST['password'])) {
    // echo "name" . checkusername();
    // echo "pwd" . checkpassword();
    echo "<script>alert('请输入正确格式的用户名或密码！'); history.go(-1);</script>";
    // echo "123";
    exit();
}
// function checkusername()
// {
//     $name = $_POST['name']; //post获得用户名表单值
//     if (!preg_match("/^[a-zA-Z0-9_-]{4,21}$/", $name)) {
//         // echo '密码必须由数字和字母的组合而成';
//         return false;
//     } else {
//         return true;
//     }
// }
// function checkpassword()
// {
//     $passowrd = $_POST['password']; //post获得用户密码单值
//     if (!preg_match("/^[a-zA-Z0-9_-]{4,21}$/", $passowrd)) {
//         // echo '密码必须由数字和字母的组合而成';
//         return false;
//     } else {
//         return true;
//     }

// }
include 'connect.php'; //链接数据库
$name = $_POST['name']; //post获得用户名表单值
$passowrd = $_POST['password']; //post获得用户密码单值
// $name = "test1";
// $passowrd = "123456";

if ($name && $passowrd) { //如果用户名和密码都不为空
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    // $sql = "select * from user where username = '$name' and password='$md5pwd'"; //检测数据库是否有对应的username和password的sql
    $sql = "select status from user where username = ? and password= ? "; //检测数据库是否有对应的username和password的sql

    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $name, md5($passowrd));
    $stmt->execute();

    $stmt->bind_result($status);

    if ($stmt->fetch()) {
        // printf("%s \n", $status);
        if ($status == '1') {
            $_SESSION['name'] = $name;
            if ($_SESSION['share'] == "shared") { // 点击心愿单进入的登录界面
                $url = $_SESSION['url'];
                header("refresh:0;url=$url"); //如果成功跳转至商品页面
            } else {
                header("refresh:0;url=products.php"); //如果成功跳转至商品页面
            }
            exit;
        } else {
            echo "<h1 align='center'>请先激活您的账号！</h1>";

            echo "
                      <script>
                            setTimeout(function(){window.location.href='login.html';},3000);
                      </script>";

            //如果错误使用js 1秒后跳转到登录页面重试;
        }

    } else {
        echo "<script>alert('用户名或密码错误！请重新输入'); history.go(-1);</script>";

    }
} else {
    echo "<script>alert('请正确填写用户名和密码！'); history.go(-1);</script>";

    //如果错误使用js 1秒后跳转到登录页面重试;
}
$stmt->close();
mysqli_close($con); //关闭数据库
