<!-- @author 你哥 -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, 			minimum-scale=1.0, user-scalable=no, width=device-width">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>待处理详情</title>
		<link href="<?php echo base_url("zeros/app/css/common.css"); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url("zeros/app/css/css.css" );?>" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery-1.9.1.js");?>"></script>
        <script type="text/javascript" src="<?php echo base_url("zeros/app/js/login.js");?>"></script>
	</head>
	<body>
		<div class="container">
			<div class="header">
				<a href="javascript:history.back(-1)"><img src="<?php echo base_url("zeros/app/images/fanhui.png");?>"/></a>
				<p>维修中心</p>
			</div>
			<div class="contain bg-white">
	             <div class="area">
	             	<p><b class="w4">单号</b><b>：</b><?php echo $pending['order_id']?></p>
	             	<p><b class="w4">住址</b><b>：</b><?php echo $pending['village_name'].$pending['building_name'].$pending['room_name']?></p>
	             	<p><b class="w4">维修员</b><b>：</b><?php echo $pending['repairman']?></p>
	             	<p><b class="w4">服务电话</b><b>：</b><?php echo $pending['repairman_tel']?></p>
	             	<p><b class="w4">联系人</b><b>：</b><?php echo $pending['user_name']?></p>
	             	<p><b class="w4">联系电话</b><b>：</b><?php echo $pending['user_tel']?></p>
	             	<p><b class="w4">预约时间</b><b>：</b><?php echo $pending['appointment_start']?> ~ </p>
	             	<p><b class="w5"></b><?php echo $pending['appointment_end']?></p>
	             	<p><b class="w4">故障描述</b><b>：</b><?php echo $pending['fault_description']?></p>
	             	<p><b class="w4">备注</b><b>：</b><?php echo $pending['user_description']?></p>
	             	<p><b class="w4">系统预判</b><b>：</b><?php echo $pending['system_predicts']?></p>
	             	<p><b class="w4">报修时间</b><b>：</b><?php echo $pending['report_time']?></p>
	             </div>
	             <div class="wx-box">
	             <?php $imgs = explode(',', $pending['image_path']);?>
	             <?php 
	             if(strcmp($imgs[0], '') != 0){
	               foreach ($imgs as $img){?>
             		<img src="<?php echo base_url("uploads/".$img);?>" />
         		<?php }
                }?>
             	</div>
	            <div class="clear"></div>
            	<div class="bor-top"><h1>最近三次报修记录</h1></div>
            	<?php foreach ($last as $lt) {?>
	            <div class="bor-top">
	            	<div class="wx-history">
	            	<div class="area">
                        <p><b class="w4">单号</b><b>：</b><?php echo $lt['order_id']?></p>
		             	<p><b class="w4">住址</b><b>：</b><?php echo $lt['village_name'].$lt['building_name'].$lt['room_name']?></p>
		             	<p><b class="w4">维修员</b><b>：</b><?php echo $lt['repairman']?></p>
		             	<p><b class="w4">联系人</b><b>：</b><?php echo $lt['user_name']?></p>
		             	<p><b class="w4">联系电话</b><b>：</b><?php echo $lt['user_tel']?></p>
		             	<p><b class="w4">预约时间</b><b>：</b><?php echo $lt['appointment_start']?> ~ </p>
	             	    <p><b class="w5"></b><?php echo $lt['appointment_end']?></p>
		             	<p><b class="w4">故障描述</b><b>：</b><?php echo $lt['fault_description']?></p>
		             	<p><b class="w4">备注</b><b>：</b><?php echo $lt['user_description']?></p>
		             	<p><b class="w4">系统预判</b><b>：</b><?php echo $lt['system_predicts']?></p>
                        <p><b class="w4">客户评价</b><b>：</b>
                        <?php 
                        $star = '';
                        for ($i = 0; $i < $lt['user_star_rate']; $i = $i + 1) {
                            $star = $star.'<i></i>';      
                        }
                        echo $star;
                        ?>
                        <span><?php echo $lt['user_service_rate']?></span></p>
                     </div>
                     <div class="wx-box">
    	             <?php $imgs_lt = explode(',', $lt['image_path']);?>
    	             <?php 
    	             if(strcmp($imgs_lt[0], '') != 0){  
    	               foreach ($imgs_lt as $img_lt){?>
                 		<img src="<?php echo base_url("uploads/".$img_lt);?>" />
             		 <?php }
    	             }?>
                 	 </div>
	            	 <div class="clear"></div>
	            	 <div class="datetime">
	            		报修时间：<?php echo $lt['report_time']?>
	            	 </div>
	            	 <div class="datetime">
	            		完工时间：<?php echo $lt['repair_time']?>
	            	 </div>
	                 </div>
	           </div>
	           <?php }?>
			</div>
			<div class="footer">
				<ul>
					<li><a href="<?php echo site_url("mapp/equipment");?>"><img src="<?php echo base_url("zeros/app/images/icon-11.png");?>"/><span>设备管理</span></a></li>
                    <li><a href="<?php echo site_url("mapp/voucher");?>"><img src="<?php echo base_url("zeros/app/images/icon-12.png");?>"/><span>充值中心</span></a></li>
                    <li><a href="<?php echo site_url("mapp/repair");?>"><img src="<?php echo base_url("zeros/app/images/icon-13.png");?>"/><span class="active">维修中心</span></a></li>
                    <li><a href="<?php echo site_url("mapp/user");?>"><img src="<?php echo base_url("zeros/app/images/icon-24.png");?>"/><span>我的</span></a></li>
				</ul>
			</div>
		</div>
	</body>
</html>
