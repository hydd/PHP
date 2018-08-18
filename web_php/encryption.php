<?php
// $iv = getiv();
// $data = "hello";
// $en = encrypt($data, $iv);
// echo $en;
// echo "解密" . decrypt($en, $iv);

function encrypt($data)  //加密函数
{
    // // 加密算法
    $encryptMethod = getMethond();
    return openssl_encrypt($data, $encryptMethod, 'secret');
}
function getiv()  //得到关键随机序列
{
    $encryptMethod = getMethond();
    // 生成IV
    $ivLength = openssl_cipher_iv_length($encryptMethod);
    $iv = openssl_random_pseudo_bytes($ivLength, $isStrong);
    if (false === $iv && false === $isStrong) {
        die('IV generate failed');
    }
    return $iv;
}

function getMethond()  //选择加密方法
{
    $encryptMethod = 'AES-128-ECB';  //因为iv传输有问题，所以暂时选用该不需要iv进行加密的加密算法
    return $encryptMethod;
}

function decrypt($encrypted) // 解密函数
{
    $encryptMethod = getMethond();
    return openssl_decrypt($encrypted, $encryptMethod, 'secret');
}
