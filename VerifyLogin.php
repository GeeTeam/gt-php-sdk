<?php 
/**
 * 通过引用并调用 geetestlib 中的函数，进行服务器端验证，从而决定提交按钮后的行为
 * 本文件示例只是简单的输出 Yes or No
 */
require_once('lib/geetestlib.php');
$geetest = new GeetestLib();
$geetest->set_privatekey("0f1a37e33c9ed10dd2e133fe2ae9c459");

if (isset($_POST['geetest_challenge']) && isset($_POST['geetest_validate']) && isset($_POST['geetest_seccode'])) {
	$result = $geetest->validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);
	if ($result == TRUE) {
		echo 'Yes!';
	} else if ($result == FALSE) {
		echo 'No';
	} else {
		echo 'FORBIDDEN';
	}

} else {
	echo "use your own captcha validate ";
	//网站原有验证码的验证
	//$result = your_own_captcha_validate()
}
?>