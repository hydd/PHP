<?php
include_once "checklogin.php";
if (!isLogin()) {
    echo "<script>alert('请先登录！');setTimeout(function(){window.location.href='login.html';},100);
    </script>";
    exit();
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
        echo "";
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
function addcollection($pid)    //添加收藏
{
    include "connect.php";
    // include_once "checklogin.php";
    $uid = getuid();
    $sql = "insert into collection(uid,pid) values (?,?)";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $uid, $pid);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function delcollection($pid)    //删除收藏
{   
    include "connect.php";
    $uid = getuid();
    $sql = "delete from collection where uid = ? and pid =?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $uid, $pid);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function checkcollection($pid)  //判断是否已收藏
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
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}
