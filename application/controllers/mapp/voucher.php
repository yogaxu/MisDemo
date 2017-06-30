<?php

/**
 * @author 你哥
 *
 */
class voucher extends CI_Controller {

    public function __construct(){
        parent::__construct();
        user_islogin();
        $this->load->model("mapp/register_mod");
        $this->load->model("mapp/user_mod");
        //$this->load->helper(array('form', 'url'));
    }

    public function index(){
        $pay_flag = $this->uri->segment(4, 'null');
        
        //获取用户信息
        $data['dict'] = $this->session->userdata('dict');
        $data['village'] = $this->session->userdata('village');
        $data['building'] = $this->session->userdata('building');
        $data['room'] = $this->session->userdata('room');
        $data['password'] = $this->session->userdata('password');
        $data['meter_id'] = $this->session->userdata('meter_id');
        $user_info = $this->user_mod->user_info($data['meter_id']);
        $data['village_no'] = $user_info['VILLAGE_NO'];
        $data['building_no'] = $user_info['BUILDING_NO'];
        $data['room_no'] = $user_info['ROOM_NO'];
        $data['area'] = $user_info['AREA'];
        $data['price_prepaid'] = $user_info['price_prepaid'];
        $data['price_base'] = $user_info['price_base'];
        $data['price_meas'] = $user_info['price_meas'];
        $data['use_card'] = $user_info['USE_CARD'];
        $data['payment_type'] = $user_info['payment_type'];
        
        $data['pay_flag'] = $pay_flag;
        
        //获取用户充值记录
        $data['deposits'] = $this->db->where('CARD_NUM', $data['meter_id'])->where('VILLAGE_NO', $user_info['VILLAGE_NO'])
            ->where('BUILDING_NO', $user_info['BUILDING_NO'])->where('ROOM_NO', $user_info['ROOM_NO'])
            ->order_by("DEPOSIT_TIME", "DESC")->get('deposits')->result_array();
        
        $this->load->view("app/voucher", $data);
    }

    /**
     *  支付宝支付接口
     * 
     */
    public function aliPay()
    {
        header("Content-type:text/html;charset=utf-8");
        // 调用支付宝支付接口配置信息
        $this->load->config('alipay_config', TRUE);
        
        // 加载支付宝支付请求类库
        $this->load->library('ci_alipay', $this->config->item('alipay_config'));
        
        //交易参数
        $parameter = array(
            'service' => $this->config->item('service', 'alipay_config'),
            'partner' => $this->config->item('partner', 'alipay_config'),
            'seller_id' => $this->config->item('seller_id', 'alipay_config'),
            'payment_type' => $this->config->item('payment_type', 'alipay_config'),
            'notify_url' => $this->config->item('notify_url', 'alipay_config'),
            'return_url' => $this->config->item('return_url', 'alipay_config'),
            '_input_charset' => $this->config->item('input_charset', 'alipay_config'),
            'out_trade_no' => $this->input->post('good_id'), // 订单编号
            'subject' => '供暖缴费'.$this->input->post('good_id'), // 订单商品
            'total_fee' => $this->input->post('fee'), // 订单总额
            'body' => '供暖缴费', // 商品描述
            'show_url' => '', // 选填
            'anti_phishing_key' => '', // 选填
            'exter_invoke_ip' => '', // 选填
            "app_pay"	=> "Y",//启用此参数能唤起钱包APP支付宝
        );
        
        $this->session->set_userdata('village_no', $this->input->post('village_no'));
        $this->session->set_userdata('building_no', $this->input->post('building_no'));
        $this->session->set_userdata('room_no', $this->input->post('room_no'));
        
        //请求交易
        $body = $this->ci_alipay->buildRequestForm($parameter, "get", "确认");
        
        echo $body;
    }
    
