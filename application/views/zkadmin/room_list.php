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
<link rel="stylesheet" href="<?php echo base_url("zeros/jedate/skin/jedate.css");?>">
<script src="<?php echo base_url("zeros/js/jquery.js");?>"></script>
<script src="<?php echo base_url("zeros/js/pintuer.js");?>"></script>
<script src="<?php echo base_url("zeros/js/layer/layer.js");?>"></script>
<script src="<?php echo base_url("zeros/jedate/jedate.min.js");?>"></script>
</head>
<body>
	<div class="panel admin-panel">
		<div class="panel-head">
			<strong class="icon-reorder"> 房间列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<div class="padding border-bottom">
			<ul class="search">
				<li style="float: left;">
					<button class="button border-main icon-plus" onclick="add();">添加</button>
				</li>
    			<form action="<?php echo site_url("zkadmin/room/index");?>"
    				class="form-horizontal" method="get">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按房间名进行搜索" name="keywords" class="input"
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
		</script>
		<table class="table table-hover text-center">
			<tr>
				<th>房间编号</th>
				<th>房间名称</th>
				<th>楼栋编号</th>
				<th>楼栋名称</th>
				<th>小区编号</th>
				<th>小区名称</th>
				<th>操作</th>
			</tr>
			<tbody>
                <?php for($i=0; $i<count($list); $i=$i+1){ ?>
                <tr>
    				<td><?php echo $list[$i]["ROOM_NO"] ?></td>
    				<td><?php echo $list[$i]["ROOM_NAME"] ?></td>
    				<td><?php echo $list[$i]["BUILDING_NO"] ?></td>
    				<td><?php echo $list[$i]["BUILDING_NAME"]?></td>
    				<td><?php echo $list[$i]["VILLAGE_NO"] ?></td>
    				<td><?php echo $list[$i]["VILLAGE_NAME"]?></td>
    				<td>
    					<div class="button-group">
    						<a class="button border-green" href="<?php echo site_url("zkadmin/room/detail/".$list[$i]['ROOM_NO']);?>"><span class="icon-search-plus"></span> 详情</a>
    						<button class="button border-main" onclick="update('<?php echo $i?>');"><span class="icon-edit"></span> 修改</button>
    					    <button class="button border-red" onclick="del('<?php echo $list[$i]['ROOM_NO']?>');"><span class="icon-times"></span> 删除</button>
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
        							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/room/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
        							aria-label="Previous">上一页</a>
                          <?php echo $page_links; ?>
                          <a
        							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/room/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
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
        var village = JSON.parse(village_info);
        var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/room/update");?>' + '" method="post" class="form-small">'
            + '<input type="hidden" value="' + item_json.ROOM_NO + '" name="ROOM_NO">'
            + '<div style="height: 400px;"><div class="form-inline"><span class="addon">小区名称</span><select id="village_select_up" class="input" name="VILLAGE_NO">';
        $.each(village, function(k, v){
            if(v.VILLAGE_NO == item_json.VILLAGE_NO){
                content += '<option value="' + v.VILLAGE_NO + '" selected="selected">' + v.VILLAGE_NAME + '</option>';
            }else{
                content += '<option value="' + v.VILLAGE_NO + '">' + v.VILLAGE_NAME + '</option>';
            }
        });
        content += '</select><span class="addon">楼栋名称</span><select id="building_select_up" class="input" name="BUILDING_NO"></select></div>'
            + '<div class="form-inline"><span class="addon">房间名称</span><input value="' + item_json.ROOM_NAME + '" type="text" class="input" name="ROOM_NAME" size="20" /><span class="addon">城市名称</span><input value="' + item_json.CITY_NAME + '" type="text" class="input" name="CITY_NAME" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">分摊系数</span><input value="' + item_json.RATIO + '" type="text" class="input" name="RATIO" size="20" /><span class="addon">建筑面积</span><input value="' + item_json.FLOOR_AREA + '" type="text" class="input" name="FLOOR_AREA" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">使用面积</span><input value="' + item_json.USABLE_AREA + '" type="text" class="input" name="USABLE_AREA" size="20" /><span class="addon">房间类型</span><input value="' + item_json.ROOM_TYPE + '" type="text" class="input" name="ROOM_TYPE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">单元名称</span><input value="' + item_json.UNIT_NAME + '" type="text" class="input" name="UNIT_NAME" size="20" /><span class="addon">住户姓名</span><input value="' + item_json.USER_NAME + '" type="text" class="input" name="USER_NAME" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">身份证号码</span><input value="' + item_json.ID_CARD + '" type="text" class="input" name="ID_CARD" size="20" /><span class="addon">手机号码</span><input value="' + item_json.MOBILE + '" type="text" class="input" name="MOBILE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">电话号码</span><input value="' + item_json.TELEPHONE + '" type="text" class="input" name="TELEPHONE" size="20" /><span class="addon">剩余热量</span><input value="' + item_json.BALANCE_HEAT + '" type="text" class="input" name="BALANCE_HEAT" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">累计热量</span><input value="' + item_json.TOTAL_HEAT + '" type="text" class="input" name="TOTAL_HEAT" size="20" /><span class="addon">欠费警告值</span><input value="' + item_json.ARREARS_NUM + '" type="text" class="input" name="ARREARS_NUM" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">计量类型</span><select class="input" name="METERING_TYPE">';
        switch(item_json.METERING_TYPE){
        case '1': 
            content += '<option value="1" selected="selected">分摊法</option><option value="2">热表法</option></select>';
            break;
        default:
            content += '<option value="1">分摊法</option><option value="2" selected="selected">热表法</option></select>';
        }
        content += '<span class="addon">使用类型</span><select class="input" name="USABLE_TYPE">';
        switch(item_json.USABLE_TYPE){
        case '1': 
            content += '<option value="1" selected="selected">分户</option><option value="2">楼栋</option><option value="9">其他</option></select>';
            break;
        case '2': 
            content += '<option value="1">分户</option><option value="2" selected="selected">楼栋</option><option value="9">其他</option></select>';
            break;
        default:
            content += '<option value="1">分户</option><option value="2">楼栋</option><option value="9" selected="selected">其他</option></select>';
        }
        content += '<span class="addon">下载状态</span><select class="input" name="DN_STATE">';
        switch(item_json.DN_STATE){
        case '0': 
            content += '<option value="0" selected="selected">未下载</option><option value="1">已下载</option></select></div>';
            break;
        default:
            content += '<option value="0">未下载</option><option value="1" selected="selected">已下载</option></select></div>';
        }
        content += '<div class="form-inline"><span class="addon">温度上限</span><input value="' + item_json.TEMP_UPPER + '" type="text" class="input" name="TEMP_UPPER" size="20" /><span class="addon">温度下限</span><input value="' + item_json.TEMP_LOWER + '" type="text" class="input" name="TEMP_LOWER" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">防冻温度</span><input value="' + item_json.TEMP_ANTI + '" type="text" class="input" name="TEMP_ANTI" size="20" /><span class="addon">备注信息</span><input value="' + item_json.NOTES + '" type="text" class="input" name="NOTES" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">设定温度</span><input value="' + item_json.TEMP_SET + '" type="text" class="input" name="TEMP_SET" size="20" /><span class="addon">温控器显示内容</span><input value="' + item_json.DISPLAY_CONTENT + '" type="text" class="input" name="DISPLAY_CONTENT" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">分摊周期</span><input value="' + item_json.FT_CYCLE + '" type="text" class="input" name="FT_CYCLE" size="20" /><span class="addon">采样周期</span><input value="' + item_json.SAMPLE_CYCLE + '" type="text" class="input" name="SAMPLE_CYCLE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">供暖起始时间</span><input value="' + item_json.SUPPLY_HEAT_START + '" type="text" id="SUPPLY_HEAT_START_SELECT_UP" class="input" name="SUPPLY_HEAT_START" size="20" /><span class="addon">供暖结束时间</span><input value="' + item_json.SUPPLY_HEAT_END + '" id="SUPPLY_HEAT_END_SELECT_UP" type="text" class="input" name="SUPPLY_HEAT_END" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">累计时间</span><input value="' + item_json.TOTAL_TIME + '" type="text" class="input" name="TOTAL_TIME" size="20" /><span class="addon">累计充值热量</span><input value="' + item_json.TOTAL_BALANCE + '" type="text" class="input" name="TOTAL_BALANCE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">无线失连期间防冻开阀时间</span><input value="' + item_json.ANTI_NUM + '" type="text" class="input" name="ANTI_NUM" size="20" /></div></div></form>';
        layer.open({
            title: '修改房间信息',
            content: content,
            area: 'auto',
            maxWidth: 550,
            zIndex: 100,
            btn: ['确定', '取消'],
            yes: function(index, layero){
                $('#update_form').submit();
                layer.close(index);
                layer.msg('修改成功');
            },
            btn2: function(index, layero){
                return false;
            },
            success: function(index, layero){
            	function get_buildings(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/room/get_buildings");?>',
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
                        }
                    });
                };
                get_buildings();
                $('#village_select_up').change(function(){
                    get_buildings();
                });

                jeDate({
            		dateCell: "#SUPPLY_HEAT_START_SELECT_UP",
            		format: "YYYY-MM-DD",
            		isTime: true
            	});
                jeDate({
            		dateCell: "#SUPPLY_HEAT_END_SELECT_UP",
            		format: "YYYY-MM-DD",
            		isTime: true
            	});
            }
        });
    }

    //删除
    function del(id){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/room/del");?>' +'" method="post">'
            + '<input type="hidden" name="ROOM_NO" value="' + id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加
    function add(){
        var village = JSON.parse(village_info);
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/room/add");?>' + '" method="post" class="form-small">'
            + '<div style="height: 400px;"><div class="form-inline"><span class="addon">小区名称</span><select id="village_select" class="input" name="VILLAGE_NO">';
        $.each(village, function(k, v){
            content += '<option value="' + v.VILLAGE_NO + '">' + v.VILLAGE_NAME + '</option>';
        });
        content += '</select><span class="addon">楼栋名称</span><select id="building_select" class="input" name="BUILDING_NO"></select></div>'
            + '<div class="form-inline"><span class="addon">房间名称</span><input type="text" class="input" name="ROOM_NAME" size="20" /><span class="addon">城市名称</span><input type="text" class="input" name="CITY_NAME" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">分摊系数</span><input type="text" class="input" name="RATIO" size="20" /><span class="addon">建筑面积</span><input type="text" class="input" name="FLOOR_AREA" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">使用面积</span><input type="text" class="input" name="USABLE_AREA" size="20" /><span class="addon">房间类型</span><input type="text" class="input" name="ROOM_TYPE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">单元名称</span><input type="text" class="input" name="UNIT_NAME" size="20" /><span class="addon">住户姓名</span><input type="text" class="input" name="USER_NAME" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">身份证号码</span><input type="text" class="input" name="ID_CARD" size="20" /><span class="addon">手机号码</span><input type="text" class="input" name="MOBILE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">电话号码</span><input type="text" class="input" name="TELEPHONE" size="20" /><span class="addon">剩余热量</span><input type="text" class="input" name="BALANCE_HEAT" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">累计热量</span><input type="text" class="input" name="TOTAL_HEAT" size="20" /><span class="addon">欠费警告值</span><input type="text" class="input" name="ARREARS_NUM" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">计量类型</span><select class="input" name="METERING_TYPE"><option value="1">分摊法</option><option value="2">热表法</option></select>'
            + '<span class="addon">使用类型</span><select class="input" name="USABLE_TYPE"><option value="1">分户</option><option value="2">楼栋</option><option value="9">其他</option></select>'
            + '<span class="addon">下载状态</span><select class="input" name="DN_STATE"><option value="0">未下载</option><option value="1">已下载</option></select></div>'
            + '<div class="form-inline"><span class="addon">温度上限</span><input type="text" class="input" name="TEMP_UPPER" size="20" /><span class="addon">温度下限</span><input type="text" class="input" name="TEMP_LOWER" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">防冻温度</span><input type="text" class="input" name="TEMP_ANTI" size="20" /><span class="addon">备注信息</span><input type="text" class="input" name="NOTES" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">设定温度</span><input type="text" class="input" name="TEMP_SET" size="20" /><span class="addon">温控器显示内容</span><input type="text" class="input" name="DISPLAY_CONTENT" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">分摊周期</span><input type="text" class="input" name="FT_CYCLE" size="20" /><span class="addon">采样周期</span><input type="text" class="input" name="SAMPLE_CYCLE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">供暖起始时间</span><input type="text" id="SUPPLY_HEAT_START_SELECT" class="input" name="SUPPLY_HEAT_START" size="20" /><span class="addon">供暖结束时间</span><input id="SUPPLY_HEAT_END_SELECT" type="text" class="input" name="SUPPLY_HEAT_END" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">累计时间</span><input type="text" class="input" name="TOTAL_TIME" size="20" /><span class="addon">累计充值热量</span><input type="text" class="input" name="TOTAL_BALANCE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">无线失连期间防冻开阀时间</span><input type="text" class="input" name="ANTI_NUM" size="20" /></div></div></form>';
        layer.open({
            title: '添加房间信息',
            content: content,
            area: 'auto',
            maxWidth: 550,
            zIndex: 100,
            btn: ['确定', '取消'],
            yes: function(index, layero){
                $('#add_form').submit();
                layer.close(index);
                layer.msg('添加成功');
            },
            btn2: function(index, layero){
                return false;
            },
            success: function(index, layero){
            	function get_buildings(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/room/get_buildings");?>',
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
                        }
                    });
                };
                get_buildings();
                $('#village_select').change(function(){
                    get_buildings();
                });

                jeDate({
            		dateCell: "#SUPPLY_HEAT_START_SELECT",
            		format: "YYYY-MM-DD",
            		isinitVal: true,
            		isTime: true
            	});
                jeDate({
            		dateCell: "#SUPPLY_HEAT_END_SELECT",
            		format: "YYYY-MM-DD",
            		isinitVal: true,
            		isTime: true
            	});
            }
        });
    }
	</script>
</body>
</html>