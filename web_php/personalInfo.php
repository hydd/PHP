<?php
session_start();
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
    <style type="text/css">
    .round_icon{
      width: 100px;
      height: 100px;
      display: flex;
      border-radius: 50%;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }</style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container theme-showcase" role="main">
    <a href='products.php'>查看所有商品</a>
    <a href='logout.php' class="col-md-offset-10">退出登录</a>

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1 align="center">个人信息</h1>
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
            <thead>
            <a href='changeicon.html' class="col-md-offset-12 btn btn-default btn-lg active btn-sm" role="button">设置头像</a>
            </thead>
              <br><br><br>
              <img border="1" class="col-md-offset-5  round_icon" id="capthcha_img" src="selecticon.php" align="center"></img>
              <br><br><br>


                <?php

// define('SQL_HOST', 'localhost'); //数据库地址
// define("SQL_USER", "root"); //数据库用户名
// define("SQL_PASSWORD", "123456"); //数据库密码
// define("SQL_DATABASE", "test"); //连接的数据库名字
// define("SQL_PORT", "3306"); //数据库端口号,默认为3306
// //define("SQL_SOCKDET","");

// $mysql = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASSWORD, SQL_DATABASE, SQL_PORT) or die(mysqli_error());
// //连接不上切换数据库

include "connect.php";
unset($_SESSION['search']);
$name = $_SESSION['name'];
$sql = "select * from user where username = '$name'";
$results = mysqli_query($con, $sql); //查询
// print_r($results);
//遍历循环打印数据

echo "<br>";
if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
    //查询语句

    // echo '<tr><th>' . '姓名' . '<th>' . '邮箱' . '<th>' . '简介' . '<th>';
    while ($row = mysqli_fetch_array($results)) {
        //    print_r($row);
        // echo $row[0];
        // echo 'while';
        $info = "此用户什么也没有填写";
        // echo "<tr><td>" . $row["username"] . "</td><td>" . $row["email"] . "</td><td>" . $info . "</td><tr>";
        $namelink = "updatename.html";
        $pwdlink = "updatepwd.html";
        echo "<tr><td>" . '用户名:' . "<td>" . $row["username"];
        echo "<td>" . "<a href='{$namelink}'>修改用户名</a>";
        echo "<tr><td>" . '密码:' . "<td>" . "******";
        echo "<td>" . "<a href='{$pwdlink}'>修改密码</a>";
        echo "<tr><td>" . '邮箱:' . "<td>" . $row["email"] . "<td>";
        echo "<tr><td>" . '简介:' . "<td>" . $info . "<td>";

    }
} else {
    $size = 12;
    echo "<font size=" . $size . ">" . '请先登录！' . "</font>";
}
//释放
mysqli_free_result($results);
//关闭连接
mysqli_close($con);

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
