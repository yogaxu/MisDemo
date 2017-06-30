<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Village extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/village_mod");
    }

    /**
     *
     * 小区列表
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
		$count_all = $this->village_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/village/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/village/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->village_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
// 		$data['roles'] = $this->db->get('admin_role')->result_array();
        $this->load->view('zkadmin/village_list', $data);
    }
    
    /**
     * 修改
     */
    public function update(){
        $VILLAGE_NO = $this->input->post('VILLAGE_NO');
        $VILLAGE_NAME = $this->input->post('VILLAGE_NAME');
        $VILLAGE_AREA = $this->input->post('VILLAGE_AREA');
        $TOTAL_BUILDING = $this->input->post('TOTAL_BUILDING');
        $TOTAL_HOUSE = $this->input->post('TOTAL_HOUSE');
        $CITY_NAME = $this->input->post('CITY_NAME');
        $THERMAL_COMPANY = $this->input->post('THERMAL_COMPANY');
        $PROPERTY_COMPANY = $this->input->post('PROPERTY_COMPANY');
        $PROPERTY_COMPANY_CONTACT = $this->input->post('PROPERTY_COMPANY_CONTACT');
        $PROPERTY_COMPANY_TEL = $this->input->post('PROPERTY_COMPANY_TEL');
        $VILLAGE_ADDRESS = $this->input->post('VILLAGE_ADDRESS');
        $NOTES = $this->input->post('NOTES');
        
        if(empty($VILLAGE_NAME) || empty($VILLAGE_AREA) || empty($TOTAL_BUILDING)
            || empty($TOTAL_HOUSE) || empty($THERMAL_COMPANY)){
            alert('输入信息有误');
        }
        
        $exist = $this->db->where('VILLAGE_NAME', $VILLAGE_NAME)->where('VILLAGE_NO !=', $VILLAGE_NO)->get('village_info')->row_array();
        if($exist){
            alert('小区信息已存在');
        }
        
        $data = array(
            'VILLAGE_NAME' => $VILLAGE_NAME,
            'VILLAGE_AREA' => $VILLAGE_AREA,
            'TOTAL_BUILDING' => $TOTAL_BUILDING,
            'TOTAL_HOUSE' => $TOTAL_HOUSE,
            'CITY_NAME' => $CITY_NAME,
            'THERMAL_COMPANY' => $THERMAL_COMPANY,
            'PROPERTY_COMPANY' => $PROPERTY_COMPANY,
            'PROPERTY_COMPANY_CONTACT' => $PROPERTY_COMPANY_CONTACT,
            'PROPERTY_COMPANY_TEL' => $PROPERTY_COMPANY_TEL,
            'VILLAGE_ADDRESS' => $VILLAGE_ADDRESS,
            'NOTES' => $NOTES
        );
        $this->db->where('VILLAGE_NO', $VILLAGE_NO)->update('village_info', $data);
        redirect('zkadmin/village');
    }
    
    /**
     * 删除
     */
    public function del(){
        $village_no = $this->input->post('village_no');
        //是否存在楼栋
        $building_exist = $this->db->where('VILLAGE_NO', $village_no)->get('building_info')->result_array();
        if($building_exist){
            alert('该小区存在下级楼栋信息');
        }
        $this->db->where('VILLAGE_NO', $village_no)->delete('village_info');
        redirect('zkadmin/village');
    }
    
    /**
     * 添加
     */
    public function add(){
        $VILLAGE_NAME = $this->input->post('VILLAGE_NAME');
        $VILLAGE_AREA = $this->input->post('VILLAGE_AREA');
        $TOTAL_BUILDING = $this->input->post('TOTAL_BUILDING');
        $TOTAL_HOUSE = $this->input->post('TOTAL_HOUSE');
        $CITY_NAME = $this->input->post('CITY_NAME');
        $THERMAL_COMPANY = $this->input->post('THERMAL_COMPANY');
        $PROPERTY_COMPANY = $this->input->post('PROPERTY_COMPANY');
        $PROPERTY_COMPANY_CONTACT = $this->input->post('PROPERTY_COMPANY_CONTACT');
        $PROPERTY_COMPANY_TEL = $this->input->post('PROPERTY_COMPANY_TEL');
        $VILLAGE_ADDRESS = $this->input->post('VILLAGE_ADDRESS');
        $NOTES = $this->input->post('NOTES');
        
        if(empty($VILLAGE_NAME) || empty($VILLAGE_AREA) || empty($TOTAL_BUILDING)
            || empty($TOTAL_HOUSE) || empty($THERMAL_COMPANY)){
            alert('输入信息有误');
        }
        
        $exist = $this->db->where('VILLAGE_NAME', $VILLAGE_NAME)->get('village_info')->row_array();
        if($exist){
            alert('小区信息已存在');
        }
        
        //自定义自增编号，数据库唯一标示都没有定义自增
        $village_max = $this->db->select_max('VILLAGE_NO')->get('village_info')->row_array();
        
        $data = array(
            'VILLAGE_NO' => $village_max['VILLAGE_NO']+1,
            'VILLAGE_NAME' => $VILLAGE_NAME,
            'VILLAGE_AREA' => $VILLAGE_AREA,
            'TOTAL_BUILDING' => $TOTAL_BUILDING,
            'TOTAL_HOUSE' => $TOTAL_HOUSE,
            'CITY_NAME' => $CITY_NAME,
            'THERMAL_COMPANY' => $THERMAL_COMPANY,
            'PROPERTY_COMPANY' => $PROPERTY_COMPANY,
            'PROPERTY_COMPANY_CONTACT' => $PROPERTY_COMPANY_CONTACT,
            'PROPERTY_COMPANY_TEL' => $PROPERTY_COMPANY_TEL,
            'VILLAGE_ADDRESS' => $VILLAGE_ADDRESS,
            'NOTES' => $NOTES
        );
        $this->db->insert('village_info', $data);
        redirect('zkadmin/village');
    }

    /**
     * 详情
     */
    public function detail() {
        $village_no = $this->uri->segment(4);
        $data['village'] = $this->db->where('VILLAGE_NO', $village_no)->get('village_info')->row_array();
        $this->load->view('zkadmin/village_detail', $data);
    }
}

?>