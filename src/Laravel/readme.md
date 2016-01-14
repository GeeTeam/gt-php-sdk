gt-php-sdk
============

极验行为式验证 for Laravel 扩展包。

## 使用

要使用本服务提供者，你必须自己注册服务提供者到Laravel服务提供者列表中。

打开配置文件 `config/app.php`。

找到key为 `providers` 的数组，在数组中添加服务提供者。

```php
    'providers' => [
        // ...
        GeeTeam\Geetest\Laravel\GeetestServiceProvider::class,
    ]
```

找到key为 `aliases` 的数组，在数组中注册Facades。

```php
    'aliases' => [
        // ...
        'Geetest' => GeeTeam\Geetest\Laravel\Facades\Geetest::class,
    ]
```

运行 `php artisan vendor:publish` 命令，发布配置文件到你的项目中。

修改配置文件 `config/geetest.php` 内的配置信息。

## 例子

### 视图 login.blade.php
```
	...
	@if (Geetest::register())
		{!! Geetest::getWidget('float')!!}
	@else
		<input type="text" class="form-control" placeholder="验证码" name="captcha" autocomplete="off">
		<img class="img-rounded" src="{{ Captcha::url() }}" alt="图形验证码" id="CaptchaImg">
	@endif
	...
```

### 控制器 AuthController.php
```php
	// 验证输入。
	$validator = $this->getValidationFactory()->make($request->all(), [
		// ...
	], [
		'captcha.required' => '请填写验证图片中的文字。',
		'geetest_challenge.required' => '请拖动滑块完成验证。'
	]);
	$validator->sometimes('captcha', 'required|captcha', function ($input) {
		// 其它验证方式，比如图形验证码。
		return is_null($input->geetest_challenge) || is_null($input->geetest_validate) || is_null($input->geetest_seccode);
	});
	$validator->sometimes('geetest_challenge', 'required|geetest', function ($input) {
		// 极验行为式验证。
		return ! is_null($input->geetest_challenge) && ! is_null($input->geetest_validate) && ! is_null($input->geetest_seccode);
	});
	if ($validator->fails()) {
		$this->throwValidationException($request, $validator);
	}
```
