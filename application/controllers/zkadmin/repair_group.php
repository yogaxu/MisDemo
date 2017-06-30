<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Repair_group extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		islogin();
		$this->load->model("zkadmin/repairer_mod");
		//$this->load->helper(array('form', 'url'));
	}
     /**
	 *
	 *维修分组列表
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
		$count_all = $this->repairer_mod->count_group_all($search);
		
	    //生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/repair_group/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/repair_group/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->repairer_mod->get_group_list($search, $start, $limit);
		$data['keywords'] = $search;
		
	    $this->load->view('zkadmin/repair_group_list', $data);
	}
	
	/**
	 * 添加
	 */
	public function add(){
	    $group_name = $this->input->post('group_name');
	    $supervisor = $this->input->post('supervisor');
	    $supervisor_tel = $this->input->post('supervisor_tel');
	    $company_name = $this->input->post('company_name');
	    $count = count($this->db->get('repair_group_info')->result_array());
	    $company_id = $count+rand(2, 5);
	     
	    $data = array(
	        'company_id' => $company_id,
	        'group_id' => $company_id.rand(10, 99),
	        'group_name' => $group_name,
	        'supervisor' => $supervisor,
	        'supervisor_tel' => $supervisor_tel,
	        'company_name' => $company_name
	    );
	    $this->db->insert('repair_group_info', $data);
	    redirect('zkadmin/repair_group');
	}

	/**
	 * 修改
	 */
	public function update(){
	    $id = $this->input->post('id');
	    $group_name = $this->input->post('group_name');
	    $supervisor = $this->input->post('supervisor');
	    $supervisor_tel = $this->input->post('supervisor_tel');
	    $company_name = $this->input->post('company_name');
	
	    $data = array(
	        'group_name' => $group_name,
	        'supervisor' => $supervisor,
	        'supervisor_tel' => $supervisor_tel,
	        'company_name' => $company_name
	    );
	    $this->db->where('id', $id)->update('repair_group_info', $data);
	    redirect('zkadmin/repair_group');
	}
	
	/**
	 * 删除
	 */
	public function del(){
	    $id = $this->input->post('id');
	    $this->db->where('id', $id)->delete('repair_group_info');
	    redirect('zkadmin/repair_group');
	}
	
}