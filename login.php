<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>极验行为式验证 php 类网站安装测试页面</title>
</head>
<body>
	<style type="text/css">

		.container{
			width: 960px;
			margin: 0 auto;
		}
		.content{
			width: 960px;
			margin: 10 auto;
			border-top: 1px solid #ccc;

		}
		.box{
			width:300px;
			margin: 30px auto; 
		}
		.header{
			margin: 80px auto 30px auto;
			text-align: center;
			font-size: 34px;
		}
		input{
			width: 200px;
			padding: 6px 9px;
		}
		button{
			cursor: pointer;
			line-height: 35px;
			width: 110px;
			margin:30px 0 0 90px;
			border: 1px solid #FFFFF0;
			background-color: #31C552;

			border-radius: 4px;
			font-size: 14px;	
			color: #FFFFF0;	
		}
	</style>

	<div class="container">
		<div class="header">
			极验行为式验证 php 类网站安装测试页面
		</div>
		<div class="content">
			<form method="post" action="VerifyLogin.php">
				<div class="box">
					<label>邮箱：</label>
					<input type="text" name="email" value="geetest@geetest.com"/>
				</div>
				<div class="box">
					<label>密码：</label>
					<input type="password" name="password" value="geetest"/>
				</div>
				<div class="box">
				<?php
					require_once("./lib/geetestlib.php");
					$geetest = new GeetestLib();
					$geetest->set_captchaid("a40fd3b0d712165c5d13e6f747e948d4");
					if ($geetest->register()) {
						echo $geetest->get_widget("float");//若采用弹出式，要添加第二个参数（提交按钮的id）
					} else {
						echo "use your own captcha HTML web code!";//这里输出网站原有验证码
					}
				 ?>
				</div>
				<div class="box">
					<button id="submit_button">提交</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>