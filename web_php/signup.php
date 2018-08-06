<?php
session_start();
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
    isNull();
} else {
    header("refresh:1;url=signup.html"); //返回注册界面
    exit("请先填写注册信息，错误执行");
}

// function checkmail()
// {
//     $email = $_POST['email'];
//     mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
//     $q = "select token from user where email = $email"; //查询token
//     //查询
//     $result = $con->query($q);
// }
function singup()
{
    $name = $_POST['name']; //post获取表单里的name
    $password = $_POST['password']; //post获取表单里的password
    $md5pwd = md5($password);
    $token = md5($name . $password . time());
    $email = trim($_POST['email']);
    $regtime = time();
    $restime = 0;
    $respwd = 0;
    // echo $email;
    $status = 0;
    $icon = rand(10001, 10013);
    include 'connect.php'; //链接数据库
    include 'sendMail.php'; //发送激活邮件
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    // $q = "insert into user(id,username,password,email,token,status) values (null,'$name','$password','$email','$token',$status)"; //向数据库插入表单传来的值的sql
    $q = "insert into user(id,username,password,email,token,status,regtime,restime,respwd,icon) values (null,'$name','$md5pwd','$email','$token','$status','$regtime','$restime','$respwd',null)"; //向数据库插入表单传来的值的sql
    //查询
    $result = $con->query($q);

    if (!$result) {
        die(mysqli_error($con)); //如果sql执行失败输出错误
    } else {
        postmail($email, '注册', $token, $name, 'signup');
        header("refresh:0;url=checkMail.html"); //如果成功跳转至登陆页面
        echo "注册成功"; //成功输出注册成功
        exit;
    }

    mysqli_close($con); //关闭数据库
}

function checkNewUser()
{
    $name = $_POST['name']; //post获取表单里的name
    include 'connect.php'; //链接数据库
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select * from user where username = '$name'"; //检测数据库是否有对应的username和password的sql
    $result = $con->query($sql);
    $rows = mysqli_num_rows($result); //返回一个数值
    // echo $rows;
    if ($rows != "") {
        header("refresh:0;url=signup.html"); //跳转至注册页面
        echo "该账户已存在，请修改用户名！";
    } else if ($_POST['password'] != $_POST['password1']) {
        // echo "注册成功"; //成功输出注册成功
        header("refresh:0;url=signup.html"); //跳转至注册页面
        echo "请检查您的密码";
    } else {
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
