<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>冷水表详情</title>
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
				<strong class="icon-reorder"> 冷水表详情</strong> <a href=""
					style="float: right; display: none;">添加字段</a>
			</div>
			<div class="padding">
				<table class="table text-center table-bordered">
					<tr>
						<th colspan="4">冷水表信息</th>
					</tr>
					<tr>
						<td class="text-right">水表ID</td>
						<td class="text-left"><?php echo $water_meter["WATER_METER_ID"]; ?></td>
						<td class="text-right">集中器ID</td>
						<td class="text-left"><?php echo $water_meter["CMR_ID"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">楼栋名称</td>
						<td class="text-left"><?php echo $water_meter["BUILDING_NAME"];?></td>
						<td class="text-right">门牌号</td>
						<td class="text-left"><?php echo $water_meter["ROOM_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">面积</td>
						<td class="text-left"><?php echo $water_meter["FLOOR_AREA"]; ?>m²</td>
						<td class="text-right">水表类型</td>
						<td class="text-left"><?php echo $water_meter["MODEL"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">批次号</td>
						<td class="text-left"><?php echo $water_meter["BATCH_NO"]; ?></td>
						<td class="text-right">序列号</td>
						<td class="text-left"><?php echo $water_meter["SERIAL_NO"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">通道号</td>
						<td class="text-left"><?php echo $water_meter["CH"]; ?></td>
						<td class="text-right">当前累计流量</td>
						<td class="text-left"><?php echo $water_meter["CUR_TOTAL_FLOW"].$water_meter['UNIT_CUR_TOTAL_FLOW']; ?></td>
					</tr>
					<tr>
						<td class="text-right">结算日累计流量</td>
						<td class="text-left"><?php echo $water_meter["DAY_TOTAL_FLOW"].$water_meter['UNIT_DAY_TOTAL_FLOW']; ?></td>
						<td class="text-right">瞬时流量</td>
						<td class="text-left"><?php echo $water_meter["IN_FLOW"].$water_meter['UNIT_IN_FLOW']; ?></td>
					</tr>
					<tr>
						<td class="text-right">正向流量</td>
						<td class="text-left"><?php echo $water_meter["FORWARD_FLOW"].$water_meter['UNIT_FORWARD_FLOW']; ?></td>
						<td class="text-right">反向流量</td>
						<td class="text-left"><?php echo $water_meter["REVERSE_FLOW"].$water_meter['UNIT_REVERSE_FLOW']; ?></td>
					</tr>
					<tr>
						<td class="text-right">采样时间</td>
						<td class="text-left"><?php echo $water_meter["TIME_SAMPLE"]; ?></td>
						<td class="text-right">上传时间</td>
						<td class="text-left"><?php echo $water_meter["TIME_UPLOAD"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">实时时间</td>
						<td class="text-left"><?php echo $water_meter["REALTIME"]; ?></td>
					</tr>
				</table>
			</div>

		</div>
	</form>
</body>
</html>



