<?php
/**
 * 极验行为式验证安全平台，php 网站主后台包含的库文件
 */

// define("PRIVATE_KEY","0f1a37e33c9ed10dd2e133fe2ae9c459");

class geetestdemo{
	function __construct($PRIVATE_KEY,$CAPTCHA_KEY){
		$this->PRIVATE_KEY = $PRIVATE_KEY;
		$this->CAPTCHA_KEY = $CAPTCHA_KEY;
		$this->api = "http://api.geetest.com";
		$str = str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
		$time = strval(time());
		$rand = strval(rand(0,99999));
		$test = $time.$str.$rand;
		$this->challenge = md5($test);
	}

	function geetest_validate($challenge, $validate, $seccode) {	
		$apiserver = 'api.geetest.com';
		if (strlen($validate) > 0 && $this->_check_result_by_private($challenge, $validate)) {		
			$query = 'seccode='.$seccode;
			$servervalidate = $this->_http_post($apiserver, '/validate.php', $query);			
			if (strlen($servervalidate) > 0 && $servervalidate == md5($seccode)) {
				return TRUE;
			}else if($servervalidate == "false"){
				return FALSE;
			}else{ 
				return $servervalidate;
			}
		}
		
		return FALSE;
	}
	function failback(){
		$url = $this->api."/register.php?gt=".$this->CAPTCHA_KEY."&challenge=".$this->challenge;
		$content_challenge = file_get_contents($url); 
		$opts = array(
		    'http'=>array(
		    'method'=>"GET",
		    'timeout'=>3,
		    )
	    );
	    $context = stream_context_create($opts);
	    $content = file_get_contents($this->api.'/check_status.php', false, $context); 
		if ($content_challenge == "ok" && $content == "ok") {
			return 1;
		}else{
			return 0;
		}
	}

	function geetest_api(){
		return "<script type='text/javascript' src='http://api.geetest.com/get.php?gt=".$this->CAPTCHA_KEY."&challenge=".$this->challenge."'></script>";
	}

	function _check_result_by_private($origin, $validate) {
		return $validate == md5($this->PRIVATE_KEY.'geetest'.$origin) ? TRUE : FALSE;
	}

	function _http_post($host, $path, $data, $port = 80) {
		// $data = _fix_encoding($data);
		
		$http_request  = "POST $path HTTP/1.0\r\n";
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

	function _fix_encoding($str) { 	
		$curr_encoding = mb_detect_encoding($str) ; 
		
		if($curr_encoding == "UTF-8" && mb_check_encoding($str,"UTF-8")) {
			return $str; 
		} else {
			return utf8_encode($str); 
		}
	}
}
?>