<?php
session_start();
header("Content-Type: text/html; charset=utf8");
if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
    // echo "登录成功：" . $_SESSION['name'];
} else {
    // exit("错误执行");
    header("refresh:1;url=login.html"); //如果成功跳转至商品页面
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <script type="text/javascript" src="test.php?id=test"></script>

    <title>Theme Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Custom styles for this template -->
    <link href="theme.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1 align="center">全部商品</h1>
        <a href='personalInfo.php' style="font-size:8" class="col-md-offset-11">个人主页</a>
        <!-- <p>This is a template showcasing the optional theme stylesheet included in Bootstrap. Use it as a starting point to create something more unique by building on or modifying it.</p> -->
      </div>

      <div class="page-header">
        <!-- <h1>Tables</h1> -->
      </div>
      <div class="row">
        <div class="col-md-2">
      </div>
        <div class="col-md-8">
          <table class="table table-hover">

                <?php
$total_size = 50;
$page = $_GET['p'];
// echo "p" . $page;
if ($page == "") {
    $page = 1;
}

include "connect.php";
mysqli_query($con, "set names utf8"); //utf8 设为对应的编码
//查询语句
// $sql = "select * from mi_products limit" . ($page - 1) * 10 . ",10";
$sql = "select * from mi_products limit " . ($page - 1) * $total_size . ",$total_size";
$results = mysqli_query($con, $sql); //utf8 设为对应的编码//查询
//遍历循环打印数据
echo "<br>";
if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
    echo '<tr><th>' . '编号' . '<th>' . '商品' . '<th>' . '简介' . '<th>' . '价格' . '<tr>';
    while ($row = mysqli_fetch_assoc($results)) {
        //    print_r($row);
        // echo $row[0];
        // echo 'while';
        if ($row['name'] != 'name') {
            echo "<tr><td>" . $row["nid"] . "</td><td>" . $row["name"] . "</td><td>" . $row["info"] . "</td><td>" . $row["price"] . "</td><tr>";
        }
    }
} else {
    $size = 12;
    echo "<font size=" . $size . ">" . '请先登录！' . "</font>";
}
//释放
mysqli_free_result($results);

$total_sql = "select count(*) from mi_products";
$total_result = mysqli_fetch_array(mysqli_query($con, $total_sql));
$total = $total_result[0];
// echo $total;
$total_page = ceil($total / $total_size);
// echo $total_page;
//关闭连接
mysqli_close($con);
$page_banner = "";
if ($page > 1) {
    $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . 1 . "'>首页</a>";
    $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($page - 1) . "'>上一页</a>";

}
if ($page < $total_page) {
    $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($page + 1) . "'>下一页</a>";
    $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?p=" . ($total_page) . "'>末页</a>";

}
$page_banner .= "共{$total_page}页";
echo $page_banner;
?>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-2">
      </div>
        </div>
      </div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
