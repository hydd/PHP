<?php
session_start();
// header("Content-Type: text/html; charset=utf8");
define('TOTAL_SIZE', 50);
define('SHOWPAGE', 5);
// getData();
// showPageBanner();
// getSql();
// getTotalPage();
include_once "checklogin.php";
if (!isLogin()) {
    exit("请登录");
}
function getSearch()
{
    $type = $_GET['type']; //查看全部商品
    // echo "type" . $type . "tppe";
    if ($type == 1) {
        unset($_SESSION['search']); //清空搜索
    }

    $search = $_GET['search'];
    if ($search == "") {
        $search = $_SESSION['search'];
    } else {
        $_SESSION['search'] = $search;
    }

    return $search;
}
function getSql()
{
    $total_size = TOTAL_SIZE;
    $search = getSearch();
    $sort = $_GET['sort'];
    if ($sort != 1 && $sort != 2 && $sort != 3 && $sort != 4) {
        $sort = 1;
    }
    // echo $sort;
    // $search = "%" . $search . "%";
    // echo "$search" . $search;
    if ($search == "") {
        switch ($sort) {
            case 1:
                $sql = "select * from mi_products limit " . (getPage() - 1) * $total_size . ", $total_size";
                break;
            case 2:
                $sql = "select * from mi_products order by nid desc limit " . (getPage() - 1) * $total_size . ", $total_size";
                break;
            case 3:
                $sql = "select * from mi_products order by price limit " . (getPage() - 1) * $total_size . ", $total_size";
                break;
            case 4:
                $sql = "select * from mi_products order by price desc limit " . (getPage() - 1) * $total_size . ", $total_size";
                break;
        }

    } else {
        switch ($sort) {
            case 1:
                $sql = "select * from mi_products where name like CONCAT('%',?,'%') or info like CONCAT('%',?,'%') order by nid limit " . (getPage() - 1) * $total_size . ", $total_size";
                break;
            case 2:
                $sql = "select * from mi_products where name like CONCAT('%',?,'%') or info like CONCAT('%',?,'%') order by nid desc limit " . (getPage() - 1) * $total_size . ", $total_size";
                break;
            case 3:
                $sql = "select * from mi_products where name like CONCAT('%',?,'%') or info like CONCAT('%',?,'%') order by price limit " . (getPage() - 1) * $total_size . ", $total_size";
                break;
            case 4:
                $sql = "select * from mi_products where name like CONCAT('%',?,'%') or info like CONCAT('%',?,'%') order by price desc limit " . (getPage() - 1) * $total_size . ", $total_size";
                break;
        }
    }
    // echo $sql;
    return $sql;
}
function getCountSql()
{
    $total_size = TOTAL_SIZE;
    $search = getSearch();
    // $search = "%" . $search . "%";
    // echo "$search" . $search;
    if ($search == "") {
        $sql = "select count(*) from mi_products ";

    } else {
        $sql = "select count(*) from mi_products where name like CONCAT('%',?,'%')";
    }
    return $sql;
}
function getTotalPage()
{
    include "connect.php";
    $search = getSearch();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    // $total_sql = "select count(*) from mi_products";
    $total_sql = getCountSql();
    $stmt = $con->stmt_init();
    $stmt->prepare($total_sql);
    if (getSearch() != "") {
        $stmt->bind_param("s", $search);
    }
    $stmt->execute();
    $stmt->bind_result($totalcount);
    if ($stmt->fetch()) {
        // echo $totalcount;
        // echo ceil($totalcount / TOTAL_SIZE);
        return ceil($totalcount / TOTAL_SIZE);
    }
}

function getPage()
{
    $page = $_GET['p'];
    // echo "p" . $page;
    if ($page == "" || $page < 0) {
        $page = 1;
    }
    $page = $page > getTotalPage() ? getTotalPage() : $page;
    $page = $page > 0 ? $page : 1;
    return $page;
}

