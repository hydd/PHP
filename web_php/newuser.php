<?php
include "encryption.php";
include "invition.php";
$uid = decrypt($_GET['share']);
updateUserClickNum($uid, getUserClickNum($uid) + 1);
setSession($uid);
// updateRegistrationNum($uid, getRegistrationNum($uid) + 1);

header("refresh:0;url=signup.html"); //如果成功跳转至登陆页面

function setSession($uid)
{
    $_SESSION['fromid'] = $uid;
}
