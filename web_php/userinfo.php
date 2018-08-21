<?php
function isUser($id) //判断是否唯一注册用户

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

function getSonId($uid) //得到儿子用户

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $sql = "select id from user where fromid = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($sons);
    $all_sons = array();
    while ($stmt->fetch()) {
        array_push($all_sons, $sons);
    }
    print_r($all_sons);
    // return $all_sons;
}

function getInfo($uid) //获取用户的部分信息

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $sql = "select username,email,actnum from user where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($username, $email, $actnum);
    if ($stmt->fetch()) {
        $info = array($username, $email, $actnum);
        // print_r($info);
    } else {
        die(mysqli_error($con)); //如果sql执行失败输出错误
    }
    return $info;
}
// print_r(getAllSons(88, 2));
// getAllSons(88, 3);
function getAllSons($uid, $n)
{
    static $sons = array();
    static $sn = 1;
    static $count = 0;
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $sql = "select id,username,email from user where fromid = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($id, $username, $email);
    $info = array();
    while ($stmt->fetch()) {
        array_push($info, array($id, $username, $email, $uid));
        array_push($sons, array($id, $username, $email, $uid));
        // $info = array($uid, $username, $email);
    }
    $count++;
    // print_r($count);
    // echo " " . $uid . " ";
    // print_r(count($info));
    if ($count == count($info)) {
        $sn++;
        $count = 0;
    }

    if ($sn < $n) {
        // print_r($sons);
        foreach ($info as $value) {
            getAllSons($value[0], $n);
        }
    }

    return $sons;
}
