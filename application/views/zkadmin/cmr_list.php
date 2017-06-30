<!-- @author 你哥 -->
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet"
	href="<?php echo base_url("zeros/css/pintuer.css");?>">
<link rel="stylesheet"
	href="<?php echo base_url("zeros/css/admin.css");?>">
<link rel="stylesheet" href="<?php echo base_url("zeros/css/style.css");?>">
<script src="<?php echo base_url("zeros/js/jquery.js");?>"></script>
<script src="<?php echo base_url("zeros/js/pintuer.js");?>"></script>
<script src="<?php echo base_url("zeros/js/layer/layer.js");?>"></script>
<script src="<?php echo base_url("zeros/jeDate/jedate.js");?>"></script>
</head>
<body>
	<div class="panel admin-panel">
		<div class="panel-head">
			<strong class="icon-reorder"> 采集器列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<div class="padding border-bottom">
			<ul class="search">
				<li style="float: left;">
					<button class="button border-main icon-plus" onclick="add();">添加</button>
				</li>
    			<form action="<?php echo site_url("zkadmin/cmr_state_info/index");?>"
    				class="form-horizontal" method="get">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按小区名进行搜索" name="keywords" class="input"
					style="width: 250px; line-height: 17px; display: inline-block" />
					<button type="submit" class="button border-main icon-search">搜索</button>
				</li>
    			</form>
			</ul>
		</div>
		<script type="text/javascript">
	    //
		var list = '<?php echo json_encode($list)?>';
		var village_info = '<?php echo json_encode($village_info)?>';
	    var building_info = '<?php echo json_encode($building_info)?>';
		</script>
		<table class="table table-hover text-center">
			<tr>
				<th>采集器ID</th>
				<th>小区</th>
				<th>楼栋</th>
				<th>使用状态</th>
				<th>录入时间</th>
				<th>安装时间</th>
				<th>操作</th>
			</tr>
			<tbody>
                <?php for($i=0; $i<count($list); $i=$i+1){ ?>
                <tr>
    				<td><?php echo $list[$i]["CMR_ID"]; ?></td>
    				<td><?php 
    				foreach ($village_info as $vill){
    				    if($vill['VILLAGE_NO'] == $list[$i]['VILLAGE_NO']){
            				echo $vill['VILLAGE_NAME'];
    				    }
    				}?></td>
    				<td><?php 
    				foreach ($building_info as $build){
    				    if($build['BUILDING_NO'] == $list[$i]['BUILDING_NO']){
            				echo $build['BUILDING_NAME'];
    				    }
    				}?></td>
    				<td><?php echo $list[$i]["STATE"]; ?></td>
    				<td><?php echo $list[$i]["TIME_ENTRY"]; ?></td>
    				<td><?php echo $list[$i]["TIME_INSTALL"]; ?></td>
    				<td>
    					<div class="button-group">
    						<a class="button border-green" href="<?php echo site_url("zkadmin/cmr_info/detail/".$list[$i]['CMR_ID']);?>"><span class="icon-search-plus"></span> 详情</a>
    						<button class="button border-main" onclick="update('<?php echo $i?>');"><span class="icon-edit"></span> 修改</button>
    						<button class="button border-red" onclick="del('<?php echo $list[$i]['CMR_ID']?>');"><span class="icon-times"></span> 删除</button>
    					</div>
    				</td>
    			</tr>
                <?php } ?>
            </tbody>
			<tr>
				<td colspan="8">
					<div class="pagelist"> 
                        <?php if($page > 1){?>
                          <span style="margin-left: 25px">共有<?php echo $start; ?>记录，共<?php echo $page; ?>页</span>
        						<a
        							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/cmr_info/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
        							aria-label="Previous">上一页</a>
                          <?php echo $page_links; ?>
                          <a
        							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/cmr_info/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
        							aria-label="Next">下一页</a>
                        <?php } ?>
                    </div>
				</td>
			</tr>
		</table>
	</div>
	<script type="text/javascript">
	//修改
    function update(index){
        var item_json = JSON.parse(list)[index];
    	var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/cmr_info/update");?>' + '" method="post" class="form-small">'
 	        + '<input type="hidden" value="' + item_json.CMR_ID + '" name="CMR_ID"/>'
            + '<div class="form-inline"><span class="addon">硬件版本号</span><input value="' + item_json.CMR_HW + '" type="text" class="input" name="CMR_HW" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">软件版本号</span><input value="' + item_json.CMR_SW + '" type="text" class="input" name="CMR_SW" size="20" /><span class="addon">网络类型</span><select class="input" name="NETWORK_TYPE">';
        switch(item_json.NETWORK_TYPE){
        case '0': 
            content += '<option value="0" selected="selected">以太网</option><option value="1">DTU内置</option><option value="2">DTU外挂</option><option value="3">RS485</option><option value="9">未知</option></select>';
            break;
        case '1': 
            content += '<option value="0">以太网</option><option value="1" selected="selected">DTU内置</option><option value="2">DTU外挂</option><option value="3">RS485</option><option value="9">未知</option></select>';
            break;
        case '2': 
            content += '<option value="0">以太网</option><option value="1">DTU内置</option><option value="2" selected="selected">DTU外挂</option><option value="3">RS485</option><option value="9">未知</option></select>';
            break;
        case '3': 
            content += '<option value="0">以太网</option><option value="1">DTU内置</option><option value="2">DTU外挂</option><option value="3" selected="selected">RS485</option><option value="9">未知</option></select>';
            break;
        default:
            content += '<option value="0">以太网</option><option value="1">DTU内置</option><option value="2">DTU外挂</option><option value="3">RS485</option><option value="9" selected="selected">未知</option></select>';
        }
        content += '<span class="addon">连接类型</span><select class="input" name="CONNECT_TYPE">';
        switch(item_json.CONNECT_TYPE){
        case '0':
            content += '<option value="0" selected="selected">TCPClient</option><option value="1">TCPServer</option><option value="2">UDPClient</option><option value="3">UDPServer</option></select>';
            break;
        case '1':
            content += '<option value="0">TCPClient</option><option value="1" selected="selected">TCPServer</option><option value="2">UDPClient</option><option value="3">UDPServer</option></select>';
            break;
        case '2':
            content += '<option value="0">TCPClient</option><option value="1">TCPServer</option><option value="2" selected="selected">UDPClient</option><option value="3">UDPServer</option></select>';
            break;
        default: 
            content += '<option value="0">TCPClient</option><option value="1">TCPServer</option><option value="2">UDPClient</option><option value="3" selected="selected">UDPServer</option></select>';
        }
        content += '</div><div class="form-inline"><span class="addon">IP地址</span><input value="' + item_json.IP + '" type="text" class="input" name="IP" size="20" />'
            + '<span class="addon">端口号</span><input value="' + item_json.PORT + '" type="text" class="input" name="PORT" size="20" /><span class="addon">使用状态</span><select class="input" name="STATE">';
        switch(item_json.STATE){
        case '使用中':
            content += '<option value="1" selected="selected">使用中</option><option value="2">空闲中</option><option value="3">维修中</option><option value="4">报损</option></select></div>';
            break;
        case '空闲中':
            content += '<option value="1">使用中</option><option value="2" selected="selected">空闲中</option><option value="3">维修中</option><option value="4">报损</option></select></div>';
            break;
        case '维修中':
            content += '<option value="1">使用中</option><option value="2">空闲中</option><option value="3" selected="selected">维修中</option><option value="4">报损</option></select></div>';
            break;
        default:
            content += '<option value="1">使用中</option><option value="2">空闲中</option><option value="3">维修中</option><option value="4" selected="selected">报损</option></select></div>';
        }
        content += '<div class="form-inline"><span class="addon">SIM卡IMSI</span><input value="' + item_json.SIM_IMSI + '" type="text" class="input" name="SIM_IMSI" size="20" /><span class="addon">电话号码</span><input value="' + item_json.PHONE + '" type="text" class="input" name="PHONE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">串口配置-通道1</span><input value="' + item_json.CONFIG_CH1 + '" type="text" class="input" name="CONFIG_CH1" size="20" /><span class="addon">串口配置-通道2</span><input value="' + item_json.CONFIG_CH2 + '" type="text" class="input" name="CONFIG_CH2" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">串口配置-通道3</span><input value="' + item_json.CONFIG_CH3 + '" type="text" class="input" name="CONFIG_CH3" size="20" /><span class="addon">串口配置-通道4</span><input value="' + item_json.CONFIG_CH4 + '" type="text" class="input" name="CONFIG_CH4" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">串口配置-通道5</span><input value="' + item_json.CONFIG_CH5 + '" type="text" class="input" name="CONFIG_CH5" size="20" /><span class="addon">串口配置-通道6</span><input value="' + item_json.CONFIG_CH6 + '" type="text" class="input" name="CONFIG_CH6" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">串口配置-通道7</span><input value="' + item_json.CONFIG_CH7 + '" type="text" class="input" name="CONFIG_CH7" size="20" /><span class="addon">串口配置-通道8</span><input value="' + item_json.CONFIG_CH8 + '" type="text" class="input" name="CONFIG_CH8" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">串口配置-485</span><input value="' + item_json.CONFIG_RS485 + '" type="text" class="input" name="CONFIG_RS485" size="20" /><span class="addon">备注</span><input value="' + item_json.NOTES + '" type="text" class="input" name="NOTES" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">小区</span><select class="input" name="VILLAGE_NO" id="VILLAGE_NO_SELECT_UP">'
        $.each(JSON.parse(village_info), function(k, v){
            if(v.VILLAGE_NO == item_json.VILLAGE_NO){
                content += '<option value="' + v.VILLAGE_NO + '" selected="selected">' + v.VILLAGE_NAME +'</option>';
            }else{
                content += '<option value="' + v.VILLAGE_NO + '">' + v.VILLAGE_NAME +'</option>';
            }
        });
        content += '</select><span class="addon">楼栋</span><select class="input" name="BUILDING_NO" id="BUILDING_NO_SELECT_UP"></select></div>'
            + '<div class="form-inline"><span class="addon">录入时间</span><input value="' + item_json.TIME_ENTRY + '" id="TIME_ENTRY_UP" type="text" class="input" name="TIME_ENTRY" size="20" /><span class="addon">安装时间</span><input value="' + item_json.TIME_INSTALL + '" id="TIME_INSTALL_UP" type="text" class="input" name="TIME_INSTALL" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">抄表周期-存储</span><input value="' + item_json.CYCLE_STORAGE + '" type="text" class="input" name="CYCLE_STORAGE" size="20" /><span class="addon">抄表周期-刷新</span><input value="' + item_json.CYCLE_REF + '" type="text" class="input" name="CYCLE_REF" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">仪表数量</span><input value="' + item_json.METER_NUM + '" type="text" class="input" name="METER_NUM" size="20" /><span class="addon">板卡类型</span><input value="' + item_json.BOARD_TYPE + '" type="text" class="input" name="BOARD_TYPE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">签到周期</span><input value="' + item_json.LOGIN_CYCLE + '" type="text" class="input" name="LOGIN_CYCLE" size="20" /><span class="addon">心跳周期</span><input value="' + item_json.HEARTBEAT_CYCLE + '" type="text" class="input" name="HEARTBEAT_CYCLE" size="20" /></div></form>';
        layer.open({
            title: '修改采集器信息',
            content: content,
            area: 'auto',
            maxWidth: 600,
            zIndex: 100,
            btn: ['确定', '取消'],
            yes: function(index, layero){
                $('#update_form').submit();
                layer.msg('修改成功');
            },
            btn2: function(index, layero){
                return false;
            },
            success: function(index, layero){
            	function get_buildings(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/cmr_info/get_buildings");?>',
                        type:'POST',
                        data:{  
                            village_no: $('#VILLAGE_NO_SELECT_UP').val()  
                        },  
                        dataType:'json',  
                        success:function(data){
                            var options = '';
                            $.each(data, function(k, v){
                                if(v.BUILDING_NO == item_json.BUILDING_NO){
                                    options += '<option value="' + v.BUILDING_NO + '" selected="selected">' + v.BUILDING_NAME +'</option>'; 
                                }else{
                                    options += '<option value="' + v.BUILDING_NO + '">' + v.BUILDING_NAME +'</option>'; 
                                }
                            });
                            $('#BUILDING_NO_SELECT_UP').html(options);
                        }
                    });
                }
                get_buildings();
                $('#VILLAGE_NO_SELECT_UP').change(function(){
                    get_buildings();
                });
            	jeDate({
            		dateCell: "#TIME_INSTALL_UP",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isTime: true
            	});
            	jeDate({
            		dateCell: "#TIME_ENTRY_UP",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isTime: true
            	});
            }
        });
    }

    //删除
    function del(id){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/cmr_info/del");?>' +'" method="post">'
            + '<input type="hidden" name="CMR_ID" value="' + id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加
    function add(){
    	var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/cmr_info/add");?>' + '" method="post" class="form-small">'
            + '<div class="form-inline"><span class="addon">采集器ID</span><input type="text" class="input" name="CMR_ID" size="20" /><span class="addon">硬件版本号</span><input type="text" class="input" name="CMR_HW" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">软件版本号</span><input type="text" class="input" name="CMR_SW" size="20" /><span class="addon">网络类型</span><select class="input" name="NETWORK_TYPE"><option value="0">以太网</option><option value="1">DTU内置</option><option value="2">DTU外挂</option><option value="3">RS485</option><option value="9">未知</option></select>'
            + '<span class="addon">连接类型</span><select class="input" name="CONNECT_TYPE"><option value="0">TCPClient</option><option value="1">TCPServer</option><option value="2">UDPClient</option><option value="3">UDPServer</option></select></div><div class="form-inline"><span class="addon">IP地址</span><input type="text" class="input" name="IP" size="20" />'
            + '<span class="addon">端口号</span><input type="text" class="input" name="PORT" size="20" /><span class="addon">使用状态</span><select class="input" name="STATE"><option value="1">使用中</option><option value="2">空闲中</option><option value="3">维修中</option><option value="4">报损</option></select></div>'
            + '<div class="form-inline"><span class="addon">SIM卡IMSI</span><input type="text" class="input" name="SIM_IMSI" size="20" /><span class="addon">电话号码</span><input type="text" class="input" name="PHONE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">串口配置-通道1</span><input type="text" class="input" name="CONFIG_CH1" size="20" /><span class="addon">串口配置-通道2</span><input type="text" class="input" name="CONFIG_CH2" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">串口配置-通道3</span><input type="text" class="input" name="CONFIG_CH3" size="20" /><span class="addon">串口配置-通道4</span><input type="text" class="input" name="CONFIG_CH4" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">串口配置-通道5</span><input type="text" class="input" name="CONFIG_CH5" size="20" /><span class="addon">串口配置-通道6</span><input type="text" class="input" name="CONFIG_CH6" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">串口配置-通道7</span><input type="text" class="input" name="CONFIG_CH7" size="20" /><span class="addon">串口配置-通道8</span><input type="text" class="input" name="CONFIG_CH8" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">串口配置-485</span><input type="text" class="input" name="CONFIG_RS485" size="20" /><span class="addon">备注</span><input type="text" class="input" name="NOTES" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">小区</span><select class="input" name="VILLAGE_NO" id="VILLAGE_NO_SELECT">'
        $.each(JSON.parse(village_info), function(k, v){
            content += '<option value="' + v.VILLAGE_NO + '">' + v.VILLAGE_NAME +'</option>';
        });
        content += '</select><span class="addon">楼栋</span><select class="input" name="BUILDING_NO" id="BUILDING_NO_SELECT"></select></div>'
            + '<div class="form-inline"><span class="addon">录入时间</span><input id="TIME_ENTRY" type="text" class="input" name="TIME_ENTRY" size="20" /><span class="addon">安装时间</span><input id="TIME_INSTALL" type="text" class="input" name="TIME_INSTALL" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">抄表周期-存储</span><input type="text" class="input" name="CYCLE_STORAGE" size="20" /><span class="addon">抄表周期-刷新</span><input type="text" class="input" name="CYCLE_REF" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">仪表数量</span><input type="text" class="input" name="METER_NUM" size="20" /><span class="addon">板卡类型</span><input type="text" class="input" name="BOARD_TYPE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">签到周期</span><input type="text" class="input" name="LOGIN_CYCLE" size="20" /><span class="addon">心跳周期</span><input type="text" class="input" name="HEARTBEAT_CYCLE" size="20" /></div></form>';
        layer.open({
            title: '添加采集器',
            content: content,
            area: 'auto',
            maxWidth: 600,
            zIndex: 100,
            btn: ['确定', '取消'],
            yes: function(index, layero){
                $('#add_form').submit();
                layer.msg('添加成功');
            },
            btn2: function(index, layero){
                return false;
            },
            success: function(index, layero){
            	function get_buildings(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/cmr_info/get_buildings");?>',
                        type:'POST',
                        data:{  
                            village_no: $('#VILLAGE_NO_SELECT').val()  
                        },  
                        dataType:'json',  
                        success:function(data){
                            var options = '';
                            $.each(data, function(k, v){
                                options += '<option value="' + v.BUILDING_NO + '">' + v.BUILDING_NAME +'</option>'; 
                            });
                            $('#BUILDING_NO_SELECT').html(options);
                        }
                    });
                }
                get_buildings();
                $('#VILLAGE_NO_SELECT').change(function(){
                    get_buildings();
                });
            	jeDate({
            		dateCell: "#TIME_INSTALL",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isinitVal: true,
            		isTime: true
            	});
            	jeDate({
            		dateCell: "#TIME_ENTRY",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isinitVal: true,
            		isTime: true
            	});
            }
        });
    }
	</script>
</body>
</html>