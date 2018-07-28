<?php
header("Content-Type: text/html; charset=utf8");

// if(!isset($_POST['submit'])||!isset($_POST['submit1'])){
//     exit("错误执行");
// }//判断是否有submit操作
if (isset($_POST['submit'])) {
    checkPwd();
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
        // echo "注册成功"; //成功输出注册成功
        postmail('15658050107@163.com', 'test', $token, $name, 'signup');
        header("refresh:0;url=checkMail.html"); //如果成功跳转至登陆页面
        exit;
    }

    mysqli_close($con); //关闭数据库
}

function checkPwd()
{
    $pwd=$_POST['password'];
    $pwd1=$_POST['password1'];

}
