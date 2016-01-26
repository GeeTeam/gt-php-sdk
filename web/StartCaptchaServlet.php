<?php 
/**
 * 使用Get的方式返回：challenge和capthca_id 此方式以实现前后端完全分离的开发模式 专门实现failback
 * @author Tanxu
 */
//error_reporting(0);
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
require_once dirname(dirname(__FILE__)) . '/config/config.php';
$GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
session_start();
$status = $GtSdk->pre_process();
$_SESSION['gtserver'] = $status;
echo $GtSdk->get_response_str();
 ?>