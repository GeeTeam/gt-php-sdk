<?php 
/**
 * 二次的短信验证
 * @author Tanxu
 * $result   1:验证成功;  -7:失败;
*/
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestmsg.php';
session_start();
$GtMsgSdk = $_SESSION['gtmsgsdk'];
if ($_SESSION['gtserver'] == 1) {
    $GtMsgSdk = $_SESSION['gtmsgsdk'];
    $action = "validate";
    $code = $_POST['code'];
    $phone = $_POST['phone'];
    $data = array(
            'phone' => $phone,
            'msg_id' => CAPTCHA_ID,
            'code' => $code
        );
    $result = $GtMsgSdk->send_msg_request($action,$data);
    echo $result;
}else{
    echo "use your own captcha result";
}

 ?>