<?php
session_start();

function updateUserClickNum($uid, $clicknum) //更新用户邀请被点击次数

{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "update user set clicknum = ? where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $clicknum, $uid);
    $stmt->execute();
}

function getUserClickNum($uid) //查看用户邀请链接被点击次数

{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select clicknum from user where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($id);
    if ($stmt->fetch()) {
        if ($id == "") {
            $id = 0;
        }
    } else {
        die(mysqli_error($con));
    }
    return $id;
}

function getRegistrationNum($uid) //查看通过用户邀请链接注册人数

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $sql = "select regnum from user where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($regnum);
    if ($stmt->fetch()) {
        if ($regnum == "") {
            $regnum = 0;
        }
    } else {
        die(mysqli_error($con));
    }
    return $regnum;
}

function updateRegistrationNum($uid, $regnum) //更新通过用户连接注册人数

{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "update user set regnum = ? where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $regnum, $uid);
    $stmt->execute();
}

function getActivitionNum($uid) //查看通过用户链接注册并激活人数

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $sql = "select actnum from user where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($actnum);
    if ($stmt->fetch()) {
        if ($actnum == "") {
            $actnum = 0;
        }
    } else {
        die(mysqli_error($con));
    }
    return $actnum;
}

function updateActivitionNum($uid, $actnum) //更新通过用户链接注册并激活人数

{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "update user set actnum = ? where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $actnum, $uid);
    $stmt->execute();
}

function getFromId($uid) //得到父用户

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $sql = "select fromid from user where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($fromid);
    if ($stmt->fetch()) {
        if ($fromid == "") {
            $fromid = 0;
        }
    } else {
        die(mysqli_error($con));
    }
    return $fromid;
}

// getCollectType();

function getCollectType()
{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    // $id = 1;
    $sql = "select name from favorites ";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    // $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($name);
    $names = array();
    while ($stmt->fetch()) {
        array_push($names, $name);
    }
    // print_r($names);
    return $names;
}
