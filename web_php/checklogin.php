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

function getuid() // 通过session存储的用户名获取用户ID

{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $name = $_SESSION['name'];
    $sql = "select id from user where username = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($id);
    if ($stmt->fetch()) {
        $stmt->close();
        return $id;
    }
}

function getuser($id) // 通过传入的用户ID获取用户名

{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select username from user where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($id);
    if ($stmt->fetch()) {
        $stmt->close();
        return $id;
    }
}

function isUser($id)
{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select username from user where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($id);
    if ($stmt->fetch()) {
        if ($id == "") {
            return false;
        } else {
            return true;
        }
    }
}
