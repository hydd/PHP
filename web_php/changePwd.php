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
    $verify = $_SESSION['verify'];
    unset($_SESSION['verify']);
    updatePwd($verify);

} else {
    exit("错误执行");
}

function updatePwd($verify)
{
    $pwd = $_POST['password'];
    $pwd1 = $_POST['password1'];
    if ($pwd != $pwd1) {
        echo "<script>alert('两次密码输入需要相同！'); history.go(-1);</script>";
    } else {
        include 'connect.php'; //链接数据库
        $sql = "update user set password = ? where token = ?";
        $stmt = $con->stmt_init();
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("ss", md5($pwd), $verify);
            if ($stmt->execute()) {
                header("refresh:0;url=login.html"); //如果成功跳转至登陆页面
                echo '密码修改成功，请使用新密码登陆！';
                $stmt->close();
                exit;
            } else {
                die(mysqli_error($con)); //如果sql执行失败输出错误
            }
        }
        mysqli_close($con); //关闭数据库
    }

}
