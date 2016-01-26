<?php 
/**
 * 本文件示例只是简单的输出 Yes or No
 */
// error_reporting(0);
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
require_once dirname(dirname(__FILE__)) . '/config/config.php';
session_start();
$GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
if ($_SESSION['gtserver'] == 1) {
    $result = $GtSdk->sucess_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);
    if ($result) {
        echo 'Yes!';
    } else{
        echo 'No';
    }
}else{
    if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
        echo "yes";
    }else{
        echo "no";
    }
}
?>