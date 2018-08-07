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

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PWD', '123456');
define('DB_NAME', 'test');

function conn()
{
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_NAME); //链接数据库
    mysqli_query($conn, "set names utf8");
    return $conn;
}
//获得结果集
function doresult($sql)
{
    $result = mysqli_query(conn(), $sql);
    return $result;
}

//结果集转为对象集合
function dolists($result)
{
    return mysqli_fetch_array($result);
}

function totalnums($sql)
{
    $result = mysqli_query(conn(), $sql);
    return $result->num_rows;
}
