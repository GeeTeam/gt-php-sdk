<?php 
/**
 * 使用Get的方式返回：challenge和capthca_id 此方式以实现前后端完全分离的开发模式 专门实现failback
 * @author Tanxu
 */
error_reporting(0);
session_start();
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestmsg.php';

$GtMsgSdk = new MsgGeetestLib();
$_SESSION['gtmsgsdk'] = $GtMsgSdk;
if ($GtMsgSdk->register()) {
    $_SESSION['gtserver'] = 1;
    $result = array(
            'success' => 1,
            'gt' => CAPTCHA_ID,
            'challenge' => $GtMsgSdk->challenge
        );
    echo json_encode($result);
}else{
    $_SESSION['gtserver'] = 0;
    $result = array(
            'success' => 0
        );
    echo json_encode($result);
}
        

 ?>