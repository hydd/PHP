<?php
session_start();

include_once "checklogin.php";
if (!isLogin()) {
    echo "<script>alert('请先登录！');setTimeout(function(){window.location.href='login.html';},1000);
    </script>";
    exit();
}
$name = $_SESSION['name'];

getInvitionInfo($name);
getSons($name);

function getInvitionInfo($name)
{
    include "connect.php";
    include_once "userinfo.php";
    $sql = "select username,email,clicknum,regnum,actnum from user where username = ?";
    $stmt = $con->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($username, $email, $clicknum, $regnum, $actnum);
    }

    if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
        echo '<tr><th>' . '昵称' . '</th><th>' . '邀请链接点击次数' . '</th><th>' . '注册人数' . '</th><th>' . "激活人数" . "</th></tr>";
        while ($stmt->fetch()) {
            $clicknum = $clicknum == "" ? 0 : $clicknum;
            $regnum = $regnum == "" ? 0 : $regnum;
            $actnum = $actnum == "" ? 0 : $actnum;

            echo "<tr><td>" . $username . "</td><td>" . $clicknum . "</td><td>" . $regnum . "</td><td>" . $actnum . "</td></tr>";
        }
    } else {
        $size = 12;
        echo "<font size=" . $size . ">" . '请先登录！' . "</font>";
    }
    //释放
    $stmt->close();

    //关闭连接
    mysqli_close($con);
}

function getSons($name)
{
    include_once "userinfo.php";
    $sons = getAllSonsInfo(getuid($name), 3);
    $i = 1;
    $temp = "";
    foreach ($sons as $son) {
        if (count($son) != 0) {
            $temp .= "<table class='table table-bordered'><thead><tr><th>ID</th><th>" . 第 . $i . 代用户名 . "</th><th>Email</th><th>下一级邀请人数</th><th>来自邀请人</th></tr></thead>";
            foreach ($son as $so) {
                $temp .= "<tr><td>" . $so[0] . "</td><td>" . $so[1] . "</td><td>" . $so[2] . "</td><td>" . $so[3] . "</td><td>" . getuser($so[4]) . "</td></tr>";
            }
            $temp .= "</table>";
            $i++;
        }
    }
    echo $temp;
}
