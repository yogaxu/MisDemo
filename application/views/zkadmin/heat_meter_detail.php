<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>楼栋总表详情</title>
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
				<strong class="icon-reorder"> 楼栋总表详情</strong> <a href=""
					style="float: right; display: none;">添加字段</a>
			</div>
			<div class="padding">
				<table class="table text-center table-bordered">
					<tr>
						<th colspan="4">热表信息</th>
					</tr>
					<tr>
						<td class="text-right">热表ID</td>
						<td class="text-left"><?php echo $heat_meter["HEAT_METER_ID"]; ?></td>
						<td class="text-right">集中器ID</td>
						<td class="text-left"><?php echo $heat_meter["CMR_ID"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">楼栋名称</td>
						<td class="text-left"><?php echo $heat_meter["BUILDING_NAME"];?></td>
						<td class="text-right">门牌号</td>
						<td class="text-left"><?php echo $heat_meter["ROOM_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">面积</td>
						<td class="text-left"><?php echo $heat_meter["FLOOR_AREA"]; ?>m²</td>
						<td class="text-right">累计热量</td>
						<td class="text-left"><?php echo $heat_meter["HEAT_QUANTITY_REAL"]; ?><?php echo $heat_meter["HEAT_QUANTITY_UNIT"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">累计流量</td>
						<td class="text-left"><?php echo $heat_meter["VOLUME"]; ?><?php echo $heat_meter["VOLUME_UNIT"]; ?></td>
						<td class="text-right">热功率</td>
						<td class="text-left"><?php echo $heat_meter["HEAT_POWER"]; ?><?php echo $heat_meter["HEAT_POWER_UNIT"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">瞬时流量</td>
						<td class="text-left"><?php echo $heat_meter["FLOWRATE_REAL"]; ?><?php echo $heat_meter["FLOWRATE_UNIT"]; ?></td>
						<td class="text-right">实时状态</td>
						<td class="text-left"><?php echo $heat_meter["STATE"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">进水</td>
						<td class="text-left"><?php echo $heat_meter["TEMP_INTAKE"]; ?>℃</td>
						<td class="text-right">回水</td>
						<td class="text-left"><?php echo $heat_meter["TEMP_RETURN"]; ?>℃</td>
					</tr>
					<tr>
						<td class="text-right">采集时间</td>
						<td class="text-left"><?php echo $heat_meter["TIME_SAMPLE"]; ?></td>
						<td class="text-right">上传时间</td>
						<td class="text-left"><?php echo $heat_meter["TIME_UPLOAD"]; ?></td>
					</tr>
				</table>
			</div>

		</div>
	</form>
</body>
</html>



