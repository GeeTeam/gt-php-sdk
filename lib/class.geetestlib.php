<?php
/**
 * 极验行为式验证安全平台，php 网站主后台包含的库文件
 */
require_once dirname(dirname(__FILE__)) . '/config/config.php';
class GeetestLib{
	const GT_API_SERVER  = 'http://api.geetest.com';
	const GT_SSL_SERVER  = 'https://api.geetest.com';
	const GT_SDK_VERSION  = 'php_2.15.4.2.2';
	public function __construct() {
		$this->challenge = "";
	}
	public function register() {
		$this->challenge = $this->send_request("/register.php", array("gt"=>CAPTCHA_ID));
		if (strlen($this->challenge) != 32) {
			return 0;
		}
		return 1;
	}
	public function validate($challenge, $validate, $seccode) {
		if ( ! $this->check_validate($challenge, $validate)) {
			return FALSE;
		}
		$data = array(
			"seccode"=>$seccode,
			"sdk"=>self::GT_SDK_VERSION,
		);
		$url = "http://api.geetest.com/validate.php";
		$codevalidate = $this->post_request($url, $data);
		if (strlen($codevalidate) > 0 && $codevalidate == md5($seccode)) {
			return TRUE;
		} else if ($codevalidate == "false"){
			return FALSE;
		} else {
			return $codevalidate;
		}
	}
	private function check_validate($challenge, $validate) {
		if (strlen($validate) != 32) {
			return FALSE;
		}
		if (md5(PRIVATE_KEY.'geetest'.$challenge) != $validate) {
			return FALSE;
		}
		return TRUE;
	}
	private function send_request($path, $data, $method = "GET") {
		if ($method == "GET") {
			$opts = array(
			    'http'=>array(
				    'method'=>"GET",
				    'timeout'=>2,
			    )
		    );
		    $context = stream_context_create($opts);
			$response = file_get_contents(self::GT_API_SERVER.$path."?". http_build_query($data), false, $context);
			return $response;
		}
	}

	public function decode_response($challenge,$string) {
		if (strlen($string) > 100) {
			return 0;
		}
		$key = array();
		$chongfu = array();
		$shuzi = [1,2,5,10,50];
		$count = 0;
		$res = 0;
		$array_challenge = str_split($challenge);
		$array_value = str_split($string);
		for ($i=0; $i < strlen($challenge); $i++) { 
			$item = $array_challenge[$i];
			if (in_array($item, $chongfu)) {
				continue;
			 }else{
				$value = $shuzi[$count % 5];
				array_push($chongfu, $item);
				$count++;
				$key[$item] = $value;
			}
		}

		for ($j=0; $j < strlen($string); $j++) { 
			$res += $key[$array_value[$j]];
		}
		$res = $res - $this->decodeRandBase($challenge);
		return $res;	
	}


	public function get_x_pos_from_str($x_str) {
		if (strlen($x_str) != 5) {
			return 0;
		}
		$sum_val = 0;
		$x_pos_sup = 200;
		$sum_val = base_convert($x_str,16,10);
		$result = $sum_val % $x_pos_sup;
		$result = ($result < 40) ? 40 : $result;
		return $result;
	}

	public function get_failback_pic_ans($full_bg_index,$img_grp_index) {
		$full_bg_name = substr(md5($full_bg_index),0,9);
		$bg_name = substr(md5($img_grp_index),10,9);

		$answer_decode = "";
		for ($i=0; $i < 9; $i++) { 
			if ($i % 2 == 0) {
				$answer_decode = $answer_decode . $full_bg_name[$i];
			}elseif ($i % 2 == 1) {
				$answer_decode = $answer_decode . $bg_name[$i];
			}
		}
		$x_decode = substr($answer_decode, 4 , 5);
    		$x_pos = $this->get_x_pos_from_str($x_decode);
    		return $x_pos;
	}

	public function decodeRandBase($challenge) {
		$base = substr($challenge, 32, 2);
		$tempArray = array();
		for ($i=0; $i < strlen($base); $i++) { 
			$tempAscii = ord($base[$i]);
			$result = ($tempAscii > 57) ? ($tempAscii - 87) : ($tempAscii -48);
			array_push($tempArray,$result);
		}
		$decodeRes = $tempArray['0'] * 36 + $tempArray['1'];
		return $decodeRes;
	}

	public function post_request($url, $postdata = null){
	    	$data = http_build_query($postdata);
	    	if(function_exists('curl_exec')){
	    		$ch = curl_init();
	    		curl_setopt($ch, CURLOPT_URL, $url);
	    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    		if(!$postdata){
	    			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	    			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	    		}else{
	    			curl_setopt($ch, CURLOPT_POST, 1);
	    			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    		}
	    		$data = curl_exec($ch);
	    		curl_close($ch);
	    	}else{
	    		if($postdata){
		    		$url = $url.'?'.$data;
				$opts = array(
					'http' => array (
			            		'method' => 'POST',
			            		'header'=> "Content-type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . strlen($data) . "\r\n",
			            		'content' => $data
			            		)
				    );
				$context = stream_context_create($opts);
		    		$data = file_get_contents($url, false, $context);
	    		}
	    	}
    	return $data;
    }
}
?>