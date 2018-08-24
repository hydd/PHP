<?php
// getCollectType();

function getCollectType() //返回现有所有收藏夹名称

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

// getCollectTypeInfo();
function getCollectTypeInfo() //返回现有收藏夹全部信息

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $sql = "select id,name,info from favorites";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($id, $name, $info);
    $collectioninfo = array();
    while ($stmt->fetch()) {
        if ($info == "") {
            $info = "暂无介绍";
        }
        array_push($collectioninfo, array($id, $name, $info));
    }
    // print_r($collectioninfo);
    return $collectioninfo;
}
// createNewFavorite("测试", "");
function createNewFavorite($name, $info) //新增收藏夹

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $sql = "insert into favorites(name,info) values(?,?)";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $name, $info);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// isFavorite("测试");
function isFavorite($name)
{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $sql = "select id from favorites where name = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($id);
    if ($stmt->fetch()) {
        return true;
    } else {
        return false;
    }
}
