<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/29
 * Time: 13:10
 */
class user extends CI_Controller {

    public function __construct(){
        parent::__construct();
        user_islogin();
        $this->load->model("mapp/register_mod");
        //$this->load->helper(array('form', 'url'));
    }

    public function index(){
        $info = get_info();
        $this->db->where('VILLAGE_NO',$info['village'])->where('BUILDING_NO',$info['building'])
            ->where('ROOM_NO',$info['room']);
        $query = $this->db->get('meter_info');
        $meter = $query->row_array();
        $this->load->view("app/user",$meter);
    }

    //退出清空登陆信息
    public function login_out(){
        $this->session->unset_userdata('dict');
        $this->session->unset_userdata('village');
        $this->session->unset_userdata('building');
        $this->session->unset_userdata('room');
        $this->session->unset_userdata('password');
        $this->session->unset_userdata('user_islogin');
        redirect("mapp/login");
    }

}