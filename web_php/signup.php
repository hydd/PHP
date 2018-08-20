<?php
session_start();
unset($_SESSION['share']);
header("Content-Type: text/html; charset=utf8");
if (isset($_POST['submit'])) {
    // if (isset($_REQUEST['autocode'])) {
    //     // session_start();
    //     if (strtolower($_POST['autocode']) != $_SESSION['authcode']) {
    //         header("refresh:1;url=signup.html"); //返回注册界面
    //         exit("验证码错误,请重新输入！");
    //     } else {
    //         isNull();
    //     }
    // }
    if (checkformat()) {
        isNull();
    } else {
        echo "<script>alert('请根据提示输入正确格式的信息！'); history.go(-1);</script>";
    }
    // singup();
} else {
    header("refresh:1;url=signup.html"); //返回注册界面
    exit("请先填写注册信息，错误执行");
}
function checkformat()
{
    include "checkinfo.php";
    if (checkusername($_POST['name']) && checkpassword($_POST['password']) && checkemail($_POST['email'])) {
        return true;
    } else {
        return false;
    }
}
function singup()
{
    // $id = $con->lastInsertId() + 1;
    // $id = null;
    $name = $_POST['name']; //post获取表单里的name
    $password = $_POST['password']; //post获取表单里的password
    $token = md5($name . $password . time());
    $email = trim($_POST['email']);
    $regtime = time();
    $restime = 0;
    $respwd = 0;
    // echo $email;
    $status = 0;
    $icon = null;
    if (isset($_SESSION['fromid']) && !empty($_SESSION['fromid'])) {
        $fromid = $_SESSION['fromid'];
        unset($_SESSION['fromid']);
    } else {
        $fromid = null;
    }
    include 'connect.php'; //链接数据库
    include 'sendMail.php'; //发送激活邮件
    include "invition.php"; //更新邀请者邀请成功人数
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    // $q = "insert into user(id,username,password,email,token,status) values (null,'$name','$password','$email','$token',$status)"; //向数据库插入表单传来的值的sql
    // $q = "insert into user(id,username,password,email,token,status,regtime,restime,respwd,icon) values (null,'$name','$md5pwd','$email','$token','$status','$regtime','$restime','$respwd',null)"; //向数据库插入表单传来的值的sql
    //查询
    $sql = "insert into user(username,password,email,token,status,regtime,restime,respwd,fromid) values (?,?,?,?,?,?,?,?,?)"; //向数据库插入表单传来的值的sql
    $stmt = $con->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("sssssssss", $name, md5($password), $email, $token, $status, $regtime, $restime, $respwd, $fromid);
        // $stmt->execute();
        if ($stmt->execute()) {
            postmail($email, '注册', $token, $name, 'signup');
            header("refresh:0;url=checkMail.html"); //如果成功跳转至登陆页面
            // echo "注册成功"; //成功输出注册成功
            if (!is_null($fromid)) {
                updateRegistrationNum($fromid, getRegistrationNum($fromid) + 1);
            }
            exit();
        } else {
            die(mysqli_error($con));
        }
        $stmt->close();
    }
    mysqli_close($con); //关闭数据库
}

function checkNewUser()
{
    $name = $_POST['name']; //post获取表单里的name
    include 'connect.php'; //链接数据库
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    // $sql = "select * from user where username = '$name'"; //检测数据库是否有对应的username和password的sql
    $sql = "select id from user where username = ? ";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();

    if ($stmt->fetch()) {
        // header("refresh:1;url=signup.html"); //跳转至注册页面
        // echo "该账户已存在，请修改用户名！";
        echo "<script>alert('该账户已存在，请更换用户名！'); history.go(-1);</script>";
    } else if ($_POST['password'] != $_POST['password1']) {
        // header("refresh:1;url=signup.html"); //跳转至注册页面
        // echo "请检查您的密码";
        echo "<script>alert('请检查您的密码！'); history.go(-1);</script>";
    } else {
        // echo "zhuce";
        singup(); //注册
    }

    mysqli_close($con); //关闭数据库
}

function isNull()
{
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];
    $email = $_POST['email'];
    if ($name && $password && $password1 && $email) {
        isCode();
    } else {
        echo "<script>alert('请完整填写所有信息！'); history.go(-1);</script>";
    }
}

function isCode()
{
    if (isset($_REQUEST['autocode'])) {
        // session_start();
        if (strtolower($_POST['autocode']) != $_SESSION['authcode']) {
            header("refresh:1;url=signup.html"); //返回注册界面
            exit("验证码错误,请重新输入！");
        } else {
            checkNewUser();
        }
    }
}
