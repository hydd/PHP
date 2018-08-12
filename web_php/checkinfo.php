<?php
function checkusername($name)
{
    // $name = $_POST['name']; //post获得用户名表单值
    if (!preg_match("/^[a-zA-Z0-9_-]{5,20}$/", $name) || checklength($name) < 5 || checklength($name) > 20) {
        // echo '密码必须由数字和字母的组合而成';
        return false;
    } else {
        return true;
    }
}
function checkpassword($passowrd)
{
    // $passowrd = $_POST['password']; //post获得用户密码单值
    if (!preg_match("/^[a-zA-Z0-9_-]{5,20}$/", $passowrd) || checklength($passowrd) < 5) {
        // echo '密码必须由数字和字母的组合而成';
        return false;
    } else {
        return true;
    }
}
function checkemail($email)
{
    if (!preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/", $email)) {
        return false;
    } else {
        return true;
    }
}

function checklength($str)
{
    return strlen($str);
}
