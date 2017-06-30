
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, 			minimum-scale=1.0, user-scalable=no, width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>报修单填写</title>
    <link href="<?php echo base_url("zeros/app/css/common.css"); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url("zeros/app/css/style.css");?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url("zeros/app/css/date.css");?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url("zeros/app/css/swiper.min.css");?>" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/jquery-1.9.1.js");?>"></script>
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/login.js");?>"></script>
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/date.js");?>" ></script>
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/iscroll.js");?>" ></script>
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/sctp.js");?>"></script>
    <script type="text/javascript" src="<?php echo base_url("zeros/app/js/swiper.min.js");?>"></script>
    <script type="text/javascript">
        $(function(){
            $('#beginTime').date({theme:"datetime"});
            $('#endTime').date({theme:"datetime"});
        });
    </script>
</head>
<body>
<div class="container">
    <div class="header">
        <a href="javascript:history.go(-1)"><img src="<?php echo base_url("zeros/app/images/fanhui.png");?>"/></a>
        <p>维修中心</p>
    </div>
    <div class="contain bg-white">
        <div class="swiper-container">
            <div class="my-pagination">
                <ul class="my-pagination-ul"></ul>
                <div class="clear"></div>
            </div>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="bx-edit">
                        <form action="<?php echo site_url("mapp/repair/save");?>" method="post" enctype="multipart/form-data">
                            <div class="input-group">
                                <label>住址：</label>
                                <p><?php echo $VILLAGE_NAME;echo $BUILDING_NAME;echo $ROOM_NAME?></p>
                                <div class="clear"></div>
                            </div>
                            <div class="input-group">
                                <label>联系人：</label>
                                <input type="text" name="user_name" />
                                <div class="clear"></div>
                            </div>
                            <div class="input-group">
                                <label>联系电话：</label>
                                <input type="text" name="user_tel" />
                                <div class="clear"></div>
                            </div>
                            <div class="input-group">
                                <label>预约时间：</label>
                                <input id="beginTime" value="" name="beginTime" type="text"/>
                                <div class="clear"></div>
                                <p style="text-align: center; padding-left: 32%;">至</p>
                                <div class="clear"></div>
                                <input type="text" id="endTime" name="endTime"/>
                                <div class="clear"></div>
                            </div>
                            <div id="datePlugin"></div>
                            <div class="input-group">
                                <label>故障描述：</label>
                                <select name="falut">
                                    <?php foreach($faluts as $falut){?>
                                        <option value="<?php echo $falut['FAULT_NAME']; ?>"><?php echo $falut['FAULT_NAME']; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="clear"></div>
                                <span class="evaluate">系统预判：<?php echo $predict?></span>
                                <input type="hidden" value="<?php echo $predict?>" name="predict">
                            </div>
                            <div class="input-group">
                                <label style="text-align: left;">备注：</label>
                                <div class="clear"></div>
                                <textarea name="user_description"></textarea>
                                <div class="clear"></div>
                            </div>
                            <div class="input-group">
                                <label>上传图片：</label>
                                <div class="clear"></div>
                                <div id="img">
                                    <div class="imgbox empty">
                                        <div class="imgnum">
                                            <input type="file" class="filepath" accept="image/*" name="images"/>
                                            <span class="close"><img src="<?php echo base_url("zeros/app/images/cha.png");?>"/></span>
                                            <img src="<?php echo base_url("zeros/app/images/btn.png");?>" class="img1" />
                                            <img src="" class="img2" />
                                        </div>
                                    </div>
                                </div>
            
                                <span class="tips">上传图片为了帮助我们更好的解决问题，请上传图片。最多5张，每张照片不超过5M，支持JPG、PNG格式。</span>
                            </div>
                            <div class="input-group">
                                <input type="submit" value="提交" />
                            </div>
                            <div class="clear"></div>
                        </form>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="dcl-list">
                        <ul>
                            <?php foreach ($repair_wait as $rw_item) {?>
							<li>
								<div class="money">
									<a href="<?php echo site_url("mapp/repair/pending_detail/".$rw_item['id']);?>">
    									<p>单号：<?php echo $rw_item['order_id']?></p>
    									<span>待处理</span>
    									<div class="clear"></div>
									</a>
								</div>
								<div class="detail">
									<a href="<?php echo site_url("mapp/repair/pending_detail/".$rw_item['id']);?>"><p><span><b class="w4">住址</b><b>：</b><?php echo $rw_item['village_name'].$rw_item['building_name'].$rw_item['room_name']?></span><span><b class="w4">故障描述</b><b>：</b><?php echo $rw_item['fault_description']?></span><span><b class="w4">备注</b><b>：</b><?php echo $rw_item['user_description']?></span><span><b class="w4">系统预判</b><b>：</b><?php echo $rw_item['system_predicts']?></span></p></a>
    								<div class="qx-btn">
    									<button onclick="cancel_order('<?php echo $rw_item['id']?>');">取消</button>
    								</div>
    								<div class="clear"></div>
								</div>
								<div class="cz-time"><a href="<?php echo site_url("mapp/repair/pending_detail/".$rw_item['id']);?>"><span><b class="w4">预约时间</b><b>：</b><?php echo $rw_item['appointment_start']?> ~ </span><span><b class="w5"></b><?php echo $rw_item['appointment_end']?> </span><i>报修时间：<?php echo $rw_item['report_time']?></i></a></div>
							</li>
							<?php }?>
							<!-- <li>
								<div class="money">
									<a href="dcl-detail.html">
    									<p>单号：372738787</p>
    									<span>待处理</span>
    									<div class="clear"></div>
									</a>
								</div>
								<div class="detail">
									<a href="dcl-detail.html"><p><span><b class="w4">住址</b><b>：</b>泰禾1号楼101</span><span><b class="w4">故障描述</b><b>：</b>通讯标识不显示</span><span><b class="w4">备注</b><b>：</b>无线标志不显示</span><span><b class="w4">系统预判</b><b>：</b>通讯失连</span></p></a>
    								<div class="qx-btn">
    									<button>取消</button>
    								</div>
    								<div class="clear"></div>
								</div>
								<div class="cz-time"><a href="dcl-detail.html"><span><b class="w4">预约时间</b><b>：</b>17/04/20 17:59:00 ~ </span><span><b class="w5"></b>17/04/20 17:59:00 </span><i>报修时间：17/04/20 17:59:00</i></a></div>
							</li> -->
						</ul>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bxhis-list">
						<ul>
						    <?php foreach ($history as $his) {?>
							<li>
								<div class="money">
									<a href="<?php echo site_url("mapp/repair/history_detail/".$his['id']);?>">
									<p>单号：<?php echo $his['order_id']?></p>
									</a>
									<?php if (!strcmp($his['user_star_rate'], '') && !strcmp($his['user_service_rate'], '')) {?>
									<a class="evaluate" href="<?php echo site_url("mapp/evaluate/index/".$his['id']);?>">评价</a>
									<?php }?>
									<div class="clear"></div>
								</div>
								<div class="detail">
									<a href="<?php echo site_url("mapp/repair/history_detail/".$his['id']);?>">
									<p><span><b class="w4">故障描述</b><b>：</b><?php echo $his['fault_description']?></span><span><b class="w4">备注</b><b>：</b><?php echo $his['user_description']?></span><span><b class="w4">系统预判</b><b>：</b><?php echo $his['system_predicts']?></span><span><b class="w4">维修员</b><b>：</b><?php echo $his['repairman']?></span></p></a>
    								<div class="clear"></div>
								</div>
								<div class="cz-time"><a href="<?php echo site_url("mapp/repair/history_detail/".$his['id']);?>"><span>报修时间：<?php echo $his['report_time']?></span><span>完工时间：<?php echo $his['repair_time']?></span></a></div>
								<div class="clear"></div>
							</li>
							<?php }?>
						</ul>
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <ul>
            <li><a href="<?php echo site_url("mapp/equipment");?>"><img src="<?php echo base_url("zeros/app/images/icon-11.png");?>"/><span>设备管理</span></a></li>
            <li><a href="<?php echo site_url("mapp/voucher");?>"><img src="<?php echo base_url("zeros/app/images/icon-12.png");?>"/><span>充值中心</span></a></li>
            <li><a href="<?php echo site_url("mapp/repair");?>"><img src="<?php echo base_url("zeros/app/images/icon-13.png");?>"/><span class="active">维修中心</span></a></li>
            <li><a href="<?php echo site_url("mapp/user");?>"><img src="<?php echo base_url("zeros/app/images/icon-24.png");?>"/><span>我的</span></a></li>
        </ul>
    </div>
</div>
<script>
    var mySwiper = new Swiper('.swiper-container',{
        pagination: '.my-pagination-ul',
        paginationClickable: true,
        paginationBulletRender: function (index, className) {
            switch (index) {
                case 0: name='报修单';break;
                case 1: name='待处理';break;
                case 2: name='报修历史';break;
                default: name='';
            }
            return '<li class="' + className + '">' + name + '</li>';
        }
    });

    //取消报修单
    function cancel_order(id){
        var url = '<?php echo site_url("mapp/repair/cancel_order/");?>';
        if(confirm('是否取消?')){
            $.post(url, {'id': id}, function(data){
                if(data == 'del_succ'){
                    alert('取消成功');
                    location.reload(true);
                }else{
                    alert('取消失败');
                    location.reload(true);
                }
            });
        }
    }
</script>
</body>
</html>