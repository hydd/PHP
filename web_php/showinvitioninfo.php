<?php
session_start();
include_once "checklogin.php";
if (!isLogin()) {
    echo "<script>alert('请先登录！');setTimeout(function(){window.location.href='login.html';},100);
    </script>";
    exit();
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
    <title>邀请统计</title>
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
  </head>

  <body>

    <div class="container theme-showcase" role="main">
    <a href='personalinfo.php' style='text-decoration: none;'>我的主页</a>
    <a href='logout.php' class="col-md-offset-10" style='text-decoration: none;'>退出登录</a>

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1 align="center">邀请信息统计</h1>
      </div>

      <div class="page-header">
      </div>
      <div class="row">
        <div class="col-md-2">
      </div>
        <div class="col-md-8">
          <table class="table table-hover">
            <thead>
            </thead>
              <br>
              <img border="1" class="col-md-offset-5  round_icon" id="capthcha_img" src="selecticon.php" align="center"></img>
              <br>

                <?php
include "connect.php";
include "userinfo.php";
$name = $_SESSION['name'];
$sql = "select username,email,clicknum,regnum,actnum from user where username = ?";
$stmt = $con->stmt_init();
if ($stmt->prepare($sql)) {
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($username, $email, $clicknum, $regnum, $actnum);
}

if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
    //查询语句

    echo '<tr><th>' . '昵称' . '<th>' . '邀请链接点击人数' . '<th>' . '注册人数' . '<th>' . "激活人数" . "<th>";
    while ($stmt->fetch()) {
        $clicknum = $clicknum == "" ? 0 : $clicknum;
        $regnum = $regnum == "" ? 0 : $regnum;
        $actnum = $actnum == "" ? 0 : $actnum;

        echo "<tr><td>" . $username . "<td>" . $clicknum . "<td>" . $regnum . "<td>" . $actnum . "<td><tr>";
    }
} else {
    $size = 12;
    echo "<font size=" . $size . ">" . '请先登录！' . "</font>";
}
$sons = getAllSons(getuid($name), 3);
echo " <table class='table table-bordered'><thead><tr><th>ID</th><th>用户名</th><th>Email</th><th>邀请人</th></tr></thead><tbody>";
foreach ($sons as $son) {
    echo " <tr><td>" . $son[0] . "</td><td>" . $son[1] . "</td><td>" . $son[2] . "</td><td>" . getuser($son[3]) . "</td></tr>";
}
echo " </tbody></table>";
//释放
$stmt->close();

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap core CSS -->
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="./js/share.js?v=1"></script>
  </body>
</html>
