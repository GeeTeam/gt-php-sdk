<?php 
/**
 * 通过引用并调用 geetestlib 中的函数，进行服务器端验证，从而决定提交按钮后的行为
 * 本文件示例只是简单的输出 Yes or No
 */
require_once('lib/geetestlib.php');
$private_key = "d8e6e5299189cf9be0f2c26f387ffbb4";
$captcha_key = "6055c3b4b35860d554ad91b823f927b5";
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