<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Pay_config extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
    }

    /**
     *
     * 获取支付参数列表
     */
    public function index(){
        $data['alipay'] = $this->db->where('type', 1)->get('payment_info')->row_array();
        $data['wepay'] = $this->db->where('type', 2)->get('payment_info')->row_array();
        $this->load->view('zkadmin/pay_config', $data);
    }
    
    /**
     * 配置支付参数
     */
    public function add() {
        $input = $this->input->post();
        $data = array();
        $exist = array();
        
        if(strcmp($input['type'], '1') == 0){
            if(empty($input['partner']) || empty($input['alikey'])){
                alert('信息输入有误');
            }
            
            $exist = $this->db->where('type', 1)->get('payment_info')->row_array();
            
            $data['partner'] = $input['partner'];
            $data['alikey'] = $input['alikey'];
            $data['type'] = 1;
        }
        
        if(strcmp($input['type'], '2') == 0){
            if(empty($input['appid']) || empty($input['mchid']) || empty($input['key']) || empty($input['appsecret'])){
                alert('信息输入有误');
            }
            
            $exist = $this->db->where('type', 2)->get('payment_info')->row_array();
            
            $data['appid'] = $input['appid'];
            $data['mchid'] = $input['mchid'];
            $data['key'] = $input['key'];
            $data['appsecret'] = $input['appsecret'];
            $data['type'] = 2;
        }
        
        //防止冗余数据
        if(!empty($exist)){
            $this->db->where('id', $exist['id'])->delete('payment_info');
        }
        
        $this->db->insert('payment_info', $data);
        redirect('zkadmin/pay_config');
    }
    
    /**
     * 修改支付参数
     */
    public function update(){
        $input = $this->input->post();
        $data = array();
        
        if(strcmp($input['type'], '1') == 0){
            if(empty($input['partner']) || empty($input['alikey'])){
                alert('信息输入有误');
            }
        
            $data['partner'] = $input['partner'];
            $data['alikey'] = $input['alikey'];
        }
        
        if(strcmp($input['type'], '2') == 0){
            if(empty($input['appid']) || empty($input['mchid']) || empty($input['key']) || empty($input['appsecret'])){
                alert('信息输入有误');
            }
        
            $data['appid'] = $input['appid'];
            $data['mchid'] = $input['mchid'];
            $data['key'] = $input['key'];
            $data['appsecret'] = $input['appsecret'];
        }
        
        $this->db->where('type', $input['type'])->where('id', $input['id'])->update('payment_info', $data);
        redirect('zkadmin/pay_config');
    }
    
    /**
     * 删除支付参数
     */
    public function del() {
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('payment_info');
        redirect('zkadmin/pay_config');
    }
}

?>