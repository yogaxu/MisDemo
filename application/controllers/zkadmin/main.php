<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Main extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		islogin();
		$this->load->model("zkadmin/main_mod");
	}
	
	public function index(){
		
	    $user = get_info_admin();
	    if($user['role_id'] == 0){
	        $data['auth_parent'] = $this->db->where('parent_id', 0)
	           ->order_by('id', 'asc')->get('admin_auth')->result_array(); //目录
	        $data['auth_son'] = $this->db->where('parent_id !=', 0)
	           ->order_by('id', 'asc')->get('admin_auth')->result_array(); //权限
	    }else{
	        $role = $this->db->where('id',$user['role_id'])->get('admin_role')->row_array();
	        $auth_array = explode('_', $role['auth']);
	        $data['auth_parent'] = $this->db->where_in('id', $auth_array)
	           ->where('type', 0)->where('parent_id', 0)
	           ->order_by('id', 'asc')->get('admin_auth')->result_array();
	        $data['auth_son'] = $this->db->where_in('id', $auth_array)
	           ->where('type', 0)->where('parent_id !=', 0)
	           ->order_by('id', 'asc')->get('admin_auth')->result_array();
	    }
	    
		$data['index'] = "overview";
		$this->load->view('zkadmin/header');
		$this->load->view('zkadmin/menu',$data);
		$this->load->view('zkadmin/footer');
	}
}