<?php
session_start();

include "connect.php";
$username = "test";
$password = "123456";
$status = 0;
$verify = "87409b12dd7aa3690ccd9cce1302a15a";

$query = "SELECT id FROM user WHERE username like CONCAT('%',?,'%')";
// $query = "select nid,name,info,price form mi_products";

$stmt = $con->stmt_init();

if ($stmt->prepare($query)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $stmt->bind_result($id);
    while ($stmt->fetch()) {
        printf("%s \n", $id);
        echo "full";
    }

    $stmt->close();
}
