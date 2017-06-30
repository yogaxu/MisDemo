<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>房间详情</title>
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
				<strong class="icon-reorder"> 房间详情</strong> <a href=""
					style="float: right; display: none;">添加字段</a>
			</div>
			<div class="padding">
				<table class="table text-center table-bordered">
					<tr>
						<th colspan="4">房间信息</th>
					</tr>
					<tr>
						<td class="text-right">房间编号</td>
						<td class="text-left"><?php echo $room["ROOM_NO"]; ?></td>
						<td class="text-right">房间名称</td>
						<td class="text-left"><?php echo $room["ROOM_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">楼栋编号</td>
						<td class="text-left"><?php echo $room["BUILDING_NO"]; ?></td>
						<td class="text-right">楼栋名称</td>
						<td class="text-left"><?php echo $room["BUILDING_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">小区编号</td>
						<td class="text-left"><?php echo $room["VILLAGE_NO"]; ?></td>
						<td class="text-right">小区名称</td>
						<td class="text-left"><?php echo $room["VILLAGE_NAME"];?></td>
					</tr>
					<tr>
						<td class="text-right">城市名称</td>
						<td class="text-left"><?php echo $room["CITY_NAME"]; ?></td>
						<td class="text-right">分摊系数</td>
						<td class="text-left"><?php echo $room["RATIO"];?></td>
					</tr>
					<tr>
						<td class="text-right">建筑面积</td>
						<td class="text-left"><?php echo $room["FLOOR_AREA"]; ?>m²</td>
						<td class="text-right">使用面积</td>
						<td class="text-left"><?php echo $room["USABLE_AREA"];?>m²</td>
					</tr>
					<tr>
						<td class="text-right">房间类型</td>
						<td class="text-left"><?php echo $room["ROOM_TYPE"]; ?></td>
						<td class="text-right">单元名称</td>
						<td class="text-left"><?php echo $room["UNIT_NAME"];?></td>
					</tr>
					<tr>
						<td class="text-right">住户姓名</td>
						<td class="text-left"><?php echo $room["USER_NAME"]; ?></td>
						<td class="text-right">身份证号码</td>
						<td class="text-left"><?php echo $room["ID_CARD"];?></td>
					</tr>
					<tr>
						<td class="text-right">手机号码</td>
						<td class="text-left"><?php echo $room["MOBILE"]; ?></td>
						<td class="text-right">电话号码</td>
						<td class="text-left"><?php echo $room["TELEPHONE"];?></td>
					</tr>
					<tr>
						<td class="text-right">剩余热量</td>
						<td class="text-left"><?php echo $room["BALANCE_HEAT"]; ?></td>
						<td class="text-right">累计热量</td>
						<td class="text-left"><?php echo $room["TOTAL_HEAT"];?></td>
					</tr>
					<tr>
						<td class="text-right">计量类型</td>
						<td class="text-left"><?php 
                        switch ($room['METERING_TYPE']){
                            case 1: echo '分摊法'; break;
                            default: echo '热表法';
                        }
						?></td>
						<td class="text-right">使用类型</td>
						<td class="text-left"><?php 
						switch ($room['USABLE_TYPE']){
						    case 1: echo '分户'; break;
						    case 2: echo '楼栋'; break;
						    default: echo '其他';
						}
						?></td>
					</tr>
					<tr>
						<td class="text-right">下载状态</td>
						<td class="text-left"><?php 
						switch ($room['DN_STATE']){
						    case 0: echo '未下载'; break;
						    default: echo '已下载';
						}
						?></td>
						<td class="text-right">备注信息</td>
						<td class="text-left"><?php echo $room["NOTES"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">欠费警告值</td>
						<td class="text-left"><?php echo $room["ARREARS_NUM"]; ?>kWh</td>
						<td class="text-right">无线失连期间冻开阀时间</td>
						<td class="text-left"><?php echo $room["ANTI_NUM"]; ?>分钟/小时</td>
					</tr>
					<tr>
						<td class="text-right">温度上限</td>
						<td class="text-left"><?php echo $room["TEMP_UPPER"]; ?></td>
						<td class="text-right">温度下限</td>
						<td class="text-left"><?php echo $room["TEMP_LOWER"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">防冻温度</td>
						<td class="text-left"><?php echo $room["TEMP_ANTI"]; ?></td>
						<td class="text-right">设定温度</td>
						<td class="text-left"><?php echo $room["TEMP_SET"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">分摊周期</td>
						<td class="text-left"><?php echo $room["FT_CYCLE"]; ?>分钟</td>
						<td class="text-right">采样周期</td>
						<td class="text-left"><?php echo $room["SAMPLE_CYCLE"]; ?>分钟</td>
					</tr>
					<tr>
						<td class="text-right">供暖起始时间</td>
						<td class="text-left"><?php echo $room["SUPPLY_HEAT_START"]; ?></td>
						<td class="text-right">供暖结束时间</td>
						<td class="text-left"><?php echo $room["SUPPLY_HEAT_END"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">累计时间</td>
						<td class="text-left"><?php echo $room["TOTAL_TIME"]; ?>分钟</td>
						<td class="text-right">累计充值热量</td>
						<td class="text-left"><?php echo $room["TOTAL_BALANCE"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">温控器显示内容</td>
						<td class="text-left"><?php echo $room["DISPLAY_CONTENT"]; ?></td>
					</tr>
				</table>
			</div>

		</div>
	</form>
</body>
</html>



