<?php
// getAllCollectTypeInfo();

function getAllCollectTypeInfo() //返回现有所有收藏夹名称

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    // $id = 1;
    $sql = "select id,name,info,faid from favorites ";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    // $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($id, $name, $info, $faid);
    $cinfo = array();
    while ($stmt->fetch()) {
        if ($info == "") {
            $info = "暂无介绍";
        }
        array_push($cinfo, array($id, $name, $info, $faid));
    }
    // print_r($cinfo);
    return $cinfo;
}

// getCollectTypeInfo();
function getCollectTypeInfo($faid) //返回现有一级收藏夹全部信息

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $sql = "select id,name,info from favorites where faid=?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $faid);
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
// getFather(6);
function getFather($id) //返回父节点ID

{
    include "connect.php";
    $sql = "select faid from favorites where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($faid);
    if ($stmt->fetch()) {
        // print($faid);
        return $faid;
    }

}

// createNewFavorite("测试", "");
function createNewFavorite($name, $info) //新增收藏夹

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    $faid = 1;
    $sql = "insert into favorites(name,info,faid) values(?,?,?)";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("sss", $name, $info, $faid);
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
// echo (isFather(2));
function isFather($faid) //判断是否有子节点

{
    include "connect.php";
    $sql = "select id from favorites where faid = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $faid);
    $stmt->execute();
    // $stmt->bind_result($id);
    if ($stmt->fetch()) {
        return true;
    } else {
        return false;
    }
}
// echo (isSon(5, 6));
function isSon($fid, $sid) //判断传入的两个节点是否为父子关系

{
    include "connect.php";
    $sql = "select faid from favorites where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $sid);
    $stmt->execute();
    $stmt->bind_result($faid);
    if ($stmt->fetch()) {
        if ($faid == $fid) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function getNameById($id) //通过收藏夹id获取名称

{
    include "connect.php";
    $sql = "select name from favorites where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($name);
    if ($stmt->fetch()) {
        return $name;
    } else {
        die(mysqli_error($con)); //如果sql执行失败输出错误
    }
}
// updateFavorites(17, 2);
function updateFavorites($fid, $faid) //更新收藏夹

{
    include "connect.php";
    $sql = "update favorites set faid = ? where id = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $faid, $fid);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
