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
<link rel="stylesheet" href="<?php echo base_url("zeros/css/style.css");?>">
<script src="<?php echo base_url("zeros/js/jquery.js");?>"></script>
<script src="<?php echo base_url("zeros/js/pintuer.js");?>"></script>
<script src="<?php echo base_url("zeros/jeDate/jedate.js");?>"></script>
<script src="<?php echo base_url("zeros/js/layer/layer.js");?>"></script>
</head>
<body>
  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 维修分组列表</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
     <div class="padding border-bottom">
        <li style="float: left;">
			<button class="button border-main icon-plus" onclick="add();">添加</button>
		</li>
		<form action="<?php echo site_url("zkadmin/repair_group/index");?>"
			class="form-horizontal" method="get">
			<ul class="search">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按分组名称查询" name="keywords" class="input"
					style="width: 250px; line-height: 17px; display: inline-block" />
					<button type="submit" class="button border-main icon-search">搜索</button>
				</li>
			</ul>
		</form>
	</div>
    <script type="text/javascript">
    var list = '<?php echo json_encode($list)?>';
    </script>
    <table class="table table-hover text-center">
      <tr>
        <th>维修分组ID</th>
        <th>分组名称</th>
        <th>主管姓名</th>
        <th>主管电话</th>
        <th>所属运营公司名称</th>
        <th>操作</th>
      </tr>
        <tbody>
           <?php for($i=0; $i<count($list); $i=$i+1){ ?>
             <tr id="">
                <td><?php echo $list[$i]["group_id"]; ?></td>
                <td><?php echo $list[$i]["group_name"]; ?></td>
                <td><?php echo $list[$i]["supervisor"]; ?></td>
                <td><?php echo $list[$i]["supervisor_tel"]; ?></td>
                <td><?php echo $list[$i]["company_name"]; ?></td>
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
                  <a href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/repair_group/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>" aria-label="Previous">上一页</a>
                  <?php echo $page_links; ?>
                  <a href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/repair_group/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>" aria-label="Next">下一页</a>
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
	var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/repair_group/update");?>' + '" method="post" class="form-x">'
	    + '<input type="hidden" name="id" value="' + item_json.id + '">'
        + '<div class="input-group"><span class="addon">分组名称</span><input value="' + item_json.group_name + '" type="text" class="input" name="group_name" size="20" placeholder="分组名称" /></div><br>'
        + '<div class="input-group"><span class="addon">主管姓名</span><input value="' + item_json.supervisor + '" type="text" class="input" name="supervisor" size="20" placeholder="主管姓名" /></div><br>'
        + '<div class="input-group"><span class="addon">主管电话</span><input value="' + item_json.supervisor_tel + '" type="text" class="input" name="supervisor_tel" size="20" placeholder="主管电话" /></div><br>'
        + '<div class="input-group"><span class="addon">所属公司</span><input value="' + item_json.company_name + '" type="text" class="input" name="company_name" size="20" placeholder="所属运营公司名称" /></div>';
    layer.open({
        title: '修改维修分组',
        content: content,
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
    var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/repair_group/del");?>' +'" method="post">'
        + '<input type="hidden" name="id" value="' + id + '"></form>确定要删除?';
	layer.confirm(content, function(index){
    	$('#del_form').submit();
	    layer.close(index);
    	layer.msg('删除成功');       
	});
}

//添加
function add(){
    var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/repair_group/add");?>' + '" method="post" class="form-x">'
        + '<div class="input-group"><span class="addon">分组名称</span><input type="text" class="input" name="group_name" size="20" placeholder="分组名称" /></div><br>'
        + '<div class="input-group"><span class="addon">主管姓名</span><input type="text" class="input" name="supervisor" size="20" placeholder="主管姓名" /></div><br>'
        + '<div class="input-group"><span class="addon">主管电话</span><input type="text" class="input" name="supervisor_tel" size="20" placeholder="主管电话" /></div><br>'
        + '<div class="input-group"><span class="addon">所属公司</span><input type="text" class="input" name="company_name" size="20" placeholder="所属运营公司名称" /></div>';
    layer.open({
        title: '添加维修分组',
        content: content,
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