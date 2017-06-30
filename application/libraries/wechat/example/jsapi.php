<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once dirname(__FILE__)."/../lib/WxPay.Api.php";
require_once dirname(__FILE__)."/WxPay.JsApiPay.php";
//require_once 'log.php';

//初始化日志
//$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("test");
$input->SetAttach("test");
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee("1");
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://fang1996.w3.luyouxia.net/example/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>微信支付样例-支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				alert(res.err_code+res.err_desc+res.err_msg);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
			function(res){
				var value1 = res.proviceFirstStageName;
				var value2 = res.addressCitySecondStageName;
				var value3 = res.addressCountiesThirdStageName;
				var value4 = res.addressDetailInfo;
				var tel = res.telNumber;

				alert(value1 + value2 + value3 + value4 + ":" + tel);
			}
		);
	}

	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress);
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};

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
                <p>需支付<span>0.1元</span></p>
                <div class="in-pay-type">
                    <div class="cell-icon">
                        <img src="<?php echo base_url("zeros/app/images/weixin2-2.png");?>" alt="微信支付">
                    </div>
                    <div class="cell-left">
                        <div class="in-pay-title cell-ellipsis">微信支付 </div>
                    </div>
                    <div class="checkbox">
                        <input type="radio" name="pay-method" data-index="1">
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
                        <input type="radio" name="pay-method" data-index="1">
                        <span class="checkbox-icon-round"></span>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="zf-btn">
                    <input type="button" onclick="callpay()" value="确认支付" />
                </div>
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
</body>>
</html>