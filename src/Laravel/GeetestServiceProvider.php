<?php
namespace GeeTeam\Geetest\Laravel;

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
			$config = $app->config->get('geetest');
			$geetest = new Geetest();
			$geetest->setConfig($config);
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
