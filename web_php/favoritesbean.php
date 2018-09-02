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
    mysqli_query($con, "set names utf8");
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
    mysqli_query($con, "set names utf8");
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

function getIDByName($name) //通过收藏夹name获取id

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
        return $id;
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

// getFavByPid(2005);
function getFavByPid($pid) //得到商品所属收藏夹

{
    include "connect.php";
    // $uid = getuid();
    $uid = 88;
    $sql = "select fid from collection where uid = ? and pid = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("ss", $uid, $pid);
    $stmt->execute();
    $stmt->bind_result($fid);
    if ($stmt->fetch()) {
        return $fid;
    }
}

function showFavCha($collection_id) //修改收藏夹界面显示

{
    $collectioninfo = getAllCollectTypeInfo();
    echo "<tr><th>" . "ID" . "</th><th>" . "名称" . "</th><th>" . "简介" . "</th><th>" . "</th><tr>";
    // $coltype = getFavByPid($_POST['collection_id']) == "" ? 2 : getFavByPid($_POST['collection_id']);
    $coltype = getFavByPid($collection_id);
    foreach ($collectioninfo as $info) {
        echo "<tr><td>" . $info[0] . "</td><td>" . $info[1] . "</td><td>" . $info[2] . "</td><td>";
        if ($coltype == $info[0]) {
            echo "<button type='button' class='changefavorite btn btn-primary' data-type='change' data-id='" . $info[0] . "' disabled='disabled'>当前收藏夹</button></td></tr>";
        } else {
            echo "<button type='button' class='changefavorite btn btn-default' data-type='change' data-id='" . $info[0] . "'>选择</button></td></tr>";
        }
    }
}

function showFavMan() //管理收藏夹界面显示

{
    $collectioninfo = getAllCollectTypeInfo();
    echo "<tr><th>" . "ID" . "</th><th>" . "名称" . "</th><th>" . "简介" . "</th><th>" . "修改父收藏夹" . "</th><tr>";
    foreach ($collectioninfo as $info) {
        echo "<tr><td>" . $info[0] . "</td><td>" . $info[1] . "</td><td>" . $info[2] . "</td><td>";
        echo "<select class='mycollections_m form-control' id = 'mycollections_m' name='mycollections_m' data-id='" . $info[0] . "'>";
        if ($info[3] == 1) {
            echo "<option value=1 selected='selected'>" . "无" . "</option>";
        }
        $types = getAllCollectTypeInfo();
        foreach ($types as $type) {
            if (getFather($info[0]) == $type[0]) {
                echo "<option value=$type[0] selected='selected'>" . $type[1] . "</option>";
            } else {
                echo "<option value=$type[0]>" . $type[1] . "</option>";
            }
        }
        echo "</select>";

    }
}
// getTreeFav(3);
// getSonByfaid(1);
function getSonByfaid($fid) //返回所有子收藏夹

{
    include "connect.php";
    mysqli_query($con, "set names utf8");
    // $i = 0;
    // $fid = 1;
    $sql = "select name from favorites where faid = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $fid);
    $stmt->execute();
    $stmt->bind_result($name);
    $names = array();
    while ($stmt->fetch()) {
        if (isFather(getIDByName($name))) {
            array_push($names, array("text" => $name, "nodes" => ""));
        } else {
            array_push($names, array("text" => $name));
        }

    }
    // print_r($names);
    return $names;
}

// getTreeFav(3);
function getTreeFav($n) //返回导航树所需节点信息

{
    static $treenodes = array();
    $treenodes = getSonByfaid(1);
    // print_r($treenodes);
    foreach ($treenodes as &$tree) {
        // print_r($tree);
        if (array_key_exists('nodes', $tree) && $tree['nodes'] == "") {
            unset($tree["nodes"]);
            // $tree["nodes"] = 1;
        }
    }
    // print_r($treenodes);
    echo json_encode($treenodes);
    // print_r(json_decode(json_encode($treenodes)));
    return json_encode($treenodes);
}
