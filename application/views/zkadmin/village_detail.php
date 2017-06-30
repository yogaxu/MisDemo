<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>小区详情</title>
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
				<strong class="icon-reorder"> 小区详情</strong> <a href=""
					style="float: right; display: none;">添加字段</a>
			</div>
			<div class="padding">
				<table class="table text-center table-bordered">
					<tr>
						<th colspan="4">小区信息</th>
					</tr>
					<tr>
						<td class="text-right">小区编号</td>
						<td class="text-left"><?php echo $village["VILLAGE_NO"]; ?></td>
						<td class="text-right">小区名称</td>
						<td class="text-left"><?php echo $village["VILLAGE_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">小区面积</td>
						<td class="text-left"><?php echo $village["VILLAGE_AREA"]; ?> m²</td>
						<td class="text-right">小区地址</td>
						<td class="text-left"><?php echo $village["VILLAGE_ADDRESS"];?></td>
					</tr>
					<tr>
						<td class="text-right">楼栋总数</td>
						<td class="text-left"><?php echo $village["TOTAL_BUILDING"]; ?></td>
						<td class="text-right">住宅套数</td>
						<td class="text-left"><?php echo $village["TOTAL_HOUSE"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">城市名称</td>
						<td class="text-left"><?php echo $village['CITY_NAME']?></td>
						<td class="text-right">供热负责单位</td>
						<td class="text-left"><?php echo $village['THERMAL_COMPANY']?></td>
					</tr>
					<tr>
						<td class="text-right">物业负责单位</td>
						<td class="text-left"><?php echo $village["PROPERTY_COMPANY"]; ?></td>
						<td class="text-right">物业联系人</td>
						<td class="text-left"><?php echo $village["PROPERTY_COMPANY_CONTACT"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">物业联系电话</td>
						<td class="text-left"><?php echo $village["PROPERTY_COMPANY_TEL"]; ?></td>
						<td class="text-right">备注</td>
						<td class="text-left"><?php echo $village["NOTES"]; ?></td>
					</tr>
				</table>
			</div>

		</div>
	</form>
</body>
</html>



