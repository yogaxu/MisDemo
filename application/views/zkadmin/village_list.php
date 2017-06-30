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
			<strong class="icon-reorder"> 小区列表</strong> <a href=""
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
		</script>
		<table class="table table-hover text-center">
			<tr>
				<th>小区编号</th>
				<th>小区名称</th>
				<th>供热负责单位</th>
				<th>物业联系人</th>
				<th>物业联系电话</th>
				<th>操作</th>
			</tr>
			<tbody>
                <?php for($i=0; $i<count($list); $i=$i+1){ ?>
                <tr>
    				<td><?php echo $list[$i]["VILLAGE_NO"]; ?></td>
    				<td><?php echo $list[$i]["VILLAGE_NAME"]?></td>
    				<td><?php echo $list[$i]["THERMAL_COMPANY"]?></td>
    				<td><?php echo $list[$i]["PROPERTY_COMPANY_CONTACT"]; ?></td>
    				<td><?php echo $list[$i]["PROPERTY_COMPANY_TEL"]; ?></td>
    				<td>
    					<div class="button-group">
    						<a class="button border-green" href="<?php echo site_url("zkadmin/village/detail/".$list[$i]['VILLAGE_NO']);?>"><span class="icon-search-plus"></span> 详情</a>
    						<button class="button border-main" onclick="update('<?php echo $i?>');"><span class="icon-edit"></span> 修改</button>
    						<button class="button border-red" onclick="del('<?php echo $list[$i]['VILLAGE_NO']?>');"><span class="icon-times"></span> 删除</button>
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
        							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/village/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
        							aria-label="Previous">上一页</a>
                          <?php echo $page_links; ?>
                          <a
        							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/village/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
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
    	var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/village/update");?>' + '" method="post" class="form-small">'
 	        + '<input type="hidden" value="' + item_json.VILLAGE_NO + '" name="VILLAGE_NO">'
            + '<div class="form-inline"><span class="addon">小区名称</span><input type="text" value="' + item_json.VILLAGE_NAME + '" class="input" name="VILLAGE_NAME" size="20" /><span class="addon">小区面积</span><input type="text" value="' + item_json.VILLAGE_AREA + '" class="input" name="VILLAGE_AREA" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">楼栋总数</span><input type="text" value="' + item_json.TOTAL_BUILDING + '" class="input" name="TOTAL_BUILDING" size="20" /><span class="addon">住宅套数</span><input type="text" value="' + item_json.TOTAL_HOUSE + '" class="input" name="TOTAL_HOUSE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">城市名称</span><input type="text" value="' + item_json.CITY_NAME + '" class="input" name="CITY_NAME" size="20" /><span class="addon">供热责任单位</span><input type="text" value="' + item_json.THERMAL_COMPANY + '" class="input" name="THERMAL_COMPANY" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">物业责任单位</span><input type="text" value="' + item_json.PROPERTY_COMPANY + '" class="input" name="PROPERTY_COMPANY" size="20" /><span class="addon">物业联系人</span><input type="text" value="' + item_json.PROPERTY_COMPANY_CONTACT + '" class="input" name="PROPERTY_COMPANY_CONTACT" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">物业联系电话</span><input type="text" value="' + item_json.PROPERTY_COMPANY_TEL + '" class="input" name="PROPERTY_COMPANY_TEL" size="20" /><span class="addon">小区地址</span><input type="text" value="' + item_json.VILLAGE_ADDRESS + '" class="input" name="VILLAGE_ADDRESS" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">备注</span><input type="text" value="' + item_json.NOTES + '" class="input" name="NOTES" size="20" /></div>';
        content += '</form>';
        layer.open({
            title: '修改小区信息',
    		content: content,
    		area: 'auto',
            maxWidth: 500,
    		btn: ['确定', '取消'],
    		yes: function(index, layero){
    		    $('#update_form').submit();
    		    layer.msg('修改成功');   
    		},
    		btn2: function(index, layero){
    		    return false;
    		}
    	});
    }

    //删除
    function del(id){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/village/del");?>' +'" method="post">'
            + '<input type="hidden" name="village_no" value="' + id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加
    function add(){
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/village/add");?>' + '" method="post" class="form-small">'
            + '<div class="form-inline"><span class="addon">小区名称</span><input type="text" class="input" name="VILLAGE_NAME" size="20" /><span class="addon">小区面积</span><input type="text" class="input" name="VILLAGE_AREA" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">楼栋总数</span><input type="text" class="input" name="TOTAL_BUILDING" size="20" /><span class="addon">住宅套数</span><input type="text" class="input" name="TOTAL_HOUSE" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">城市名称</span><input type="text" class="input" name="CITY_NAME" size="20" /><span class="addon">供热责任单位</span><input type="text" class="input" name="THERMAL_COMPANY" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">物业责任单位</span><input type="text" class="input" name="PROPERTY_COMPANY" size="20" /><span class="addon">物业联系人</span><input type="text" class="input" name="PROPERTY_COMPANY_CONTACT" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">物业联系电话</span><input type="text" class="input" name="PROPERTY_COMPANY_TEL" size="20" /><span class="addon">小区地址</span><input type="text" class="input" name="VILLAGE_ADDRESS" size="20" /></div>'
            + '<div class="form-inline"><span class="addon">备注</span><input type="text" class="input" name="NOTES" size="20" /></div>';
        content += '</form>';
        layer.open({
            title: '添加小区信息',
            content: content,
            area: 'auto',
            maxWidth: 500,
            btn: ['确定', '取消'],
            yes: function(index, layero){
                $('#add_form').submit();
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