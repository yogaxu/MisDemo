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
			<strong class="icon-reorder"> 楼栋列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<div class="padding border-bottom">
			<ul class="search">
				<li style="float: left;">
					<button class="button border-main icon-plus" onclick="add();">添加</button>
				</li>
    			<form action="<?php echo site_url("zkadmin/village/index");?>"
    				class="form-horizontal" method="get">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按楼栋名进行搜索" name="keywords" class="input"
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
				<th>楼栋编号</th>
				<th>楼栋名称</th>
				<th>小区编号</th>
				<th>小区名称</th>
				<th>操作</th>
			</tr>
			<tbody>
                <?php for($i=0; $i<count($list); $i=$i+1){ ?>
                <tr>
    				<td><?php echo $list[$i]["BUILDING_NO"]; ?></td>
    				<td><?php echo $list[$i]["BUILDING_NAME"]?></td>
    				<td><?php echo $list[$i]["VILLAGE_NO"]; ?></td>
    				<td><?php echo $list[$i]["VILLAGE_NAME"]?></td>
    				<td>
    					<div class="button-group">
    						<a class="button border-green" href="<?php echo site_url("zkadmin/building/detail/".$list[$i]['BUILDING_NO']);?>"><span class="icon-search-plus"></span> 详情</a>
    						<button class="button border-main" onclick="update('<?php echo $i?>');"><span class="icon-edit"></span> 修改</button>
    						<button class="button border-red" onclick="del('<?php echo $list[$i]['BUILDING_NO']?>');"><span class="icon-times"></span> 删除</button>
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
        							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/building/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
        							aria-label="Previous">上一页</a>
                          <?php echo $page_links; ?>
                          <a
        							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/building/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
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
        var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/building/update");?>' + '" method="post" class="form-small">'
            + '<input type="hidden" name="BUILDING_NO" value="' + item_json.BUILDING_NO + '">'
            + '<div class="form-inline"><span class="addon">楼栋名称</span><input type="text" value="' + item_json.BUILDING_NAME + '" class="input" name="BUILDING_NAME" size="20" /><span class="addon">小区名称</span><select class="input" name="VILLAGE_NO">';
        $.each(village, function(k, v){
            if(v.VILLAGE_NO == item_json.VILLAGE_NO){
                content += '<option value="' + v.VILLAGE_NO + '" selected="selected">' + v.VILLAGE_NAME + '</option>';
            }else{
                content += '<option value="' + v.VILLAGE_NO + '">' + v.VILLAGE_NAME + '</option>';
            }
        });
        content += '</select></div><div class="form-inline"><span class="addon">建筑类型</span><select class="input" name="BUILDING_TYPE">';
        switch(item_json.BUILDING_TYPE){
        case "1": 
            content += '<option value="1" selected="selected">塔楼</option><option value="2">板楼</option><option value="9">其他</option></select>';
            break;
        case "2": 
            content += '<option value="1">塔楼</option><option value="2" selected="selected">板楼</option><option value="9">其他</option></select>';
            break;
        default:                
            content += '<option value="1">塔楼</option><option value="2">板楼</option><option value="9" selected="selected">其他</option></select>';
        }
        content += '<span class="addon">结构类型</span><select class="input" name="STRUCT_TYPE">';
        switch(item_json.STRUCT_TYPE){
        case "1":
            content += '<option value="1" selected="selected">砖混</option><option value="2">现浇剪力墙</option><option value="3">框架结构</option><option value="9">其他</option></select></div>';
            break;
        case "2":
            content += '<option value="1">砖混</option><option value="2" selected="selected">现浇剪力墙</option><option value="3">框架结构</option><option value="9">其他</option></select></div>';
            break;
        case "3":
            content += '<option value="1">砖混</option><option value="2">现浇剪力墙</option><option value="3" selected="selected">框架结构</option><option value="9">其他</option></select></div>';
            break;
        default: 
            content += '<option value="1">砖混</option><option value="2">现浇剪力墙</option><option value="3">框架结构</option><option value="9" selected="selected">其他</option></select></div>';
        }
        content += '<div class="form-inline"><span class="addon">使用类型</span><select class="input" name="USE_TYPE">';
        switch(item_json.USE_TYPE){
        case "1":
            content += '<option value="1" selected="selected">普通住宅</option><option value="2">公寓</option><option value="3">别墅</option><option value="4">商用</option><option value="9">其他</option></select>';
            break;
        case "2":
            content += '<option value="1">普通住宅</option><option value="2" selected="selected">公寓</option><option value="3">别墅</option><option value="4">商用</option><option value="9">其他</option></select>';
            break;
        case "3":
            content += '<option value="1">普通住宅</option><option value="2">公寓</option><option value="3" selected="selected">别墅</option><option value="4">商用</option><option value="9">其他</option></select>';
            break;
        case "4":
            content += '<option value="1">普通住宅</option><option value="2">公寓</option><option value="3">别墅</option><option value="4" selected="selected">商用</option><option value="9">其他</option></select>';
            break;
        default:
            content += '<option value="1">普通住宅</option><option value="2">公寓</option><option value="3">别墅</option><option value="4">商用</option><option value="9" selected="selected">其他</option></select>';
        }
        content += '<span class="addon">计量方法</span><select class="input" name="METHODS">';
        switch(item_json.METHODS){
        case "0":
            content += '<option value="0" selected="selected">通断法</option><option value="1">流温法</option><option value="2">温度面积法</option><option value="3">热表法</option><option value="4">温度采集系统</option><option value="5">远程抄表系统</option><option value="6">预付费IC卡锁闭阀</option></select></div>';
            break;
        case "1":
            content += '<option value="0">通断法</option><option value="1" selected="selected">流温法</option><option value="2">温度面积法</option><option value="3">热表法</option><option value="4">温度采集系统</option><option value="5">远程抄表系统</option><option value="6">预付费IC卡锁闭阀</option></select></div>';
            break;
        case "2":
            content += '<option value="0">通断法</option><option value="1">流温法</option><option value="2" selected="selected">温度面积法</option><option value="3">热表法</option><option value="4">温度采集系统</option><option value="5">远程抄表系统</option><option value="6">预付费IC卡锁闭阀</option></select></div>';
            break;
        case "3":
            content += '<option value="0">通断法</option><option value="1">流温法</option><option value="2">温度面积法</option><option value="3" selected="selected">热表法</option><option value="4">温度采集系统</option><option value="5">远程抄表系统</option><option value="6">预付费IC卡锁闭阀</option></select></div>';
            break;
        case "4":
            content += '<option value="0">通断法</option><option value="1">流温法</option><option value="2">温度面积法</option><option value="3">热表法</option><option value="4" selected="selected">温度采集系统</option><option value="5">远程抄表系统</option><option value="6">预付费IC卡锁闭阀</option></select></div>';
            break;
        case "5":
            content += '<option value="0">通断法</option><option value="1">流温法</option><option value="2">温度面积法</option><option value="3">热表法</option><option value="4">温度采集系统</option><option value="5" selected="selected">远程抄表系统</option><option value="6">预付费IC卡锁闭阀</option></select></div>';
            break;
        default:
            content += '<option value="0">通断法</option><option value="1">流温法</option><option value="2">温度面积法</option><option value="3">热表法</option><option value="4">温度采集系统</option><option value="5">远程抄表系统</option><option value="6" selected="selected">预付费IC卡锁闭阀</option></select></div>';
        }
        content += '<div class="form-inline"><span class="addon">总高度</span><input value="' + item_json.HEIGHT + '" type="text" class="input" name="HEIGHT" size="20" /><span class="addon">总层数</span><input value="' + item_json.TOTAL_FLOORS + '" type="text" class="input" name="TOTAL_FLOORS" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">住宅数</span><input value="' + item_json.TOTAL_HOUSE + '" type="text" class="input" name="TOTAL_HOUSE" size="20" /><span class="addon">单元数</span><input value="' + item_json.TOTAL_UNITS + '" type="text" class="input" name="TOTAL_UNITS" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">每层每单元房间数</span><input value="' + item_json.TOTAL_FU_HOUSE + '" type="text" class="input" name="TOTAL_FU_HOUSE" size="20" /><span class="addon">配置ID</span><input value="' + item_json.CONFIG_ID + '" type="text" class="input" name="CONFIG_ID" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">备注</span><input value="' + item_json.NOTES + '" type="text" class="input" name="NOTES" size="20" /></div></form>';
        layer.open({
            title: '修改楼栋信息',
    		content: content,
    		area: 'auto',
            maxWidth: 500,
    		btn: ['确定', '取消'],
    		yes: function(index, layero){
    		    $('#update_form').submit();
    		    layer.close(index);
    		    layer.msg('修改成功');   
    		},
    		btn2: function(index, layero){
    		    return false;
    		}
    	});
    }

    //删除
    function del(id){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/building/del");?>' +'" method="post">'
            + '<input type="hidden" name="building_no" value="' + id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加
    function add(){
        var village = JSON.parse(village_info);
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/building/add");?>' + '" method="post" class="form-small">'
            + '<div class="form-inline"><span class="addon">楼栋名称</span><input type="text" class="input" name="BUILDING_NAME" size="20" /><span class="addon">小区名称</span><select class="input" name="VILLAGE_NO">';
        $.each(village, function(k, v){
            content += '<option value="' + v.VILLAGE_NO + '">' + v.VILLAGE_NAME + '</option>';
        });
        content += '</select></div><div class="form-inline"><span class="addon">建筑类型</span><select class="input" name="BUILDING_TYPE"><option value="1">塔楼</option><option value="2">板楼</option><option value="9">其他</option></select>'
            + '<span class="addon">结构类型</span><select class="input" name="STRUCT_TYPE"><option value="1">砖混</option><option value="2">现浇剪力墙</option><option value="3">框架结构</option><option value="9">其他</option></select></div>'
            + '<div class="form-inline"><span class="addon">使用类型</span><select class="input" name="USE_TYPE"><option value="1">普通住宅</option><option value="2">公寓</option><option value="3">别墅</option><option value="4">商用</option><option value="9">其他</option></select>'
            + '<span class="addon">计量方法</span><select class="input" name="METHODS"><option value="0">通断法</option><option value="1">流温法</option><option value="2">温度面积法</option><option value="3">热表法</option><option value="4">温度采集系统</option><option value="5">远程抄表系统</option><option value="6">预付费IC卡锁闭阀</option></select></div>'
            + '<div class="form-inline"><span class="addon">总高度</span><input type="text" class="input" name="HEIGHT" size="20" /><span class="addon">总层数</span><input type="text" class="input" name="TOTAL_FLOORS" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">住宅数</span><input type="text" class="input" name="TOTAL_HOUSE" size="20" /><span class="addon">单元数</span><input type="text" class="input" name="TOTAL_UNITS" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">每层每单元房间数</span><input type="text" class="input" name="TOTAL_FU_HOUSE" size="20" /><span class="addon">配置ID</span><input type="text" class="input" name="CONFIG_ID" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">备注</span><input type="text" class="input" name="NOTES" size="20" /></div></form>';
        layer.open({
            title: '添加楼栋信息',
            content: content,
            area: 'auto',
            maxWidth: 500,
            btn: ['确定', '取消'],
            yes: function(index, layero){
                $('#add_form').submit();
                layer.close(index);
                layer.msg('添加成功');
            },
            btn2: function(index, layero){
                return false;
            }
        });
    }
	</script>
</body>
</html>