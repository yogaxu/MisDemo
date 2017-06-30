<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>室温表详情</title>
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
				<strong class="icon-reorder"> 室温表详情</strong> <a href=""
					style="float: right; display: none;">添加字段</a>
			</div>
			<div class="padding">
				<table class="table text-center table-bordered">
					<tr>
						<th colspan="4">室温表信息</th>
					</tr>
					<tr>
						<td class="text-right">室温表ID</td>
						<td class="text-left"><?php echo $on_off["CTRL_ID"]; ?></td>
						<td class="text-right">分摊器ID</td>
						<td class="text-left"><?php echo $on_off["FTQ_ID"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">楼栋名称</td>
						<td class="text-left"><?php echo $on_off["BUILDING_NAME"];?></td>
						<td class="text-right">门牌号</td>
						<td class="text-left"><?php echo $on_off["ROOM_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">面积</td>
						<td class="text-left"><?php echo $on_off["FLOOR_AREA"]; ?>m²</td>
						<td class="text-right">流水号</td>
						<td class="text-left"><?php echo $on_off["SERIAL_NO"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">开阀时间</td>
						<td class="text-left"><?php echo $on_off["ON_TIME"]; ?></td>
						<td class="text-right">关阀时间</td>
						<td class="text-left"><?php echo $on_off["OFF_TIME"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">室内温度</td>
						<td class="text-left"><?php echo $on_off["TRUE_TEMP"]; ?></td>
						<td class="text-right">设定温度</td>
						<td class="text-left"><?php echo $on_off["SET_TEMP"] ?></td>
					</tr>
					<tr>
						<td class="text-right">平均温度</td>
						<td class="text-left"><?php echo $on_off["AVG_TEMP"] ?></td>
						<td class="text-right">控制模式</td>
						<td class="text-left"><?php echo $on_off["CTRL_MODE"] ?></td>
					</tr>
					<tr>
						<td class="text-right">进水温度</td>
						<td class="text-left"><?php echo $on_off["TEMP_INTAKE"] ?></td>
						<td class="text-right">回水温度</td>
						<td class="text-left"><?php echo $on_off["TEMP_RETURN"] ?></td>
					</tr>
					<tr>
						<td class="text-right">操作计数器</td>
						<td class="text-left"><?php echo $on_off["OP_COUNT"] ?></td>
						<td class="text-right">电池电压</td>
						<td class="text-left"><?php echo $on_off["VOLTAGE"] ?></td>
					</tr>
					<tr>
						<td class="text-right">湿度</td>
						<td class="text-left"><?php echo $on_off["HUMIDITY"] ?></td>
						<td class="text-right">信号值</td>
						<td class="text-left"><?php echo $on_off["SIGNAL_VALUE"] ?></td>
					</tr>
					<tr>
						<td class="text-right">数据状态</td>
						<td class="text-left"><?php
						switch ($on_off["DT_STATE"]){
						    case "0": echo "正常"; break;
						    default: echo "补数据";
						}
						?></td>
						<td class="text-right">阀门状态</td>
						<td class="text-left"><?php
						switch ($on_off["DT_STATE"]){
						    case "0": echo "关阀"; break;
						    case "1": echo "开阀"; break;
						    case "2": echo "开阀故障"; break;
						    default: echo "关阀故障";
						}
						?></td>
					</tr>
					<tr>
						<td class="text-right">计量时间</td>
						<td class="text-left"><?php echo $on_off["TIME_MEASURE"] ?></td>
						<td class="text-right">采样时间</td>
						<td class="text-left"><?php echo $on_off["TIME_SAMPLE"] ?></td>
					</tr>
					<tr>
						<td class="text-right">上传时间</td>
						<td class="text-left"><?php echo $on_off["TIME_UPLOAD"] ?></td>
					</tr>
				</table>
			</div>

		</div>
	</form>
</body>
</html>