    /**
     * 同步通知
     */
    public function alipayNotifyUrl(){
        $this->load->config('alipay_config', TRUE);
        require_once(APPPATH."libraries/AliPay/lib/alipay_notify.class.php");
        
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($this->config->item('alipay_config'));
        $verify_result = $alipayNotify->verifyNotify();
        
        if($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代
        
        
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
        
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
        
            //商户订单号
        
            $out_trade_no = $_POST['out_trade_no'];
        
            //支付宝交易号
        
            $trade_no = $_POST['trade_no'];
        
            //交易状态
            $trade_status = $_POST['trade_status'];
        
        
            if($_POST['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序
        
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
        
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序
        
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
        
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
        
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        	$this->updateOrderPay($_POST);
//             echo "success";		//请不要修改或删除
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            redirect('mapp/voucher/index/fail');
            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }
    
    /**
     * 异步通知
     */
    public function alipayReturnUrl(){
    	$this->load->config('alipay_config', TRUE);
    	require_once(APPPATH."libraries/AliPay/lib/alipay_notify.class.php");
		// $this->alipayNotifyUrl();
		// 计算得出通知验证结果
		$alipayNotify = new AlipayNotify ( $this->config->item ( 'alipay_config' ) );
		$verify_result = $alipayNotify->verifyReturn ();
		if ($verify_result) { // 验证成功
		                     // ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		                     // 请在这里加上商户的业务逻辑程序代码
		                     
			// ——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		                     // 获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
		                     
			// 商户订单号
			
			$out_trade_no = $_GET ['out_trade_no'];
			
			// 支付宝交易号
			
			$trade_no = $_GET ['trade_no'];
			
			// 交易状态
			$trade_status = $_GET ['trade_status'];
			
			if ($_GET ['trade_status'] == 'TRADE_FINISHED' || $_GET ['trade_status'] == 'TRADE_SUCCESS') {
				// 判断该笔订单是否在商户网站中已经做过处理
				// 如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				// 如果有做过处理，不执行商户的业务程序
			} else {
				echo "trade_status=" . $_GET ['trade_status'];
			}
// 			var_dump($_GET);
// 			echo "验证成功<br />";
			
			// ——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			$this->updateOrderPay($_GET);
			// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		} else {
			// 验证失败
			// 如要调试，请看alipay_notify.php页面的verifyReturn函数
			redirect('mapp/voucher/index/fail');
		}
    }
    
    /**
     * 更新订单记录
     */
    public function updateOrderPay($alipay_data){
    	$alipay_data['village_no'] = $this->session->userdata('village_no');
    	$alipay_data['building_no'] = $this->session->userdata('building_no');
    	$alipay_data['room_no'] = $this->session->userdata('room_no');
    	$this->user_mod->update_user_order_alipay($alipay_data);
//     	$this->_CI->load->model('order_model');
//     	// 根据订单号获取订单信息
//     	$order_code = $alipay_data['out_trade_no'];
//     	$order_info = $this->_CI->order_model->getOrderByID($order_code, true);
//     	if (empty($order_info) || ! isset($order_info['pay_status'])) return;
//     	if ($order_info['order_status'] == 0 && $order_info['pay_status'] != '1') {
//     		// 更新订单的支付状态及支付方式
//     		// pay_status => 1 表示支付成功
//     		// pay_method => 1 表示支付方式为支付宝支付
//     		$pay_info = array('pay_status' => '1', 'pay_method' => 1);
//     		$pay_result = $this->_CI->order_model->updateOrderPayStatus($order_code, $pay_info, true);
//     		// 添加订单支付信息
//     		// user_id 用户ID
//     		// order_id 订单ID
//     		// total_fee 支付总额
//     		// buyer_id 用户支付宝ID buyer_id
//     		$order_pay_info = array(
//     				'user_id'      => $order_info['user_id'],
//     				'order_id'     => $order_info['id'],
//     				'trade_no'     => $alipay_data['trade_no'],
//     				'total_fee'    => $alipay_data['total_fee'],
//     				#'total_fee'   => $alipay_data['price'],
//     				'seller_id'    => $alipay_data['seller_id'],
//     				'seller_email' => $alipay_data['seller_email'],
//     				'buyer_id'     => $alipay_data['buyer_id'],
//     				'buyer_email'  => $alipay_data['buyer_email'],
//     				'add_time'     => time()
//     		);
//     		$this->_CI->order_model->addPayLogForOrderAliPay($order_pay_info);
//     		// 添加用户收支日志
//     		// correlation_id 关联ID 这里为订单ID
//     		// action_type => 1 表示xxxx商城订单事件
//     		// pay_type => 1 表示微信支付
//     		$payment_log = array(
//     				'user_id'        => $order_info['user_id'],
//     				'correlation_id' => $order_info['id'],
//     				'action_type'    => 1,
//     				'pay_type'       => 1,
//     				'cash_fee'       => $alipay_data['total_fee'],
//     				'remark'         => 'xxxx商城订单：支付宝支付'.$alipay_data['total_fee'],
//     				'action_ip'      => $_SERVER['REMOTE_ADDR'],
//     				'add_time'       => time()
//     		);
//     		$this->_CI->order_model->addLogForUserPay($payment_log);
//     		// 添加支付宝支付日志
//     		$alipay_log = array(
//     				'user_id'        => $order_info['user_id'],
//     				'correlation_id' => $order_info['id'],
//     				'seller_id'      => $alipay_data['seller_id'],
//     				'seller_email'   => $alipay_data['seller_email'],
//     				'buyer_id'       => $alipay_data['buyer_id'],
//     				'buyer_email'    => $alipay_data['buyer_email'],
//     				'total_fee'      => $alipay_data['total_fee'],
//     				'trade_no'       => $alipay_data['trade_no'],
//     				'gmt_create'     => $alipay_data['gmt_create'],
//     				'gmt_payment'    => $alipay_data['gmt_payment'],
//     				'price'          => $alipay_data['total_fee'],
//     				'action_ip'      => $_SERVER['REMOTE_ADDR'],
//     				'add_time'       => time()
//     		);
//     		$this->_CI->order_model->addLogForAliPay($alipay_log);
//     	}
    
    	return true;
    }
}