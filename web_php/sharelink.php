<?php
include "checklogin.php";
include "encryption.php";
if (!isLogin()) {
    header("refresh:1;url=login.html"); //如果成功跳转至商品页面
} else {
    $id = getUid();
    // echo $id;
    create_share_link($id);
}

function create_share_link($id)
{
    $url = "http://118.25.102.34/hydd/showtoothers.php";
    $info = "请复制以下链接分享给您的好友。";
    // $id = 88;
    // $iv = getiv();
    $res = encrypt($id);
    $res2 = decrypt($res);
    echo $info . $url . "?share=" . $res;
    // echo $res2;
}
