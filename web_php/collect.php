<?php
include_once "checklogin.php";
include_once "userinfo.php";
if (!isLogin()) {
    echo "<script>alert('请先登录！');setTimeout(function(){window.location.href='login.html';},100);
    </script>";
    exit();
}
$pid = $_POST['x'];
// echo $pid;
$type = $_POST['t'];
// echo $pid;
// exit();
if (!checkcollection($pid)) {
    // echo $pid;
    if ($type == "add") {
        if (addcollection($pid)) {
            // echo "<script>alert('收藏成功！');window.location.href='products.php';</script>";
            echo "success";
        } else {
            // echo "<script>alert('收藏失败！');window.location.href='products.php';</script>";
            // echo "alert('收藏失败！');";
            echo "";
            // echo $pid;
        }
    }
} else {
    if ($type == "del") {
        if (delcollection($pid)) {
            echo "del";
        } else {
            echo "ndel";
        }
    } elseif ($type == "change") {
        $fid = $_POST['f'];
        if (changeFavoriteType($fid, $pid)) {
            echo "changed";
        } else {
            echo "unchanged";
        }

    }
    // echo "<script>alert('已收藏！');window.location.href='products.php';</script>";
}
function addcollection($pid) //添加收藏

{
    include "connect.php";
    // include_once "checklogin.php";
    $uid = getuid();
    $fid = 2;
    $sql = "insert into collection(uid,pid,fid) values (?,?,?)";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("sss", $uid, $pid, $fid);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function delcollection($pid) //删除收藏

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

function checkcollection($pid) //判断是否已收藏

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

function changeFavoriteType($fid, $pid) //更改物品所属收藏夹

{
    include "connect.php";
    $uid = getuid();
    $sql = "update collection set fid = ? where uid = ? and pid = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("sss", $fid, $uid, $pid);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

