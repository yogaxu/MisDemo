<!-- @author 你哥 -->
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>电表列表</title>
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
			<strong class="icon-reorder"> 电表列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<div class="padding border-bottom">
			<ul class="search">
				<li style="float: left;">
					<button class="button border-main icon-plus" onclick="add();">添加</button>
				</li>
    			<form action="<?php echo site_url("zkadmin/elec_meter/index");?>"
    				class="form-horizontal" method="get">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按电表ID进行搜索" name="keywords" class="input"
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
				<th>电表ID</th>
				<th>电表时间</th>
				<th>操作</th>
			</tr>
			<tbody>
                <?php for($i=0; $i<count($list); $i=$i+1){?>
                <tr>
    				<td><?php echo $list[$i]["CMR_ID"]; ?></td>
    				<td><?php echo $list[$i]['BUILDING_NAME']?></td>
    				<td><?php echo $list[$i]['ROOM_NAME']?></td>
    				<td><?php echo $list[$i]['FLOOR_AREA'] ?></td>
    				<td><?php echo $list[$i]["ELEC_METER_ID"]; ?></td>
    				<td><?php echo $list[$i]["REALTIME"]; ?></td>
    				<td>
    					<div class="button-group">
    						<a class="button border-green" href="<?php echo site_url("zkadmin/elec_meter/detail/".$list[$i]['ELEC_METER_ID']);?>"><span class="icon-search-plus"></span> 详情</a>
    					    <button class="button border-main" onclick="update('<?php echo $i?>');"><span class="icon-edit"></span> 修改</button>
    						<button class="button border-red" onclick="del('<?php echo $list[$i]['ELEC_METER_ID']?>','<?php echo $list[$i]['CMR_ID']?>');"><span class="icon-times"></span> 删除</button>
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
        							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/elec_meter/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
        							aria-label="Previous">上一页</a>
                          <?php echo $page_links; ?>
                          <a
        							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/elec_meter/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
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
        var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/elec_meter/update");?>' + '" method="post" class="form-small">'
            + '<div style="height: 400px;"><input type="hidden" value="' + item_json.CMR_ID + '" name="CMR_ID"><input type="hidden" value="' + item_json.ELEC_METER_ID + '" name="ELEC_METER_ID">'
            + '<div class="form-inline"><span class="addon">批次号</span><input value="' + item_json.BATCH_NO + '" type="text" class="input" name="BATCH_NO" size="20" /><span class="addon">序列号</span><input value="' + item_json.SERIAL_NO + '" type="text" class="input" name="SERIAL_NO" size="20" /><span class="addon">频率</span><input value="' + item_json.FRE + '" type="text" class="input" name="FRE" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">单项表电压</span><input value="' + item_json.VOLTAGE + '" type="text" class="input" name="VOLTAGE" size="10" /><span class="addon">A相电压</span><input value="' + item_json.A_VOLTAGE + '" type="text" class="input" name="A_VOLTAGE" size="10" /><span class="addon">B相电压</span><input value="' + item_json.B_VOLTAGE + '" type="text" class="input" name="B_VOLTAGE" size="10" /><span class="addon">C相电压</span><input value="' + item_json.C_VOLTAGE + '" type="text" class="input" name="C_VOLTAGE" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">单项表电流</span><input value="' + item_json.CURRENT + '" type="text" class="input" name="CURRENT" size="10" /><span class="addon">A相电流</span><input value="' + item_json.A_CURRENT + '" type="text" class="input" name="A_CURRENT" size="10" /><span class="addon">B相电流</span><input value="' + item_json.B_CURRENT + '" type="text" class="input" name="B_CURRENT" size="10" /><span class="addon">C相电流</span><input value="' + item_json.C_CURRENT + '" type="text" class="input" name="C_CURRENT" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">正向有功总电能</span><input value="' + item_json.ACTIVE_ENERGY + '" type="text" class="input" name="ACTIVE_ENERGY" size="10" /><span class="addon">正向有功费率1电能示值(尖)</span><input value="' + item_json.ACTIVE_ENERGY1 + '" type="text" class="input" name="ACTIVE_ENERGY1" size="10" /><span class="addon">正向有功费率2电能示值(峰)</span><input value="' + item_json.ACTIVE_ENERGY2 + '" type="text" class="input" name="ACTIVE_ENERGY2" size="10" /></div></br>'
            + '<div class="form-inline"><span class="addon">正向有功费率3电能示值(平)</span><input value="' + item_json.ACTIVE_ENERGY3 + '" type="text" class="input" name="ACTIVE_ENERGY3" size="10" /><span class="addon">正向有功费率4电能示值(谷)</span><input value="' + item_json.ACTIVE_ENERGY4 + '" type="text" class="input" name="ACTIVE_ENERGY4" size="10" /><span class="addon">正向无功总电能</span><input value="' + item_json.REACTIVE_ENERGY + '" type="text" class="input" name="REACTIVE_ENERGY" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">正向无功费率1电能示值量1</span><input value="' + item_json.REACTIVE_ENERGY1 + '" type="text" class="input" name="REACTIVE_ENERGY1" size="10" /><span class="addon">正向无功费率2电能示值量2</span><input value="' + item_json.REACTIVE_ENERGY2 + '" type="text" class="input" name="REACTIVE_ENERGY2" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">正向无功费率3电能示值量3</span><input value="' + item_json.REACTIVE_ENERGY3 + '" type="text" class="input" name="REACTIVE_ENERGY3" size="10" /><span class="addon">正向无功费率4电能示值量4</span><input value="' + item_json.REACTIVE_ENERGY4 + '" type="text" class="input" name="REACTIVE_ENERGY4" size="10" /><span class="addon">总有功功率</span><input value="' + item_json.ACTIVE_POWER + '" type="text" class="input" name="ACTIVE_POWER" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">A相有功功率</span><input value="' + item_json.ACTIVE_POWER_A + '" type="text" class="input" name="ACTIVE_POWER_A" size="15" /><span class="addon">B相有功功率</span><input value="' + item_json.ACTIVE_POWER_B + '" type="text" class="input" name="ACTIVE_POWER_B" size="15" /><span class="addon">C相有功功率</span><input value="' + item_json.ACTIVE_POWER_C + '" type="text" class="input" name="ACTIVE_POWER_C" size="15" /></div><br>'
            + '<div class="form-inline"><span class="addon">总无功功率</span><input value="' + item_json.REACTIVE_POWER + '" type="text" class="input" name="REACTIVE_POWER" size="15" /><span class="addon">A相无功功率</span><input value="' + item_json.REACTIVE_POWER_A + '" type="text" class="input" name="REACTIVE_POWER_A" size="15" /><span class="addon">B相无功功率</span><input value="' + item_json.REACTIVE_POWER_B + '" type="text" class="input" name="REACTIVE_POWER_B" size="15" /></div><br>'
            + '<div class="form-inline"><span class="addon">C相无功功率</span><input value="' + item_json.REACTIVE_POWER_C + '" type="text" class="input" name="REACTIVE_POWER_C" size="15" /><span class="addon">总功率因数</span><input value="' + item_json.POWER_FACTOR + '" type="text" class="input" name="POWER_FACTOR" size="15" /><span class="addon">A相功率因数</span><input value="' + item_json.POWER_FACTOR_A + '" type="text" class="input" name="POWER_FACTOR_A" size="15" /></div><br>'
            + '<div class="form-inline"><span class="addon">B相功率因数</span><input value="' + item_json.POWER_FACTOR_B + '" type="text" class="input" name="POWER_FACTOR_B" size="15" /><span class="addon">C相功率因数</span><input value="' + item_json.POWER_FACTOR_C + '" type="text" class="input" name="POWER_FACTOR_C" size="15" /><span class="addon">反向有功总电能</span><input value="' + item_json.ACTIVE_ENERGY_REVERSE + '" type="text" class="input" name="ACTIVE_ENERGY_REVERSE" size="15" /></div><br>'
            + '<div class="form-inline"><span class="addon">反向有功费率1电能示值</span><input value="' + item_json.ACTIVE_ENERGY_REVERSE1 + '" type="text" class="input" name="ACTIVE_ENERGY_REVERSE1" size="10" /><span class="addon">反向有功费率2电能示值</span><input value="' + item_json.ACTIVE_ENERGY_REVERSE2 + '" type="text" class="input" name="ACTIVE_ENERGY_REVERSE2" size="10" /><span class="addon">反向有功费率3电能示值</span><input value="' + item_json.ACTIVE_ENERGY_REVERSE3 + '" type="text" class="input" name="ACTIVE_ENERGY_REVERSE3" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">反向有功费率4电能示值</span><input value="' + item_json.ACTIVE_ENERGY_REVERSE4 + '" type="text" class="input" name="ACTIVE_ENERGY_REVERSE4" size="10" /><span class="addon">反向无功总电能</span><input value="' + item_json.REACTIVE_ENERGY_REVERSE + '" type="text" class="input" name="REACTIVE_ENERGY_REVERSE" size="10" /><span class="addon">反向无功费率1电能示值</span><input value="' + item_json.REACTIVE_ENERGY_REVERSE1 + '" type="text" class="input" name="REACTIVE_ENERGY_REVERSE1" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">反向无功费率2电能示值</span><input value="' + item_json.REACTIVE_ENERGY_REVERSE2 + '" type="text" class="input" name="REACTIVE_ENERGY_REVERSE2" size="10" /><span class="addon">反向无功费率3电能示值</span><input value="' + item_json.REACTIVE_ENERGY_REVERSE3 + '" type="text" class="input" name="REACTIVE_ENERGY_REVERSE3" size="10" /><span class="addon">反向无功费率4电能示值</span><input value="' + item_json.REACTIVE_ENERGY_REVERSE4 + '" type="text" class="input" name="REACTIVE_ENERGY_REVERSE4" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">一象限无功电能示值</span><input value="' + item_json.QUADRANT_REACTIVE_POWER1 + '" type="text" class="input" name="QUADRANT_REACTIVE_POWER1" size="10" /><span class="addon">二象限无功电能示值</span><input value="' + item_json.QUADRANT_REACTIVE_POWER2 + '" type="text" class="input" name="QUADRANT_REACTIVE_POWER2" size="10" /><span class="addon">三象限无功电能示值</span><input value="' + item_json.QUADRANT_REACTIVE_POWER3 + '" type="text" class="input" name="QUADRANT_REACTIVE_POWER3" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">四象限无功电能示值</span><input value="' + item_json.QUADRANT_REACTIVE_POWER4 + '" type="text" class="input" name="QUADRANT_REACTIVE_POWER4" size="10" /><span class="addon">CT变化</span><input value="' + item_json.CT + '" type="text" class="input" name="CT" size="10" /><span class="addon">控制状态</span><select class="input" name="ELEC_STATE">';
        switch(item_json.ELEC_STATE){
        case '0':
            content += '<option value="0" selected="selected">关闸</option><option value="1">合闸</option></select></div><br>';
            break;
        default:
            content += '<option value="0">关闸</option><option value="1" selected="selected">合闸</option></select></div><br>';
        }    
        content += '<div class="form-inline"><span class="addon">采样时间</span><input value="' + item_json.TIME_SAMPLE + '" id="TIME_SAMPLE_UP" type="text" class="input" name="TIME_SAMPLE" size="20" /><span class="addon">上传时间</span><input value="' + item_json.TIME_UPLOAD + '" id="TIME_UPLOAD_UP" type="text" class="input" name="TIME_UPLOAD" size="20" /><span class="addon">实时时间</span><input value="' + item_json.REALTIME + '" id="REALTIME_UP" type="text" class="input" name="REALTIME" size="20" /></div></div></form>';
        layer.open({
            title: '修改电表信息',
            content: content,
            area: 'auto',
            maxWidth: 700,
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
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/elec_meter/del");?>' +'" method="post">'
            + '<input type="hidden" name="meter_id" value="' + meter_id + '"><input type="hidden" name="cmr_id" value="' + cmr_id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加
    function add(){
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/elec_meter/add");?>' + '" method="post" class="form-small">'
            + '<div style="height: 400px;"><div class="form-inline"><span class="addon">电表ID</span><select name="ELEC_METER_ID" class="input">';
        $.each(JSON.parse(meter_info), function(k, v){
            content += '<option value="' + v.METER_ID + '">' + v.METER_ID + '</option>';
        });
        content += '</select><span class="addon">批次号</span><input type="text" class="input" name="BATCH_NO" size="20" /><span class="addon">序列号</span><input type="text" class="input" name="SERIAL_NO" size="20" /><span class="addon">频率</span><input type="text" class="input" name="FRE" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">单项表电压</span><input type="text" class="input" name="VOLTAGE" size="10" /><span class="addon">A相电压</span><input type="text" class="input" name="A_VOLTAGE" size="10" /><span class="addon">B相电压</span><input type="text" class="input" name="B_VOLTAGE" size="10" /><span class="addon">C相电压</span><input type="text" class="input" name="C_VOLTAGE" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">单项表电流</span><input type="text" class="input" name="CURRENT" size="10" /><span class="addon">A相电流</span><input type="text" class="input" name="A_CURRENT" size="10" /><span class="addon">B相电流</span><input type="text" class="input" name="B_CURRENT" size="10" /><span class="addon">C相电流</span><input type="text" class="input" name="C_CURRENT" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">正向有功总电能</span><input type="text" class="input" name="ACTIVE_ENERGY" size="10" /><span class="addon">正向有功费率1电能示值(尖)</span><input type="text" class="input" name="ACTIVE_ENERGY1" size="10" /><span class="addon">正向有功费率2电能示值(峰)</span><input type="text" class="input" name="ACTIVE_ENERGY2" size="10" /></div></br>'
            + '<div class="form-inline"><span class="addon">正向有功费率3电能示值(平)</span><input type="text" class="input" name="ACTIVE_ENERGY3" size="10" /><span class="addon">正向有功费率4电能示值(谷)</span><input type="text" class="input" name="ACTIVE_ENERGY4" size="10" /><span class="addon">正向无功总电能</span><input type="text" class="input" name="REACTIVE_ENERGY" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">正向无功费率1电能示值量1</span><input type="text" class="input" name="REACTIVE_ENERGY1" size="10" /><span class="addon">正向无功费率2电能示值量2</span><input type="text" class="input" name="REACTIVE_ENERGY2" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">正向无功费率3电能示值量3</span><input type="text" class="input" name="REACTIVE_ENERGY3" size="10" /><span class="addon">正向无功费率4电能示值量4</span><input type="text" class="input" name="REACTIVE_ENERGY4" size="10" /><span class="addon">总有功功率</span><input type="text" class="input" name="ACTIVE_POWER" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">A相有功功率</span><input type="text" class="input" name="ACTIVE_POWER_A" size="15" /><span class="addon">B相有功功率</span><input type="text" class="input" name="ACTIVE_POWER_B" size="15" /><span class="addon">C相有功功率</span><input type="text" class="input" name="ACTIVE_POWER_C" size="15" /></div><br>'
            + '<div class="form-inline"><span class="addon">总无功功率</span><input type="text" class="input" name="REACTIVE_POWER" size="15" /><span class="addon">A相无功功率</span><input type="text" class="input" name="REACTIVE_POWER_A" size="15" /><span class="addon">B相无功功率</span><input type="text" class="input" name="REACTIVE_POWER_B" size="15" /></div><br>'
            + '<div class="form-inline"><span class="addon">C相无功功率</span><input type="text" class="input" name="REACTIVE_POWER_C" size="15" /><span class="addon">总功率因数</span><input type="text" class="input" name="POWER_FACTOR" size="15" /><span class="addon">A相功率因数</span><input type="text" class="input" name="POWER_FACTOR_A" size="15" /></div><br>'
            + '<div class="form-inline"><span class="addon">B相功率因数</span><input type="text" class="input" name="POWER_FACTOR_B" size="15" /><span class="addon">C相功率因数</span><input type="text" class="input" name="POWER_FACTOR_C" size="15" /><span class="addon">反向有功总电能</span><input type="text" class="input" name="ACTIVE_ENERGY_REVERSE" size="15" /></div><br>'
            + '<div class="form-inline"><span class="addon">反向有功费率1电能示值</span><input type="text" class="input" name="ACTIVE_ENERGY_REVERSE1" size="10" /><span class="addon">反向有功费率2电能示值</span><input type="text" class="input" name="ACTIVE_ENERGY_REVERSE2" size="10" /><span class="addon">反向有功费率3电能示值</span><input type="text" class="input" name="ACTIVE_ENERGY_REVERSE3" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">反向有功费率4电能示值</span><input type="text" class="input" name="ACTIVE_ENERGY_REVERSE4" size="10" /><span class="addon">反向无功总电能</span><input type="text" class="input" name="REACTIVE_ENERGY_REVERSE" size="10" /><span class="addon">反向无功费率1电能示值</span><input type="text" class="input" name="REACTIVE_ENERGY_REVERSE1" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">反向无功费率2电能示值</span><input type="text" class="input" name="REACTIVE_ENERGY_REVERSE2" size="10" /><span class="addon">反向无功费率3电能示值</span><input type="text" class="input" name="REACTIVE_ENERGY_REVERSE3" size="10" /><span class="addon">反向无功费率4电能示值</span><input type="text" class="input" name="REACTIVE_ENERGY_REVERSE4" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">一象限无功电能示值</span><input type="text" class="input" name="QUADRANT_REACTIVE_POWER1" size="10" /><span class="addon">二象限无功电能示值</span><input type="text" class="input" name="QUADRANT_REACTIVE_POWER2" size="10" /><span class="addon">三象限无功电能示值</span><input type="text" class="input" name="QUADRANT_REACTIVE_POWER3" size="10" /></div><br>'
            + '<div class="form-inline"><span class="addon">四象限无功电能示值</span><input type="text" class="input" name="QUADRANT_REACTIVE_POWER4" size="10" /><span class="addon">CT变化</span><input type="text" class="input" name="CT" size="10" /><span class="addon">控制状态</span><select class="input" name="ELEC_STATE"><option value="0">关闸</option><option value="1">合闸</option></select></div><br>'
            + '<div class="form-inline"><span class="addon">采样时间</span><input id="TIME_SAMPLE" type="text" class="input" name="TIME_SAMPLE" size="20" /><span class="addon">上传时间</span><input id="TIME_UPLOAD" type="text" class="input" name="TIME_UPLOAD" size="20" /><span class="addon">实时时间</span><input id="REALTIME" type="text" class="input" name="REALTIME" size="20" /></div></div></form>';
        layer.open({
            title: '添加电表',
            content: content,
            area: 'auto',
            maxWidth: 700,
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