function getData()
{
    include "connect.php";
    $search = getSearch();
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $total_size = TOTAL_SIZE;
    //查询语句
    // $sql = "select * from mi_products limit " . (getPage() - 1) * $total_size . ", $total_size";
    $sql = getSql();
    $stmt = $con->stmt_init();
    $stmt->prepare($sql);
    if (getSearch() != "") {
        $stmt->bind_param("ss", $search, $search);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    if (isLogin()) {
        // echo "<br>";
        if ($row == "") {
            echo "<h1 align='center'>查询为空！</h1>";
            echo "<br>";
        } else {
            showPageBanner();
            echo '<tr><th>' . '编号' . '<th>' . '商品' . '<th>' . '简介' . '<th>' . '价格' . '<tr>';
            echo "<script src='./js/collect.js?v=8'></script>";
            include_once "collect.php";
            while ($row = $result->fetch_assoc()) {

                $id = $row["nid"];
                echo "<tr><td>" . $row["nid"] . "</td><td>" . $row["name"] . "</td><td>" . $row["info"] . "</td><td>" . $row["price"] . "</td><td>";
                // . "<button id='like' onclick='islike()' value='like'>like</button>"
                // . "<button id='unlike' onclick='islike()' style='display:none;'>unlike</button>"
                // echo "<input type=button onclick=\"allow('$id',this);\" value='like'>" . "</td><tr>";
                // echo "<a href='collect.php?x=" . $id . "'>收藏</a></td><tr>";
                if (!checkcollection($row["nid"])) {
                    echo "<button class='collect' data-id='" . $row['nid'] . "'>收藏</button></td><tr>";
                } else {
                    echo "<button class='collect' data-id='" . $row['nid'] . "'>取消收藏</button></td><tr>";
                }
            }
        }

    } else {
        $size = 12;
        echo "<font size=" . $size . ">" . '请先登录！' . "</font>";
    }
    //释放
    if ($results) {
        mysqli_free_result($results);
    }

    //关闭连接
    mysqli_close($con);
}
function showPageBanner()
{
    $page = getPage();
    $total_pages = getTotalPage();
    // $total_pages = 3;
    $showpage = SHOWPAGE;
    $pageoffset = (SHOWPAGE - 1) / 2;
    $start = 1;
    $end = $total_pages;
    $search = getSearch();

    $page_banner = "";

    if ($page > 1) {
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . 1 . "&&search=$search' style='text-decoration: none;'>首页&emsp;</a>";
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($page - 1) . "&&search=$search' style='text-decoration: none;'>上一页&emsp;</a>";

    }
    //头部省略
    if ($total_pages > $showpage) {
        if ($page > $pageoffset + 1) {
            $page_banner .= "...&emsp;";
        }
        if ($page > $pageoffset) {
            $start = $page - $pageoffset;
            $end = $total_pages > $page + $pageoffset ? $page + $pageoffset : $total_pages;
        } else {
            $start = 1;
            $end = $total_pages > $showpage ? $showpage : $total_pages;
        }
        if ($page + $pageoffset > $total_pages) {
            $start = $start - ($page + $pageoffset - $end);
        }
    } else {
        $start = 1;
        $end = $total_pages;
    }
    for ($i = $start; $i <= $end; $i++) {
        if ($i == getPage()) {
            $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . $i . "&&search=$search' style='color:#FF0000;text-decoration: none;'>$i&emsp;</a>";
        } else {
            $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . $i . "&&search=$search' style='text-decoration: none;'>$i&emsp;</a>";
        }
    }
    //尾部省略
    if ($total_pages > $showpage && $total_pages > $page + $pageoffset) {
        $page_banner .= "...&emsp;";
    }
    if ($page < $total_pages) {
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($page + 1) . "&&search=$search' style='text-decoration: none;'>下一页&emsp;</a>";
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($total_pages) . "&&search=$search' style='text-decoration: none;'>末页&emsp;</a>";

    }
    $page_banner .= "<br></br>";
    // $page_banner .= "共{$total_pages}页,";
    $page_banner .= "<form action='products.php' method='get'>";
    $page_banner .= "到第<input type='test' size='2' name='p'>页";
    $page_banner .= ",共{$total_pages}页&emsp;";

    $page_banner .= "<input type='submit' value='确定'>&emsp;</input>";
    $page_banner .= "<input type='text' size='8' name='search' placeholder='$search' method='get'>&emsp;</input>";
    $page_banner .= "<input type='submit' value = '搜索'>&emsp;";
    // $page_banner .= "<select name='sort'>
    //                 <option value='1'>编号递增</option>
    //                 <option value='2'>编号递减</option>
    //                 <option value='3'>价格递增</option>
    //                 <option value='4'>价格递减</option>
    //                 </select>&emsp;&emsp;";
    // $page_banner .= " <input type='submit' value='排序'>";

    $data = array(
        array('id' => 1, 'name' => '编号递增'),
        array('id' => 2, 'name' => '编号递减'),
        array('id' => 3, 'name' => '价格递增'),
        array('id' => 4, 'name' => '价格递减')); //需要遍历的 select 数组

    $id = $_GET['sort'];
    // echo "id" . $id . "id";
    $page_banner .= "<select name='sort'>";
    foreach ($data as $arr) {
        $aid = $arr['id'];
        $aname = $arr['name'];
        if ($arr['id'] == $id) {
            $page_banner .= "<option value=$aid selected='selected'>$aname</option>";
        } else {
            $page_banner .= "<option value=$aid>$aname</option>";

        }
    }
    $page_banner .= "</select>&emsp;&emsp;";
    $page_banner .= " <input type='submit' value='排序'></input>";

    $page_banner .= "</form>";
    if (isLogin()) {
        echo $page_banner;
    }
}
