<?php
session_start();

include "connect.php";
$username = "test1";
$password = "123456";
$status = 0;
$verify = "87409b12dd7aa3690ccd9cce1302a15a";

$query = "SELECT id FROM user WHERE status = ? and token = ?";
// $query = "select nid,name,info,price form mi_products";

$stmt = $con->stmt_init();

if ($stmt->prepare($query)) {
    $stmt->bind_param("ss", $status, $verify);
    $stmt->execute();

    $stmt->bind_result($status);
    if ($stmt->fetch()) {
        printf("%s \n", $status);
    } else {
        echo "null";
    }
    $stmt->close();
}
