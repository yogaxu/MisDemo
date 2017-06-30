<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Repaircomplete extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		islogin();
		$this->load->model("zkadmin/repair_mod");
	}

	
	/**
	 *
	 * 已维修列表
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
		$count_all = $this->repair_mod->count_all($search);
	
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/repaircomplete/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/repaircomplete/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->repair_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
	
		$this->load->view('zkadmin/repaircomplete_list', $data);
	}
	
	/**
	 * 
	 * 详情
	 */
	public function edit(){
		$id = $this->uri->segment(4, 0);
		$data['edit'] = $this->repair_mod->get_repairs($id);
		$this->load->view('zkadmin/repaircomplete_edit', $data);
		$this->load->view('zkadmin/footer');
	}
	
	
	/**
	 *
	 * 删除
	 */
	public function subs(){
		$id = $this->uri->segment(4, 0);
		$data['edit'] = $this->repair_mod->get_deletes($id);
		redirect("zkadmin/repaircomplete");
		
		
	}
}