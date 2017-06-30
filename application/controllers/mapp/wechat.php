<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/29
 * Time: 18:30
 */
class wechat extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("mapp/register_mod");
        $this->load->library("wechat/index");
        //$this->load->helper(array('form', 'url'));
    }

    public function index(){
        $this->load->library("wechat/index");
    }
}