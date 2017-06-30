<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/auth_mod");
    }

    /**
     *
     * 权限列表
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
		$count_all = $this->auth_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/auth/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/auth/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->auth_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
		$data['parent_auths'] = $this->db->where('parent_id', 0)->get('admin_auth')->result_array();
        $this->load->view('zkadmin/auth_list', $data);
    }
    
    /**
     * 修改权限
     */
    public function update_auth(){
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $url = $this->input->post('url');
        $type = $this->input->post('type');
        $parent_id = $this->input->post('parent_id');
        $icon = $this->input->post('icon');
        if(strcmp($name, '') == 0 || strcmp($type, '') == 0 
            || strcmp($parent_id, '') == 0 || strcmp($icon, '') == 0){
            alert('输入信息有误');
        }
        $data = array(
            'name' => $name,
            'url' => $url,
            'type' => $type,
            'parent_id' => $parent_id,
            'icon' => $icon
        );
        $this->db->where('id', $id)->update('admin_auth', $data);
        redirect('zkadmin/auth');
    }
    
    /**
     * 删除权限
     */
    public function del_auth(){
        $id = $this->input->post('id');
        $used_auth = $this->db->like('auth', $id)->get('admin_role')->result_array();
        if(count($used_auth) > 0){
            alert('该权限正在被使用');
        }
        $has_son = $this->db->where('parent_id', $id)->get('admin_auth')->result_array();
        if(count($has_son) > 0){
            alert('该目录存在子权限');
        }
        $this->db->where('id', $id)->delete('admin_auth');
        redirect('zkadmin/auth');
    }
    
    /**
     * 添加目录权限
     */
    public function add_root() {
        $name = $this->input->post('name');
        $icon = $this->input->post('icon');
        $type = $this->input->post('type');
        $auth = $this->db->where('name', $name)->where('type', $type)->get('admin_auth')->row_array();
        if($auth){
            alert('该目录已存在');
        }
        if(strcmp($name, '') == 0 || strcmp($type, '') == 0){
            alert('输入信息有误');
        }
        if(empty($icon)){
            $data = array(
                'name' => $name,
                'type' => $type,
                'parent_id' => 0
            );
        }else{
            $data = array(
                'name' => $name,
                'type' => $type,
                'parent_id' => 0,
                'icon' => $icon
            );
        }
        $this->db->insert('admin_auth', $data);
        redirect('zkadmin/auth');
    }
    
    /**
     * 添加路径权限
     */
    public function add_url() {
        $name = $this->input->post('name');
        $url = $this->input->post('url');
        $parent_id = $this->input->post('parent_id');
        $type = $this->input->post('type');
        $auth = $this->db->where('name', $name)->where('type', $type)->get('admin_auth')->row_array();
        if($auth){
            alert('该目录已存在');
        }
        if(strcmp($name, '') == 0 || strcmp($type, '') == 0
            || strcmp($parent_id, '') == 0 || strcmp($url, '') == 0){
            alert('输入信息有误');
        }
        $data = array(
            'name' => $name,
            'type' => $type,
            'url' => $url,
            'parent_id' => $parent_id
        );
        $this->db->insert('admin_auth', $data);
        redirect('zkadmin/auth');
    }
}

?>