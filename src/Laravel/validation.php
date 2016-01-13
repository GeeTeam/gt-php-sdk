<?php

Validator::extend('geetest', function ($attribute, $value, $parameters, $validator) {
	$data = $validator->getData();
	if (key_exists('geetest_challenge', $data) && key_exists('geetest_validate', $data) && key_exists('geetest_seccode', $data)) {
		return true === app('geetest')->validate($data['geetest_challenge'], $data['geetest_validate'], $data['geetest_seccode']);
	}
	return false;
});
