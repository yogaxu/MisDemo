<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Repairer extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		islogin();
		$this->load->model("zkadmin/repairer_mod");
	}

	/**
	 *
	 *维修员列表
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
		$count_all = $this->repairer_mod->count_all($search);
		
	    //生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/repairer/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/repairer/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->repairer_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
		
		//获取小区、维护分组
		$data['villages'] = $this->db->get('village_info')->result_array();
		$data['repair_group'] = $this->db->get('repair_group_info')->result_array();
		
	    $this->load->view('zkadmin/repairer_list', $data);
	}
		
	/**
	 * 获取小区楼栋 ajax
	 */
	public function get_buildings(){
	    $village_no = $this->input->post('village_no');
	    $buildings = $this->db->where('VILLAGE_NO', $village_no)->get('building_info')->result_array();
	    
	    //防中文乱码
	    foreach ( $buildings as $building => $v) {
	        foreach ($buildings[$building] as $key => $value){
    	        $buildings[$building][$key] = urlencode($value);
	        }
	    }
	    
	    echo urldecode(json_encode($buildings));
	    exit;
	}
		
	/**
	 * 修改
	 */
	public function update(){
	    $id = $this->input->post('id');
	    $village_no = $this->input->post('village_no');
	    $building_no = $this->input->post('building_no');
	    $group_id = $this->input->post('group_id');
	    $repairman = $this->input->post('repairman');
	    $repairman_tel = $this->input->post('repairman_tel');
	    $village = $this->db->where('VILLAGE_NO', $village_no)->get('village_info')->row_array();
	    $building = $this->db->where('BUILDING_NO', $building_no)->get('building_info')->row_array();
	    $group = $this->db->where('id', $group_id)->get('repair_group_info')->row_array();

	    $data = array(
	        'repairman' => $repairman,
	        'repairman_tel' => $repairman_tel,
	        'village_name' => $village['VILLAGE_NAME'],
	        'village_no' => $village_no,
	        'building_name' => $building['BUILDING_NAME'],
	        'building_no' => $building_no,
	        'group_id' => $group_id,
	        'group_name' => $group['group_name']
	    );
	    $this->db->where('id', $id)->update('repairman_info', $data);
	    redirect('zkadmin/repairer');
	}	
	
	/**
	 * 添加
	 */
	public function add(){
	    $village_no = $this->input->post('village_no');
	    $building_no = $this->input->post('building_no');
	    $group_id = $this->input->post('group_id');
	    $repairman = $this->input->post('repairman');
	    $repairman_tel = $this->input->post('repairman_tel');
	    $village = $this->db->where('VILLAGE_NO', $village_no)->get('village_info')->row_array();
	    $building = $this->db->where('BUILDING_NO', $building_no)->get('building_info')->row_array();
	    $group = $this->db->where('id', $group_id)->get('repair_group_info')->row_array();
	    $count = count($this->db->get('repairman_info')->result_array());
	    
	    $data = array(
	        'repairman_id' => $count.rand(2, 5),
	        'repairman' => $repairman,
	        'repairman_tel' => $repairman_tel,
	        'village_name' => $village['VILLAGE_NAME'],
	        'village_no' => $village_no,
	        'building_name' => $building['BUILDING_NAME'],
	        'building_no' => $building_no,
	        'group_id' => $group_id,
	        'group_name' => $group['group_name']
	    );
	    $this->db->insert('repairman_info', $data);
	    redirect('zkadmin/repairer');
	}
	
	/**
	 * 删除
	 */
	public function del(){
	    $id = $this->input->post('id');
	    $this->db->where('id', $id)->delete('repairman_info');
	    redirect('zkadmin/repairer');
	}
	
}