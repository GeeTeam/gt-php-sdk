<?php
namespace GeeTeam\Geetest\Laravel;

require_once __DIR__ . '/../../lib/class.geetestlib.php';

/**
 * 极验行为式验证
 *
 * @author Latrell Chan
 */
class Geetest extends \GeetestLib
{

	public function getWidget($product, $popupbtnid = '')
	{
		$params = array(
			'gt' => $this->captcha_id,
			'challenge' => $this->challenge,
			'product' => $product
		);
		if ($product == "popup") {
			$params["popupbtnid"] = $popupbtnid;
		}
		return '<script type="text/javascript" src="http://api.geetest.com/get.php?' . http_build_query($params) . '"></script>';
	}
}
