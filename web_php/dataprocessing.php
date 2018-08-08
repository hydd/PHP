<?php
session_start();
// header("Content-Type: text/html; charset=utf8");
define('TOTAL_SIZE', 50);
define('SHOWPAGE', 5);

// getSql();

function isLogin()
{
    if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
        // echo "登录成功：" . $_SESSION['name'];
        return true;
    } else {
        // exit("错误执行");
        return false;
    }
}
function getSearch()
{
    $type = $_GET['type'];
    // echo "type" . $type . "tppe";
    if ($type == 1) {
        unset($_SESSION['search']);
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
                $sql = "select * from mi_products where name like '%$search%' or info like '%$search%' order by nid limit " . (getPage() - 1) * $total_size . ", $total_size";
                break;
            case 2:
                $sql = "select * from mi_products where name like '%$search%' or info like '%$search%' order by nid desc limit " . (getPage() - 1) * $total_size . ", $total_size";
                break;
            case 3:
                $sql = "select * from mi_products where name like '%$search%' or info like '%$search%' order by price limit " . (getPage() - 1) * $total_size . ", $total_size";
                break;
            case 4:
                $sql = "select * from mi_products where name like '%$search%' or info like '%$search%' order by price desc limit " . (getPage() - 1) * $total_size . ", $total_size";
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
        $sql = "select count(*) from mi_products where name like '%$search%'";
    }
    return $sql;
}
function getTotalPage()
{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    // $total_sql = "select count(*) from mi_products";
    $total_sql = getCountSql();
    $total_result = mysqli_fetch_array(mysqli_query($con, $total_sql));
    $total = $total_result[0];
    // echo $total;
    $total_pages = ceil($total / TOTAL_SIZE);
    // echo $total_page;
    return $total_pages;
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
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $total_size = TOTAL_SIZE;
    //查询语句
    // $sql = "select * from mi_products limit " . (getPage() - 1) * $total_size . ", $total_size";
    $sql = getSql();
    // echo $sql;
    $results = mysqli_query($con, $sql); //查询
    //遍历循环打印数据
    echo "<br>";
    $row = mysqli_fetch_array($results);
    if (isLogin()) {
        // echo "<br>";
        if ($row == "") {
            echo "<h1 align='center'>查询为空！</h1>";
            echo "<br>";
        } else {
            echo '<tr><th>' . '编号' . '<th>' . '商品' . '<th>' . '简介' . '<th>' . '价格' . '<tr>';
            while ($row = mysqli_fetch_array($results)) {
                //    print_r($row);
                // echo $row[0];
                // echo 'while';
                if ($row['name'] != 'name') {
                    echo "<tr><td>" . $row["nid"] . "</td><td>" . $row["name"] . "</td><td>" . $row["info"] . "</td><td>" . $row["price"] . "</td><tr>";
                    // echo "<br>";
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
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . 1 . "&&search=$search'>首页&emsp;</a>";
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($page - 1) . "&&search=$search'>上一页&emsp;</a>";

    }
    //头部省略
    if ($total_pages > $showpage) {
        if ($page > $pageoffset + 1) {
            $page_banner .= "...";
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
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . $i . "&&search=$search'>$i&emsp;</a>";
    }
    //尾部省略
    if ($total_pages > $showpage && $total_pages > $page + $pageoffset) {
        $page_banner .= "...&emsp;";
    }
    if ($page < $total_pages) {
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($page + 1) . "&&search=$search'>下一页&emsp;</a>";
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($total_pages) . "&&search=$search'>末页&emsp;</a>";

    }
    $page_banner .= "共{$total_pages}页，";
    $page_banner .= "<form action='products.php' method='get'>";
    $page_banner .= "到第<input type='test' size='2' name='p'>页&emsp;";
    $page_banner .= "<input type='submit' value='确定'>&emsp;</input>";
    $page_banner .= "<input type='text' size='8' name='search' placeholder='$search' method='get'>&emsp;</input>";
    $page_banner .= "<input type='submit' value = '搜索'>&emsp;";
    $page_banner .= "<select name='sort'><option value='1'>编号递增</option>
                    <option value='2'>编号递减</option>
                    <option value='3'>价格递增</option>
                    <option value='4'>价格递减</option></select>&emsp;&emsp;";
    $page_banner .= " <input type='submit' value='排序'>";
    if (isLogin()) {
        echo $page_banner;
    }
}
