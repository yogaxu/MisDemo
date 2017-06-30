<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, 			minimum-scale=1.0, user-scalable=no, width=device-width">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>登录</title>
        <link href="<?php echo base_url("zeros/app/css/common.css"); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url("zeros/app/css/css.css"); ?>" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery-1.9.0.min.js");?>"></script>
		<script type="text/javascript" src="<?php echo base_url("zeros/app/js/login.js");?>"></script>
		<script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery.toggle-password.js");?>"></script>
		<script type="text/javascript">
		</script>
	</head>
	<body>
    <form action="<?php echo site_url("mapp/login/check");?>" method="post">
		<div class="container">
			<div class="login-box">
				<div class="logo-box">
					<img src="<?php echo base_url("zeros/app/images/logo.png");?>" style="height: 10em"/>
				</div>
				<div class="input-box">
                    <div class="input-group adress-box">
							<img src="<?php echo base_url("zeros/app/images/icon-3.png");?>"/>
							<input type="text" class="adress" />
                    </div>
                    <div class="input-group password-box">
							<img src="<?php echo base_url("zeros/app/images/icon-31.png");?>" />
							<input name="password" type="password" class="password" placeholder="密 码"/>
						</div>
                    <div class="input-group">
							<input name="remember" type="checkbox"/><label>记住密码</label>
						</div>
                    <div class="input-group">
							<input type="submit" value="登录" />
						</div>
                    <div class="input-group">
							<div class="link">
								<a href="forget.html">找回密码</a><span>|</span><a href="register.html">账号注册</a>
							</div>
						</div>
				</div>
			</div>
		</div>
		<div class="reg-bg">
			<div class="login-choice">
				<div class="group">
					<label>
                        <select class="city" name="dict" id="login_city_select">
                            <option>请选择城市</option><?php foreach($dicts as $dict){?>
                                <option value="<?php echo $dict['id']; ?>"><?php echo $dict['name']; ?></option>
                            <?php } ?>
                        </select>
                    </label>
				</div>
				<div class="group">
					<label>
                        <select class="village" name="village" id="login_village_select">
                            <option>请选择小区</option>
                            <?php foreach($villages as $village){ ?>
                                <option value="<?php echo $village['VILLAGE_NO']; ?>"><?php echo $village['VILLAGE_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </label>
				</div>
				<div class="group">
					<label>
                        <select class="build" name="building" id="login_building_select">
                        </select>
                    </label>
				</div>
				<div class="group">
					<label>
                        <select class="number" name="room" id="login_room_select">
                        </select>
                    </label>
				</div>
				<div class="group">
					<p>确定</p>
				</div>
			</div>
		</div>
    </form>
    <script type="text/javascript">
    function get_buildings(){
    	$.ajax({
            url: '<?php echo site_url("mapp/login/get_buildings");?>',
            type:'POST',
            data:{  
                village_no: $('#login_village_select').val()  
            },  
            dataType:'json',  
            success:function(data){
                var options = '<option>请选择楼号</option>';
                $.each(data, function(k, v){
                    options += '<option value="' + v.BUILDING_NO + '">' + v.BUILDING_NAME +'</option>'; 
                });
                $('#login_building_select').html(options);
                get_rooms();
            }
        });
    };
    get_buildings();
    $('#login_village_select').change(function(){
        get_buildings();
    });

    function get_rooms(){
    	$.ajax({
            url: '<?php echo site_url("mapp/login/get_rooms");?>',
            type:'POST',
            data:{  
                building_no: $('#login_building_select').val()  
            },  
            dataType:'json',  
            success:function(data){
                var options = '<option>请选择门牌号</option>';
                $.each(data, function(k, v){
                    options += '<option value="' + v.ROOM_NO + '">' + v.ROOM_NAME +'</option>'; 
                });
                $('#login_room_select').html(options);
            }
        });
    };
    $('#login_building_select').change(function(){
        get_rooms();
    });
    </script>
	</body>
</html>
