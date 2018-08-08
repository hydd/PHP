<?php
$server = "127.0.0.1"; //主机
$db_username = "root"; //你的数据库用户名
$db_password = "123456"; //你的数据库密码
$sql_database = 'test'; //连接的数据库名字

$con = mysqli_connect($server, $db_username, $db_password, $sql_database); //链接数据库
if (!$con) {
    die("can't connect" . mysqli_error()); //如果链接失败输出错误
} else {
    // echo('连接成功！');
}


