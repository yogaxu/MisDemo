<?php
require_once dirname(__FILE__)."/../../libraries/wechat/lib/WxPay.Api.php";
require_once dirname(__FILE__)."/../../libraries/wechat/example/WxPay.JsApiPay.php";
require_once dirname(__FILE__)."/../../libraries/wechat/lib/WxPay.Notify.php";
require_once dirname(__FILE__)."/../../libraries/wechat/example/notify.php";

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6
 * Time: 0:45
 */
class wepay extends CI_Controller{

    public function __construct(){
        parent::__construct();
        user_islogin();
        $this->load->model("mapp/user_mod");
    }

    public function index(){
        $param = $this->input->get();
        $fee = $param['fee']*100;
        //①、获取用户openid
        $tools = new JsApiPay();
        $openId = $tools->GetOpenid();
        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody("test");
        $input->SetAttach("test");
        $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
        $input->SetTotal_fee($fee);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("应缴纳热费");
        $input->SetNotify_url("http://yogaxu1996.w3.luyouxia.net/mapp");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);

        //获取共享收货地址js函数参数
        $editAddress = $tools->GetEditAddressParameters();
        $data['jsApiParameters']=$jsApiParameters;
        $data['fee']=$fee/100;
        $data['editAddress']=$editAddress;
        $this->load->view('app/wepay',$data);
    }



    public function save(){
        $info = get_info();
        $this->db->join("meter_info","room_info.ROOM_NO=meter_info.ROOM_NO && room_info.ROOM_NO = ".$info['room']
            ." && room_info.BUILDING_NO = ".$info['building']." && room_info.VILLAGE_NO = ".$info['village']);
        $room_row = $this->db->get("room_info")->row_array();
        $this->db->where('VILLAGE_NO',$info['village'])->where('BUILDING_NO',$info['building'])
            ->where('ROOM_NO',$info['room']);
        $query = $this->db->get('meter_info');
        $card = $query->row_array();
        $user_info = $this->user_mod->user_info($card['METER_ID']);
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
            'C_Money' => $user_info['AREA']*$user_info['price_area'],
            'DEPOSIT_TIME' => date('Y-m-d H:i:s'),
            'recharge_type' => '微信支付',
        );
        $this->db->insert('deposits', $data);
        echo 1;
    }
}