<html>
<head>
    head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, 			minimum-scale=1.0, user-scalable=no, width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>支付页面</title>
    <link href="<?php echo base_url("zeros/app/css/common.css"); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url("zeros/app/css/css.css"); ?>" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery-1.8.3.min.js");?>"></script>
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/login.js");?>"></script>
    <script type="text/javascript">
        callpay();
        //调用微信JS api 支付
        function jsApiCall() {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters; ?>,
                function (res) {
                    if(res.err_msg == "get_brand_wcpay_request:ok" ){
                        $.ajax({
                            url:'<?php echo site_url("mapp/wepay/save");?>',
                            success : function(ret){
                                if(ret==1){
                                    //成功后返回我的订单页面
                                    location.href="<?php echo site_url("mapp/voucher/index/success");?>";
                                }
                            }
                        });
                    }else{
                        alert("支付失败，请重试!");
                        history.go(-1);
                    }

                }
            );
        }

        function callpay() {
            if (typeof WeixinJSBridge == "undefined") {
                if (document.addEventListener) {
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                } else if (document.attachEvent) {
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            } else {
                jsApiCall();
            }
        }
    </script>
    <script type="text/javascript">
        //获取共享地址
        function editAddress() {
            WeixinJSBridge.invoke(
                'editAddress',
                <?php echo $editAddress; ?>,
                function (res) {
                    var value1 = res.proviceFirstStageName;
                    var value2 = res.addressCitySecondStageName;
                    var value3 = res.addressCountiesThirdStageName;
                    var value4 = res.addressDetailInfo;
                    var tel = res.telNumber;
                }
            );
        }

        window.onload = function () {
            if (typeof WeixinJSBridge == "undefined") {
                if (document.addEventListener) {
                    document.addEventListener('WeixinJSBridgeReady', editAddress, false);
                } else if (document.attachEvent) {
                    document.attachEvent('WeixinJSBridgeReady', editAddress);
                    document.attachEvent('onWeixinJSBridgeReady', editAddress);
                }
            } else {
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
        </div>
    </div>
</div>
</body>
</html>