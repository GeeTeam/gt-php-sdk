<?php 
/**
 * PHP SDK--打包了短信验证的库
 * @author Tanxu
 */
require_once dirname(dirname(__FILE__)) . "/config/config.php";
// require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
class MsgGeetestLib extends GeetestLib{
    const API_SERVER = "http://messageapi.geetest.com/";
    const SEND = "send";
    const VALIDATE = "validate";
    public function send_msg_request($action,$data){
        $url = self::API_SERVER . $action;
        // if ($data['geetest_validate'] == md5(PRIVATE_KEY . 'geetest' . $data['geetest_challenge'])) {
        //     $codedata = array(
        //             "seccode" => $data['geetest_seccode'],
        //             "sdk" => "php_2.15.4.1.1",
        //             "phone" =>$data['phone'],
        //             "msg_id" => CAPTCHA_ID
        //         );
            $result = $this->post_request($url,$data);
            $res = json_decode($result,true);
            echo $res['res'];
        // }else{
        //     echo "-11";
        // }
    }

    // public function send_code_request($data){
    //     $url = 
    // }

}


 ?>