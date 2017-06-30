<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/29
 * Time: 13:10
 */
class equipment extends CI_Controller {

    public function __construct(){
        parent::__construct();
        user_islogin();
//        $this->load->model("mapp/register_mod");
        //$this->load->helper(array('form', 'url'));
    }

    public function index(){
        $info = get_info();
        $this->db->where('VILLAGE_NO',$info['village'])->where('BUILDING_NO',$info['building'])
            ->where('ROOM_NO',$info['room']);
        $query = $this->db->get('meter_info');
        $card = $query->row_array();
        $this->db->where('card_no',$card['METER_ID']);
        $query = $this->db->get('v_bs_user_realtime_data');
        $data= $query->row_array();
        $data['village'] = $card['VILLAGE_NAME'];
        $data['building'] = $card['BUILDING_NAME'];
        $data['room'] = $card['ROOM_NAME'];
        $this->load->view("app/equipment",$data);
    }

    public function save_temp(){
        $temp = $this->input->post("temp", TRUE);
        $rule = '^[1-9]d*|0$'; //温度格式匹配
        $info = get_info();
        $this->db->where('VILLAGE_NO',$info['village'])->where('BUILDING_NO',$info['building'])
            ->where('ROOM_NO',$info['room']);
        $query = $this->db->get('meter_info');
        $meter = $query->row_array();
        //插入msg
        $data=array(
            'DEV_ID'=> $meter['METER_ID'],
            'MSG_TYPE'=>4,
            'MSG_STATE'=>1,
            'VALUE'=>$temp,
            'TIME_WRITE'=>date('Y-m-d H:i:s')
        );
        $this->db->insert('msg',$data);
        //更新room_info
        $data=array(
            'SET_TEMP'=>$temp
        );
//         $this->db->where('VILLAGE_NO',$info['village'])->where('BUILDING_NO',$info['building'])
//             ->where('ROOM_NO',$info['room'])->update('room_info',$data);
        $this->db->where('CTRL_ID',$meter['METER_ID'])->update('on_off_data_last',$data);
        alert('温度设置成功！');
    }
}

?>