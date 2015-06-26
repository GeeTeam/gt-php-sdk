<?php 
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
// require_once dirname(dirname(__FILE__)) . '/lib/class.geetestmsg.php';
// $msggeetestlib = new MsgGeetestLib();
session_start();
$GtSdk = $_SESSION['gtsdk'];

$data = json_decode($_POST['value'],true);
$url = "http://messageapi.geetest.com/send";
if ($data['geetest_validate'] == md5(PRIVATE_KEY . 'geetest' . $data['geetest_challenge'])) {
    $codedata = array(
            "seccode" => $data['geetest_seccode'],
            "sdk" => "php_2.15.4.1.1",
            "phone" =>$data['phone'],
            "msg_id" => CAPTCHA_ID
        );
    $result = $GtSdk->post_request($url,$codedata);
    $res = json_decode($result,true);
    echo $res['res'];
}else{
    echo "-11";
}
 ?>