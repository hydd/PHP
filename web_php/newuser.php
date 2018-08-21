<?php
include "encryption.php";
include "invition.php";
include "checklogin.php";
include "userinfo.php";
$uid = decrypt($_GET['share']);
// echo $uid;
if (is_numeric($uid) && isUser($uid)) {
    updateUserClickNum($uid, getUserClickNum($uid) + 1);
    setSession($uid);
}

// updateRegistrationNum($uid, getRegistrationNum($uid) + 1);

header("refresh:0;url=signup.html"); //如果成功跳转至登陆页面

function setSession($uid)
{
    $_SESSION['fromid'] = $uid;
}
