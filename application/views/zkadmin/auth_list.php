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
			<strong class="icon-reorder"> 权限列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<div class="padding border-bottom">
			<ul class="search">
				<li style="float: left;">
					<button class="button border-main icon-plus" onclick="add_root();">添加目录</button>
				</li>
				<li style="float: left;">
					<button class="button border-main icon-plus" onclick="add_url();">添加权限</button>
				</li>
    			<form action="<?php echo site_url("zkadmin/auth/index");?>"
    				class="form-horizontal" method="get">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按权限名进行搜索" name="keywords" class="input"
					style="width: 250px; line-height: 17px; display: inline-block" />
					<button type="submit" class="button border-main icon-search">搜索</button>
				</li>
    			</form>
			</ul>
		</div>
		<script type="text/javascript">
		var parent = '<?php echo json_encode($parent_auths)?>';
		</script>
		<table class="table table-hover text-center">
			<tr>
				<th>权限名</th>
				<th>指向路径</th>
				<th>级别</th>
				<th>类型</th>
				<th>父权限</th>
				<th>操作</th>
			</tr>
			<tbody>
            <?php foreach($list as $item){ ?>
            <tr>
				<td><?php echo $item["name"]; ?></td>
				<td><?php echo $item['url'];?></td>
				<td>
				    <?php 
				    switch ($item["type"]){
				        case 0: echo '普通';break;
				        default: echo '高级';
				    }
				    ?>
			    </td>
				<td>
				    <?php 
				    if($item['parent_id'] == 0){
				        echo '目录';
				    }else{
				        echo '路径权限';
				    }
				    ?>
			    </td>
				<td>
				    <?php foreach ($parent_auths as $parent_auth) { 
				            if($parent_auth['id'] == $item['parent_id']){
				                echo $parent_auth['name'];
				            }
				    }?>
			    </td>
				<td>
					<div class="button-group">
						<button class="button border-main" onclick="update_auth('<?php echo $item['id']?>', '<?php echo $item['name']?>', '<?php echo $item['url']?>', '<?php echo $item['type']?>', '<?php echo $item['parent_id']?>', '<?php echo $item['icon']?>');"><span class="icon-edit"></span> 修改</button>
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
							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/auth/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
							aria-label="Previous">上一页</a>
                  <?php echo $page_links; ?>
                  <a
							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/auth/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
							aria-label="Next">下一页</a>
                <?php } ?>
            </div>
				</td>
			</tr>
		</table>
	</div>
	<script type="text/javascript">
	//修改权限
    function update_auth(id, name, url, type, parent_id, icon){
        var content = '<form id="auth_up_form' + id + '" action="' + '<?php echo site_url("zkadmin/auth/update_auth");?>' + '" method="post" class="form-x">'
            +'<input type="hidden" name="id" value="' + id + '">';
        if(parent_id == 0){
            content += '<div class="input-group"><span class="addon">权限名</span><input type="text" class="input" value="' + name +'" name="name" size="20" placeholder="权限名" /></div><br>'
                + '<div class="input-group"><span class="addon">图标</span><input type="text" class="input" value="' + icon + '" name="icon" size="20" placeholder="图标,例: icon-user" /></div><br>'
                + '<input type="hidden" name="url" value="' + url + '"><input type="hidden" name="parent_id" value="' + parent_id + '">';
            if(type == 0){
                content += '<label><input name="type" value="0" type="radio" checked="checked">普通</label><br>'
                    + '<label><input name="type" value="1" type="radio">高级</label>';
            }else{
                content += '<label><input name="type" value="0" type="radio">普通</label><br>'
                    + '<label><input name="type" value="1" type="radio" checked="checked">高级</label>';
            }
        }else{
            content += '<div class="input-group"><span class="addon">权限名</span><input type="text" class="input" value="' + name +'" name="name" size="20" placeholder="权限名" /></div><br>'
                + '<div class="input-group"><span class="addon">路径</span><input type="text" class="input" value="' + url + '" name="url" size="20" placeholder="路径" /></div><br>'
                + '<input type="hidden" name="icon" value="' + icon + '">';
            var parent_json = JSON.parse(parent);
            var select = '<select class="input" name="parent_id">';
            $.each(parent_json, function(k, v){
                if(v.id == parent_id){
                	select += '<option value="' + v.id + '" selected="selected">' + v.name + '</option>';
                }else{
                	select += '<option value="' + v.id + '" >' + v.name + '</option>';
                }
            });
            if(type == 0){
                content += select + '<label><input name="type" value="0" type="radio" checked="checked">普通</label><br>'
                    + '<label><input name="type" value="1" type="radio">高级</label>';
            }else{
                content += select + '<label><input name="type" value="0" type="radio">普通</label><br>'
                    + '<label><input name="type" value="1" type="radio" checked="checked">高级</label>';
            }
        }
        content += '</form>';
        layer.open({
            title: '修改权限',
    		content: content,
    		btn: ['确定', '取消'],
    		yes: function(index, layero){
    		    $('#auth_up_form'+id).submit();
    		    layer.msg('修改成功');   
    		},
    		btn2: function(index, layero){
    		    return false;
    		}
    	});
    }

    //删除权限
    function del(id){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/auth/del_auth");?>' +'" method="post">'
            + '<input type="hidden" name="id" value="' + id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加目录
    function add_root(){
        var content = '<form id="add_root_form" action="' + '<?php echo site_url("zkadmin/auth/add_root");?>' + '" method="post" class="form-x">'
            + '<div class="input-group"><span class="addon">权限名</span><input type="text" class="input" name="name" size="20" placeholder="权限名" /></div><br>'
            + '<div class="input-group"><span class="addon">图标</span><input type="text" class="input" name="icon" size="20" placeholder="图标,例: icon-user" /></div><br>'
            + '<label><input name="type" value="0" type="radio" checked="checked">普通</label><br>'
            + '<label><input name="type" value="1" type="radio">高级</label></form>';
        layer.open({
            title: '添加目录权限',
            content: content,
            btn: ['确定', '取消'],
            yes: function(index, layero){
                $('#add_root_form').submit();
                layer.msg('添加成功');
            },
            btn2: function(index, layero){
                return false;
            }
        });
    }

    //添加权限
    function add_url(){
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/auth/add_url");?>' + '" method="post" class="form-x">'
            + '<div class="input-group"><span class="addon">权限名</span><input type="text" class="input" name="name" size="20" placeholder="权限名" /></div><br>'
            + '<div class="input-group"><span class="addon">路径</span><input type="text" class="input" name="url" size="20" placeholder="路径" /></div><br>';
        var parent_json = JSON.parse(parent);
        var select = '<select class="input" name="parent_id">';
        $.each(parent_json, function(k, v){
        	select += '<option value="' + v.id + '" >' + v.name + '</option>';
        });
        content += select + '</select><br><label><input name="type" value="0" type="radio" checked="checked">普通</label><br>'
        + '<label><input name="type" value="1" type="radio">高级</label></form>';
        layer.open({
            title: '添加路径权限',
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