<?php 
session_start();
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
$GtSdk = new GeetestLib();
$_SESSION['gtsdk'] = $GtSdk;
if ($GtSdk->register()) {
    $_SESSION['gtserver'] = 1;
    $result = array(
            'success' => 1,
            'gt' => CAPTCHA_ID,
            'challenge' => $GtSdk->challenge
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