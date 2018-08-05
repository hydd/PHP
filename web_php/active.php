<?php

$verify = stripslashes(trim($_GET['verify']));
$type = stripslashes(trim($_GET['type']));
// echo $type;

if ($type == "signup") {
    if (checkRegTime($verify)) {
        newAccount($verify);
    } else {
        header("refresh:0;url=signup.html"); //如果链接过期跳转至登陆页面
        echo "链接过期，请重新注册！";
    }
} else {
    // echo checkPermission("Permission" . $verify);
    // echo checkTime("Time" . $verify);
    if (checkResTime($verify)) {
        changePwd($verify);
    } else {
        header("refresh:0;url=login.html"); //如果链接过期跳转至登陆页面
        echo "链接无效，请重新获取！";
    }
    // checkTime($verify);
}

function newAccount($verify = '')
{
    include "connect.php"; //连接数据库
    // mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select id from user where status='0' and token='$verify'"; //检测数据库是否有对应的username和password的sql
    $result = $con->query($sql);
    // while ($row = mysqli_fetch_array($result)) {
    //     echo $row['id'];
    // }

    $row = mysqli_fetch_array($result);

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
        $msg = '该账号已激活，请登录.';
        header("refresh:1;url=login.html"); //如果成功跳转至登陆页面
    }
    echo $msg;

}

function changePwd($verify)
{
    include "connect.php"; //连接数据库
    // mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select id from user where status='1' and token='$verify'"; //检测数据库是否有对应的username和password的sql
    $result = mysqli_query($con, $sql);
    // while ($row = mysqli_fetch_array($result)) {
    //     echo $row['id'];
    // }

    $row = mysqli_fetch_array($result); //返回一个数值
    // echo $row;
    if ($row != '') {
        // $msg = '账户验证成功。';
        setSession($verify);
        // showPwd($verify);
        header("refresh:0;url=changePwd.html"); //如果成功跳转至登陆页面
    } else {
        $msg = '账户尚未激活，请先进入邮箱激活账户。';
        header("refresh:1;url=login.html"); //如果成功跳转至登陆页面
    }
    echo $msg;

}

function setSession($verify)
{
    session_start();
    $_SESSION['verify'] = $verify;
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

function checkResTime($verify)
{
    $nowtime = time();
    include 'connect.php'; //链接数据库
    $sql = "select restime,respwd from user where token='$verify'";
    $result = mysqli_query($con, $sql);
    $rows = mysqli_fetch_array($result); //
    if ($nowtime > $rows['restime'] + 24 * 60 * 3600 || $rows['respwd'] != 1) {
        return false;
    } else {
        $sql = "update user set respwd='0' where token='$verify'";
        $con->query($sql);
        // changePwd($verify);
        return true;
    }
}
function checkRegTime($verify)
{
    include 'connect.php'; //链接数据库
    $nowtime = time();
    $sql = "select regtime from user where token='$verify'";
    $result = mysqli_query($con, $sql);
    $rows = mysqli_fetch_array($result);
    if ($nowtime > $rows['regtime'] + 24 * 60 * 3600) {
        // echo "Time False";
        return false;
    } else {
        // echo "Time T";
        return true;
    }
}
function checkPermission($verify)
{
    include 'connect.php'; //链接数据库
    $sql = "select respwd from user where token='$verify'";
    $result = mysqli_query($con, $sql);
    $rows = mysqli_fetch_array($result);
    if ($rows['respwd'] != 1) {
        // echo "Per F";
        return false;
    } else {
        $sql = "update user set respwd='0' where token='$verify'";
        $con->query($sql);
        // echo "Per T";
        return true;
    }

}
