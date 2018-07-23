<?php
    session_start();
    // header("Content-Type: text/html; charset=utf8");
    if (!isset($_POST["submit"])) {
        exit("错误执行");
    }//检测是否有submit操作

    include('connect.php');//链接数据库
    $name = $_POST['name'];//post获得用户名表单值
    $passowrd = $_POST['password'];//post获得用户密码单值

    if ($name && $passowrd) {//如果用户名和密码都不为空
             mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
             $sql = "select * from user where username = '$name' and password='$passowrd'";//检测数据库是否有对应的username和password的sql
             $result = $con -> query($sql);

        $rows=mysqli_num_rows($result);//返回一个数值
             if ($rows) {//0 false 1 true
                //    $is_login=TRUE;
                   $_SESSION['name'] = $name;
                 header("refresh:0;url=test.php");//如果成功跳转至商品页面
                 exit;
             } else {
                 echo "用户名或密码错误";
                 echo "
                    <script>
                            setTimeout(function(){window.location.href='login.html';},1000);
                    </script>

                ";//如果错误使用js 1秒后跳转到登录页面重试;
             }
    } else {//如果用户名或密码有空
        echo "表单填写不完整";
        echo "
                      <script>
                            setTimeout(function(){window.location.href='login.html';},1000);
                      </script>";

        //如果错误使用js 1秒后跳转到登录页面重试;
    }
    echo $is_login;
    mysqli_close();//关闭数据库
