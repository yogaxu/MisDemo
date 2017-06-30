<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, 			minimum-scale=1.0, user-scalable=no, width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>我的</title>
    <link href="<?php echo base_url("zeros/app/css/common.css"); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url("zeros/app/css/css.css"); ?>" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery-1.8.3.min.js");?>"></script>
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/login.js");?>"></script>
</head>
<body>
<div class="container">
    <div class="header">
        <a href="javascript:history.go(-1)"><img src="<?php echo base_url("zeros/app/images/fanhui.png");?>"/></a>
        <p>我的</p>
    </div>
    <div class="contain">
        <div class="person">
            <div class="per-box">
                <div class="img-box">
                    <img src="<?php echo base_url("zeros/app/images/touxiang.png");?>"/>
                </div>
            </div>
            <p><?php echo $VILLAGE_NAME ?></p>
            <p><?php echo $BUILDING_NAME?></p>
            <p><?php echo $ROOM_NAME?></p>
        </div>
        <div class="con-bottom">
            <ul>
                <li>
                    <img src="<?php echo base_url("zeros/app/images/icon-27.png");?>"><span><a href="">关于我们</a></span>
                </li>
                <li>
                    <img src="<?php echo base_url("zeros/app/images/icon-28.png");?>"><span><a href="">操作指南</a></span>
                </li>
                <li>
                    <img src="<?php echo base_url("zeros/app/images/icon-26.png");?>"><span><a href="<?php echo site_url("mapp/user/login_out");?>">退出</a></span>
                </li>
            </ul>
        </div>

    </div>
    <div class="footer">
        <ul>
            <li><a href="<?php echo site_url("mapp/equipment");?>"><img src="<?php echo base_url("zeros/app/images/icon-11.png");?>"/><span>设备管理</span></a></li>
            <li><a href="<?php echo site_url("mapp/voucher");?>"><img src="<?php echo base_url("zeros/app/images/icon-12.png");?>"/><span>充值中心</span></a></li>
            <li><a href="<?php echo site_url("mapp/repair");?>"><img src="<?php echo base_url("zeros/app/images/icon-10.png");?>"/><span >维修中心</span></a></li>
            <li><a href="<?php echo site_url("mapp/user");?>"><img src="<?php echo base_url("zeros/app/images/icon-25.png");?>"/><span class="active">我的</span></a></li>
        </ul>
    </div>
</div>
</body>
</html>
