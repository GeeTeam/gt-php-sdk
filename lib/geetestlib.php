<?php
/**
 * 极验行为式验证安全平台，php 网站主后台包含的库文件
 */

// define("PRIVATE_KEY","0f1a37e33c9ed10dd2e133fe2ae9c459");

class geetestdemo{
	function __construct($CAPTCHA_KEY,$PRIVATE_KEY){
		$this->CAPTCHA_KEY = $CAPTCHA_KEY;
		$this->PRIVATE_KEY = $PRIVATE_KEY;
		$this->api = "http://api.geetest.com";
		$this->challenge = "";
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

	function get_context(){
		$opts = array(
		    'http'=>array(
		    'method'=>"GET",
		    'timeout'=>2,
		    )
	    );
	    $context = stream_context_create($opts);
	}
	
	function register_challenge(){
		$url = $this->api."/register.php?gt=".$this->CAPTCHA_KEY;
		$context = $this->get_context();
		$this->challenge = file_get_contents($url,false,$context); 

		if (strlen($this->challenge) != 32) {
			return 0;
		}
		return 1;

	}

	function failback(){
		$context = $this->get_context();
	    $content = file_get_contents($this->api.'/check_status.php', false, $context); 
		if ($content != "ok"){
			return 0;
		}
		return 1;	
	}

	function process(){
	    if ($this->register_challenge() != 1) {
	    	return 0;
	    }
	    return 1;
	}

	function geetest_api($product){
		return "<script type='text/javascript' src='http://api.geetest.com/get.php?gt=".$this->CAPTCHA_KEY."&challenge=".$this->challenge."&product=".$product."'></script>";
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