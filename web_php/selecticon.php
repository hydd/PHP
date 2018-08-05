<?php
session_start();
$name = $_SESSION['name'];
// echo $name;
include "connect.php";
$sql = "select icon from user where username = '$name'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
if ($row['icon'] == '') {
    // echo   "null";
    $icon = rand(10001, 10012);
    $url = './icons/' . $icon . '.jpg';
    $img = file_get_contents($url, true);
    header("Content-Type: image/jpeg;text/html; charset=utf-8");
    echo $img;
    exit;
} else {
    // echo $row['icon'];
    $url = './icons/' . $row['icon'];
    $img = file_get_contents($url, true);
    header("Content-Type: image/jpeg;text/html; charset=utf-8");
    echo $img;
    exit;
}
