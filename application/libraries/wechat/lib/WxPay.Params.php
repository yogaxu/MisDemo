<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WxPayParams extends CI_Controller
{
    protected $_CI;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_appid(){
        $wepay = $this->db->where('type', 2)->get('payment_info')->row_array();
        return $wepay['appid'];
    }
    
    public function get_mchid(){
        $wepay = $this->db->where('type', 2)->get('payment_info')->row_array();
        return $wepay['mchid'];        
    }
    
    public function get_key(){
        $wepay = $this->db->where('type', 2)->get('payment_info')->row_array();
        return $wepay['key'];        
    }
    
    public function get_appsecret(){
        $wepay = $this->db->where('type', 2)->get('payment_info')->row_array();
        return $wepay['appsecret'];        
    }
}