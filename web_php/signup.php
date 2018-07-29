<?php
header("Content-Type: text/html; charset=utf8");

// if(!isset($_POST['submit'])||!isset($_POST['submit1'])){
//     exit("错误执行");
// }//判断是否有submit操作
if (isset($_POST['submit'])) {
    checkNewUser();
} else if (isset($_POST['submit1'])) {
    exit("验证码");
} else {
    exit("错误执行");
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
    $token = md5($name . $password . time());
    $email = trim($_POST['email']);
    // echo $email;
    $status = 0;
    include 'connect.php'; //链接数据库
    include 'sendMail.php'; //发送激活邮件
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    // $q = "insert into user(id,username,password,email,token,status) values (null,'$name','$password','$email','$token',$status)"; //向数据库插入表单传来的值的sql
    $q = "insert into user(id,username,password,email,token,status) values (null,'$name','$password','$email','$token','$status')"; //向数据库插入表单传来的值的sql
    //查询
    $result = $con->query($q);

    if (!$result) {
        die(mysqli_error($con)); //如果sql执行失败输出错误
    } else {
        echo "注册成功"; //成功输出注册成功
        postmail($email, '注册', $token, $name, 'signup');
        header("refresh:0;url=checkMail.html"); //如果成功跳转至登陆页面
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
        echo "该账户已存在，请修改用户名！";
        header("refresh:0;url=signup.html"); //跳转至注册页面
    } else if ($_POST['password'] != $_POST['password1']) {
        // echo "注册成功"; //成功输出注册成功
        echo "请检查您的密码";
        header("refresh:0;url=signup.html"); //跳转至注册页面
    } else {
        singup(); //注册
    }

    mysqli_close($con); //关闭数据库
}
