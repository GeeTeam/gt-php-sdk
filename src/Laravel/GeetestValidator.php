<?php
namespace GeeTeam\Geetest\Laravel;

use Illuminate\Validation\Validator;
use InvalidArgumentException;

class GeetestValidator extends Validator
{

	/**
	 * 极验行为式验证
	 */
	public function validateGeetest($attribute, $value, $parameters)
	{
		if (key_exists('geetest_challenge', $this->data) && key_exists('geetest_validate', $this->data) && key_exists('geetest_seccode', $this->data)) {
			return true === app('geetest')->validate($this->data['geetest_challenge'], $this->data['geetest_validate'], $this->data['geetest_seccode']);
		}
		return false;
	}
}