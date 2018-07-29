<?php
header("Content-Type: text/html; charset=utf8");
session_start();
if (isset($_SESSION['verify']) && !empty($_SESSION['verify'])) {
    // echo "亲爱的用户：" . $_SESSION['verify'];
} else {
    // exit("错误执行");
    header("refresh:1;url=login.html"); //如果成功跳转至商品页面
}
// if(!isset($_POST['submit'])||!isset($_POST['submit1'])){
//     exit("错误执行");
// }//判断是否有submit操作
if (isset($_POST['submit'])) {
    // checkPwd();
    updatePwd($_SESSION['verify']);
} else {
    exit("错误执行");
}

function updatePwd($verify)
{
    $pwd = $_POST['password'];
    $pwd1 = $_POST['password1'];
    if ($pwd != $pwd1) {
        echo "两次密码输入需要相同.";
    } else {
        include 'connect.php'; //链接数据库

        // $q = "insert into user(id,username,password,email,token,status) values (null,'$name','$password','$email','$token',$status)"; //向数据库插入表单传来的值的sql
        $q = "update user set password='$pwd' where token ='$verify'"; //向数据库插入表单传来的值的sql
        $result = mysqli_query($con, $q);
        // $result = $con->query($q);

        if (!$result) {
            die(mysqli_error($con)); //如果sql执行失败输出错误
        } else {
            // echo "注册成功"; //成功输出注册成功
            echo '密码修改成功，请使用新密码登陆！';
            header("refresh:0;url=login.html"); //如果成功跳转至登陆页面
            exit;
        }

        mysqli_close($con); //关闭数据库
    }

}
