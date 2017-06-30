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
<script src="<?php echo base_url("zeros/jeDate/jedate.js");?>"></script>
</head>
<body>
	<div class="panel admin-panel">
		<div class="panel-head">
			<strong class="icon-reorder"> 用户列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>
		<div class="padding border-bottom">
				<ul class="search">
				    <li style="float: left;">
    					<button class="button border-main icon-plus" onclick="add();">添加</button>
    				</li>
        			<form action="<?php echo site_url("zkadmin/user/index");?>"
        				class="form-horizontal" method="get">
					<li style="float: right; padding-right: 60px;"><input type="text"
						placeholder="按卡号进行搜索" name="keywords" class="input"
						style="width: 250px; line-height: 17px; display: inline-block" />
						<button type="submit" class="button border-main icon-search">搜索</button>
					</li>
        			</form>
				</ul>
		</div>
		<script type="text/javascript">
		var list = '<?php echo json_encode($list)?>';
	    var village_info = '<?php echo json_encode($village_info)?>';
		</script>
		<table class="table table-hover text-center">
			<tr>
				<th>卡号</th>
				<th>用户姓名</th>
				<th>住址</th>
				<th>房间编号</th>
				<th>操作</th>
			</tr>
			<tbody>
            <?php for($i=0; $i<count($list); $i=$i+1){ ?>
            <tr>
				<td><?php echo $list[$i]["METER_ID"]; ?></td>
				<td><?php echo $list[$i]["USER_NAME"]; ?></td>
				<td><?php echo $list[$i]["VILLAGE_NAME"].$list[$i]["BUILDING_NAME"].$list[$i]["ROOM_NAME"]; ?></td>
				<td><?php echo $list[$i]["ROOM_NO"]; ?> </td>
				<td>
					<div class="button-group">
						<a class="button border-green"
							href="<?php echo site_url("zkadmin/user/detail/".$list[$i]['METER_ID']);?>"><span
							class="icon-edit"></span> 详情</a>
						<button class="button border-main" onclick="update('<?php echo $i?>');"><span class="icon-edit"></span> 修改</button>
						<button class="button border-red" onclick="del('<?php echo $list[$i]['VILLAGE_NO']?>','<?php echo $list[$i]['BUILDING_NO']?>','<?php echo $list[$i]['ROOM_NO']?>');"><span class="icon-times"></span> 删除</button>
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
							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/user/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
							aria-label="Previous">上一页</a>
                  <?php echo $page_links; ?>
                  <a
							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/user/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
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
        var content = '<form id="update_form" action="' + '<?php echo site_url("zkadmin/user/update");?>' + '" method="post" class="form-small">'
            + '<input id="meter_id_select_up" type="hidden" name="METER_ID">'
            + '<input value="' + item_json.METER_ID + '" type="hidden" name="OLD_METER_ID">'
            + '<div class="form-inline"><span class="addon">小区</span><select id="village_select_up" name="VILLAGE_NO" class="input">';
        $.each(JSON.parse(village_info), function(k, v){
            if(v.VILLAGE_NO == item_json.VILLAGE_NO){
                content += '<option value="' + v.VILLAGE_NO + '" selected="selected">' + v.VILLAGE_NAME + '</option>';
            }else{
                content += '<option value="' + v.VILLAGE_NO + '">' + v.VILLAGE_NAME + '</option>';
            }
        });
        content += '</select></div><br>'
            + '<div class="form-inline"><span class="addon">楼栋</span><select id="building_select_up" name="BUILDING_NO" class="input"></select></div><br>'
            + '<div class="form-inline"><span class="addon">房间</span><select id="room_select_up" name="ROOM_NO" class="input"><option data-meter="' + item_json.METER_ID + '" value="' + item_json.ROOM_NO + '">' + item_json.ROOM_NAME + '</option></select></div><br>'
            + '<div class="form-inline"><span class="addon">住户姓名</span><input value="' + item_json.USER_NAME + '" type="text" class="input" name="USER_NAME" size="22" /></div><br>'
            + '<div class="form-inline"><span class="addon">身份证号</span><input value="' + item_json.ID_CARD + '" type="text" class="input" name="ID_CARD" size="22" /></div><br>'
            + '<div class="form-inline"><span class="addon">手机号码</span><input value="' + item_json.MOBILE + '" type="text" class="input" name="MOBILE" size="22" /></div><br>'
            + '<div class="form-inline"><span class="addon">电话号码</span><input value="' + item_json.TELEPHONE + '" type="text" class="input" name="TELEPHONE" size="22" /></div><br>'
            + '<div class="form-inline"><span class="addon">原密码</span><input type="password" class="input" name="OLD_PASSWD" size="22" /></div><br>'
            + '<div class="form-inline"><span class="addon">新密码</span><input type="password" class="input" name="PASSWD" size="22" /></div><br>'
            + '<div class="form-inline"><span class="addon">重复密码</span><input type="password" class="input" name="REPASSWD" size="22" /></div><form>';
        layer.open({
            title: '修改用户信息',
            content: content,
            area: 'auto',
            maxWidth: 300,
            zIndex: 100,
            btn: ['确定', '取消'],
            yes: function(index, layero){
                var form_data = $('#update_form').serialize();
                $.ajax({
                	url: '<?php echo site_url("zkadmin/user/update");?>',
                    type:'POST',
                    data:form_data,  
                    dataType:'json',  
                    success:function(data){
                        layer.close(index);
                        if(data.ret == 'succ'){
                            layer.alert('修改成功<br>此用户卡号为: ' + data.msg, function(index){
                                window.location.href = '../zkadmin/user';
                            });
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            },
            btn2: function(index, layero){
                return false;
            },
            success: function(index, layero){
            	function get_buildings(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/user/get_buildings");?>',
                        type:'POST',
                        data:{  
                            village_no: $('#village_select_up').val()  
                        },  
                        dataType:'json',  
                        success:function(data){
                            var options = '';
                            $.each(data, function(k, v){
                                options += '<option value="' + v.BUILDING_NO + '">' + v.BUILDING_NAME +'</option>'; 
                            });
                            $('#building_select_up').html(options);
                            get_rooms();
                        }
                    });
                };
                get_buildings();
                $('#village_select_up').change(function(){
                    get_buildings();
                });
    
                function get_rooms(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/user/get_rooms");?>',
                        type:'POST',
                        data:{  
                            building_no: $('#building_select_up').val()  
                        },  
                        dataType:'json',  
                        success:function(data){
                            var options = '';
                            $.each(data, function(k, v){
                                options += '<option data-meter="' + v.METER_ID + '" value="' + v.ROOM_NO + '">' + v.ROOM_NAME +'</option>'; 
                            });
                            if($('#room_select_up')[0].options.length == 1){
                                $('#room_select_up').append(options);
                            }else{
                                $('#room_select_up').html(options);
                            }
                            get_meter_id();
                        }
                    });
                };
                $('#building_select_up').change(function(){
                    get_rooms();
                });
    
                function get_meter_id(){
                    var meter_id = $('#room_select_up option:selected').data('meter');
                    $('#meter_id_select_up').val(meter_id);
                }
                $('#room_select_up').change(function(){
                	get_meter_id();
                });
            }
        });
    }

    //删除
    function del(vid,bid,rid){
        var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/user/del");?>' +'" method="post">'
            + '<input type="hidden" name="vid" value="' + vid + '"><input type="hidden" name="bid" value="' + bid + '"><input type="hidden" name="rid" value="' + rid + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
  		});
    }

    //添加
    function add(){
        var content = '<form id="add_form" action="' + '<?php echo site_url("zkadmin/user/add");?>' + '" method="post" class="form-small">'
            + '<input id="meter_id_select" type="hidden" name="METER_ID">'
            + '<div class="form-inline"><span class="addon">小区</span><select id="village_select" name="VILLAGE_NO" class="input">';
        $.each(JSON.parse(village_info), function(k, v){
            content += '<option value="' + v.VILLAGE_NO + '">' + v.VILLAGE_NAME + '</option>';
        });
        content += '</select></div><br>'
            + '<div class="form-inline"><span class="addon">楼栋</span><select id="building_select" name="BUILDING_NO" class="input"></select></div><br>'
            + '<div class="form-inline"><span class="addon">房间</span><select id="room_select" name="ROOM_NO" class="input"></select></div><br>'
            + '<div class="form-inline"><span class="addon">住户姓名</span><input type="text" class="input" name="USER_NAME" size="22" /></div><br>'
            + '<div class="form-inline"><span class="addon">身份证号</span><input type="text" class="input" name="ID_CARD" size="22" /></div><br>'
            + '<div class="form-inline"><span class="addon">手机号码</span><input type="text" class="input" name="MOBILE" size="22" /></div><br>'
            + '<div class="form-inline"><span class="addon">电话号码</span><input type="text" class="input" name="TELEPHONE" size="22" /></div><br>'
            + '<div class="form-inline"><span class="addon">初始密码</span><input type="password" class="input" name="PASSWD" size="22" /></div>'
            + '<div class="form-inline"><span class="addon">重复密码</span><input type="password" class="input" name="REPASSWD" size="22" /></div><form>';
        layer.open({
            title: '添加用户信息',
            content: content,
            area: 'auto',
            maxWidth: 300,
            zIndex: 100,
            btn: ['确定', '取消'],
            yes: function(index, layero){
                var form_data = $('#add_form').serialize();
                $.ajax({
                	url: '<?php echo site_url("zkadmin/user/add");?>',
                    type:'POST',
                    data:form_data,  
                    dataType:'json',  
                    success:function(data){
                        layer.close(index);
                        if(data.ret == 'succ'){
                            layer.alert('添加成功<br>此用户卡号为: ' + data.msg, function(index){
                                window.location.href = '../zkadmin/user';
                            });
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            },
            btn2: function(index, layero){
                return false;
            },
            success: function(index, layero){
            	function get_buildings(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/user/get_buildings");?>',
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
                            get_rooms();
                        }
                    });
                };
                get_buildings();
                $('#village_select').change(function(){
                    get_buildings();
                });

                function get_rooms(){
                	$.ajax({
                        url: '<?php echo site_url("zkadmin/user/get_rooms");?>',
                        type:'POST',
                        data:{  
                            building_no: $('#building_select').val()  
                        },  
                        dataType:'json',  
                        success:function(data){
                            var options = '';
                            $.each(data, function(k, v){
                                options += '<option data-meter="' + v.METER_ID + '" value="' + v.ROOM_NO + '">' + v.ROOM_NAME +'</option>'; 
                            });
                            $('#room_select').html(options);
                            get_meter_id();
                        }
                    });
                };
                $('#building_select').change(function(){
                    get_rooms();
                });

                function get_meter_id(){
                    var meter_id = $('#room_select option:selected').data('meter');
                    $('#meter_id_select').val(meter_id);
                }
                $('#room_select').change(function(){
                	get_meter_id();
                });
            }
        });
    }
	</script>
</body>
</html>