<?php 
/**
 * Msg套件下的拼图一次验证
 * @author Tanxu
 * $result   1:验证成功; 
 */
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestmsg.php';
session_start();
$GtMsgSdk = $_SESSION['gtmsgsdk'];
$data = json_decode($_POST['value'],true);
if ($data['geetest_validate'] == md5(PRIVATE_KEY . 'geetest' . $data['geetest_challenge'])) {
    $codedata = array(
            "seccode" => $data['geetest_seccode'],
            "sdk" => "php_2.15.4.1.1",
            "phone" =>$data['phone'],
            "msg_id" => CAPTCHA_ID
        );
    $action = "send";
    $result = $GtMsgSdk->send_msg_request($action,$codedata);
    echo $result;
}else{
    echo "-11";
}
 ?>