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
			<strong class="icon-reorder"> 支付参数</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<script type="text/javascript">
	    var alipay = '<?php echo json_encode($alipay)?>';
	    var wepay = '<?php echo json_encode($wepay)?>';
		</script>
		<div class="padding border-bottom">
		    <br>
			<table class="table table-hover text-center">
			<thead>
			<tr>
			     <td>类型</td>
			     <td>参数</td>
			     <td>操作</td>
			</tr>
			</thead>
			<tr>
			     <td>支付宝设置</td>
			     <td>
			         <?php if(empty($alipay) || strcmp($alipay['partner'], '') == 0 || strcmp($alipay['alikey'], '') == 0){?>
			         <p><span class="tips">未配置</span></p>
			         <?php }else{?>
			         <p><label>合作身份者ID</label><b>：</b><span class="tips"><?php echo $alipay['partner']?></span></p>
			         <p><label>MD5安全密钥</label><b>：</b><span class="tips"><?php echo $alipay['alikey']?></span></p>
			         <?php }?>
		         </td>
		         <td>
		              <div class="button-group">
    			        <?php if(empty($alipay) || strcmp($alipay['partner'], '') == 0 || strcmp($alipay['alikey'], '') == 0){?>
						<button class="button border-main" onclick="add(1);"><span class="icon-plus"></span> 添加</button>
						<?php }else{?>
						<button class="button border-main" onclick="update(1,<?php echo $alipay['id']?>);"><span class="icon-edit"></span> 修改</button>
						<button class="button border-red" onclick="del('<?php echo $alipay['id']?>');"><span class="icon-times"></span> 删除</button>
						<?php }?>
					  </div>
		         </td>
			</tr>
			<tr>
			     <td>微信设置</td>
			     <td>
			         <?php if(empty($wepay) || strcmp($wepay['appid'], '') == 0 || strcmp($wepay['mchid'], '') == 0 || strcmp($wepay['key'], '') == 0 || strcmp($wepay['appsecret'], '') == 0){?>
			         <p><span class="tips">未配置</span></p>
			         <?php }else{?>
			         <p><label>APPID</label><b>：</b><span class="tips"><?php echo $wepay['appid']?></span></p>
			         <p><label>商户号</label><b>：</b><span class="tips"><?php echo $wepay['mchid']?></span></p>
			         <p><label>商户支付密钥</label><b>：</b><span class="tips"><?php echo $wepay['key']?></span></p>
			         <p><label>公众帐号secert</label><b>：</b><span class="tips"><?php echo $wepay['appsecret']?></span></p>
			         <?php }?>
			     </td>
		         <td>
		              <div class="button-group">
    			        <?php if(empty($wepay) || strcmp($wepay['appid'], '') == 0 || strcmp($wepay['mchid'], '') == 0 || strcmp($wepay['key'], '') == 0 || strcmp($wepay['appsecret'], '') == 0){?>
						<button class="button border-main" onclick="add(2);"><span class="icon-plus"></span> 添加</button>
						<?php }else{?>
						<button class="button border-main" onclick="update(2,<?php echo $wepay['id']?>);"><span class="icon-edit"></span> 修改</button>
						<button class="button border-red" onclick="del('<?php echo $wepay['id']?>');"><span class="icon-times"></span> 删除</button>
						<?php }?>
					  </div>
		         </td>
			</tr>
			</table>
		</div>
	</div>
	<script type="text/javascript">
    function add(type){
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/pay_config/add");?>' + '" method="post" class="form-x">';
        var title = '';
        if(type == 1){
            title = '添加支付宝参数';
            content += '<input name="type" value="1" type="hidden">'
                + '<div class="input-group"><span class="addon">合作身份者ID</span><input type="text" class="input" name="partner" size="40"/></div><br>'
                + '<div class="input-group"><span class="addon">MD5安全密钥</span><input type="text" class="input" name="alikey" size="40"/></div>';
        }else{
            title = '添加微信参数';
            content += '<input name="type" value="2" type="hidden">'
                + '<div class="input-group"><span class="addon">APPID</span><input type="text" class="input" name="appid" size="40"/></div><br>'
                + '<div class="input-group"><span class="addon">商户号</span><input type="text" class="input" name="mchid" size="40"/></div><br>'
                + '<div class="input-group"><span class="addon">商户支付密钥</span><input type="text" class="input" name="key" size="40"/></div><br>'
                + '<div class="input-group"><span class="addon">公众号secret</span><input type="text" class="input" name="appsecret" size="40"/></div>';
        }
        content += '</form>';
        layer.open({
            title: title,
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

    
    function update(type, id){
        var alipay_json = JSON.parse(alipay);
        var wepay_json = JSON.parse(wepay);
        var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/pay_config/update");?>' + '" method="post" class="form-x">';
        var title = '';
        if(type == 1){
            title = '修改支付宝参数';
            content += '<input name="type" value="1" type="hidden"><input name="id" value="' + id + '" type="hidden">'
                + '<div class="input-group"><span class="addon">合作身份者ID</span><input value="' + alipay_json.partner + '" type="text" class="input" name="partner" size="40"/></div><br>'
                + '<div class="input-group"><span class="addon">MD5安全密钥</span><input value="' + alipay_json.alikey + '" type="text" class="input" name="alikey" size="40"/></div>';
        }else{
            title = '修改微信参数';
            content += '<input name="type" value="2" type="hidden"><input name="id" value="' + id + '" type="hidden">'
                + '<div class="input-group"><span class="addon">APPID</span><input value="' + wepay_json.appid + '" type="text" class="input" name="appid" size="40"/></div><br>'
                + '<div class="input-group"><span class="addon">商户号</span><input value="' + wepay_json.mchid + '" type="text" class="input" name="mchid" size="40"/></div><br>'
                + '<div class="input-group"><span class="addon">商户支付密钥</span><input value="' + wepay_json.key + '" type="text" class="input" name="key" size="40"/></div><br>'
                + '<div class="input-group"><span class="addon">公众号secret</span><input value="' + wepay_json.appsecret + '" type="text" class="input" name="appsecret" size="40"/></div>';
        }
        content += '</form>';
        layer.open({
            title: title,
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


    function del(id){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/pay_config/del");?>' +'" method="post">'
            + '<input type="hidden" name="id" value="' + id + '"></form>该操作可能导致支付流程异常。<br>确定要删除?';
    	layer.confirm(content,{icon: 3, title:'警告'}, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }
	</script>
</body>
</html>