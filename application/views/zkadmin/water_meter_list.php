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
			<strong class="icon-reorder"> 冷水表列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<div class="padding border-bottom">
			<ul class="search">
				<li style="float: left;">
					<button class="button border-main icon-plus" onclick="add();">添加</button>
				</li>
    			<form action="<?php echo site_url("zkadmin/water_meter/index");?>"
    				class="form-horizontal" method="get">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按水表ID进行搜索" name="keywords" class="input"
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
				<th>水表ID</th>
				<th>水表时间</th>
				<th>操作</th>
			</tr>
			<tbody>
                <?php for($i=0; $i<count($list); $i=$i+1){?>
                <tr>
    				<td><?php echo $list[$i]["CMR_ID"]; ?></td>
    				<td><?php echo $list[$i]['BUILDING_NAME']?></td>
    				<td><?php echo $list[$i]['ROOM_NAME']?></td>
    				<td><?php echo $list[$i]['FLOOR_AREA'] ?></td>
    				<td><?php echo $list[$i]["WATER_METER_ID"]; ?></td>
    				<td><?php echo $list[$i]["REALTIME"]; ?></td>
    				<td>
    					<div class="button-group">
    						<a class="button border-green" href="<?php echo site_url("zkadmin/water_meter/detail/".$list[$i]['WATER_METER_ID']);?>"><span class="icon-search-plus"></span> 详情</a>
    					    <button class="button border-main" onclick="update('<?php echo $i?>');"><span class="icon-edit"></span> 修改</button>
    						<button class="button border-red" onclick="del('<?php echo $list[$i]['WATER_METER_ID']?>','<?php echo $list[$i]['CMR_ID']?>');"><span class="icon-times"></span> 删除</button>
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
        							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/water_meter/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
        							aria-label="Previous">上一页</a>
                          <?php echo $page_links; ?>
                          <a
        							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/water_meter/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
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
        var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/water_meter/update");?>' + '" method="post" class="form-small">'
            + '<input type="hidden" value="' + item_json.CMR_ID + '" name="CMR_ID">'
            + '<input type="hidden" value="' + item_json.WATER_METER_ID + '" name="WATER_METER_ID">'
            + '<div class="form-inline"><span class="addon">批次号</span><input value="' + item_json.BATCH_NO + '" type="text" class="input" name="BATCH_NO" size="20" /><span class="addon">序列号</span><input value="' + item_json.SERIAL_NO + '" type="text" class="input" name="SERIAL_NO" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">当前累计流量</span><input value="' + item_json.BATCH_NO + '" type="text" class="input" name="CUR_TOTAL_FLOW" size="20" /><span class="addon">当前累计流量单位</span><input value="' + item_json.UNIT_CUR_TOTAL_FLOW + '" type="text" class="input" name="UNIT_CUR_TOTAL_FLOW" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">结算日累计流量</span><input value="' + item_json.CUR_TOTAL_FLOW + '" type="text" class="input" name="DAY_TOTAL_FLOW" size="22" /><span class="addon">结算日累计流量单位</span><input value="' + item_json.UNIT_DAY_TOTAL_FLOW + '" type="text" class="input" name="UNIT_DAY_TOTAL_FLOW" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">瞬时流量</span><input value="' + item_json.IN_FLOW + '" type="text" class="input" name="IN_FLOW" size="22" /><span class="addon">瞬时流量单位</span><input value="' + item_json.UNIT_IN_FLOW + '" type="text" class="input" name="UNIT_IN_FLOW" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">正向流量</span><input value="' + item_json.FORWARD_FLOW + '" type="text" class="input" name="FORWARD_FLOW" size="22" /><span class="addon">正向流量单位</span><input value="' + item_json.UNIT_FORWARD_FLOW + '" type="text" class="input" name="UNIT_FORWARD_FLOW" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">反向流量</span><input value="' + item_json.REVERSE_FLOW + '" type="text" class="input" name="REVERSE_FLOW" size="22" /><span class="addon">反向流量单位</span><input value="' + item_json.UNIT_REVERSE_FLOW + '" type="text" class="input" name="UNIT_REVERSE_FLOW" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">采样时间</span><input value="' + item_json.TIME_SAMPLE + '" id="TIME_SAMPLE_UP" type="text" class="input" name="TIME_SAMPLE" size="22" /><span class="addon">上传时间</span><input value="' + item_json.TIME_UPLOAD + '" id="TIME_UPLOAD_UP" type="text" class="input" name="TIME_UPLOAD" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">实时时间</span><input value="' + item_json.REALTIME + '" id="REALTIME_UP" type="text" class="input" name="REALTIME" size="22" /></div></form>';
        layer.open({
            title: '修改水表信息',
            content: content,
            area: 'auto',
            maxWidth: 550,
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
            		dateCell: "#TIME_SAMPLE_UP",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isTime: true
            	});
            	jeDate({
            		dateCell: "#TIME_UPLOAD_UP",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isTime: true
            	});
            	jeDate({
            		dateCell: "#REALTIME_UP",
            		format: "YYYY-MM-DD hh:mm:ss",
            		isTime: true
            	});
            }
        });
    }

    //删除
    function del(meter_id,cmr_id){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/water_meter/del");?>' +'" method="post">'
            + '<input type="hidden" name="meter_id" value="' + meter_id + '"><input type="hidden" name="cmr_id" value="' + cmr_id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加
    function add(){
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/water_meter/add");?>' + '" method="post" class="form-small">'
            + '<div class="form-inline"><span class="addon">水表ID</span><select name="WATER_METER_ID" class="input">';
        $.each(JSON.parse(meter_info), function(k, v){
            content += '<option value="' + v.METER_ID + '">' + v.METER_ID + '</option>';
        });
        content += '</select></div>'
            + '<div class="form-inline"><span class="addon">批次号</span><input type="text" class="input" name="BATCH_NO" size="20" /><span class="addon">序列号</span><input type="text" class="input" name="SERIAL_NO" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">当前累计流量</span><input type="text" class="input" name="CUR_TOTAL_FLOW" size="20" /><span class="addon">当前累计流量单位</span><input type="text" class="input" name="UNIT_CUR_TOTAL_FLOW" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">结算日累计流量</span><input type="text" class="input" name="DAY_TOTAL_FLOW" size="22" /><span class="addon">结算日累计流量单位</span><input type="text" class="input" name="UNIT_DAY_TOTAL_FLOW" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">瞬时流量</span><input type="text" class="input" name="IN_FLOW" size="22" /><span class="addon">瞬时流量单位</span><input type="text" class="input" name="UNIT_IN_FLOW" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">正向流量</span><input type="text" class="input" name="FORWARD_FLOW" size="22" /><span class="addon">正向流量单位</span><input type="text" class="input" name="UNIT_FORWARD_FLOW" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">反向流量</span><input type="text" class="input" name="REVERSE_FLOW" size="22" /><span class="addon">反向流量单位</span><input type="text" class="input" name="UNIT_REVERSE_FLOW" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">采样时间</span><input id="TIME_SAMPLE" type="text" class="input" name="TIME_SAMPLE" size="22" /><span class="addon">上传时间</span><input id="TIME_UPLOAD" type="text" class="input" name="TIME_UPLOAD" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">实时时间</span><input id="REALTIME" type="text" class="input" name="REALTIME" size="22" /></div></form>';
        layer.open({
            title: '添加水表',
            content: content,
            area: 'auto',
            maxWidth: 550,
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
            	jeDate({
            		dateCell: "#REALTIME",
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