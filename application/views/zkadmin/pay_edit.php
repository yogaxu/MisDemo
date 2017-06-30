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
    <div class="panel-head"><strong class="icon-reorder"> 缴费详情</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    <div class="padding">
    	<table class="table text-center table-bordered">
      <tr>
        <th colspan="4">缴费信息</th>
      </tr>
        <tr>
          <td class="text-right">卡号</td>
          <td class="text-left"><?php echo $edit["CARD_NUM"]; ?></td>
          <td class="text-right">用户名</td>
          <td class="text-left"><?php echo $edit["USER_NAME"]; ?></td>
          
        </tr>
        <tr>
          <td class="text-right">住址地区</td>
         <td class="text-left"><?php echo $edit["VILLAGE_NAME"]; ?><?php echo $edit["BUILDING_NAME"]; ?><?php echo $edit["ROOM_NAME"]; ?></td>
           <td class="text-right">住址编号</td>
         <td class="text-left"><?php echo $edit["VILLAGE_NO"]; ?><?php echo $edit["BUILDING_NO"]; ?><?php echo $edit["ROOM_NO"]; ?></td>       
                   
        </tr>
        <tr>
          <td class="text-right">身份证号 </td>
          <td class="text-left"><?php echo $edit["ID_CARD"]; ?></td>
          <td class="text-right">支付方式</td>
          <td class="text-left"><?php echo $edit["recharge_type"]; ?></td>
        </tr>
         <tr>
          <td class="text-right">缴费金额</td>
          <td class="text-left"><?php echo $edit["C_Money"]; ?></td>
          <td class="text-right">缴费时间</td>
          <td class="text-left"><?php echo $edit["DEPOSIT_TIME"]; ?></td>
         </tr>
   </table>
   </div>
  	
    </div>
</form>
</body>
</html>



