<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/admin_mod");
    }

    /**
     *
     * 管理员列表 -> 超管除外
     */
    public function index(){
        $search = $this->input->get('keywords');
		
		//分页使用的
		$data['id_c'] = $this->input->get('per_page');
		if(empty($data['id_c'])){
		    $data['id_c'] = 1;
		}
		$page = $this->input->get('per_page');
		if(empty($page)){
		    $page = 1;
		}
		$limit = 5;
		$start = ($page-1) * $limit;
		$count_all = $this->admin_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/admin/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/admin/index?keywords=".$search."&per_page=1.html");
		$config['total_rows'] = $count_all;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;
		$this->pages->initialize($config);
		$data['page_links'] = $this->pages->create_links();
		
		//获取栏目信息
		$data['start'] =$count_all; 
		$data['page'] = ceil($count_all / $limit);
		$data['all'] = $count_all;
		$data['list'] = $this->admin_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
		$data['roles'] = $this->db->get('admin_role')->result_array();
        $this->load->view('zkadmin/admin_list', $data);
    }
    
    /**
     * 分配角色
     */
    public function update_role(){
        $id = $this->input->post('id');
        $data = array(
            'role_id' => $this->input->post('role_id')
        );
        $this->db->where('id', $id)->update('admin_info', $data);
        redirect('zkadmin/admin');
    }
    
    /**
     * 删除账号
     */
    public function del_admin(){
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('admin_info');
        redirect('zkadmin/admin');
    }
    
    /**
     * 添加账号
     */
    public function add_admin(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $role_id = $this->input->post('role_id');
        
        if(empty($username) || empty($password) || empty($role_id)){
            alert('输入信息有误');
        }
        
        $account = $this->db->where('username', $username)->get('admin_info')->row_array();
        if($account){
            alert('该账号已存在');
        }
        
        $data = array(
            'username' => $username,
            'password' => md5($password),
            'role_id' => $role_id,
            'status' => 0,
            'reg_time' => date('y-m-d H:i:s',time())
        );
        $this->db->insert('admin_info', $data);
        redirect('zkadmin/admin');
    }
}

?>