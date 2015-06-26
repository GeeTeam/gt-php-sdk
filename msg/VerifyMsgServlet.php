<?php 
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
require_once dirname(dirname(__FILE__)) . '/config/config.php';
$GtSdk = new GeetestLib();

$url = "http://messageapi.geetest.com/validate";
$code = $_POST['code'];
$phone = $_POST['phone'];
$data = array(
        'phone' => $phone,
        'msg_id' => CAPTCHA_ID,
        'code' => $code
    );
$result = $GtSdk->post_request($url,$data);
echo json_decode($result,true)['res'];
 ?>