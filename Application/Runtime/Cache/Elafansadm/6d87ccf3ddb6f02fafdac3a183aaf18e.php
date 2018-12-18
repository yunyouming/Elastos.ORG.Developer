<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>亦来云技术指南后台管理系统</title> 
<link href="<?php echo (PUBLIC_F); ?>Elafansadm/css/base.css" rel="stylesheet">
<link href="<?php echo (PUBLIC_F); ?>Elafansadm/css/login/login.css" rel="stylesheet">
</head> 
<body class="white">
	<div class="login-hd">
		<div class="left-bg"></div>
		<div class="right-bg"></div>
		<div class="hd-inner">
			<span class="logo" style="background-position:13px 13px;"></span>
			<span class="split"></span>
			<span class="sys-name" style="color:#777;top: -26px;">后台管理系统</span>
		</div>
	</div>
	<div class="login-bd">
		<div class="bd-inner">
			<div class="inner-wrap">
				<div class="lg-zone">
					<div class="lg-box">
						<div class="lg-label"><h4>用户登录</h4></div>
						<div class="alert alert-error" style="display:none;">
			              <i class="iconfont">&#xe62e;</i>
			              <span>请输入用户名</span>
			            </div>
						<form>
							<div class="lg-username input-item clearfix">
								<i class="iconfont">&#xe60d;</i>
								<input type="text" id="uid" placeholder="账号">
							</div>
							<div class="lg-password input-item clearfix">
								<i class="iconfont">&#xe634;</i>
								<input type="password" id="upwd" placeholder="请输入密码">
							</div>
							<div class="lg-check clearfix">
								<div class="input-item">
									<i class="iconfont">&#xe633;</i>
									<input type="text" id="lcode" placeholder="验证码">
								</div>
								<span class="check-code"><img src="<?php echo ($curhost); ?>Index/img" style="width:116px;height:44px;" id="curcodeimg" title="点击换一张" onclick="this.src='<?php echo ($curhost); ?>Index/img?id='+Math.random();" /></span>
							</div>
							<div class="enter">
								<a href="javascript:;" id="loginbtn" class="purchaser" >登录</a>
								<a href="javascript:;" id="resetbtn" class="supplier">取消</a>
							</div>
						</form>
						<div class="line line-y"></div>
						<div class="line line-g"></div>
					</div>
				</div>
				<div class="lg-poster"></div>
			</div>
		</div>
	</div>
	<div class="login-ft">
		<div class="ft-inner">
			<div class="about-us" style="width:500px;color:#474242;font-size:12px;">
				Copyright© 2018 www.eladevp.com.cn All rights reserved 河北绿沙蓬 版权所有
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="<?php echo (PUBLIC_F); ?>Elafansadm/js/jquery-1.7.2.min.js"></script>
<script>
$(document).ready(function(){
	$("#loginbtn").click(function(){
		var userid = $("#uid").val();
		var userpwd = $("#upwd").val();
		var code = $("#lcode").val();
		$.post(
			'<?php echo ($curhost); ?>Index/logincheck',
			{
				uid:userid,
				upwd:userpwd,
				lcode:code
			},
			function(data){
				if(data==1){
					window.location.href="<?php echo ($curhost); ?>Main";
				}else if(data==4){
					alert("该账户已经停用!");
					$("#curcodeimg").attr("src","<?php echo ($curhost); ?>Index/img");
					return false;
				}else if(data==2){
					alert("验证码错误!");
					$("#curcodeimg").attr("src","<?php echo ($curhost); ?>Index/img");
					return false;
				}else{
					alert("登录失败!");
					$("#curcodeimg").attr("src","<?php echo ($curhost); ?>Index/img");
					return false;
				}
			}
		);
	});
});
</script> 
</html>