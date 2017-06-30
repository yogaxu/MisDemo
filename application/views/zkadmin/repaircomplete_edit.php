<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title>店铺列表</title>
<link rel="stylesheet" href="<?php echo base_url("zeros/css/pintuer.css");?>">
<link rel="stylesheet" href="<?php echo base_url("zeros/css/admin.css");?>">
<link rel="stylesheet" href="<?php echo base_url("zeros/css/style.css");?>">
<!--<link rel="stylesheet" href="css/ace.min.css">-->
<script src="<?php echo base_url("zeros/js/jquery.js");?>"></script>
<script src="<?php echo base_url("zeros/js/pintuer.js");?>"></script>

</head>
<body>
<form method="post" action="" id="listform" class="form-x">
  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 待维修</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    <div class="padding">
    	<table class="table text-center table-bordered">
      <tr>
        <th colspan="4">信息详情</th>
      </tr>
        <tr>
          <td class="text-right">工单号</td>
          <td class="text-left"><?php echo $edit["order_id"]; ?></td>
          <td class="text-right">地址</td>
          <td class="text-left"><?php echo $edit["village_name"]; ?><?php echo $edit["building_name"]; ?><?php echo $edit["room_name"]; ?></td>
          </tr>
        <tr>
          <td class="text-right">业主姓名</td>
         <td class="text-left"><?php echo $edit["user_name"]; ?></td>       
          <td class="text-right">业主电话 </td>
          <td class="text-left"><?php echo $edit["user_tel"]; ?></td>         
        </tr>
        <tr>
           <td class="text-right">设备编号</td>
         <td class="text-left"><?php echo $edit["meter_id"]; ?></td>
          <td class="text-right">报修时间</td>
          <td class="text-left"><?php echo $edit["report_time"]; ?></td>
         </tr>
          <tr>
          <td class="text-right">维修员</td>
          <td class="text-left"><?php echo $edit["repairman"]; ?></td>
          <td class="text-right">维修员电话</td>
          <td class="text-left"><?php echo $edit["repairman_tel"]; ?></td>
         </tr>
          <tr>
          <td class="text-right">预约开始时间</td>
          <td class="text-left"><?php echo $edit["appointment_start"]; ?></td>
          <td class="text-right">预约结束时间</td>
          <td class="text-left"><?php echo $edit["appointment_end"]; ?></td>
         </tr>
          <tr> 
          <td class="text-right">用户备注</td>
          <td class="text-left"colspan="3"><?php echo $edit["user_description"]; ?></td>
        </tr>
          <tr> 
          <td class="text-right">故障描述</td>
          <td class="text-left"colspan="3"><?php echo $edit["fault_description"]; ?></td>
        </tr>
        <tr> 
         <td class="text-right">系统预判</td>
          <td class="text-left"colspan="3"><?php echo $edit["system_predicts"]; ?></td>
        </tr>
        <tr>
        <td colspan="4">
        <?php $imgs = explode(',', $edit['image_path']);?>
        <?php 
        if(strcmp($imgs[0], '') != 0){
            foreach ($imgs as $img){?>
     		<img src="<?php echo base_url("uploads/".$img);?>" width="200px" style="vertical-align: top;"/>
 		<?php }
        }?>
 		</td>
        </tr>
   </table>
   </div>
  	
    </div>
</form>
</body>
</html>



