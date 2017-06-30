<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="<?php echo base_url("zeros/css/pintuer.css");?>">
<link rel="stylesheet" href="<?php echo base_url("zeros/css/admin.css");?>">
<script src="<?php echo base_url("zeros/js/jquery.js");?>"></script>
<script src="<?php echo base_url("zeros/js/pintuer.js");?>"></script>
<script src="<?php echo base_url("zeros/js/layer/layer.js");?>"></script>
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 维修员列表</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    <div class="padding border-bottom">
        <li style="float: left;">
			<button class="button border-main icon-plus" onclick="add();">添加</button>
		</li>
		<form action="<?php echo site_url("zkadmin/repairer/index");?>"
			class="form-horizontal" method="get">
			<ul class="search">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按维修员姓名查询" name="keywords" class="input"
					style="width: 250px; line-height: 17px; display: inline-block" />
					<button type="submit" class="button border-main icon-search">搜索</button>
				</li>
			</ul>
		</form>
	</div>
    <script type="text/javascript">
    var villages = '<?php echo json_encode($villages)?>';
    var repair_groups = '<?php echo json_encode($repair_group)?>';
    var list = '<?php echo json_encode($list)?>';
    </script>
    <table class="table table-hover text-center">
        <tr>
            <th>维修员ID</th>
            <th>姓名</th>
            <th>电话号码</th>
            <th>负责小区</th>
            <th>负责楼栋</th>
            <th>维修分组名称</th>
            <th>操作</th>
        </tr>
        <tbody>
            <?php for($i=0; $i<count($list); $i=$i+1){ ?>
            <tr>
                <td><?php echo $list[$i]["repairman_id"]; ?></td>
                <td><?php echo $list[$i]["repairman"]; ?></td>
                <td><?php echo $list[$i]["repairman_tel"]; ?></td>
                <td><?php echo $list[$i]["village_name"]; ?></td>
                <td><?php echo $list[$i]["building_name"]; ?></td>
                <td><?php echo $list[$i]["group_name"]; ?></td>
                <td>
                    <div class="button-group">
						<button class="button border-main" onclick="update('<?php echo $i?>');"><span class="icon-edit"></span> 修改</button>
						<button class="button border-red" onclick="del('<?php echo $list[$i]['id']?>');"><span class="icon-times"></span> 删除</button>
					</div>
                </td>
            </tr>
            <?php } ?>
        </tbody>  
        <tr>
            <td colspan="8">
                <div class="pagelist"> 
                    <?php if($page > 1){?>
                    <span   style=margin-left:25px>共有<?php echo $start; ?>记录，共<?php echo $page; ?>页</span>
                    <a href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/repairer/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>" aria-label="Previous">上一页</a>
                    <?php echo $page_links; ?>
                    <a href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/repairer/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>" aria-label="Next">下一页</a>
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
	var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/repairer/update");?>' + '" method="post" class="form-x">'
	    + '<input type="hidden" name="id" value="' + item_json.id + '">'
        + '<div class="input-group"><span class="addon">姓名</span><input value="' + item_json.repairman +'" type="text" class="input" name="repairman" size="20" placeholder="维修员姓名" /></div><br>'
        + '<div class="input-group"><span class="addon">电话</span><input value="' + item_json.repairman_tel +'" type="text" class="input" name="repairman_tel" size="20" placeholder="维修员电话" /></div><br>'
        + '<div class="input-group"><span class="addon">小区</span><select name="village_no" class="input" id="village_select_up">';
    var village_json = JSON.parse(villages);
    $.each(village_json, function(k, v){
        if(v.VILLAGE_NO == item_json.village_no){
        	content += '<option value="' + v.VILLAGE_NO +'" selected="selected">' + v.VILLAGE_NAME +'</option>';
        }else{
        	content += '<option value="' + v.VILLAGE_NO +'">' + v.VILLAGE_NAME +'</option>';
        }
    });
    content += '</select></div><br><div class="input-group"><span class="addon">楼栋</span><select name="building_no" class="input" id="building_select_up"></select></div><br>'
        + '<div class="input-group"><span class="addon">分组</span><select name="group_id" id="group_select_up" class="input">';
    var group_json = JSON.parse(repair_groups);
    $.each(group_json, function(k, v){
        if(v.id == item_json.group_id){
            content += '<option value="' + v.id + '" selected="selected">' + v.group_name +'</option>';
        }else{
            content += '<option value="' + v.id + '">' + v.group_name +'</option>';
        }
    });
    content += '</select></div></form>';
    layer.open({
        title: '修改维修员',
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
                    url: '<?php echo site_url("zkadmin/repairer/get_buildings");?>',
                    type:'POST',
                    data:{  
                        village_no: $('#village_select_up').val()  
                    },  
                    dataType:'json',  
                    success:function(data){
                        var options = '';
                        $.each(data, function(k, v){
                            if(v.BUILDING_NO == item_json.building_no){
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
        }
    });
}

//删除
function del(id){
    var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/repairer/del");?>' +'" method="post">'
        + '<input type="hidden" name="id" value="' + id + '"></form>确定要删除?';
	layer.confirm(content, function(index){
    	$('#del_form').submit();
	    layer.close(index);
    	layer.msg('删除成功');       
	});
}

//添加
function add(){
    var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/repairer/add");?>' + '" method="post" class="form-x">'
        + '<div class="input-group"><span class="addon">姓名</span><input type="text" class="input" name="repairman" size="20" placeholder="维修员姓名" /></div><br>'
        + '<div class="input-group"><span class="addon">电话</span><input type="text" class="input" name="repairman_tel" size="20" placeholder="维修员电话" /></div><br>'
        + '<div class="input-group"><span class="addon">小区</span><select name="village_no" class="input" id="village_select">';
    var village_json = JSON.parse(villages);
    $.each(village_json, function(k, v){
    	content += '<option value="' + v.VILLAGE_NO +'">' + v.VILLAGE_NAME +'</option>';
    });
    content += '</select></div><br><div class="input-group"><span class="addon">楼栋</span><select name="building_no" class="input" id="building_select"></select></div><br>'
        + '<div class="input-group"><span class="addon">分组</span><select name="group_id" id="group_select" class="input">';
    var group_json = JSON.parse(repair_groups);
    $.each(group_json, function(k, v){
        content += '<option value="' + v.id + '">' + v.group_name +'</option>';
    });
    content += '</select></div></form>';
    layer.open({
        title: '添加维修员',
        content: content,
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
                    url: '<?php echo site_url("zkadmin/repairer/get_buildings");?>',
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
        }
    });
}
</script>
</body>
</html>