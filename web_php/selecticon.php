<?php
session_start();
$name = $_SESSION['name'];
// $name = "1";
// echo $name;
include "connect.php";
// $sql = "select icon from user where username = '$name'";

$sql = "select icon from user where username = ?";

$stmt = $con->stmt_init();

if ($stmt->prepare($sql)) {
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($icon);
}
if ($stmt->fetch()) {
    if ($icon != "") {
        // printf("%s \n", $icon);
        $url = './icons/' . $icon;
        $img = file_get_contents($url, true);
        header("Content-Type: image/jpeg;text/html; charset=utf-8");
        echo $img;
        // exit;
    } else {
        // echo "null";
        $icon = rand(10001, 10012);
        $url = './icons/' . $icon . '.jpg';
        $img = file_get_contents($url, true);
        header("Content-Type: image/jpeg;text/html; charset=utf-8");
        echo $img;
        // exit;
    }
}
$stmt->close();
mysqli_close($son);
exit();
