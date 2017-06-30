<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>电表详情</title>
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
				<strong class="icon-reorder"> 电表详情</strong> <a href=""
					style="float: right; display: none;">添加字段</a>
			</div>
			<div class="padding">
				<table class="table text-center table-bordered">
					<tr>
						<th colspan="4">电表信息</th>
					</tr>
					<tr>
						<td class="text-right">电表ID</td>
						<td class="text-left"><?php echo $elec_meter["ELEC_METER_ID"]; ?></td>
						<td class="text-right">集中器ID</td>
						<td class="text-left"><?php echo $elec_meter["CMR_ID"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">楼栋名称</td>
						<td class="text-left"><?php echo $elec_meter["BUILDING_NAME"];?></td>
						<td class="text-right">门牌号</td>
						<td class="text-left"><?php echo $elec_meter["ROOM_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">面积</td>
						<td class="text-left"><?php echo $elec_meter["FLOOR_AREA"]; ?>m²</td>
						<td class="text-right">批次号</td>
						<td class="text-left"><?php echo $elec_meter["BATCH_NO"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">序列号</td>
						<td class="text-left"><?php echo $elec_meter["SERIAL_NO"]; ?></td>
						<td class="text-right">通道号</td>
						<td class="text-left"><?php echo $elec_meter["CH"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">电表类型</td>
						<td class="text-left"><?php echo $elec_meter["MODEL"]; ?></td>
						<td class="text-right">控制状态</td>
						<td class="text-left"><?php
						switch($elec_meter['ELEC_STATE']){
						    case '0': echo '关闸'; break;
						    default: echo '合闸';
						}
						?></td>
					</tr>
					<tr>
						<td class="text-right">单项表电压</td>
						<td class="text-left"><?php echo $elec_meter["VOLTAGE"]; ?>℃</td>
						<td class="text-right">单项表电流</td>
						<td class="text-left"><?php echo $elec_meter["CURRENT"]; ?>℃</td>
					</tr>
					<tr>
						<td class="text-right">A相电压</td>
						<td class="text-left"><?php echo $elec_meter["A_VOLTAGE"]; ?></td>
						<td class="text-right">A相电流</td>
						<td class="text-left"><?php echo $elec_meter["A_CURRENT"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">B相电压</td>
						<td class="text-left"><?php echo $elec_meter["B_VOLTAGE"]; ?></td>
						<td class="text-right">B相电流</td>
						<td class="text-left"><?php echo $elec_meter["B_CURRENT"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">C相电压</td>
						<td class="text-left"><?php echo $elec_meter["C_VOLTAGE"]; ?></td>
						<td class="text-right">C相电流</td>
						<td class="text-left"><?php echo $elec_meter["C_CURRENT"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">正向有功总电能</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_ENERGY"]; ?></td>
						<td class="text-right">正向无功总电能</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_ENERGY"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">正向有功费率1电能示值(尖)</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_ENERGY1"]; ?></td>
						<td class="text-right">正向无功费率1电能示值量1</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_ENERGY1"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">正向有功费率2电能示值(峰)</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_ENERGY2"]; ?></td>
						<td class="text-right">正向无功费率2电能示值量2</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_ENERGY2"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">正向有功费率3电能示值(平)</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_ENERGY3"]; ?></td>
						<td class="text-right">正向无功费率3电能示值量3</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_ENERGY3"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">正向有功费率4电能示值(谷)</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_ENERGY4"]; ?></td>
						<td class="text-right">正向无功费率4电能示值量4</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_ENERGY4"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">总有功功率</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_POWER"]; ?></td>
						<td class="text-right">总无功功率</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_POWER"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">A相有功功率</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_POWER_A"]; ?></td>
						<td class="text-right">A相无功功率</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_POWER_A"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">B相有功功率</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_POWER_B"]; ?></td>
						<td class="text-right">B相无功功率</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_POWER_B"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">C相有功功率</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_POWER_C"]; ?></td>
						<td class="text-right">C相无功功率</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_POWER_C"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">总功率因数</td>
						<td class="text-left"><?php echo $elec_meter["POWER_FACTOR"]; ?></td>
						<td class="text-right">一象限无功电能示值</td>
						<td class="text-left"><?php echo $elec_meter["QUADRANT_REACTIVE_POWER1"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">A相功率因数</td>
						<td class="text-left"><?php echo $elec_meter["POWER_FACTOR_A"]; ?></td>
						<td class="text-right">二象限无功电能示值</td>
						<td class="text-left"><?php echo $elec_meter["QUADRANT_REACTIVE_POWER2"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">B相功率因数</td>
						<td class="text-left"><?php echo $elec_meter["POWER_FACTOR_B"]; ?></td>
						<td class="text-right">三象限无功电能示值</td>
						<td class="text-left"><?php echo $elec_meter["QUADRANT_REACTIVE_POWER3"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">C相功率因数</td>
						<td class="text-left"><?php echo $elec_meter["POWER_FACTOR_C"]; ?></td>
						<td class="text-right">四象限无功电能示值</td>
						<td class="text-left"><?php echo $elec_meter["QUADRANT_REACTIVE_POWER4"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">反向有功总电能</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_ENERGY_REVERSE"]; ?></td>
						<td class="text-right">反向无功总电能</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_ENERGY_REVERSE"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">反向有功费率1电能示值</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_ENERGY_REVERSE1"]; ?></td>
						<td class="text-right">反向无功费率1电能示值</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_ENERGY_REVERSE1"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">反向有功费率2电能示值</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_ENERGY_REVERSE2"]; ?></td>
						<td class="text-right">反向无功费率2电能示值</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_ENERGY_REVERSE2"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">反向有功费率3电能示值</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_ENERGY_REVERSE3"]; ?></td>
						<td class="text-right">反向无功费率3电能示值</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_ENERGY_REVERSE3"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">反向有功费率4电能示值</td>
						<td class="text-left"><?php echo $elec_meter["ACTIVE_ENERGY_REVERSE4"]; ?></td>
						<td class="text-right">反向无功费率4电能示值</td>
						<td class="text-left"><?php echo $elec_meter["REACTIVE_ENERGY_REVERSE4"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">频率</td>
						<td class="text-left"><?php echo $elec_meter["FRE"]; ?></td>
						<td class="text-right">CT变化</td>
						<td class="text-left"><?php echo $elec_meter["CT"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">上传时间</td>
						<td class="text-left"><?php echo $elec_meter["TIME_UPLOAD"]; ?></td>
						<td class="text-right">采样时间</td>
						<td class="text-left"><?php echo $elec_meter["TIME_SAMPLE"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">实时时间</td>
						<td class="text-left"><?php echo $elec_meter["REALTIME"]; ?></td>
						<td class="text-right">备注</td>
						<td class="text-left"><?php echo $elec_meter["NOTES"]; ?></td>
					</tr>
				</table>
			</div>

		</div>
	</form>
</body>
</html>



