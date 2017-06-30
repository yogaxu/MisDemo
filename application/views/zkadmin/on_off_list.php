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
			<strong class="icon-reorder"> 室温表列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<div class="padding border-bottom">
			<ul class="search">
				<li style="float: left;">
					<button class="button border-main icon-plus" onclick="add();">添加</button>
				</li>
    			<form action="<?php echo site_url("zkadmin/on_off/index");?>"
    				class="form-horizontal" method="get">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按室温表ID进行搜索" name="keywords" class="input"
					style="width: 250px; line-height: 17px; display: inline-block" />
					<button type="submit" class="button border-main icon-search">搜索</button>
				</li>
    			</form>
			</ul>
		</div>
		<script type="text/javascript">
	    //
	    var list = '<?php echo json_encode($list)?>';
		var meter_info = '<?php echo json_encode($meter_info)?>';
		</script>
		<table class="table table-hover text-center">
			<tr>
				<th>集中器ID</th>
				<th>楼栋名称</th>
				<th>门牌号</th>
				<th>面积</th>
				<th>室温表ID</th>
				<th>计量时间</th>
				<th>操作</th>
			</tr>
			<tbody>
                <?php for($i=0; $i<count($list); $i=$i+1){?>
                <tr>
    				<td><?php echo $list[$i]["CTRL_ID"]; ?></td>
    				<td><?php echo $list[$i]['BUILDING_NAME']?></td>
    				<td><?php echo $list[$i]['ROOM_NAME']?></td>
    				<td><?php echo $list[$i]['FLOOR_AREA'] ?></td>
    				<td><?php echo $list[$i]["FTQ_ID"]; ?></td>
    				<td><?php echo $list[$i]["TIME_MEASURE"]; ?></td>
    				<td>
    					<div class="button-group">
    						<a class="button border-green" href="<?php echo site_url("zkadmin/on_off/detail/".$list[$i]['CTRL_ID']);?>"><span class="icon-search-plus"></span> 详情</a>
    					    <button class="button border-main" onclick="update('<?php echo $i?>');"><span class="icon-edit"></span> 修改</button>
    						<button class="button border-red" onclick="del('<?php echo $list[$i]['CTRL_ID']?>','<?php echo $list[$i]['FTQ_ID']?>');"><span class="icon-times"></span> 删除</button>
    					</div>
    				</td>
    			</tr>
                <?php }?>
            </tbody>
			<tr>
				<td colspan="8">
					<div class="pagelist"> 
                        <?php if($page > 1){?>
                          <span style="margin-left: 25px">共有<?php echo $start; ?>记录，共<?php echo $page; ?>页</span>
        						<a
        							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/on_off/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
        							aria-label="Previous">上一页</a>
                          <?php echo $page_links; ?>
                          <a
        							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/on_off/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
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
        var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/on_off/update");?>' + '" method="post" class="form-small">'
            + '<input type="hidden" value="' + item_json.FTQ_ID + '" name="FTQ_ID">'
            + '<input type="hidden" value="' + item_json.CTRL_ID + '" name="CTRL_ID">'
            + '<div class="form-inline"><span class="addon">流水号</span><input value="' + item_json.SERIAL_NO + '" type="text" class="input" name="SERIAL_NO" size="20" /><span class="addon">室内温度</span><input value="' + item_json.TRUE_TEMP + '" type="text" class="input" name="TRUE_TEMP" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">设定温度</span><input value="' + item_json.SET_TEMP + '" type="text" class="input" name="SET_TEMP" size="20" /><span class="addon">平均温度</span><input value="' + item_json.AVG_TEMP + '" type="text" class="input" name="AVG_TEMP" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">开阀时间</span><input value="' + item_json.ON_TIME + '" type="text" class="input" name="ON_TIME" size="22" /><span class="addon">关阀时间</span><input value="' + item_json.OFF_TIME + '" type="text" class="input" name="OFF_TIME" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">控制模式</span><input value="' + item_json.CTRL_MODE + '" type="text" class="input" name="CTRL_MODE" size="20" /><span class="addon">操作计数器</span><input value="' + item_json.OP_COUNT + '" type="text" class="input" name="OP_COUNT" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">进水温度</span><input value="' + item_json.TEMP_INTAKE + '" type="text" class="input" name="TEMP_INTAKE" size="22" /><span class="addon">回水温度</span><input value="' + item_json.TEMP_RETURN + '" type="text" class="input" name="TEMP_RETURN" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">计量时间</span><input value="' + item_json.TIME_MEASURE + '" id="TIME_MEASURE_UP" type="text" class="input" name="TIME_MEASURE" size="22" /><span class="addon">采样时间</span><input value="' + item_json.TIME_SAMPLE + '" id="TIME_SAMPLE_UP" type="text" class="input" name="TIME_SAMPLE" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">电池电压</span><input value="' + item_json.VOLTAGE + '" type="text" class="input" name="VOLTAGE" size="22" /><span class="addon">上传时间</span><input value="' + item_json.TIME_UPLOAD + '" id="TIME_UPLOAD_UP" type="text" class="input" name="TIME_UPLOAD" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">湿度</span><input value="' + item_json.HUMIDITY + '" type="text" class="input" name="HUMIDITY" size="22" /><span class="addon">信号值</span><input value="' + item_json.SIGNAL_VALUE + '" type="text" class="input" name="SIGNAL_VALUE" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">数据状态</span><select class="input" name="DT_STATE">';
        switch(item_json.DT_STATE){
        case '0': 
            content += '<option value="0" selected="selected">正常</option><option value="1">补数据</option></select><span class="addon">阀门状态</span><select class="input" name="VALVE_STATE">';
            break;
        default:
            content += '<option value="0">正常</option><option value="1" selected="selected">补数据</option></select><span class="addon">阀门状态</span><select class="input" name="VALVE_STATE">';
        }
        switch(item_json.VALVE_STATE){
        case '0':
            content += '<option value="0" selected="selected">关阀</option><option value="1">开阀</option><option value="2">开阀故障</option><option value="3">关阀故障</option></select></div></form>';
            break;
        case '1':
            content += '<option value="0">关阀</option><option value="1" selected="selected">开阀</option><option value="2">开阀故障</option><option value="3">关阀故障</option></select></div></form>';
            break;
        case '2':
            content += '<option value="0">关阀</option><option value="1">开阀</option><option value="2" selected="selected">开阀故障</option><option value="3">关阀故障</option></select></div></form>';
            break;
        default:        
            content += '<option value="0">关阀</option><option value="1">开阀</option><option value="2">开阀故障</option><option value="3" selected="selected">关阀故障</option></select></div></form>';
        }
        layer.open({
            title: '修改室温表信息',
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
            	jeDate({
            		dateCell: "#TIME_MEASURE_UP",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isinitVal: true,
            		isTime: true
            	});
            	jeDate({
            		dateCell: "#TIME_SAMPLE_UP",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isinitVal: true,
            		isTime: true
            	});
            	jeDate({
            		dateCell: "#TIME_UPLOAD_UP",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isinitVal: true,
            		isTime: true
            	});
            }
        });
    }

    //删除
    function del(meter_id,cmr_id){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/on_off/del");?>' +'" method="post">'
            + '<input type="hidden" name="meter_id" value="' + meter_id + '"><input type="hidden" name="cmr_id" value="' + cmr_id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加
    function add(){
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/on_off/add");?>' + '" method="post" class="form-small">'
            + '<div class="form-inline"><span class="addon">室温表ID</span><select name="CTRL_ID" class="input">';
        $.each(JSON.parse(meter_info), function(k, v){
            content += '<option value="' + v.METER_ID + '">' + v.METER_ID + '</option>';
        });
        content += '</select></div>'
            + '<div class="form-inline"><span class="addon">流水号</span><input type="text" class="input" name="SERIAL_NO" size="20" /><span class="addon">室内温度</span><input type="text" class="input" name="TRUE_TEMP" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">设定温度</span><input type="text" class="input" name="SET_TEMP" size="20" /><span class="addon">平均温度</span><input type="text" class="input" name="AVG_TEMP" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">开阀时间</span><input type="text" class="input" name="ON_TIME" size="22" /><span class="addon">关阀时间</span><input type="text" class="input" name="OFF_TIME" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">控制模式</span><input type="text" class="input" name="CTRL_MODE" size="20" /><span class="addon">操作计数器</span><input type="text" class="input" name="OP_COUNT" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">进水温度</span><input type="text" class="input" name="TEMP_INTAKE" size="22" /><span class="addon">回水温度</span><input type="text" class="input" name="TEMP_RETURN" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">计量时间</span><input id="TIME_MEASURE" type="text" class="input" name="TIME_MEASURE" size="22" /><span class="addon">采样时间</span><input id="TIME_SAMPLE" type="text" class="input" name="TIME_SAMPLE" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">电池电压</span><input type="text" class="input" name="VOLTAGE" size="22" /><span class="addon">上传时间</span><input id="TIME_UPLOAD" type="text" class="input" name="TIME_UPLOAD" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">湿度</span><input type="text" class="input" name="HUMIDITY" size="22" /><span class="addon">信号值</span><input type="text" class="input" name="SIGNAL_VALUE" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">数据状态</span><select class="input" name="DT_STATE"><option value="0">正常</option><option value="1">补数据</option></select><span class="addon">阀门状态</span><select class="input" name="VALVE_STATE"><option value="0">关阀</option><option value="1">开阀</option><option value="2">开阀故障</option><option value="3">关阀故障</option></select></div></form>';
        layer.open({
            title: '添加室温表',
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
            	jeDate({
            		dateCell: "#TIME_MEASURE",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isinitVal: true,
            		isTime: true
            	});
            	jeDate({
            		dateCell: "#TIME_SAMPLE",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isinitVal: true,
            		isTime: true
            	});
            	jeDate({
            		dateCell: "#TIME_UPLOAD",
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