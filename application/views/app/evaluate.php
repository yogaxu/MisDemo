<!-- @author 你哥 -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, 			minimum-scale=1.0, user-scalable=no, width=device-width">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>评价页面</title>
		<link href="<?php echo base_url("zeros/app/css/common.css"); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url("zeros/app/css/css.css" );?>" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery-1.9.1.js");?>"></script>
        <script type="text/javascript" src="<?php echo base_url("zeros/app/js/login.js");?>"></script>
        <script type="text/javascript" src="<?php echo base_url("zeros/app/js/evaluate.js");?>"></script>
	</head>
	<body>
		<div class="container">
			<div class="header">
				<a href="javascript:history.back(-1)"><img src="<?php echo base_url("zeros/app/images/fanhui.png");?>"/></a>
				<p>维修中心</p>
			</div>
			<div class="contain bg-white">
				<div class="eva-box">
					<form action="<?php echo site_url("mapp/evaluate/star/".$id);?>" method="post">
						<div id="star" class="star">
							<span>客户满意度</span>
								<ul>
									<li><a href="javascript:;">1</a></li>
									<li><a href="javascript:;">2</a></li>
									<li><a href="javascript:;">3</a></li>
									<li><a href="javascript:;">4</a></li>
									<li><a href="javascript:;">5</a></li>
								</ul>
								<span id="star_result" class="result"></span>
								<p></p>
						</div>
						<input type="hidden" id="star_num" name="user_star_rate">
						<textarea placeholder="请输入评价" name="user_service_rate"></textarea>
						<input type="submit" value="提交" />
					</form>
				</div>
			</div>
			<div class="footer">
				<ul>
                    <li><a href="<?php echo site_url("mapp/equipment");?>"><img src="<?php echo base_url("zeros/app/images/icon-11.png");?>"/><span>设备管理</span></a></li>
                    <li><a href="<?php echo site_url("mapp/voucher");?>"><img src="<?php echo base_url("zeros/app/images/icon-15.png");?>"/><span class="active">充值中心</span></a></li>
                    <li><a href="<?php echo site_url("mapp/repair");?>"><img src="<?php echo base_url("zeros/app/images/icon-10.png");?>"/><span >维修中心</span></a></li>
                    <li><a href="<?php echo site_url("mapp/user");?>"><img src="<?php echo base_url("zeros/app/images/icon-24.png");?>"/><span>我的</span></a></li>
                </ul>
			</div>
		</div>
		<script type="text/javascript">
		$("#star_result").bind('DOMNodeInserted', function(e) {  
		    switch ($(e.target).html()){
		        case '很不满意': $('#star_num').val('1'); break;
		        case '不满意': $('#star_num').val('2'); break;
		        case '一般': $('#star_num').val('3'); break;
		        case '满意': $('#star_num').val('4'); break;
		        default: $('#star_num').val('5');
		    }
		});
		</script>
	</body>
</html>
