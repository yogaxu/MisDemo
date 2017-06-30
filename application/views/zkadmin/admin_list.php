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
<script src="<?php echo base_url("zeros/js/jquery.js");?>"></script>
<script src="<?php echo base_url("zeros/js/pintuer.js");?>"></script>
<script src="<?php echo base_url("zeros/js/layer/layer.js");?>"></script>
</head>
<body>
	<div class="panel admin-panel">
		<div class="panel-head">
			<strong class="icon-reorder"> 管理员列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<div class="padding border-bottom">
			<ul class="search">
				<li style="float: left;">
					<button class="button border-main icon-plus" onclick="add();">添加账号</button>
				</li>
    			<form action="<?php echo site_url("zkadmin/admin/index");?>"
    				class="form-horizontal" method="get">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按用户名进行搜索" name="keywords" class="input"
					style="width: 250px; line-height: 17px; display: inline-block" />
					<button type="submit" class="button border-main icon-search">搜索</button>
				</li>
    			</form>
			</ul>
		</div>
		<script type="text/javascript">
	    var roles = '<?php echo json_encode($roles);?>';
		</script>
		<table class="table table-hover text-center">
			<tr>
				<th>用户名</th>
				<th>角色</th>
				<th>状态</th>
				<th>注册时间</th>
				<th>操作</th>
			</tr>
			<tbody>
            <?php foreach($list as $item){ ?>
            <tr>
				<td><?php echo $item["username"]; ?></td>
				<td>
				<?php foreach ($roles as $role) {
				        if($role['id'] == $item['role_id']){
				            echo $role['name'];
				        }
				}?>
				</td>
				<td>
				    <?php 
				    switch ($item["status"]){
				        case 0: echo '已启用';break;
				        default: echo '已禁用';
				    }
				    ?>
			    </td>
				<td><?php echo $item["reg_time"]; ?></td>
				
				<td>
					<div class="button-group">
						<button class="button border-main" onclick="update_role('<?php echo $item['id']?>', '<?php echo $item['role_id']?>');"><span class="icon-edit"></span> 角色</button>
						<button class="button border-red" onclick="del('<?php echo $item['id']?>');"><span class="icon-times"></span> 删除</button>
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
							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/admin/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
							aria-label="Previous">上一页</a>
                  <?php echo $page_links; ?>
                  <a
							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/admin/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
							aria-label="Next">下一页</a>
                <?php } ?>
            </div>
				</td>
			</tr>
		</table>
	</div>
	<script type="text/javascript">
	//更新角色
    function update_role(id, role_id){
        var content = '<form id="role_form' + id + '" action="' + '<?php echo site_url("zkadmin/admin/update_role");?>' + '" method="post">'
            +'<input type="hidden" name="id" value="' + id + '"';
        var role_json = JSON.parse(roles);
        $.each(role_json, function(k, v){
            if(role_id == v.id){
                content += '<label><input name="role_id" value="' + v.id + '" type="radio" checked="checked">' + v.name + '</label>';
            }else{
                content += '<label><input name="role_id" value="' + v.id + '" type="radio">' + v.name + '</label>';
            }
        });
        content += '</form>';
        layer.open({
            title: '分配角色',
    		content: content,
    		btn: ['确定', '取消'],
    		yes: function(index, layero){
    		    $('#role_form'+id).submit();
    		    layer.msg('角色分配完成');   
    		},
    		btn2: function(index, layero){
    		    return false;
    		}
    	});
    }

    //删除账号
    function del(id){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/admin/del_admin");?>' +'" method="post">'
            + '<input type="hidden" name="id" value="' + id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加账号
    function add(){
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/admin/add_admin");?>' + '" method="post" class="form-x">'
            + '<div class="input-group"><span class="addon icon-user"></span><input type="text" class="input" name="username" size="20" placeholder="用户名" /></div><br>'
            + '<div class="input-group"><span class="addon icon-key"></span><input type="text" class="input" name="password" size="20" placeholder="密码" /></div><br>';
        var role_json = JSON.parse(roles);
        $.each(role_json, function(k, v){
        	content += '<label><input name="role_id" value="' + v.id + '" type="radio">' + v.name + '</label><br>';
        });
        content += '</form>';
        layer.open({
            title: '添加管理员账号',
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