<?php
// 加密算法
$encryptMethod = 'aes-256-cbc';
// 明文数据
$data = 88;

// 生成IV
$ivLength = openssl_cipher_iv_length($encryptMethod);
$iv = openssl_random_pseudo_bytes($ivLength, $isStrong);
if (false === $iv && false === $isStrong) {
    die('IV generate failed');
}

// 加密
$encrypted = openssl_encrypt($data, $encryptMethod, 'secret', 0, $iv);
// 解密
$decrypted = openssl_decrypt($encrypted, $encryptMethod, 'secret', 0, $iv);

echo $encrypted;
echo "解密".$decrypted;
