<?php
session_start();
// if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
//     // echo "登录成功：" . $_SESSION['name'];
// } else {
//     // exit("错误执行");
//     header("refresh:1;url=login.html"); //如果成功跳转至商品页面
// }
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
    <title>个人信息</title>
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
  <div id ="myModal1" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">邀请注册</h4>
        </div>
        <div class="modal-body">
            <p>请将以下链接分享给您的好友。</p>
            <input type="text" id="input" value="" style="width:75%" readonly></input>
            <button class="btn btn-default" onclick="copyUrl()">点击复制链接</button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="container theme-showcase" role="main">
    <a href='products.php' style='text-decoration: none;'>查看所有商品</a>
    <a href='showcollection.php' style='text-decoration: none;'>&emsp;&emsp;&emsp;我的心愿单</a>
    <a href='logout.php' class="col-md-offset-9" style='text-decoration: none;'>退出登录</a>

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1 align="center">个人信息</h1>
      </div>

      <div class="page-header">
      <button type="button" class='invite btn btn-default' data-toggle="modal" data-target="#myModal1">邀请好友注册</button></td><td>
      <a href='changeicon.html' class="col-md-offset-9 btn btn-default" role="button">设置头像</a>
      </div>
      <div class="row">
        <div class="col-md-2">
      </div>
        <div class="col-md-8">
          <table class="table table-hover">
            <thead>
            </thead>
              <br><br><br>
              <img border="1" class="col-md-offset-5  round_icon" id="capthcha_img" src="selecticon.php" align="center"></img>
              <br><br><br>


                <?php
include "connect.php";

unset($_SESSION['search']);
unset($_SESSION['share']);
$name = $_SESSION['name'];
// $sql = "select * from user where username = '$name'";
$sql = "select username,email,clicknum,regnum,actnum from user where username = ?";
$stmt = $con->stmt_init();
if ($stmt->prepare($sql)) {
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($username, $email, $clicknum, $regnum, $actnum);
}
// if ($stmt->fetch()) {
//     printf("%s : %s", $username, $email);
// }

echo "<br>";
if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
    //查询语句

    // echo '<tr><th>' . '姓名' . '<th>' . '邮箱' . '<th>' . '简介' . '<th>';
    while ($stmt->fetch()) {
        $clicknum = $clicknum == "" ? 0 : $clicknum;
        $regnum = $regnum == "" ? 0 : $regnum;
        $actnum = $actnum == "" ? 0 : $actnum;
        $info = "此用户什么也没有填写";
        // echo "<tr><td>" . $row["username"] . "</td><td>" . $row["email"] . "</td><td>" . $info . "</td><tr>";
        $namelink = "updatename.html";
        $pwdlink = "updatepwd.html";
        $invitelink = "showinvitioninfo.php";
        echo "<tr><td>" . '用户名:' . "<td>" . $username;
        echo "<td>" . "<a href='{$namelink}'>修改用户名</a>";
        echo "<tr><td>" . '密码:' . "<td>" . "******";
        echo "<td>" . "<a href='{$pwdlink}'>修改密码</a>";
        echo "<tr><td>" . '邮箱:' . "<td>" . $email . "<td>";
        echo "<tr><td>" . '简介:' . "<td>" . $info . "<td>";
        echo "<tr><td>" . '邀请链接被点击次数:' . "<td>" . $clicknum;
        echo "<td>" . "<a href='{$invitelink}'>查看详细信息</a><td><tr>";
    }
} else {
    $size = 12;
    echo "<font size=" . $size . ">" . '请先登录！' . "</font>";
}
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
    <script src="./js/share.js?v=2"></script>
  </body>
</html>
