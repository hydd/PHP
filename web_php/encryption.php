<?php
// $iv = getiv();
// $data = "hello";
// $en = encrypt($data, $iv);
// echo $en;
// echo "解密" . decrypt($en, $iv);

function encrypt($data)
{
    // // 加密算法
    $encryptMethod = getMethond();
    return openssl_encrypt($data, $encryptMethod, 'secret');
}
function getiv()
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

function getMethond()
{
    $encryptMethod = 'AES-128-ECB';
    return $encryptMethod;
}

function decrypt($encrypted)
{
    $encryptMethod = getMethond();
    return openssl_decrypt($encrypted, $encryptMethod, 'secret');
}
