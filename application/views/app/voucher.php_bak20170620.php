<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, 			minimum-scale=1.0, user-scalable=no, width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>充值中心</title>
    <link href="<?php echo base_url("zeros/app/css/common.css"); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url("zeros/app/css/css.css"); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url("zeros/app/css/swiper.min.css");?>" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery-1.9.0.min.js");?>"></script>
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/login.js");?>"></script>
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/swiper.min.js");?>"></script>
</head>
<body>
<!-- <div class="tip-bg">
    <div class="tip-box">
        <p>充值失败<?php echo $pay_flag;?></p>
        <a href="javascript:;">返回充值中心</a>
    </div>
</div> -->
<?php if(strcmp($pay_flag, 'success') == 0){?>
<!-- <div class="tip-bg" style="display: block;">
    <div class="tip-box">
        <p>充值成功</p>
        <a href="javascript:;">返回充值中心</a>
    </div>
</div>-->
<?php }else if (strcmp($pay_flag, 'fail') == 0){?>
<!-- <div class="tip-bg" style="display: block;">
    <div class="tip-box">
        <p>充值失败</p>
        <a href="javascript:;">返回充值中心</a>
    </div>
</div> -->
<?php }?>
<div class="container">
    <div class="header">
        <a href="javascript:history.go(-1)"><img src="<?php echo base_url("zeros/app/images/fanhui.png");?>"/></a>
        <p>充值中心</p>
    </div>
    <div class="contain bg-white">
        <div class="swiper-container">
            <div class="my-pagination">
                <ul class="my-pagination-ul"></ul>
            </div>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <?php if(strcmp($use_card, '0') == 0 && strcmp($payment_type, '2') == 0){?>
                    <div class="area">
                        <p><b class="w4">住址</b> <b>：</b><?php echo $village.$building.$room;?></p>
                        <p><b class="w4">建筑面积</b> <b>：</b><?php echo $area;?>平方米</p>
                        <p><b class="w4">热费单价</b> <b>：</b><?php echo $price_prepaid;?>元/平米</p>
                        <p><b class="w4">应缴费用</b> <b>：</b><?php echo $area*$price_prepaid;?>元</p>
                        <form action="<?php echo base_url("mapp/pay");?>" method="post">
                            <input type="hidden" name="village" value="<?php echo $village;?>">
                            <input type="hidden" name="building" value="<?php echo $building;?>">
                            <input type="hidden" name="room" value="<?php echo $room;?>">
                            <input type="hidden" name="village_no" value="<?php echo $village_no;?>">
                            <input type="hidden" name="building_no" value="<?php echo $building_no;?>">
                            <input type="hidden" name="room_no" value="<?php echo $room_no;?>">
                            <input type="hidden" name="fee" value="0.01">
                            <button type="submit" class="cz-btn">充值</button>
                        </form>
                    </div>
                    <?php } if(strcmp($use_card, '0') == 0 && strcmp($payment_type, '1') == 0){?>
                    <div class="area">
                     	<p><b class="w4">住址</b><b>：</b><?php echo $village.$building.$room;?></p>
                     	<p><b class="w4">建筑面积</b><b>：</b><?php echo $area;?>平方米</p>
                     	<p><b class="w4">预收单价</b><b>：</b><?php echo $price_prepaid;?>元/平米</p>
                     	<p><b class="w4">基本单价</b><b>：</b><?php echo $price_base;?>元/平米</p>
                     	<p><b class="w4">计量单价</b><b>：</b><?php echo $price_meas;?>元/平米</p>
                     	<p><b class="w4">应缴费用</b><b>：</b><?php echo $area*$price_prepaid;?>元</p>
                        <form action="<?php echo base_url("mapp/pay");?>" method="post">
                            <input type="hidden" name="village" value="<?php echo $village;?>">
                            <input type="hidden" name="building" value="<?php echo $building;?>">
                            <input type="hidden" name="room" value="<?php echo $room;?>">
                            <input type="hidden" name="village_no" value="<?php echo $village_no;?>">
                            <input type="hidden" name="building_no" value="<?php echo $building_no;?>">
                            <input type="hidden" name="room_no" value="<?php echo $room_no;?>">
                            <input type="hidden" name="fee" value="0.01">
                            <button type="submit" class="cz-btn">充值</button>
                        </form>
                     </div>
                     <?php } if(strcmp($use_card, '1') == 0 && strcmp($payment_type, '2') == 0){?>
                     <div class="area">
                        <p><b class="w4">住址</b> <b>：</b><?php echo $village.$building.$room;?></p>
                        <p><b class="w4">建筑面积</b> <b>：</b><?php echo $area;?>平方米</p>
                        <p><b class="w4">热费单价</b> <b>：</b><?php echo $price_prepaid;?>元/平米</p>
                        <p><b class="w4">应缴费用</b> <b>：</b><?php echo $area*$price_prepaid;?>元</p>
                        <form action="<?php echo base_url("mapp/nfc_pay");?>" method="post">
                            <input type="hidden" name="village" value="<?php echo $village;?>">
                            <input type="hidden" name="building" value="<?php echo $building;?>">
                            <input type="hidden" name="room" value="<?php echo $room;?>">
                            <input type="hidden" name="village_no" value="<?php echo $village_no;?>">
                            <input type="hidden" name="building_no" value="<?php echo $building_no;?>">
                            <input type="hidden" name="room_no" value="<?php echo $room_no;?>">
                            <input type="hidden" name="fee" value="0.01">
                            <button type="submit" class="cz-btn">充值</button>
                        </form>
                    </div>
                     <?php } if(strcmp($use_card, '1') == 0 && strcmp($payment_type, '1') == 0){?>
                     <div class="area">
                     	<p><b class="w4">住址</b><b>：</b><?php echo $village.$building.$room;?></p>
                     	<p><b class="w4">建筑面积</b><b>：</b><?php echo $area;?>平方米</p>
                     	<p><b class="w4">预收单价</b><b>：</b><?php echo $price_prepaid;?>元/平米</p>
                     	<p><b class="w4">基本单价</b><b>：</b><?php echo $price_base;?>元/平米</p>
                     	<p><b class="w4">计量单价</b><b>：</b><?php echo $price_meas;?>元/平米</p>
                     	<p><b class="w4">应缴费用</b><b>：</b><?php echo $area*$price_prepaid;?>元</p>
                        <form action="<?php echo base_url("mapp/nfc_pay");?>" method="post">
                            <input type="hidden" name="village" value="<?php echo $village;?>">
                            <input type="hidden" name="building" value="<?php echo $building;?>">
                            <input type="hidden" name="room" value="<?php echo $room;?>">
                            <input type="hidden" name="village_no" value="<?php echo $village_no;?>">
                            <input type="hidden" name="building_no" value="<?php echo $building_no;?>">
                            <input type="hidden" name="room_no" value="<?php echo $room_no;?>">
                            <input type="hidden" name="fee" value="0.01">
                            <button type="submit" class="cz-btn">充值</button>
                        </form>
                     </div>
                     <?php }?>
                </div>
                <div class="swiper-slide">
                    <div class="cz-history">
                        <ul>
                            <?php foreach ($deposits as $row) { ?>
                            <li>
                                <div class="money">
                                    <p>缴费金额</p>
                                    <h1><?php echo $row['C_Money'];?>元</h1>
                                </div>
                                <div class="detail">
                                    <p><span><b class="w4">住址</b><b>：</b><?php echo $row['VILLAGE_NAME'].$row['BUILDING_NAME'].$row['ROOM_NAME'];?></span>
                                        <span><b class="w4">建筑面积</b><b>：</b><?php echo $area;?>平方米</span>
                                        <span><b class="w4">热费单价</b><b>：</b><?php echo $price_prepaid;?>元/平米</span></p>
                                </div>
                                <div class="clear"></div>
                                <div class="cz-time"><p><span>充值方式：<?php echo $row['recharge_type'];?></span><span>充值时间：<?php echo $row['DEPOSIT_TIME'];?></span></p></div>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
            </div>
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
<script>
    var mySwiper = new Swiper('.swiper-container',{
        pagination: '.my-pagination-ul',
        paginationClickable: true,
        paginationBulletRender: function (index, className) {
            switch (index) {
                case 0: name='充值';break;
                case 1: name='充值历史';break;
                default: name='';
            }
            return '<li class="' + className + '">' + name + '</li>';
        }
    });
    var pay_flag = '<?php echo $pay_flag;?>';
    if(pay_flag == 'success' || pay_flag == 'fail'){
        mySwiper.slideTo(1, 1000, false);
    }
</script>
</body>
</html>