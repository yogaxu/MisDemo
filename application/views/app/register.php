
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, 			minimum-scale=1.0, user-scalable=no, width=device-width">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>注册</title>
		<link href="<?php echo base_url("zeros/app/css/common.css"); ?>" type="text/css" rel="stylesheet" />
		<link href="<?php echo base_url("zeros/app/css/css.css"); ?>" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery-1.9.0.min.js");?>"></script>
	</head>
	<body>
		<div class="container">
			<div class="register-box">
				<div class="reg-box">
					<form action="<?php echo site_url("mapp/register/save");?>" method="post">
						<div class="in-group">
							<img src="<?php echo base_url("zeros/app/images/icon-30.png"); ?>" />
							<select name="dict">
                                <option>请选择城市</option><?php foreach($dicts as $dict){?>
                                    <option value="<?php echo $dict['id']; ?>"><?php echo $dict['name']; ?></option>
                                <?php } ?>
                            </select>
						</div>
						<div class="in-group">
							<img src="<?php echo base_url("zeros/app/images/icon-4.png"); ?>" />
							<select name="village" id="register_village_select">
                                <option>请选择小区</option>
                                <?php foreach($villages as $village){ ?>
                                    <option value="<?php echo $village['VILLAGE_NO']; ?>"><?php echo $village['VILLAGE_NAME']; ?></option>
                                <?php } ?>
                            </select>
						</div>
						<div class="in-group">
							<img src="<?php echo base_url("zeros/app/images/icon-5.png"); ?>" />
							<select name="building" id="register_building_select">
                            </select>
						</div>
						<div class="in-group">
							<img src="<?php echo base_url("zeros/app/images/icon-6.png"); ?>" />
							<select name="room" id="register_room_select">
                            </select>
						</div>
						<div class="in-group">
							<img src="<?php echo base_url("zeros/app/images/icon-7.png"); ?>" />
							<input name="meter" type="text" placeholder="请输入卡号/输入设备号"/>
						</div>
						<div class="in-group">
							<img src="<?php echo base_url("zeros/app/images/icon-8.png"); ?>" />
							<input name="password" type="password" placeholder="请输入密码"/>
						</div>
						<div class="in-group">
							<img src="<?php echo base_url("zeros/app/images/icon-8.png"); ?>" />
							<input name="com_password" type="password" placeholder="请再次输入密码" />
						</div>
						<div class="in-group">
							<input type="submit" value="注册" />
						</div>
						<div class="in-group">
							<input name="read" type="checkbox"/><label>我阅读，并同意<a href="">《使用条款和隐私政策》</a></label>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript">
        function get_buildings(){
        	$.ajax({
                url: '<?php echo site_url("mapp/register/get_buildings");?>',
                type:'POST',
                data:{  
                    village_no: $('#register_village_select').val()  
                },  
                dataType:'json',  
                success:function(data){
                    var options = '<option>请选择楼号</option>';
                    $.each(data, function(k, v){
                        options += '<option value="' + v.BUILDING_NO + '">' + v.BUILDING_NAME +'</option>'; 
                    });
                    $('#register_building_select').html(options);
                    get_rooms();
                }
            });
        };
        get_buildings();
        $('#register_village_select').change(function(){
            get_buildings();
        });
    
        function get_rooms(){
        	$.ajax({
                url: '<?php echo site_url("mapp/register/get_rooms");?>',
                type:'POST',
                data:{  
                    building_no: $('#register_building_select').val()  
                },  
                dataType:'json',  
                success:function(data){
                    var options = '<option>请选择门牌号</option>';
                    $.each(data, function(k, v){
                        options += '<option value="' + v.ROOM_NO + '">' + v.ROOM_NAME +'</option>'; 
                    });
                    $('#register_room_select').html(options);
                }
            });
        };
        $('#register_building_select').change(function(){
            get_rooms();
        });
        </script>
	</body>
</html>
