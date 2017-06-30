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
			<strong class="icon-reorder"> 角色列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<div class="padding border-bottom">
			<ul class="search">
				<li style="float: left;">
					<button class="button border-main icon-plus" onclick="add();">创建角色</button>
				</li>
    			<form action="<?php echo site_url("zkadmin/role/index");?>"
    				class="form-horizontal" method="get">
				<li style="float: right; padding-right: 60px;"><input type="text"
					placeholder="按角色名进行搜索" name="keywords" class="input"
					style="width: 250px; line-height: 17px; display: inline-block" />
					<button type="submit" class="button border-main icon-search">搜索</button>
				</li>
    			</form>
			</ul>
		</div>
		<script type="text/javascript">
		var auths = '<?php echo json_encode($auths);?>';
		</script>
		<table class="table table-hover text-center">
			<tr>
				<th>角色名</th>
				<th>权限</th>
				<th>操作</th>
			</tr>
			<tbody>
            <?php foreach($list as $item){ ?>
            <tr>
				<td><?php echo $item["name"]; ?></td>
				<td>
				<?php $auth_name = '';
				      $auth_array = explode('_', $item['auth']);
				      foreach ($auth_array as $auth){
				          foreach ($auths as $ai){
				              if($auth == $ai['id']){
				                  $auth_name = $auth_name.$ai['name'].'|';
				              }
				          }
				      }
				      echo mb_substr($auth_name, 0, mb_strlen($auth_name)-1);
		        ?>
				</td>
				<td>
					<div class="button-group">
						<button class="button border-main" onclick="update_auth('<?php echo $item['id']?>','<?php echo $item['auth']?>');"><span class="icon-edit"></span> 权限</button>
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
							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/role/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
							aria-label="Previous">上一页</a>
                  <?php echo $page_links; ?>
                  <a
							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/role/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
							aria-label="Next">下一页</a>
                <?php } ?>
            </div>
				</td>
			</tr>
		</table>
	</div>
	<script type="text/javascript">
	//更新权限
    function update_auth(id, auth){
        var content = '<form id="role_form' + id + '" action="' + '<?php echo site_url("zkadmin/role/update_auth");?>' + '" method="post">'
            +'<input type="hidden" name="id" value="' + id + '"';
        var auth_json = JSON.parse(auths);
        var auth_pre = auth.split('_');
        $.each(auth_json, function(k, v){
            var flag = true;
            $.each(auth_pre, function(kk, vv){
                if(vv == v.id){
                    content += '<label><input name="auth[]" value="' + v.id + '" type="checkbox" checked="checked">' + v.name + '</label><br>';
                    flag = false;
                    return false;
                }
            });
            if(flag){
                content += '<label><input name="auth[]" value="' + v.id + '" type="checkbox">' + v.name + '</label><br>';
            }
        });
        content += '</form>';
        layer.open({
            title: '分配权限',
    		content: content,
    		btn: ['确定', '取消'],
    		yes: function(index, layero){
    		    $('#role_form'+id).submit();
    		    layer.msg('权限分配完成');   
    		},
    		btn2: function(index, layero){
    		    return false;
    		}
    	});
    }

    //删除角色
    function del(id){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/role/del_role");?>' +'" method="post">'
            + '<input type="hidden" name="id" value="' + id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加角色
    function add(){
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/role/add_role");?>' + '" method="post" class="form-x">'
            + '<div class="input-group"><span class="addon icon-user"></span><input type="text" class="input" name="name" size="20" placeholder="角色名" /></div><br>';
        var auth_json = JSON.parse(auths);
        $.each(auth_json, function(k, v){
        	content += '<label><input name="auth[]" value="' + v.id + '" type="checkbox">' + v.name + '</label><br>';
        });
        content += '</form>';
        layer.open({
            title: '添加角色',
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