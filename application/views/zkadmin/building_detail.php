<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>楼栋详情</title>
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
				<strong class="icon-reorder"> 楼栋详情</strong> <a href=""
					style="float: right; display: none;">添加字段</a>
			</div>
			<div class="padding">
				<table class="table text-center table-bordered">
					<tr>
						<th colspan="4">楼栋信息</th>
					</tr>
					<tr>
						<td class="text-right">楼栋编号</td>
						<td class="text-left"><?php echo $building["BUILDING_NO"]; ?></td>
						<td class="text-right">楼栋名称</td>
						<td class="text-left"><?php echo $building["BUILDING_NAME"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">小区编号</td>
						<td class="text-left"><?php echo $building["VILLAGE_NO"]; ?></td>
						<td class="text-right">小区名称</td>
						<td class="text-left"><?php echo $building["VILLAGE_NAME"];?></td>
					</tr>
					<tr>
						<td class="text-right">建筑类型</td>
						<td class="text-left"><?php 
                        switch ($building['BUILDING_TYPE']){
                            case 1: echo '塔楼'; break;
                            case 2: echo '板楼'; break;
                            default: echo '其他';
                        }
						?></td>
						<td class="text-right">结构类型</td>
						<td class="text-left"><?php 
						switch ($building['STRUCT_TYPE']){
						    case 1: echo '砖混'; break;
						    case 2: echo '现浇剪力墙'; break;
						    case 3: echo '框架结构'; break;
						    default: echo '其他';
						}
						?></td>
					</tr>
					<tr>
						<td class="text-right">使用类型</td>
						<td class="text-left"><?php 
						switch ($building['USE_TYPE']){
						    case 1: echo '普通住宅'; break;
						    case 2: echo '公寓'; break;
						    case 3: echo '别墅'; break;
						    case 4: echo '商用'; break;
						    default: echo '其他';
						}
						?></td>
						<td class="text-right">计量方法</td>
						<td class="text-left"><?php 
						switch ($building['METHODS']){
						    case 0:echo '通断法'; break;
						    case 1:echo '流温法'; break;
						    case 2:echo '温度面积法'; break;
						    case 3:echo '热表法'; break;
						    case 4:echo '温度采集系统'; break;
						    case 5:echo '远程抄表系统'; break;
						    default: echo '预付费IC卡锁闭阀'; 
						}
						?></td>
					</tr>
					<tr>
						<td class="text-right">总高度</td>
						<td class="text-left"><?php echo $building["HEIGHT"]; ?></td>
						<td class="text-right">总层数</td>
						<td class="text-left"><?php echo $building["TOTAL_FLOORS"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">住宅数</td>
						<td class="text-left"><?php echo $building["TOTAL_HOUSE"]; ?></td>
						<td class="text-right">单元数</td>
						<td class="text-left"><?php echo $building["TOTAL_UNITS"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">每层每单元房间数</td>
						<td class="text-left"><?php echo $building["TOTAL_FU_HOUSE"]; ?></td>
						<td class="text-right">配置ID</td>
						<td class="text-left"><?php echo $building["CONFIG_ID"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">备注</td>
						<td class="text-left"><?php echo $building["NOTES"]; ?></td>
					</tr>
				</table>
			</div>

		</div>
	</form>
</body>
</html>



