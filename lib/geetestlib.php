<?php
/**
 * 极验行为式验证安全平台，php 网站主后台包含的库文件
 */

define('GT_API_SERVER', 'http://api.geetest.com');
define('GT_SDK_VERSION', 'php_2.0');

class GeetestLib{
	function __construct() {
		$this->challenge = "";
	}

	function set_captchaid($captcha_id) {
		$this->captcha_id = $captcha_id;
	}

	function set_privatekey($private_key) {
		$this->private_key = $private_key;
	}
	
	function register() {
		$this->challenge = $this->_send_request("/register.php", array("gt"=>$this->captcha_id));
		if (strlen($this->challenge) != 32) {
			return 0;
		}
		return 1;
	}
	
	function get_widget($product, $popupbtnid="") {
		$params = array(
			"gt" => $this->captcha_id,
			"challenge" => $this->challenge,
			"product" => $product,
			"sdk" => GT_SDK_VERSION,
		);
		if ($product == "popup") {
			$params["popupbtnid"] = $popupbtnid;
		}
		return "<script type='text/javascript' src='".GT_API_SERVER."/get.php?".http_build_query($params)."'></script>";
	}

	function validate($challenge, $validate, $seccode) {	
		if ( ! $this->_check_validate($challenge, $validate)) {
			return FALSE;
		}
		
		$codevalidate = $this->_send_request("/validate.php", array("seccode"=>$seccode), "POST");
		if (strlen($codevalidate)>0 && $codevalidate==md5($seccode)) {
			return TRUE;
		} else if ($codevalidate == "false"){
			return FALSE;
		} else { 
			return $codevalidate;
		}
	}
	
	function _check_validate($challenge, $validate) {
		if (strlen($validate) != 32) {
			return FALSE;
		}
		if (md5($this->private_key.'geetest'.$challenge) != $validate) {
			return FALSE;
		} 
		return TRUE;
	}

	function _send_request($path, $data, $method="GET") {
		$data['sdk'] = GT_SDK_VERSION;

		if ($method=="GET") {
			$opts = array(
			    'http'=>array(
				    'method'=>"GET",
				    'timeout'=>2,
			    )
		    );
		    $context = stream_context_create($opts);
			$response = file_get_contents(GT_API_SERVER.$path."?".http_build_query($data), false, $context);

		} else {
			$opts = array(
				'http' => array(
					'method' => "POST",
					'content' => http_build_query($data),
				)
			);
			$context = stream_context_create($opts);
			$response = file_get_contents(GT_API_SERVER.$path, false, $context);
		}
		return $response;
	}
}
?>