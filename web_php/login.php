<?php
// require_once dirname(__FILE__) . '/class.geetestlib.php';
// require_once dirname(__FILE__) . '/config.php';
// $GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
session_start();

// session_start();
header("Content-Type: text/html; charset=utf8");
if (!isset($_POST["submit"])) {
    exit("错误执行");
} //检测是否有submit操作
// if (isset($_REQUEST['autocode'])) {
//     // session_start();
//     if (strtolower($_POST['autocode']) != $_SESSION['authcode']) {
//         echo "<script>alert('请输入正确的验证码！'); history.go(-1);</script>";
//         exit();
//     }
// }
include "humanmachineverification.php";
if (!checkperson()) {
    echo "<script>alert('请进行人机验证！'); history.go(-1);</script>";
    // echo "123";
    exit();
}

include 'connect.php'; //链接数据库
$name = $_POST['name']; //post获得用户名表单值
$passowrd = $_POST['password']; //post获得用户密码单值
$md5pwd = md5($passowrd);

if ($name && $passowrd) { //如果用户名和密码都不为空
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select * from user where username = '$name' and password='$md5pwd'"; //检测数据库是否有对应的username和password的sql
    $result = $con->query($sql);

    $rows = mysqli_fetch_array($result); //返回一个数值
    if ($rows) { //0 false 1 true
        //    $is_login=TRUE;
        if ($rows['status'] == '1') {
            $_SESSION['name'] = $name;
            header("refresh:0;url=products.php"); //如果成功跳转至商品页面
            exit;
        } else {
            echo "请先激活您的账号！";
            echo "
                      <script>
                            setTimeout(function(){window.location.href='login.html';},1000);
                      </script>";

            //如果错误使用js 1秒后跳转到登录页面重试;
        }

    } else {
        echo "<script>alert('用户名或密码错误！'); history.go(-1);</script>";

        // echo "用户名或密码错误";
        // echo "
        //             <script>
        //                     setTimeout(function(){window.location.href='login.html';},1000);
        //             </script>

        //         "; //如果错误使用js 1秒后跳转到登录页面重试;
    }
} else { //如果用户名或密码有空
    // echo "表单填写不完整";
    // echo "
    //                   <script>
    //                         setTimeout(function(){window.location.href='login.html';},1000);
    //                   </script>";
    echo "<script>alert('请正确填写用户名和密码！'); history.go(-1);</script>";

    //如果错误使用js 1秒后跳转到登录页面重试;
}
// echo $is_login;
mysqli_close($con); //关闭数据库

// function checkperson()
// {
//     require_once dirname(__FILE__) . '/lib/class.geetestlib.php';
//     require_once dirname(__FILE__) . '/config.php';
//     $GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);

//     $data = array(
//         "user_id" => "test", # 网站用户id
//         "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
//         "ip_address" => "127.0.0.1", # 请在此处传输用户请求验证时所携带的IP
//     );

//     if ($_SESSION['gtserver'] == 1) { //服务器正常
//         $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
//         if ($result) {
//             // echo '{"status":"success"}';
//             return true;
//         } else {
//             // echo '{"status":"fail"}';
//             return false;
//         }
//     } else { //服务器宕机,走failback模式
//         if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
//             // echo '{"status":"success"}';
//             return true;
//         } else {
//             // echo '{"status":"fail"}';
//             return false;
//         }
//     }
// }
