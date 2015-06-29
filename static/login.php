<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
	<script src="http://api.geetest.com/get.php"></script>
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
			<form method="post" action="../web/VerifyLoginServlet.php">
				<div class="box">
					<label>邮箱：</label>
					<input type="text" name="email" value="geetest@geetest.com"/>
				</div>
				<div class="box">
					<label>密码：</label>
					<input type="password" name="password" value="geetest"/>
				</div>
				<div class="box" id="div_id_embed">
				<script type="text/javascript">
					//get  geetest server status, use the failback solution
					$.ajax({
						url : "../web/StartCapthcaServlet.php",
						type : "get",
						dataType : 'JSON',
						success : function(result) {
							console.log(result);
							if (result.success) {
								//1. use geetest capthca
								window.gt_captcha_obj = new window.Geetest({
									gt : result.gt,
									challenge : result.challenge,
									product : 'embed'
								});

								gt_captcha_obj.appendTo("#div_id_embed");

								//Ajax request demo,if you use submit form ,then ignore it 
								// gt_captcha_obj.onSuccess(function() {
								// 	geetest_ajax_results()
								// });

							} else {
								//failback :use your own captcha template
								//Geetest Server is down,Please use your own captcha system	in your web page
								//or use the simple geetest failback solution
								$("#div_id_embed").html('failback:gt-server is down ,please use your own captcha front');
								//document.write('gt-server is down ,please use your own captcha')
							}

						}
					})
				</script>
				</div>
				<div class="box">
					<button id="submit_button">提交</button>
				</div>
			</form>
			<script type="text/javascript">
				// function geetest_refresh() {
				// 	console.log("you can use this api in your own js function")
				// 	gt_captcha_obj.refresh();
				// }

				// function geetest_ajax_results() {
				// 	value = JSON.stringify(gt_captcha_obj.getValidate());

				// 	console.log(value);
				// 	$.ajax({
				// 		url : "../web/VerifyLoginServlet.php",//todo:set the servelet of your own
				// 		type : "post",
				// 		// dataType : 'JSON',
				// 		data : "value="+value,
				// 		success : function(sdk_result) {
				// 			console.log(sdk_result);
				// 		}
				// 	});
				// }
			</script>
		</div>
	</div>
</body>
</html>