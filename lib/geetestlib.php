<?php
/**
 * 极验行为式验证安全平台，php 网站主后台包含的库文件
 */

define('GT_API_SERVER', 'http://api.geetest.com');
define('GT_SSL_SERVER', 'https://api.geetest.com');

define('GT_SDK_VERSION', 'php_2.15.4.2.2');

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
	
	function get_widget($product, $popupbtnid="", $ssl=FALSE) {
		$params = array(
			"gt" => $this->captcha_id,
			"challenge" => $this->challenge,
			"product" => $product,
		);
		if ($product == "popup") {
			$params["popupbtnid"] = $popupbtnid;
		}
		$server = $ssl ? GT_SSL_SERVER : GT_API_SERVER;
		return "<script type='text/javascript' src='".$server."/get.php?".http_build_query($params)."'></script>";
	}

	function validate($challenge, $validate, $seccode) {	
		if ( ! $this->_check_validate($challenge, $validate)) {
			return FALSE;
		}
		$query = http_build_query(array("seccode"=>$seccode,"sdk"=>GT_SDK_VERSION));
		$codevalidate = $this->_http_post('api.geetest.com', '/validate.php', $query);
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
		if ($method=="GET") {
			$opts = array(
			    'http'=>array(
				    'method'=>"GET",
				    'timeout'=>2,
			    )
		    );
		    $context = stream_context_create($opts);
			$response = file_get_contents(GT_API_SERVER.$path."?".http_build_query($data), false, $context);

		}
		return $response;
	}

	function _http_post($host,$path,$data,$port = 80){
		$http_request = "POST $path HTTP/1.0\r\n";
		$http_request .= "Host: $host\r\n";
		$http_request .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$http_request .= "Content-Length: " . strlen($data) . "\r\n";
		$http_request .= "\r\n";
		$http_request .= $data;
		$response = '';
		if (($fs = @fsockopen($host, $port, $errno, $errstr, 10)) == false) {
			die ('Could not open socket! ' . $errstr);
		}		
		fwrite($fs, $http_request);
		while (!feof($fs))
			$response .= fgets($fs, 1160);
		fclose($fs);		
		$response = explode("\r\n\r\n", $response, 2);
		return $response[1];
	}
}
?>