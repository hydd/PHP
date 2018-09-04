<?php
session_start();
include "dealcollection.php";
include_once "checklogin.php";
$flag = false;
if (isLogin()) {
    // header("refresh:1;url=login.html"); //如果成功跳转至商品页面
    $flag = true;
    if (isset($_SESSION['share']) && $_SESSION['share'] == "shared") {
        unset($_SESSION['share']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<html xmlns:wb="http://open.weibo.com/wb">

<head>
    <meta charset="utf-8">
    <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <title>心愿单</title>
    <!-- Bootstrap core CSS -->

    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
    <script language="JavaScript">
    </script>

</head>

<body>

    <div class="container theme-showcase" role="main">

    <?php
if (!isLogin()) {
    echo "<a href='login.html' style='font-size:8' class='col-md-offset-9'>登录</a>";
    echo "<a href='signup.html' style='font-size:8' class='col-md-offset-1'>没有账号？点击注册</a>";
} else {
    $name = $_SESSION['name'];
    echo "<a href='' class='col-md-offset-9'></a>" . $name . "<a href='logout.php' class='col-md-offset-1' style='text-decoration: none;'>点击退出</a>";
}
?>

        <div class="jumbotron">
            <?php
include "encryption.php";
include "userinfo.php";
$share = $_GET['share'];

// 解密用户ID
$uid = decrypt($share);
// echo $id;

if (is_numeric($uid) && isUser($uid)) {
    $user = getuser($uid);
    if (!isLogin()) {
        // 设置标志位，当用户通过他人分享心愿单链接进行登录是，登录后跳转到他人心愿单界面
        $_SESSION['share'] = "shared";

        $url = "http://118.25.102.34/hydd/showtoothers.php?share=" . $share;
        $_SESSION['url'] = $url; //将用户心愿单分享链接存入session
        // unset($_SESSION['url']);
    }
} else {
    echo "<h1 align='center'>请使用正确的链接！</h1>";
    echo "<script>setTimeout(function(){window.location.href='login.html';},3000);</script>";
    exit();
}

//获取用户名
echo "<h1 align='center'>" . $user . "的心愿单</h1>";
// <h1 align="center">心愿单</h1>
?>
        <a href="products.php?type=1" style="font-size:8" class="">全部商品</a>
        <a href='personalinfo.html' style="font-size:8" class="col-md-offset-10">个人主页</a>
        </div>

        <div class="page-header">
        <?php
if (!isLogin()) {
    echo "<h1><a href='login.html' class='col-md-offset-5'>登录查看价格</a></h1>";
}
?>
        </div>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <table class="table table-hover">
                    <div align="center">
                        <?php
getPid_others($uid);
?>
                    </div>

                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
    </div>
    <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>