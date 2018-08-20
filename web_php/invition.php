<?php
session_start();

function updateUserClickNum($uid, $clicknum)
{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "update user set clicknum = ? where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $clicknum, $uid);
    $stmt->execute();
}

function getUserClickNum($uid)
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

function getRegistrationNum($uid)
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

function updateRegistrationNum($uid, $regnum)
{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "update user set regnum = ? where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $regnum, $uid);
    $stmt->execute();
}

function getActivitionNum($uid)
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

function updateActivitionNum($uid, $actnum)
{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "update user set actnum = ? where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $actnum, $uid);
    $stmt->execute();
}

function getFromId($uid)
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
