<?php
session_start();
// isLogin();
// getuid();
function isLogin()
{
    if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
        // echo "登录成功：" . $_SESSION['name'];
        return true;
    } else {
        // exit("错误执行");
        return false;
    }
}




