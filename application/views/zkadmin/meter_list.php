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
			<strong class="icon-reorder"> 终端设备列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<div class="padding border-bottom">
			<ul class="search">
				<li style="float: left;">
					<button class="button border-main icon-plus" onclick="add();">添加</button>
				</li>
    			<form action="<?php echo site_url("zkadmin/meter_info/index");?>"
    				class="form-horizontal" method="get">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按仪表ID进行搜索" name="keywords" class="input"
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
	    var room_info = '<?php echo json_encode($room_info)?>';
		</script>
		<table class="table table-hover text-center">
			<tr>
				<th>仪表ID</th>
				<th>小区</th>
				<th>楼栋</th>
				<th>单元</th>
				<th>门牌</th>
				<th>用户姓名</th>
				<th>操作</th>
			</tr>
			<tbody>
                <?php for($i=0; $i<count($list); $i=$i+1){ ?>
                <tr>
    				<td><?php echo $list[$i]["METER_ID"]; ?></td>
    				<td><?php echo $list[$i]['VILLAGE_NAME'];?></td>
    				<td><?php echo $list[$i]['BUILDING_NAME'];?></td>
    				<td><?php echo $list[$i]["UNIT_NAME"]; ?></td>
    				<td><?php echo $list[$i]["ROOM_NAME"]; ?></td>
    				<td><?php echo $list[$i]["USER_NAME"]; ?></td>
    				<td>
    					<div class="button-group">
    						<a class="button border-green" href="<?php echo site_url("zkadmin/meter_info/detail/".$list[$i]['METER_ID']);?>"><span class="icon-search-plus"></span> 详情</a>
    						<button class="button border-main" onclick="update('<?php echo $i?>');"><span class="icon-edit"></span> 修改</button>
    						<button class="button border-red" onclick="del('<?php echo $list[$i]['METER_ID']?>');"><span class="icon-times"></span> 删除</button>
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
        							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/meter_info/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
        							aria-label="Previous">上一页</a>
                          <?php echo $page_links; ?>
                          <a
        							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/meter_info/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
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
        var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/meter_info/update");?>' + '" method="post" class="form-small">'
            +'<input type="hidden" name="meter_id" value="' + item_json.METER_ID + '">'
            +'<div class="line-small"><div class="x4 label"><label>小区</label></div><div class="x8 field"><select id="village_select_up" class="input" name="village_no">';
        $.each(JSON.parse(village_info), function(k, v){
            if(v.VILLAGE_NO == item_json.VILLAGE_NO){
                content += '<option value="' + v.VILLAGE_NO + '" selected="selected">' + v.VILLAGE_NAME +'</option>';
            }else{
                content += '<option value="' + v.VILLAGE_NO + '">' + v.VILLAGE_NAME +'</option>';
            }
        });
        content += '</select></div></div><br>'
        	+'<div class="line-small"><div class="x4 label"><label>楼栋</label></div><div class="x8 field"><select id="building_select_up" class="input" name="building_no"></select></div></div><br>'
        	+'<div class="line-small"><div class="x4 label"><label>门牌号</label></div><div class="x8 field"><select id="room_select_up" class="input" name="room_no"></select></div></div><br>'
        	+'<div class="line-small"><div class="x4 label"><label>使用类型</label></div><div class="x8 field"><select class="input" name="usable_type">';
    	if(item_json.USABLE_TYPE == 1){
            content += '<option value="1" selected="selected">分户</option><option value="2">楼栋</option>';
    	}else{
            content += '<option value="1">分户</option><option value="2" selected="selected">楼栋</option>';
    	}
        content += '</select></div></div><br>'
        	+'<div class="line-small"><div class="x4 label"><label>使用卡</label></div><div class="x8 field"><select class="input" name="use_card">';
    	if(item_json.USE_CARD == 0){
            content += '<option value="0" selected="selected">不使用</option><option value="1">使用</option>';
    	}else{
            content += '<option value="0">不使用</option><option value="1" selected="selected">使用</option>';
    	}
        content += '</select></div></div><br>'
        	+'<div class="line-small"><div class="x4 label"><label>分摊类型</label></div><div class="x8 field"><select class="input" name="sharing_type">';
    	if(item_json.SHARING_TYPE == '加值'){
            content += '<option value="加值" selected="selected">加值</option><option value="减值">减值</option><option value="忽略">忽略</option>';
    	}else if(item_json.SHARING_TYPE == '减值'){
            content += '<option value="加值">加值</option><option value="减值" selected="selected">减值</option><option value="忽略">忽略</option>';
    	}else{
            content += '<option value="加值">加值</option><option value="减值">减值</option><option value="忽略" selected="selected">忽略</option>';
    	}
        content += '</select></div></div><br><div class="line-small"><div class="x4 label"><label>使用状态</label></div><div class="x8 field">';
        if(item_json.STATE == '0'){
            content += '<select class="input" name="STATE"><option value="0" selected="selected">使用中</option><option value="1">未使用</option><option value="2">已注销</option></select></div></div></form>';
        }else if(item_json.STATE == '1'){
            content += '<select class="input" name="STATE"><option value="0">使用中</option><option value="1" selected="selected">未使用</option><option value="2">已注销</option></select></div></div></form>';
        }else{
            content += '<select class="input" name="STATE"><option value="0">使用中</option><option value="1">未使用</option><option value="2" selected="selected">已注销</option></select></div></div></form>';
        }
        layer.open({
            title: '修改终端设备',
    		content: content,
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
                        url: '<?php echo site_url("zkadmin/meter_info/get_buildings");?>',
                        type:'POST',
                        data:{  
                            village_no: $('#village_select_up').val()  
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
                            $('#building_select_up').html(options);
                            get_rooms();
                        }
                    });
                };
                get_buildings();
                $('#village_select_up').change(function(){
                    get_buildings();
                });

                function get_rooms(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/meter_info/get_rooms");?>',
                        type:'POST',
                        data:{  
                            building_no: $('#building_select_up').val()  
                        },  
                        dataType:'json',  
                        success:function(data){
                            var options = '';
                            $.each(data, function(k, v){
                                if(v.ROOM_NO == item_json.ROOM_NO){
                                    options += '<option value="' + v.ROOM_NO + '" selected="selected">' + v.ROOM_NAME +'</option>'; 
                                }else{
                                    options += '<option value="' + v.ROOM_NO + '">' + v.ROOM_NAME +'</option>'; 
                                }
                            });
                            $('#room_select_up').html(options);
                        }
                    });
                };
                $('#building_select_up').change(function(){
                    get_rooms();
                });
    		}
    	});
    }

    //删除
    function del(id){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/meter_info/del_meter");?>' +'" method="post">'
            + '<input type="hidden" name="meter_id" value="' + id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加
    function add(){
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/meter_info/add");?>' + '" method="post" class="form-small">'
            + '<div class="form-inline"><span class="addon">仪表名称</span><input type="text" class="input" name="METER_NAME" size="20" /><span class="addon">仪表类型</span><select id="METER_TYPE_SELECT" class="input" name="METER_TYPE"><option value="1">超声波热表</option><option value="2">电表</option><option value="3">冷水表</option><option value="4">热水表</option><option value="5">燃气表</option><option value="6">阀门</option><option value="7">通断控制器</option><option value="8">温度采集器</option><option value="9">流温采集器</option><option value="10">嵌入式计算机</option></select></div>'
            + '<div class="form-inline"><span class="addon">仪表型号</span><select id="MODEL_ID_SELECT" class="input" name="MODEL_ID"></select></div>'
            + '<div class="form-inline"><span class="addon">通道编号</span><input type="text" class="input" name="CH" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">出厂日期</span><input id="product_time" type="text" class="input" name="PRODUCT_DATE" size="20" /><span class="addon">安装时间</span><input id="install_time" type="text" class="input" name="TIME_INSTALL" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">校准时间</span><input id="calibration_time" type="text" class="input" name="TIME_CALIBRATION" size="20" /><span class="addon">单元名称</span><input type="text" class="input" name="UNIT_NAME" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">住户姓名</span><input type="text" class="input" name="USER_NAME" size="20" /><span class="addon">集中器ID</span><input type="text" class="input" name="CMR_ID" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">集中器编号</span><input type="text" class="input" name="MBUS_ADDR" size="18" /><span class="addon">备注</span><input type="text" class="input" name="NOTES" size="24" /></div>'
            + '<div class="form-inline"><span class="addon">仪表ID</span><input type="text" class="input" name="METER_ID" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">使用状态</span><select class="input" name="STATE"><option value="0">使用中</option><option value="1">未使用</option><option value="2">已注销</option></select>'
            + '<span class="addon">使用类型</span><select class="input" name="USABLE_TYPE"><option value="1">分户</option><option value="2">楼栋</option></select></div>'
            + '<div class="form-inline"><span class="addon">使用卡</span><select class="input" name="USE_CARD"><option value="0">不使用</option><option value="1">使用</option></select>'
            + '<span class="addon">分摊类型</span><select class="input" name="SHARING_TYPE"><option value="加值">加值</option><option value="减值">减值</option><option value="忽略">忽略</option></select></div>'
            + '<div class="form-inline"><span class="addon">小区</span><select id="village_select" class="input" name="VILLAGE_NO">';
        $.each(JSON.parse(village_info), function(k, v){
            content += '<option value="' + v.VILLAGE_NO + '">' + v.VILLAGE_NAME +'</option>';
        });
        content += '</select><span class="addon">楼栋</span><select id="building_select" class="input" name="BUILDING_NO"></select>' 
            + '</div><div class="form-inline"><span class="addon">房间</span><select id="room_select" class="input" name="ROOM_NO"></select></div></form>';
        layer.open({
            title: '添加终端设备',
            content: content,
            area: 'auto',
            maxWidth: 480,
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
            	function get_models(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/meter_info/get_models");?>',
                        type:'POST',
                        data:{  
                            meter_type: $('#METER_TYPE_SELECT').val()  
                        },  
                        dataType:'json',  
                        success:function(data){
                            var options = '';
                            $.each(data, function(k, v){
                                options += '<option value="' + v.MODEL_ID + '">' + v.MODEL +'</option>'; 
                            });
                            $('#MODEL_ID_SELECT').html(options);
                        }
                    });
                };
                get_models();
                $('#METER_TYPE_SELECT').change(function(){
                    get_models();
                });

                function get_buildings(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/meter_info/get_buildings");?>',
                        type:'POST',
                        data:{  
                            village_no: $('#village_select').val()  
                        },  
                        dataType:'json',  
                        success:function(data){
                            var options = '';
                            $.each(data, function(k, v){
                                options += '<option value="' + v.BUILDING_NO + '">' + v.BUILDING_NAME +'</option>'; 
                            });
                            $('#building_select').html(options);
                            get_rooms();
                        }
                    });
                };
                get_buildings();
                $('#village_select').change(function(){
                    get_buildings();
                });

                function get_rooms(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/meter_info/get_rooms");?>',
                        type:'POST',
                        data:{  
                            building_no: $('#building_select').val()  
                        },  
                        dataType:'json',  
                        success:function(data){
                            var options = '';
                            $.each(data, function(k, v){
                                options += '<option value="' + v.ROOM_NO + '">' + v.ROOM_NAME +'</option>'; 
                            });
                            $('#room_select').html(options);
                        }
                    });
                };
                $('#building_select').change(function(){
                    get_rooms();
                });
                
            	jeDate({
            		dateCell: "#product_time",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isinitVal: true,
            		isTime: true
            	});
            	jeDate({
            		dateCell: "#install_time",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isinitVal: true,
            		isTime: true
            	});
            	jeDate({
            		dateCell: "#calibration_time",
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