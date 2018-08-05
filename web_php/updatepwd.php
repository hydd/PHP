<?php
header("Content-Type: text/html; charset=utf8");
session_start();
if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
    // echo "亲爱的用户：" . $_SESSION['name'];
} else {
    // exit("错误执行");
    header("refresh:1;url=login.html"); //如果成功跳转至商品页面
}
$name = $_SESSION['name'];
if (isset($_POST['submit'])) {
    // checkPwd();
    if(checkpwd($name)){
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
        $sql = "select password from user where username = '$name'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        if ($row) {
            if ($row['password'] == $oldpwd) {
                return true;
            } else {
                echo "<script>alert('请检查原密码是否输入正确！'); history.go(-1);</script>";
                return false;
            }
        } else {
            echo "<script>alert('请正确登录');setTimeout(function(){window.location.href='login.html';},1000);
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
    // $pwd = $_POST['password'];
    $pwd1 = $_POST['password1'];

    include 'connect.php'; //链接数据库
    // $q = "insert into user(id,username,password,email,token,status) values (null,'$name','$password','$email','$token',$status)"; //向数据库插入表单传来的值的sql
    $q = "update user set password='$pwd1' where username = '$name'"; //向数据库插入表单传来的值的sql
    $result = mysqli_query($con, $q);
    // $result = $con->query($q);
    if (!$result) {
        die(mysqli_error($con)); //如果sql执行失败输出错误
    } else {
        // echo "注册成功"; //成功输出注册成功
        // header("refresh:0;url=personalinfo.php"); //如果成功跳转至登陆页面
        // echo '密码修改成功！';
        echo "<script>alert('密码更新成功！');setTimeout(function(){window.location.href='personalinfo.php';},1000);
         </script>";
        exit;
    }
    mysqli_close($con); //关闭数据库

}
