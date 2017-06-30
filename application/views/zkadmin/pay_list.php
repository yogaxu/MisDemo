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
<link rel="stylesheet"
	href="<?php echo base_url("zeros/css/style.css");?>">
<link rel="stylesheet"
	href="<?php echo base_url("zeros/js/jedate_new/jedate/skin/jedate.css");?>">
<script src="<?php echo base_url("zeros/js/jquery.js");?>"></script>
<script src="<?php echo base_url("zeros/js/pintuer.js");?>"></script>
<script
	src="<?php echo base_url("zeros/js/jedate_new/jedate/jquery.jedate.js");?>"></script>
<script src="<?php echo base_url("zeros/js/layer/layer.js");?>"></script>
</head>
<body>
	<div class="panel admin-panel">
		<div class="panel-head">
			<strong class="icon-reorder"> 充值记录列表</strong> <a href=""
				style="float: right; display: none;">添加字段</a>
		</div>

		<div class="padding border-bottom">

			<ul class="search" style="padding-left: 10px;">
				<!--<li> <a class="button border-main icon-plus-square-o" href="add.html"> 发布文章</a> </li>-->
				<li>按年统计</li>
				<li>
					<form action="<?php echo site_url("zkadmin/pay/index");?>"
						class="form-horizontal" method="get">
						<input type="text" placeholder="按缴费年限查询" class="input" name="keywords"
							style="width: 150px; line-height: 17px; display: inline-block"
							id="nian" />
						<button type="submit" class="button border-main icon-search">查询</button>
					</form>
				</li>
				<li>按月统计</li>
				<li>
					<form action="<?php echo site_url("zkadmin/pay/index");?>"
						class="form-horizontal" method="get">
						<input type="text" placeholder="按缴费月份查询" class="input" name="keywords"
							style="width: 150px; line-height: 17px; display: inline-block"
							id="yue" />
						<button type="submit" class="button border-main icon-search">查询</button>
					</form>
				</li>
				<li>按日统计</li>
				<li>
					<form action="<?php echo site_url("zkadmin/pay/index");?>"
						class="form-horizontal" method="get">
						<input type="text" placeholder="按缴费日期查询" class="input" name="keywords"
							style="width: 150px; line-height: 17px; display: inline-block"
							id="ri" />
						<button type="submit" class="button border-main icon-search">查询</button>
					</form>
				</li>
			</ul>

		</div>
		<table class="table table-hover text-center">
			<tr>
				<th width="100" style="text-align: left; padding-left: 40px;">卡号</th>
				<th>名称</th>
				<th>地区</th>
				<th width="10%">缴费方式</th>
				<th width="10%">缴费时间</th>
				<th width="10%">缴费金额</th>
				<th width="310">操作</th>
			</tr>
			<tbody>
                   <?php foreach($list as $item){ ?>
                     <tr id="">
					<td><?php echo $item["CARD_NUM"]; ?></td>
					<td><a href=""><?php echo $item["USER_NAME"]; ?></a></td>
					<td class="hidden-xs"><?php echo $item["VILLAGE_NAME"]; ?><?php echo $item["BUILDING_NAME"]; ?><?php echo $item["ROOM_NAME"]; ?></td>
					<td><?php echo $item["recharge_type"]; ?></td>
					<td><?php echo $item["DEPOSIT_TIME"]; ?></td>
					<td><?php echo $item["C_Money"]; ?></td>
					<td><div class="button-group">
							<a class="button border-main"
								href="<?php echo site_url("zkadmin/pay/edit/".$item['ID']);?>"><span
								class="icon-edit"></span> 缴费详情</a>
							<button class="button border-red" href="javascript:void(0)"
								onclick="del('<?php echo $item['ID'];?>')">
								<span class="icon-trash-o"></span> 删除
							</button>
						</div></td>
				</tr>
                     <?php } ?>
             </tbody>
			<tr>
				<td colspan="8">
					<div class="pagelist"> 
                <?php if($page > 1){?>
                  <span style="margin-left: 25px">共有<?php echo $start; ?>记录，共<?php echo $page; ?>页</span>
						<a
							href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/pay/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>"
							aria-label="Previous">上一页</a>
                  <?php echo $page_links; ?>
                  <a
							href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/pay/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>"
							aria-label="Next">下一页</a>
                <?php } ?>
            </div>
				</td>
			</tr>
		</table>
	</div>
	<script type="text/javascript">
    $("#nian").jeDate({
        isinitVal:false,
        format:"YYYY"
    });
    $("#yue").jeDate({
        isinitVal:false,
        format:"YYYY-MM"
    });
    $("#ri").jeDate({
        isinitVal:false,
        format:"YYYY-MM-DD"
    });

    function del(id){
    	var content = '<form id="del_form" action="' + '<?php echo site_url("zkadmin/pay/del");?>' +'" method="post">'
            + '<input type="hidden" name="id" value="' + id + '"></form>确定要删除?';
    	layer.confirm(content, function(index){
        	$('#del_form').submit();
    	    layer.close(index);
        	layer.msg('删除成功');       
		});
    }
    </script>
</body>
</html>