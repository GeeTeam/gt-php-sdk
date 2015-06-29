<?php 
/**
 * PHP SDK--打包了短信验证的库
 * @author Tanxu
 */
require_once dirname(dirname(__FILE__)) . '/lib/class.geetestlib.php';
class MsgGeetestLib extends GeetestLib{
    const API_SERVER = "http://messageapi.geetest.com/";
    public function send_msg_request($action,$data){
        $url = self::API_SERVER . $action;
        $result = $this->post_request($url,$data);
        $res = json_decode($result,true);
        return $res['res'];
    }

}


 ?>