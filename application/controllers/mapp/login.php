<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/28
 * Time: 22:46
 */
class login extends CI_Controller {

    public function __construct(){
        parent::__construct();
//         user_islogin();
        $CI =& get_instance();
        $this->load->helper('cookie');
        if($CI->session->userdata('room') == true){
            redirect("mapp/equipment");
        }
        $this->load->model("mapp/register_mod");
        //$this->load->helper(array('form', 'url'));
    }

    public function index(){
        $data['dicts'] = $this->register_mod->dictResult();
        $data['villages'] = $this->register_mod->villageResult();
        $data['buildings'] = $this->register_mod->buildingResult();
        $data['rooms'] = $this->register_mod->roomResult();
        $this->load->view('app/login',$data);
    }

    public function check(){
//         virtual_login_app();
        //接收表单提交数据
        $dict = $this->input->post("dict", TRUE);
        $village=$this->input->post("village", TRUE);
        $building=$this->input->post("building", TRUE);
        $room=$this->input->post("room", TRUE);
        $password = $this->input->post("password", TRUE);
        $password_md5 = md5($password);
        $remember = $this->input->post("remember", TRUE);

        //$code = strtolower($_POST['code']);

        //验证表单是否为空
        if($dict == "" ||$village == ""||$building == ""||$room == ""|| $password == ""){
            alert("地址或者密码不可以为空", "../login");
            exit;
        }

        //验证表单数据
        $user_room = $this->db->where("VILLAGE_NO",$village)->where("BUILDING_NO",$building)
            ->where("ROOM_NO",$room)->where("PASSWD",$password_md5)->get("room_info")->row_array();
        $user = $this->db->where("VILLAGE_NO",$village)->where("BUILDING_NO",$building)
        ->where("ROOM_NO",$room)->get("meter_info")->row_array();
        if($user_room){
            //file_put_contents('./sid.txt',$this->session->userdata('session_id'));

            //是否记住用户名和密码
            if($remember == "on"){
                setcookie('dict',$dict,time()+604800);
                setcookie('village',$village,time()+604800);
                setcookie('building',$building,time()+604800);
                setcookie('room',$room,time()+604800);
                setcookie('meter_id',$user['METER_ID'],time()+604800);
                setcookie('password',$password_md5,time()+604800);
            }else{
                setcookie('dict',$dict,time()-604800);
                setcookie('village',$village,time()-604800);
                setcookie('building',$building,time()-604800);
                setcookie('room',$room,time()-604800);
                setcookie('meter_id',$user['METER_ID'],time()-604800);
                setcookie('password',$password_md5,time()-604800);
            }

            //记录登录状态
            $this->session->set_userdata('user_islogin', 1);
            $this->session->set_userdata('dict', $dict);
            $this->session->set_userdata('village', $village);
            $this->session->set_userdata('building', $building);
            $this->session->set_userdata('room', $room);
            $this->session->set_userdata('meter_id', $user['METER_ID']);
            $this->session->set_userdata('password', $password_md5);

            alert("登陆成功", "../equipment");
            //redirect("main");
        }else{
            alert("账号或密码不正确", "../login");
            //redirect("admin/login");
        }
    }

    /**
     * 获取小区楼栋 ajax
     */
    public function get_buildings(){
        $village_no = $this->input->post('village_no');
        $buildings = $this->db->where('VILLAGE_NO', $village_no)->get('building_info')->result_array();
         
        //防中文乱码
        foreach ( $buildings as $building => $v) {
            foreach ($buildings[$building] as $key => $value){
                $buildings[$building][$key] = urlencode($value);
            }
        }
         
        echo urldecode(json_encode($buildings));
        exit;
    }

    /**
     * 获取楼栋房间 ajax
     */
    public function get_rooms(){
        $building_no = $this->input->post('building_no');
        $rooms = $this->db->where('BUILDING_NO', $building_no)->get('room_info')->result_array();
         
        //防中文乱码
        foreach ( $rooms as $room => $v) {
            foreach ($rooms[$room] as $key => $value){
                $rooms[$room][$key] = urlencode($value);
            }
        }
         
        echo urldecode(json_encode($rooms));
        exit;
    }
}