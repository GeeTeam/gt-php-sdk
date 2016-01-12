<?php
namespace GeeTeam\Geetest;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

/**
 * 极验行为式验证
 *
 * @author Latrell Chan
 */
class GeetestServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// 注册自定义验证器扩展。
		Validator::resolver(function ($translator, $data, $rules, $messages) {
			return new GeetestValidator($translator, $data, $rules, $messages);
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('geetest', function ($app) {
			require_once base_path('vendor/gee-team/gt-php-sdk/src/class.geetest.php');
			$config = $app->config->get('geetest');
			$geetest = new \Geetest();
			$geetest->set_captchaid($config['captcha_id']);
			$geetest->set_privatekey($config['private_key']);
			return $geetest;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
			'geetest'
		];
	}
}
