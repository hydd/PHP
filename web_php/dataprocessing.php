<?php
session_start();
// header("Content-Type: text/html; charset=utf8");
define('TOTAL_SIZE', 50);
define('SHOWPAGE', 5);
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
function getTotalPage()
{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $total_sql = "select count(*) from mi_products";
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
    $page = ($page > getTotalPage()) ? getTotalPage() : $page;

    return $page;
}

function getData()
{
    include "connect.php";
    mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
    $total_size = TOTAL_SIZE;
    //查询语句
    $sql = "select * from mi_products limit " . (getPage() - 1) * $total_size . ", $total_size";
    $results = mysqli_query($con, $sql); //查询
    //遍历循环打印数据
    echo "<br>";
    if (isLogin()) {
        echo '<tr><th>' . '编号' . '<th>' . '商品' . '<th>' . '简介' . '<th>' . '价格' . '<tr>';
        // echo "<br>";

        while ($row = mysqli_fetch_assoc($results)) {
            //    print_r($row);
            // echo $row[0];
            // echo 'while';
            if ($row['name'] != 'name') {
                echo "<tr><td>" . $row["nid"] . "</td><td>" . $row["name"] . "</td><td>" . $row["info"] . "</td><td>" . $row["price"] . "</td><tr>";
                // echo "<br>";

            }
        }
    } else {
        $size = 12;
        echo "<font size=" . $size . ">" . '请先登录！' . "</font>";
    }
    //释放
    mysqli_free_result($results);

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

    $page_banner = "";
    if ($page > 1) {
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . 1 . "'>首页&emsp;</a>";
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($page - 1) . "'>上一页&emsp;</a>";

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
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . $i . "'>&emsp;$i&emsp;</a>";
    }
    //尾部省略
    if ($total_pages > $showpage && $total_pages > $page + $pageoffset) {
        $page_banner .= "...&emsp;";
    }
    if ($page < $total_pages) {
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($page + 1) . "'>下一页&emsp;</a>";
        $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($total_pages) . "'>末页&emsp;</a>";

    }
    $page_banner .= "共{$total_pages}页，";
    $page_banner .= "<form action='products.php' method='get'>";
    $page_banner .= "到第<input type='test' size='2' name='p'>页&emsp;";
    $page_banner .= "<input type='submit' value='确定'>";
    if (isLogin()) {
        echo $page_banner;
    }
}
