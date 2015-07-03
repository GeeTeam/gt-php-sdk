<?php 
/**
 * 本文件示例只是简单的输出 Yes or No
 */
error_reporting(0);
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
session_start();
$GtSdk = $_SESSION['gtsdk'];
if ($_SESSION['gtserver'] == 1) {
    $result = $GtSdk->validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);
    if ($result == TRUE) {
        echo 'Yes!';
    } else if ($result == FALSE) {
        echo 'No';
    } else {
        echo 'FORBIDDEN';
    }
}else{
    $validate = $_POST['geetest_validate'];
    $value = explode("_",$validate);
    $challenge = $_SESSION['challenge'];
    $GtSdk = $_SESSION['gtsdk'];
    $ans = $GtSdk->decode_response($challenge,$value['0']);
    $bg_idx = $GtSdk->decode_response($challenge,$value['1']);
    $grp_idx = $GtSdk->decode_response($challenge,$value['2']);
    $x_pos = $GtSdk->get_failback_pic_ans($bg_idx ,$grp_idx);
    if (abs($ans - $x_pos) < 4) {
        echo "yes";
    }else{
        echo "no";
    }
}



?>