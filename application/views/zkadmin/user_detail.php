<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>用户详情</title>
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
				<strong class="icon-reorder"> 用户详情</strong> <a href=""
					style="float: right; display: none;">添加字段</a>
			</div>
			<div class="padding">
				<table class="table text-center table-bordered">
					<tr>
						<th colspan="4">用户信息</th>
					</tr>
					<tr>
						<td class="text-right">卡号</td>
						<td class="text-left"><?php echo $user["METER_ID"]; ?></td>
						<td class="text-right">缴费状态</td>
						<td class="text-left"><?php echo $user["payment_status"]; ?></td>

					</tr>
					<tr>
						<td class="text-right">住址地区</td>
						<td class="text-left"><?php echo $user["CITY_NAME"].$user["VILLAGE_NAME"].$user["BUILDING_NAME"].$user["ROOM_NAME"]; ?></td>
						<td class="text-right">预设温度</td>
						<td class="text-left"><?php echo $user["temp_set"]; ?></td>

					</tr>
					<tr>
						<td class="text-right">累计热量</td>
						<td class="text-left"><?php echo $user["total_heat"]; ?></td>
						<td class="text-right">累计时间</td>
						<td class="text-left"><?php echo $user["total_time"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">剩余热量</td>
						<td class="text-left"><?php echo $user["balance"]; ?></td>
						<td class="text-right">建筑面积</td>
						<td class="text-left"><?php echo $user["area"];?></td>
					</tr>
					<tr>
						<td class="text-right">温度上限</td>
						<td class="text-left"><?php echo $user["TEMP_UPPER"]; ?></td>
						<td class="text-right">温度下限</td>
						<td class="text-left"><?php echo $user["TEMP_LOWER"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">供暖起始时间</td>
						<td class="text-left"><?php echo $user["SUPPLY_HEAT_START"]; ?></td>
						<td class="text-right">供暖结束时间</td>
						<td class="text-left"><?php echo $user["SUPPLY_HEAT_END"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">阀状态</td>
						<td class="text-left"><?php echo $user["valve_state"]; ?></td>
						<td class="text-right">采集时间</td>
						<td class="text-left"><?php echo $user["sample_time"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">电池电压</td>
						<td class="text-left"><?php echo $user["voltage"]; ?></td>
						<td class="text-right">故障提示</td>
						<td class="text-left"><?php echo $user["fault_message"]; ?></td>
					</tr>
				</table>
			</div>

		</div>
	</form>
</body>
</html>



