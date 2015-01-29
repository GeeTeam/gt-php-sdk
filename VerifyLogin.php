<?php 
/**
 * 通过引用并调用 geetestlib 中的函数，进行服务器端验证，从而决定提交按钮后的行为
 * 本文件示例只是简单的输出 Yes or No
 */
require_once('lib/geetestlib.php');
$private_key = "0f1a37e33c9ed10dd2e133fe2ae9c459";
$captcha_key = "a40fd3b0d712165c5d13e6f747e948d4";
$geetestdemo = new geetestdemo($private_key,$captcha_key);
if (isset($_POST['geetest_challenge']) && isset($_POST['geetest_validate']) && isset($_POST['geetest_seccode'])) {
	
	$validate_response = $geetestdemo->geetest_validate(@$_POST['geetest_challenge'], @$_POST['geetest_validate'], @$_POST['geetest_seccode']);

}else{
	echo "use your own captcha validate ";
	//网站原有验证码的验证
	//$validate_response = your_own_captcha_validate()
}


if ($validate_response == TRUE) {
		echo 'Yes!';
	} else {
		echo 'No';
	}



?>