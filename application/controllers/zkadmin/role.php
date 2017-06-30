<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Role extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/role_mod");
        //$this->load->helper(array('form', 'url'));
    }

    /**
     *
     * 角色列表
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
		$count_all = $this->role_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/role/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/role/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->role_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
		$data['auths'] = $this->db->where('parent_id !=', 0)->where('type !=', 1)->get('admin_auth')->result_array();
        $this->load->view('zkadmin/role_list', $data);
    }

    /**
     * 分配权限
     */
    public function update_auth(){
        $id = $this->input->post('id');
        $auth = $this->input->post('auth');
        if(count($auth) < 1){
            alert('输入信息有误');
        }
        $auth_sons = $this->db->where_in('id', $auth)->get('admin_auth')->result_array();
        $auth_spid = array();
        foreach ($auth_sons as $auth_s){
            array_push($auth_spid, $auth_s['parent_id']);
        }
        $auth_parents = $this->db->where_in('id', $auth_spid)->where('type !=', 1)->get('admin_auth')->result_array();
        $auth_ids = '';
        foreach ($auth_parents as $auth_parent){
            $auth_pid = $auth_parent['id'];
            foreach ($auth_sons as $auth_son){
                if($auth_son['parent_id'] == $auth_parent['id']){
                    $auth_pid = $auth_pid.'_'.$auth_son['id'];
                }
            }
            $auth_ids = $auth_ids.'_'.$auth_pid;
        }
        $data = array(
            'auth' => mb_substr($auth_ids, 1, mb_strlen($auth_ids))
        );
        $this->db->where('id', $id)->update('admin_role', $data);
        redirect('zkadmin/role');
    }
    
    /**
     * 删除角色
     */
    public function del_role(){
        $id = $this->input->post('id');
        $used_role = $this->db->where('role_id', $id)->get('admin_info')->result_array();
        if(count($used_role) > 0){
            alert('该角色正在被使用');
        }
        $this->db->where('id', $id)->delete('admin_role');
        redirect('zkadmin/role');
    }
    
    /**
     * 添加角色
     */
    public function add_role(){
        $name = $this->input->post('name');
        $auth = $this->input->post('auth');
    
        if(empty($name) || empty($auth)){
            alert('输入信息有误');
        }
    
        $account = $this->db->where('name', $name)->get('admin_role')->row_array();
        if($account){
            alert('该角色已存在');
        }
    
        $auth_sons = $this->db->where_in('id', $auth)->get('admin_auth')->result_array();
        $auth_spid = array();
        foreach ($auth_sons as $auth_s){
            array_push($auth_spid, $auth_s['parent_id']);
        }
        $auth_parents = $this->db->where_in('id', $auth_spid)->where('type !=', 1)->get('admin_auth')->result_array();
        $auth_ids = '';
        foreach ($auth_parents as $auth_parent){
            $auth_pid = $auth_parent['id'];
            foreach ($auth_sons as $auth_son){
                if($auth_son['parent_id'] == $auth_parent['id']){
                    $auth_pid = $auth_pid.'_'.$auth_son['id'];
                }
            }
            $auth_ids = $auth_ids.'_'.$auth_pid;
        }
        
        $data = array(
            'name' => $name,
            'auth' => $auth_ids,
        );
        $this->db->insert('admin_role', $data);
        redirect('zkadmin/role');
    }
}

?>