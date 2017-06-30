<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>终端设备详情</title>
<link rel="stylesheet"
	href="<?php echo base_url("zeros/css/pintuer.css");?>">
<link rel="stylesheet"
	href="<?php echo base_url("zeros/css/admin.css");?>">
<link rel="stylesheet"
	href="<?php echo base_url("zeros/css/style.css");?>">
<!--<link rel="stylesheet" href="css/ace.min.css">-->
<script src="<?php echo base_url("zeros/js/jquery.js");?>"></script>
<script src="<?php echo base_url("zeros/js/pintuer.js");?>"></script>

</head>
<body>
	<form method="post" action="" id="listform" class="form-x">
		<div class="panel admin-panel">
			<div class="panel-head">
				<strong class="icon-reorder"> 终端设备详情</strong> <a href=""
					style="float: right; display: none;">添加字段</a>
			</div>
			<div class="padding">
				<table class="table text-center table-bordered">
					<tr>
						<th colspan="4">设备信息</th>
					</tr>
					<tr>
						<td class="text-right">仪表ID</td>
						<td class="text-left"><?php echo $meter["METER_ID"]; ?></td>
						<td class="text-right">仪表型号</td>
						<td class="text-left"><?php echo $meter["MODEL"]; ?></td>

					</tr>
					<tr>
						<td class="text-right">仪表类型</td>
						<td class="text-left"><?php echo $meter["METER_NAME"]; ?></td>
						<td class="text-right">集中器ID</td>
						<td class="text-left"><?php echo $meter["CMR_ID"]; ?></td>

					</tr>
					<tr>
						<td class="text-right">小区名称</td>
						<td class="text-left"><?php echo $meter["VILLAGE_NAME"]; ?></td>
						<td class="text-right">楼栋名称</td>
						<td class="text-left"><?php echo $meter["BUILDING_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">单元名称</td>
						<td class="text-left"><?php echo $meter["UNIT_NAME"]; ?></td>
						<td class="text-right">门牌号</td>
						<td class="text-left"><?php echo $meter["ROOM_NAME"];?></td>
					</tr>
					<tr>
						<td class="text-right">用户姓名</td>
						<td class="text-left"><?php echo $meter["USER_NAME"]; ?></td>
						<td class="text-right">通道号</td>
						<td class="text-left"><?php echo $meter["CH"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">使用类型</td>
						<td class="text-left"><?php 
                        switch ($meter["USABLE_TYPE"]){
                            case 1: echo '分户'; break;
                            default: echo '楼栋';
                        }
						?></td>
						<td class="text-right">使用状态</td>
						<td class="text-left"><?php 
                        switch ($meter["STATE"]){
                            case 0: echo '使用中'; break;
                            case 1: echo '未使用'; break;
                            default: echo '已注销';
                        }
						?></td>
					</tr>
					<tr>
						<td class="text-right">分摊类型</td>
						<td class="text-left"><?php echo $meter["SHARING_TYPE"]; ?></td>
						<td class="text-right">出厂日期</td>
						<td class="text-left"><?php echo $meter["PRODUCT_DATE"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">安装时间</td>
						<td class="text-left"><?php echo $meter["TIME_INSTALL"]; ?></td>
						<td class="text-right">校准时间</td>
						<td class="text-left"><?php echo $meter["TIME_CALIBRATION"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">备注</td>
						<td class="text-left"><?php echo $meter["NOTES"]; ?></td>
					</tr>
				</table>
			</div>

		</div>
	</form>
</body>
</html>



