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
    // print_r($all_sons);
    return $all_sons;
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
function getSonInfo($uid) //得到儿子用户的部分信息

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $sql = "select id,username,email,actnum from user where fromid = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($id, $username, $email, $actnum);
    $all_sons = array();
    while ($stmt->fetch()) {
        $actnum = $actnum == "" ? 0 : $actnum;
        array_push($all_sons, array($id, $username, $email, $actnum, $uid));
    }
    // print_r($all_sons);
    return $all_sons;
}
// getAllSonsInfo(88, 3);

/**
 * When I wrote this, only God and I understood what I was doing
 * Now, God only knows
 * 2018.9.2
 */
function getAllSonsInfo($uid, $n) //获取指定用户指定代数的子孙信息 $uid 指定用户 $n 指定代数

{
    static $sons = array();
    array_push($sons, getSonInfo($uid)); //默认添加儿子节点信息

    static $sn = 0;

    while ($sn < $n - 1) {
        $count = count($sons[$sn]); //得到当前代数子孙节点数量
        $info = array();
        for ($loc = 0; $loc < $count; $loc++) { //得到所有子孙节点的儿子节点的信息并保存
            foreach (getSonInfo($sons[$sn][$loc][0]) as $temp) {
                array_push($info, $temp);
            }
        }
        array_push($sons, $info);
        $sn++;
    }
    // print_r($sons);
    return $sons;
}
