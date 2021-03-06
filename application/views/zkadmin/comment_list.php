<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="<?php echo base_url("zeros/css/pintuer.css");?>">
<link rel="stylesheet" href="<?php echo base_url("zeros/css/admin.css");?>">
<link rel="stylesheet" href="<?php echo base_url("zeros/css/style.css");?>">
<script src="<?php echo base_url("zeros/js/jquery.js");?>"></script>
<script src="<?php echo base_url("zeros/js/pintuer.js");?>"></script>
<script src="<?php echo base_url("zeros/jeDate/jedate.js");?>"></script>
<script src="<?php echo base_url("zeros/js/layer/layer.js");?>"></script>
</head>
<body>
  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 评论列表</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    
   <div class="padding border-bottom">
			<form action="<?php echo site_url("zkadmin/comment/index");?>"
				class="form-horizontal" method="get">
				<ul class="search">
					<li style="float: right; padding-right: 60px;"><input type="text"
						placeholder="按工单号进行搜索" name="keywords" class="input"
						style="width: 250px; line-height: 17px; display: inline-block" />
						<button type="submit" class="button border-main icon-search">搜索</button>
					</li>
				</ul>
			</form>
		</div>
    <table class="table table-hover text-center">
      <tr>
        <th width="100" style="text-align:left; padding-left:40px;">工单号</th>
        <th>地址</th>
        <th>业主姓名</th>
        <th width="10%">维修员</th>
        <th width="10%">用户星级</th>
        <th width="310">操作</th>
       
      </tr>
            <tbody>
                   <?php foreach($list as $item){ ?>
                     <tr id="">
                        <td><?php echo $item["order_id"]; ?></td>
                        <td><a href=""><?php echo $item["village_name"];echo $item["building_name"];echo $item["room_name"]; ?></a></td>
                        <td class="hidden-xs"><?php echo $item["user_name"]; ?></td>
                        <td><?php echo $item["repairman"]; ?></td>
                        <td><?php echo $item["user_star_rate"]; ?></td>
                         <td><div class="button-group"> <a class="button border-main" href="<?php echo site_url("zkadmin/comment/edit/".$item['id']);?>"><span class="icon-edit"></span> 评论详情</a> 
                          <a class="button border-red" href="<?php echo site_url("zkadmin/comment/subs/".$item['id']);?>" ><span class="icon-edit (alias)"></span> 删除</a> </div></td>                      </tr>
                     <?php } ?>
             </tbody>  
       <tr>
 <td colspan="8">
            <div class="pagelist"> 
                <?php if($page > 1){?>
                  <span   style=margin-left:25px>共有<?php echo $start; ?>记录，共<?php echo $page; ?>页</span>
                  <a href="<?php if($id_c!=1){$prev=$id_c-1;echo site_url("zkadmin/comment/index?keywords=".$keywords."&per_page=".$prev);}else{echo "javascript:;";} ?>" aria-label="Previous">上一页</a>
                  <?php echo $page_links; ?>
                  <a href="<?php if($id_c!=$page){$next=$id_c+1;echo site_url("zkadmin/comment/index?keywords=".$keywords."&per_page=".$next);}else{echo "javascript:;";} ?>" aria-label="Next">下一页</a>
                <?php } ?>
            </div>
        </td>      </tr>
    </table>
  </div>
</body>
</html>