<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>极验行为式验证 php 类网站安装测试页面</title>
	<style>	
	body {
		background-color: #9e9;
	}
	.wrap {
		width: 960px;
		margin: 100px auto;
		font-size: 125%;
	}
	.row {
		margin: 30px 0;
	}
	
	</style>
</head>
<body>
	<div class="wrap">
		<h1>极验行为式验证 php 类网站安装测试页面</h1>
		<form method="post" action="VerifyLogin.php">
			<div class="row">
				<label for="name">邮箱</label>
				<input type="text" id="email" name="email" value="geetest@126.com"/>
			</div>
			<div class="row">
				<label for="passwd">密码</label>
				<input type="password" id="passwd" name="passwd" value="gggggggg"/>
			</div>
			<div class="row">
				<?php
				 $opts = array(
				    'http'=>array(
				    'method'=>"GET",
				    'timeout'=>3,
				    )
			    );
				require_once("./lib/geetestlib.php");
				$geetestlib = new geetestdemo();
				$api = "http://api.geetest.com";
				$url = $api."/register.php?gt=a40fd3b0d712165c5d13e6f747e948d4&challenge=".$geetestlib->challenge();
				$content_challenge = file_get_contents($url); 
			    $context = stream_context_create($opts);
			    $content = file_get_contents($api.'/check_status.php', false, $context); 
					if ($content == "ok" && $content_challenge == "OK") {
						$ran = rand(1,100000);
						echo '<script type="text/javascript" src="http://api.geetest.com/get.php?gt=a40fd3b0d712165c5d13e6f747e948d4&random='.$ran.'"></script>';
					}else{
						echo "use your own captcha HTML web code!";//这里输出网站原有验证码
					}

				 ?>
				
			</div>
			<div class="row">
				<input type="submit" value="登录" />
			</div>
		</form>
	</div>	
</body>
</html>