<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Building extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/building_mod");
    }

    /**
     *
     * 列表
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
		$count_all = $this->building_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/building/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/building/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->building_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
		$data['village_info'] = $this->db->get('village_info')->result_array();
        $this->load->view('zkadmin/building_list', $data);
    }
    
    /**
     * 修改
     */
    public function update(){
        $BUILDING_NO = $this->input->post('BUILDING_NO');
        $BUILDING_NAME = $this->input->post('BUILDING_NAME');
        $VILLAGE_NO = $this->input->post('VILLAGE_NO');
        $BUILDING_TYPE = $this->input->post('BUILDING_TYPE');
        $STRUCT_TYPE = $this->input->post('STRUCT_TYPE');
        $USE_TYPE = $this->input->post('USE_TYPE');
        $HEIGHT = $this->input->post('HEIGHT');
        $TOTAL_FLOORS = $this->input->post('TOTAL_FLOORS');
        $TOTAL_HOUSE = $this->input->post('TOTAL_HOUSE');
        $TOTAL_UNITS = $this->input->post('TOTAL_UNITS');
        $TOTAL_FU_HOUSE = $this->input->post('TOTAL_FU_HOUSE');
        $NOTES = $this->input->post('NOTES');
        $CONFIG_ID = $this->input->post('CONFIG_ID');
        $METHODS = $this->input->post('METHODS');
        
        if(empty($BUILDING_NAME) || empty($VILLAGE_NO) || empty($HEIGHT)
            || empty($TOTAL_FLOORS) || empty($TOTAL_HOUSE) || empty($TOTAL_UNITS)
            || empty($TOTAL_FU_HOUSE) || empty($CONFIG_ID)){
            alert('输入信息有误');
        }
        
        $exist = $this->db->where('BUILDING_NAME', $BUILDING_NAME)->where('VILLAGE_NO', $VILLAGE_NO)
            ->where('BUILDING_NO !=', $BUILDING_NO)->get('building_info')->row_array();
        if($exist){
            alert('楼栋信息已存在');
        }
        
        $village = $this->db->where('VILLAGE_NO', $VILLAGE_NO)->get('village_info')->row_array();
        
        $data = array(
            'BUILDING_NAME' => $BUILDING_NAME,
            'VILLAGE_NO' => $VILLAGE_NO,
            'VILLAGE_NAME' => $village['VILLAGE_NAME'],
            'BUILDING_TYPE' => $BUILDING_TYPE,
            'STRUCT_TYPE' => $STRUCT_TYPE,
            'USE_TYPE' => $USE_TYPE,
            'HEIGHT' => $HEIGHT,
            'TOTAL_FLOORS' => $TOTAL_FLOORS,
            'TOTAL_HOUSE' => $TOTAL_HOUSE,
            'TOTAL_UNITS' => $TOTAL_UNITS,
            'TOTAL_FU_HOUSE' => $TOTAL_FU_HOUSE,
            'NOTES' => $NOTES,
            'CONFIG_ID' => $CONFIG_ID,
            'METHODS' => $METHODS
        );
        $this->db->where('BUILDING_NO', $BUILDING_NO)->update('building_info', $data);
        redirect('zkadmin/building');
    }
    
    /**
     * 删除
     */
    public function del(){
        $building_no = $this->input->post('building_no');
        //是否存在房间
        $room_exist = $this->db->where('BUILDING_NO', $building_no)->get('room_info')->result_array();
        if($room_exist){
            alert('该楼栋存在下级房间信息');
        }
        $this->db->where('BUILDING_NO', $building_no)->delete('building_info');
        redirect('zkadmin/building');
    }
    
    /**
     * 添加
     */
    public function add(){
        $BUILDING_NAME = $this->input->post('BUILDING_NAME');
        $VILLAGE_NO = $this->input->post('VILLAGE_NO');
        $BUILDING_TYPE = $this->input->post('BUILDING_TYPE');
        $STRUCT_TYPE = $this->input->post('STRUCT_TYPE');
        $USE_TYPE = $this->input->post('USE_TYPE');
        $HEIGHT = $this->input->post('HEIGHT');
        $TOTAL_FLOORS = $this->input->post('TOTAL_FLOORS');
        $TOTAL_HOUSE = $this->input->post('TOTAL_HOUSE');
        $TOTAL_UNITS = $this->input->post('TOTAL_UNITS');
        $TOTAL_FU_HOUSE = $this->input->post('TOTAL_FU_HOUSE');
        $NOTES = $this->input->post('NOTES');
        $CONFIG_ID = $this->input->post('CONFIG_ID');
        $METHODS = $this->input->post('METHODS');
        
        if(empty($BUILDING_NAME) || empty($VILLAGE_NO) || empty($HEIGHT)
            || empty($TOTAL_FLOORS) || empty($TOTAL_HOUSE) || empty($TOTAL_UNITS)
            || empty($TOTAL_FU_HOUSE) || empty($CONFIG_ID)){
            alert('输入信息有误');
        }
        
        $exist = $this->db->where('BUILDING_NAME', $BUILDING_NAME)->where('VILLAGE_NO', $VILLAGE_NO)->get('building_info')->row_array();
        if($exist){
            alert('楼栋信息已存在');
        }
        
        $village = $this->db->where('VILLAGE_NO', $VILLAGE_NO)->get('village_info')->row_array();
        //自定义自增编号，数据库唯一标示都没有定义自增
        $building_max = $this->db->where('VILLAGE_NO', $VILLAGE_NO)->select_max('BUILDING_NO')->get('building_info')->row_array();
        
        $data = array(
            'BUILDING_NO' => $building_max['BUILDING_NO']+1,
            'BUILDING_NAME' => $BUILDING_NAME,
            'VILLAGE_NO' => $VILLAGE_NO,
            'VILLAGE_NAME' => $village['VILLAGE_NAME'],
            'BUILDING_TYPE' => $BUILDING_TYPE,
            'STRUCT_TYPE' => $STRUCT_TYPE,
            'USE_TYPE' => $USE_TYPE,
            'HEIGHT' => $HEIGHT,
            'TOTAL_FLOORS' => $TOTAL_FLOORS,
            'TOTAL_HOUSE' => $TOTAL_HOUSE,
            'TOTAL_UNITS' => $TOTAL_UNITS,
            'TOTAL_FU_HOUSE' => $TOTAL_FU_HOUSE,
            'NOTES' => $NOTES,
            'CONFIG_ID' => $CONFIG_ID,
            'METHODS' => $METHODS
        );
        $this->db->insert('building_info', $data);
        redirect('zkadmin/building');
    }

    /**
     * 详情
     */
    public function detail() {
        $building_no = $this->uri->segment(4);
        $data['building'] = $this->db->where('BUILDING_NO', $building_no)->get('building_info')->row_array();
        $this->load->view('zkadmin/building_detail', $data);
    }
}

?>