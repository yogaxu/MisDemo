
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, 			minimum-scale=1.0, user-scalable=no, width=device-width">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>设备控制界面</title>
        <link href="<?php echo base_url("zeros/app/css/common.css"); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url("zeros/app/css/css.css"); ?>" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery-1.9.1.js");?>"></script>
        <script type="text/javascript" src="<?php echo base_url("zeros/app/js/login.js");?>"></script>

        <script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery.knob.js")?>"></script>
        <script type="text/javascript" src="<?php echo base_url("zeros/app/js/excanvas.js")?>"></script>
		<script type="text/javascript" src="<?php echo base_url("zeros/app/js/cavas.js")?>"></script>
	</head>
	<body>
		<div class="container">
			<div class="header">
				<p><?php echo $village;echo $building;echo $room?></p>
			</div>
			<div class="contain">
				<div class="con-top">
					<div class="btn-group">
						<span class="expense"><?php echo $payment_status?></span>
						<span class="switch"><?php echo $valve_state?></span>
					</div>
					<div class="pan">
						<div class="cavas-box">
						  <form action="<?php echo site_url("mapp/equipment/save_temp");?>" id="temp_form" method="post">
                            <input class="knob" data-width="230" data-angleOffset="-90" data-anglearc="180" data-fgColor="#2bc6f6"
                                   data-skin="tron" data-thickness=".1"  value="<?php echo intval($temp_set) ?>" name="temp">
                          </form>
                        </div>
						<p><span>室内温度为</span><?php echo round($temp_room,1)?><span>℃</span></p>
					</div>
				</div>
				<div class="con-bottom">
					<ul>
						<li>
							<img src="<?php echo base_url("zeros/app/images/icon-16.png");?>" /><span>累计热量：</span><i><?php echo $total_heat?>KWh</i>
						</li>
						<li>
							<img src="<?php echo base_url("zeros/app/images/icon-17.png");?>"/><span>累计时间：</span><i><?php echo $total_time?>时</i>
						</li>
						<li>
							<img src="<?php echo base_url("zeros/app/images/icon-18.png");?>" /><span>剩余热量：</span><i><?php echo $balance?>KWh</i>
						</li>
						<li>
							<img src="<?php echo base_url("zeros/app/images/icon-19.png");?>" /><span>建筑面积：</span><i><?php echo $area?>m²</i>
						</li>
					</ul>
					<ul>
						<!--<li>
							<img src="images/icon-20.png" /><span>分摊热量：</span><i>KW/h</i>
						</li>-->
						<li>
							<img src="<?php echo base_url("zeros/app/images/icon-21.png");?>" /><span>采集时间：</span><i><?php echo $sample_time?></i>
						</li>
						<li>
							<img src="<?php echo base_url("zeros/app/images/icon-22.png");?>" /><span>电池电压：</span><i><?php echo $voltage?>V</i>
						</li>
					</ul>
					<ul class="fault">
						<li><img src="<?php echo base_url("zeros/app/images/icon-23.png");?>"/><span>故障提示</span><i><?php echo $fault_message?></i>
						</li>
					</ul>
				</div>
			</div>
			<div class="footer">
                <ul>
                    <li><a href="<?php echo site_url("mapp/equipment");?>"><img src="<?php echo base_url("zeros/app/images/icon-14.png");?>"/><span class="active">设备管理</span></a></li>
                    <li><a href="<?php echo site_url("mapp/voucher");?>"><img src="<?php echo base_url("zeros/app/images/icon-12.png");?>"/><span>充值中心</span></a></li>
                    <li><a href="<?php echo site_url("mapp/repair");?>"><img src="<?php echo base_url("zeros/app/images/icon-10.png");?>"/><span >维修中心</span></a></li>
                    <li><a href="<?php echo site_url("mapp/user");?>"><img src="<?php echo base_url("zeros/app/images/icon-24.png");?>"/><span>我的</span></a></li>
                </ul>
			</div>
		</div>
    <script>
    $(".knob").knob({
        change : function (value) {
//             console.log("change : " + value);
        },
        release : function (value) {
//             console.log("release : " + value);
        	$('#temp_form').submit();
        },
        cancel : function () {
//             console.log("cancel : ", this);
        },
        draw : function () {
                // "tron" case
            if(this.$.data('skin') == 'tron') {
                var a = this.angle(this.cv)  // Angle
                    , sa = this.startAngle          // Previous start angle
                    , sat = this.startAngle         // Start angle
                    , ea                            // Previous end angle
                    , eat = sat + a                 // End angle
                    , r = 1;
                this.g.lineWidth = this.lineWidth;
                this.o.cursor
                    && (sat = eat - 0.3)
                    && (eat = eat + 0.3);
                if (this.o.displayPrevious) {
                    ea = this.startAngle + this.angle(this.v);
                    this.o.cursor
                        && (sa = ea - 0.3)
                        && (ea = ea + 0.3);
                    this.g.beginPath();
                    this.g.strokeStyle = this.pColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                    this.g.stroke();
                }
                this.g.beginPath();
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                this.g.stroke();
                this.g.lineWidth = 2;
                this.g.beginPath();
                this.g.strokeStyle = this.o.fgColor;
                this.g.arc( this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                this.g.stroke();
                return false;
            }
        }
    });
    </script>
	</body>
</html>