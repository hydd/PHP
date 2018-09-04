<?php
session_start();

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
        $invitelink = "showinvitioninfo.html";
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
