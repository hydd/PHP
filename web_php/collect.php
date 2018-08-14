<?php
include_once "checklogin.php";
if (!isLogin()) {
    exit("请登录");
}
$pid = $_GET['x'];
if (!checkcollection($pid)) {
    // echo $pid;
    if (addcollection($pid)) {
        // echo "<script>alert('收藏成功！');window.location.href='products.php';</script>";
        echo "success";
    } else {
        // echo "<script>alert('收藏失败！');window.location.href='products.php';</script>";
        // echo "alert('收藏失败！');";
        echo "error";
        // echo $pid;
    }
} else {
    // echo "<script>alert('已收藏！');window.location.href='products.php';</script>";
    if (delcollection($pid)) {
        echo "del";
    } else {
        echo "ndel";
    }
}
function addcollection($pid)
{
    include "connect.php";
    include_once "checklogin.php";
    $uid = getuid();
    $sql = "insert into collection(uid,pid) values (?,?)";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $uid, $pid);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function delcollection($pid)
{
    include "connect.php";
    $uid = getuid();
    $sql = "delete from collection where uid = ? and pid =?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $uid, $pid);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function checkcollection($pid)
{
    include "connect.php";
    $uid = getuid();
    $sql = "select id from collection where uid =? and pid =? ";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $uid, $pid);
    $stmt->execute();
    $stmt->bind_result($id);
    if ($stmt->fetch()) {
        return true;
    } else {
        return false;
    }
}
