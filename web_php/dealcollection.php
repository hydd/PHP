<?php
function getPid($uid) //返回商品ID  getPid在data-processing文件中存在同名函数！！！

{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    // $uid = getuid();
    $sql = "select pid from collection where uid = ?";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->bind_result($pid);
    echo "<script src='./js/collect.js?v=2'></script>";
    if (!$stmt->fetch()) {
        echo "null";
    } else {
        if (isLogin()) {
            echo '<tr><th>' . '编号' . '<th>' . '商品' . '<th>' . '简介' . '<th>' . '价格' . '<tr>';
        } else {
            echo '<tr><th>' . '编号' . '<th>' . '商品' . '<th>' . '简介' . '<tr>';
        }
        // echo $pid;
        getCollection($pid);
        while ($stmt->fetch()) {
            // echo $pid;
            getCollection($pid);
        }
    }

}
function getCollection($pid) //返回心愿单内容  getCollection在data-processing文件中存在同名函数！！！

{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $sql = "select * from mi_products where nid = ? order by nid";
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (isLogin()) {
        // echo "<br>";
        if ($row == "") {
            echo "<h1 align='center'>查询为空！</h1>";
            echo "<br>";
        } else {
            // showPageBanner();
            // include_once "collect.php";
            // $id = $row["nid"];
            echo "<tr><td>" . $row["nid"] . "</td><td>" . $row["name"] . "</td><td>" . $row["info"] . "</td><td>" . $row["price"] . "</td><tr>";
            // if (!checkcollection($row["nid"])) {
            //     echo "<button class='mycollect btn btn-default' data-id='" . $row['nid'] . "'>收藏</button></td><td>";
            // } else {
            //     echo "<button class='mycollect btn btn-primary' data-id='" . $row['nid'] . "'>取消收藏</button></td><td>";
            // }

            // echo "<wb:share-button addition='simple' type='button' title='您的好友向您推荐：" . $row["name"] . "' url='http://118.25.102.34/hydd/products.php?search=" . $row['name'] . "'></wb:share-button></td></tr>";
        }

    } else {
        echo "<tr><td>" . $row["nid"] . "</td><td>" . $row["name"] . "</td><td>" . $row["info"] . "</td><tr>";
    }
}
