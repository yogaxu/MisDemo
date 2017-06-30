<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, 			minimum-scale=1.0, user-scalable=no, width=device-width">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>支付页面</title>
        <link href="<?php echo base_url("zeros/app/css/common.css"); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url("zeros/app/css/css.css"); ?>" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery-1.8.3.min.js");?>"></script>
		<script type="text/javascript" src="<?php echo base_url("zeros/app/js/login.js");?>"></script>
        <script type="text/javascript">
            function callpay()
            {
            	var paymethod = $("input[name='pay-method']:checked").val();
            	if(paymethod == 'we'){
                    window.location.href="<?php echo base_url("mapp/wePay").'?fee='.$fee;?>";
            	}
            	if(paymethod == 'ali'){
                	$('#alipay_form').submit();
            	}
            }
        </script>
	</head>
	<body>
		<div class="container">
			<div class="header">
				<a href="javascript:history.go(-1)"><img src="<?php echo base_url("zeros/app/images/fanhui.png");?>"/></a>
				<p>支付</p>
			</div>
			<div class="contain">
				<div class="pay-box bg-white">
					<form action="<?php echo site_url("mapp/wePay/pay");?>" method="post">
						<p>需支付<span><?php echo $fee;?>元</span></p>
						<div class="in-pay-type">
							<div class="cell-icon">
								<img src="<?php echo base_url("zeros/app/images/weixin2-2.png");?>" alt="微信支付">
							</div>
							<div class="cell-left">
								<div class="in-pay-title cell-ellipsis">微信支付 </div>
							</div>
							<div class="checkbox">
								<input type="radio" name="pay-method" data-index="1" value="we">
								<span class="checkbox-icon-round"></span>
							</div>
							<div class="clear"></div>
						</div>
						<div class="in-pay-type">
							<div class="cell-icon">
								<img src="<?php echo base_url("zeros/app/images/alipay2-2.png");?>" alt="支付宝支付">
							</div>
							<div class="cell-left">
								<div class="in-pay-title cell-ellipsis">支付宝支付 </div>
							</div>
							<div class="checkbox">
								<input type="radio" name="pay-method" data-index="1" value="ali">
								<span class="checkbox-icon-round"></span>
							</div>
							<div class="clear"></div>
						</div>
						<div class="zf-btn">
							<input type="button" onclick="callpay()"  value="确认支付" />
						</div>
					</form>
					
					<!-- alipay可能需要的参数 -->
					<form action="<?php echo base_url("mapp/voucher/aliPay");?>" method="post" id="alipay_form">
                        <input type="hidden" name="village" value="<?php echo $village;?>">
                        <input type="hidden" name="building" value="<?php echo $building;?>">
                        <input type="hidden" name="room" value="<?php echo $room;?>">
                        <input type="hidden" name="village_no" value="<?php echo $village_no;?>">
                        <input type="hidden" name="building_no" value="<?php echo $building_no;?>">
                        <input type="hidden" name="room_no" value="<?php echo $room_no;?>">
                        <input type="hidden" name="fee" value="<?php echo $fee;?>">
                        <?php 
                        //生成订单号
                        date_default_timezone_set("Asia/Chongqing");
                        $a = date("Y");
                        $b = date("m");
                        $c = date("d");
                        $d = date("G");
                        $e = date("i");
                        $f = date("s");
                        $sNow = $a . $b . $c . $d . $e . $f;
                        ?>
                        <input type="hidden" name="good_id" value="<?php echo $sNow;?>">
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
	</body>
</html>