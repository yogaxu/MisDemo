<?php

/**
 * @author 你哥
 *
 */
class user_mod extends CI_Model{
    
    /**
     * 获取用户信息
     */
    public function user_info($meter_id){
        $this->db->where('card_no', $meter_id);
        $query = $this->db->get('v_bs_user_base_info');
        return $query->row_array();
    }
    
    /**
     * 更新用户订单 -> 支付宝充值
     */
    public function update_user_order_alipay($alipay_data){
    	$village_no = $alipay_data['village_no'];
    	$room_no = $alipay_data['room_no'];
    	$building_no = $alipay_data['building_no'];
    	$this->db->where('PASSWD !=','');
    	$this->db->join("meter_info","room_info.ROOM_NO=meter_info.ROOM_NO && room_info.ROOM_NO = ".$room_no." && room_info.BUILDING_NO = ".$building_no." && room_info.VILLAGE_NO = ".$village_no);
    	$room_row = $this->db->get("room_info")->row_array();
    	
    	$data = array(
    			'CARD_NUM' => $room_row['METER_ID'],
				'USER_NAME' => $room_row ['USER_NAME'],
				'VILLAGE_NAME' => $room_row ['VILLAGE_NAME'],
				'BUILDING_NAME' => $room_row ['BUILDING_NAME'],
				'ROOM_NAME' => $room_row ['ROOM_NAME'],
				'VILLAGE_NO' => $room_row ['VILLAGE_NO'],
				'BUILDING_NO' => $room_row ['BUILDING_NO'],
				'ROOM_NO' => $room_row ['ROOM_NO'],
    			'ID_CARD' => $room_row ['ID_CARD'],
    			'C_Money' => $alipay_data['total_fee'],
    			'DEPOSIT_TIME' => $alipay_data['notify_time'],
    			'recharge_type' => '支付宝支付',
    	);
    	$this->db->insert('deposits', $data);
    	redirect('mapp/voucher/index/success');
    	/*
    	 * $this->_CI->load->model('order_model');
    	// 根据订单号获取订单信息
    	$order_code = $alipay_data['out_trade_no'];
    	$order_info = $this->_CI->order_model->getOrderByID($order_code, true);
    	if (empty($order_info) || ! isset($order_info['pay_status'])) return;
    	if ($order_info['order_status'] == 0 && $order_info['pay_status'] != '1') {
    		// 更新订单的支付状态及支付方式
    		// pay_status => 1 表示支付成功
    		// pay_method => 1 表示支付方式为支付宝支付
    		$pay_info = array('pay_status' => '1', 'pay_method' => 1);
    		$pay_result = $this->_CI->order_model->updateOrderPayStatus($order_code, $pay_info, true);
    		// 添加订单支付信息
    		// user_id 用户ID
    		// order_id 订单ID
    		// total_fee 支付总额
    		// buyer_id 用户支付宝ID buyer_id
    		$order_pay_info = array(
    				'user_id'      => $order_info['user_id'],
    				'order_id'     => $order_info['id'],
    				'trade_no'     => $alipay_data['trade_no'],
    				'total_fee'    => $alipay_data['total_fee'],
    				#'total_fee'   => $alipay_data['price'],
    				'seller_id'    => $alipay_data['seller_id'],
    				'seller_email' => $alipay_data['seller_email'],
    				'buyer_id'     => $alipay_data['buyer_id'],
    				'buyer_email'  => $alipay_data['buyer_email'],
    				'add_time'     => time()
    		);
    		$this->_CI->order_model->addPayLogForOrderAliPay($order_pay_info);
    		// 添加用户收支日志
    		// correlation_id 关联ID 这里为订单ID
    		// action_type => 1 表示xxxx商城订单事件
    		// pay_type => 1 表示微信支付
    		$payment_log = array(
    				'user_id'        => $order_info['user_id'],
    				'correlation_id' => $order_info['id'],
    				'action_type'    => 1,
    				'pay_type'       => 1,
    				'cash_fee'       => $alipay_data['total_fee'],
    				'remark'         => 'xxxx商城订单：支付宝支付'.$alipay_data['total_fee'],
    				'action_ip'      => $_SERVER['REMOTE_ADDR'],
    				'add_time'       => time()
    		);
    		$this->_CI->order_model->addLogForUserPay($payment_log);
    		// 添加支付宝支付日志
    		$alipay_log = array(
    				'user_id'        => $order_info['user_id'],
    				'correlation_id' => $order_info['id'],
    				'seller_id'      => $alipay_data['seller_id'],
    				'seller_email'   => $alipay_data['seller_email'],
    				'buyer_id'       => $alipay_data['buyer_id'],
    				'buyer_email'    => $alipay_data['buyer_email'],
    				'total_fee'      => $alipay_data['total_fee'],
    				'trade_no'       => $alipay_data['trade_no'],
    				'gmt_create'     => $alipay_data['gmt_create'],
    				'gmt_payment'    => $alipay_data['gmt_payment'],
    				'price'          => $alipay_data['total_fee'],
    				'action_ip'      => $_SERVER['REMOTE_ADDR'],
    				'add_time'       => time()
    		);
    		$this->_CI->order_model->addLogForAliPay($alipay_log);
    	}
    	 */
    }
}

?>