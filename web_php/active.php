<?php
session_start();
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
    if (checkResTime($verify)) {
        changePwd($verify);
    } else {
        header("refresh:0;url=login.html"); //如果链接过期跳转至登陆页面
        echo "链接无效，请重新获取！";
    }
    // checkTime($verify);
}

function newAccount($verify)  //判断是否为新注册未激活用户
{
    include "connect.php"; //连接数据库
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $status = 0;

    $query = "select id from user where status = ? and token = ?"; //检测数据库是否有对应的username和password的sql
    $stmt = $con->stmt_init();
    if ($stmt->prepare($query)) {
        $stmt->bind_param("ss", $status, $verify);
        $stmt->execute();

        $stmt->bind_result($id);
        // if ($stmt->fetch()) {
        //     printf("%s \n", $status);
        // } else {
        //     echo "null";
        // }
    }

    if ($stmt->fetch()) {

        if ($id != "") {
            $sql1 = "update user set status=1 where id = ?";
            $stmt->prepare($sql1);
            $stmt->bind_param("s", $id);
            if ($stmt->execute()) {
                $msg = '激活成功！';
                header("refresh:1;url=login.html"); //如果成功跳转至登陆页面
            } else {
                die(mysqli_error($con)); //如果sql执行失败输出错误
            }
        } else {
            $msg = '该账号已激活，请登录.';
            header("refresh:1;url=login.html"); //如果成功跳转至登陆页面
        }
    }
    $stmt->close();
    echo $msg;
    exit();
}

function changePwd($verify) //通判断用户是否申请召回并重制密码
{
    $status = 1;
    include "connect.php"; //连接数据库
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    // $sql = "select id from user where status='1' and token='$verify'"; //检测数据库是否有对应的username和password的sql
    $sql = "select id from user where status = ? and token =?";
    $stmt = $con->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("ss", $status, $verify);
        $stmt->execute();
        $stmt->bind_result($id);
    }
    if ($stmt->fetch()) {
        if ($id != "") {
            setSession($verify);
            // showPwd($verify);
            header("refresh:0;url=changePwd.html"); //如果成功跳转至登陆页面
        } else {
            header("refresh:1;url=login.html"); //如果成功跳转至登陆页面
            echo ("账户尚未激活，请先进入邮箱激活账户。");

        }
        $stmt->close();
    }
}

function setSession($verify) 
{
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

function checkResTime($verify) //检查申请找回密码的时间

{
    $nowtime = time();
    include 'connect.php'; //链接数据库
    // $sql = "select restime,respwd from user where token='$verify'";
    $sql = "select restime,respwd from user where token = ?";
    $stmt = $con->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("s", $verify);
        $stmt->execute();
        $stmt->bind_result($restime, $respwd);
    }
    // if ($stmt->fetch()) {
    //     printf("%s : %s ", $restime, $respwd);
    // }
    $stmt->fetch();
    if ($nowtime > $restime + 24 * 60 * 3600 || $respwd != 1) {
        echo "false";
        return false;
    } else {
        $respwd = 0;
        $sql = "update user set respwd=? where token=?";
        $stmt->prepare($sql);
        $stmt->bind_param("ss", $respwd, $verify);
        if ($stmt->execute()) {
            // echo "true";
            return true;
        } else {
            die(mysqli_error($con)); //如果sql执行失败输出错误
            // return false;
        }
        $stmt->close();
    }
}
function checkRegTime($verify) //检查用户注册的时间

{
    include 'connect.php'; //链接数据库
    $nowtime = time();
    // echo $nowtime;
    // echo "<br>";
    // $sql = "select regtime from user where token='$verify'";
    $sql = "select regtime from user where token = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $verify);
    $stmt->execute();
    $stmt->bind_result($regtime);
    $stmt->fetch();
    $stmt->close();
    if ($nowtime > $regtime + 24 * 60 * 3600) {
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
