<?php
function checkperson()
{
    require_once dirname(__FILE__) . '/lib/class.geetestlib.php';
    require_once dirname(__FILE__) . '/config.php';
    $GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);

    $data = array(
        "user_id" => "test", # 网站用户id
        "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
        "ip_address" => "127.0.0.1", # 请在此处传输用户请求验证时所携带的IP
    );

    if ($_SESSION['gtserver'] == 1) { //服务器正常
        $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
        if ($result) {
            // echo '{"status":"success"}';
            return true;
        } else {
            // echo '{"status":"fail"}';
            return false;
        }
    } else { //服务器宕机,走failback模式
        if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
            // echo '{"status":"success"}';
            return true;
        } else {
            // echo '{"status":"fail"}';
            return false;
        }
    }
}