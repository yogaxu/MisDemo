<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>集中器详情</title>
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
				<strong class="icon-reorder"> 集中器详情</strong> <a href=""
					style="float: right; display: none;">添加字段</a>
			</div>
			<div class="padding">
				<table class="table text-center table-bordered">
					<tr>
						<th colspan="4">设备信息</th>
					</tr>
					<tr>
						<td class="text-right">集中器ID</td>
						<td class="text-left"><?php echo $cmr_state["CMR_ID"]; ?></td>
						<td class="text-right">使用状态</td>
						<td class="text-left"><?php 
						switch ($cmr_state['STATE']){
						    case 1: echo '使用中'; break;
						    case 2: echo '空闲中'; break;
						    case 3: echo '维修中'; break;
						    default: echo '报损';
						}
						?></td>

					</tr>
					<tr>
						<td class="text-right">硬件版本号</td>
						<td class="text-left"><?php echo $cmr_state["CMR_HW"]; ?></td>
						<td class="text-right">软件版本号</td>
						<td class="text-left"><?php echo $cmr_state["CMR_SW"]; ?></td>

					</tr>
					<tr>
						<td class="text-right">网络类型</td>
						<td class="text-left"><?php 
                        switch ($cmr_state['NETWORK_TYPE']){
                            case 0: echo '以太网'; break;
                            case 1: echo 'DTU-内置'; break;
                            case 2: echo 'DTU-外挂'; break;
                            case 3: echo 'RS485'; break;
                            default: echo '未知';
                        }
						?></td>
						<td class="text-right">连接类型</td>
						<td class="text-left"><?php 
						switch ($cmr_state['CONNECT_TYPE']){
						    case 0: echo 'TCPClient'; break;
						    case 1: echo 'TCPServer'; break;
						    case 2: echo 'UDPClient'; break;
						    default: echo 'UDPServer';
						}
						?></td>
					</tr>
					<tr>
						<td class="text-right">电话号码</td>
						<td class="text-left"><?php echo $cmr_state["PHONE"]; ?></td>
						<td class="text-right">SIM卡IMSI</td>
						<td class="text-left"><?php echo $cmr_state["SIM_IMSI"];?></td>
					</tr>
					<tr>
						<td class="text-right">小区编号</td>
						<td class="text-left"><?php echo $cmr_state["VILLAGE_NO"]; ?></td>
						<td class="text-right">楼栋编号</td>
						<td class="text-left"><?php echo $cmr_state["BUILDING_NO"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">录入时间</td>
						<td class="text-left"><?php echo $cmr_state['TIME_ENTRY']?></td>
						<td class="text-right">安装时间</td>
						<td class="text-left"><?php echo $cmr_state['TIME_INSTALL']?></td>
					</tr>
					<tr>
						<td class="text-right">抄表周期-存储</td>
						<td class="text-left"><?php echo $cmr_state["CYCLE_STORAGE"]; ?></td>
						<td class="text-right">抄表周期-刷新</td>
						<td class="text-left"><?php echo $cmr_state["CYCLE_REF"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">板卡类型</td>
						<td class="text-left"><?php echo $cmr_state["BOARD_TYPE"]; ?></td>
						<td class="text-right">仪表数量</td>
						<td class="text-left"><?php echo $cmr_state["METER_NUM"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">签到周期</td>
						<td class="text-left"><?php echo $cmr_state["LOGIN_CYCLE"]; ?></td>
						<td class="text-right">心跳周期</td>
						<td class="text-left"><?php echo $cmr_state["HEARTBEAT_CYCLE"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">串口配置-通道1</td>
						<td class="text-left"><?php echo $cmr_state["CONFIG_CH1"]; ?></td>
						<td class="text-right">串口配置-通道2</td>
						<td class="text-left"><?php echo $cmr_state["CONFIG_CH2"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">串口配置-通道3</td>
						<td class="text-left"><?php echo $cmr_state["CONFIG_CH3"]; ?></td>
						<td class="text-right">串口配置-通道4</td>
						<td class="text-left"><?php echo $cmr_state["CONFIG_CH4"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">串口配置-通道5</td>
						<td class="text-left"><?php echo $cmr_state["CONFIG_CH5"]; ?></td>
						<td class="text-right">串口配置-通道6</td>
						<td class="text-left"><?php echo $cmr_state["CONFIG_CH6"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">串口配置-通道7</td>
						<td class="text-left"><?php echo $cmr_state["CONFIG_CH7"]; ?></td>
						<td class="text-right">串口配置-通道8</td>
						<td class="text-left"><?php echo $cmr_state["CONFIG_CH8"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">串口配置-485</td>
						<td class="text-left"><?php echo $cmr_state["CONFIG_RS485"]; ?></td>
					</tr>
					<tr>
						<td class="text-right">备注</td>
						<td class="text-left"><?php echo $cmr_state["NOTES"]; ?></td>
					</tr>
				</table>
			</div>

		</div>
	</form>
</body>
</html>



