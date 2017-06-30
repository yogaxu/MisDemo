<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Room extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/room_mod");
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
		$count_all = $this->room_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/room/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/room/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->room_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
		$data['village_info'] = $this->db->get('village_info')->result_array();
        $this->load->view('zkadmin/room_list', $data);
    }
    
    /**
     * 修改
     */
    public function update(){
        $ROOM_NO = $this->input->post('ROOM_NO');
        $VILLAGE_NO = $this->input->post('VILLAGE_NO');
        $BUILDING_NO = $this->input->post('BUILDING_NO');
        $ROOM_NAME = $this->input->post('ROOM_NAME');
        $CITY_NAME = $this->input->post('CITY_NAME');
        $RATIO = $this->input->post('RATIO');
        $FLOOR_AREA = $this->input->post('FLOOR_AREA');
        $USABLE_AREA = $this->input->post('USABLE_AREA');
        $ROOM_TYPE = $this->input->post('ROOM_TYPE');
        $UNIT_NAME = $this->input->post('UNIT_NAME');
        $USER_NAME = $this->input->post('USER_NAME');
        $ID_CARD = $this->input->post('ID_CARD');
        $MOBILE = $this->input->post('MOBILE');
        $TELEPHONE = $this->input->post('TELEPHONE');
        $BALANCE_HEAT = $this->input->post('BALANCE_HEAT');
        $TOTAL_HEAT = $this->input->post('TOTAL_HEAT');
        $METERING_TYPE = $this->input->post('METERING_TYPE');
        $USABLE_TYPE = $this->input->post('USABLE_TYPE');
        $NOTES = $this->input->post('NOTES');
        $ARREARS_NUM = $this->input->post('ARREARS_NUM');
        $TEMP_UPPER = $this->input->post('TEMP_UPPER');
        $TEMP_LOWER = $this->input->post('TEMP_LOWER');
        $TEMP_ANTI = $this->input->post('TEMP_ANTI');
        $ANTI_NUM = $this->input->post('ANTI_NUM');
        $TEMP_SET = $this->input->post('TEMP_SET');
        $FT_CYCLE = $this->input->post('FT_CYCLE');
        $SAMPLE_CYCLE = $this->input->post('SAMPLE_CYCLE');
        $SUPPLY_HEAT_START = $this->input->post('SUPPLY_HEAT_START');
        $SUPPLY_HEAT_END = $this->input->post('SUPPLY_HEAT_END');
        $DISPLAY_CONTENT = $this->input->post('DISPLAY_CONTENT');
        $DN_STATE = $this->input->post('DN_STATE');
        $TOTAL_TIME = $this->input->post('TOTAL_TIME');
        $TOTAL_BALANCE = $this->input->post('TOTAL_BALANCE');
        
        if(empty($VILLAGE_NO) || empty($BUILDING_NO) || empty($ROOM_NAME)
            || empty($RATIO) || empty($FLOOR_AREA) || empty($USABLE_AREA)
            || empty($UNIT_NAME) || empty($BALANCE_HEAT) || empty($BALANCE_HEAT)
            || empty($TOTAL_HEAT) || empty($METERING_TYPE) || empty($USABLE_TYPE)
            || empty($ARREARS_NUM) || empty($TEMP_UPPER) || empty($TEMP_LOWER)
            || empty($TEMP_ANTI) || empty($ANTI_NUM) || empty($TEMP_SET)
            || empty($FT_CYCLE) || empty($SAMPLE_CYCLE) || empty($SUPPLY_HEAT_START)
            || empty($SUPPLY_HEAT_END) || empty($DISPLAY_CONTENT) || empty($TOTAL_TIME)
            || empty($TOTAL_BALANCE)){
            alert('输入信息有误');
        }
        
        $exist = $this->db->where('ROOM_NAME', $ROOM_NAME)->where('VILLAGE_NO', $VILLAGE_NO)
            ->where('BUILDING_NO', $BUILDING_NO)->where('ROOM_NO !=', $ROOM_NO)
            ->get('room_info')->row_array();
        if($exist){
            alert('房间信息已存在');
        }
        
        $village = $this->db->where('VILLAGE_NO', $VILLAGE_NO)->get('village_info')->row_array();
        $building = $this->db->where('BUILDING_NO', $BUILDING_NO)->get('building_info')->row_array();
        
        $data = array(
            'ROOM_NAME' => $ROOM_NAME,
            'BUILDING_NO' => $BUILDING_NO,
            'BUILDING_NAME' => $building['BUILDING_NAME'],
            'VILLAGE_NO' => $VILLAGE_NO,
            'VILLAGE_NAME' => $village['VILLAGE_NAME'],
            'CITY_NAME' => $CITY_NAME,
            'RATIO' => $RATIO,
            'FLOOR_AREA' => $FLOOR_AREA,
            'USABLE_AREA' => $USABLE_AREA,
            'ROOM_TYPE' => $ROOM_TYPE,
            'UNIT_NAME' => $UNIT_NAME,
            'USER_NAME' => $USER_NAME,
            'ID_CARD' => $ID_CARD,
            'MOBILE' => $MOBILE,
            'TELEPHONE' => $TELEPHONE,
            'BALANCE_HEAT' => $BALANCE_HEAT,
            'TOTAL_HEAT' => $TOTAL_HEAT,
            'METERING_TYPE' => $METERING_TYPE,
            'USABLE_TYPE' => $USABLE_TYPE,
            'NOTES' => $NOTES,
            'ARREARS_NUM' => $ARREARS_NUM,
            'TEMP_UPPER' => $TEMP_UPPER,
            'TEMP_LOWER' => $TEMP_LOWER,
            'TEMP_ANTI' => $TEMP_ANTI,
            'ANTI_NUM' => $ANTI_NUM,
            'TEMP_SET' => $TEMP_SET,
            'FT_CYCLE' => $FT_CYCLE,
            'SAMPLE_CYCLE' => $SAMPLE_CYCLE,
            'SUPPLY_HEAT_START' => $SUPPLY_HEAT_START,
            'SUPPLY_HEAT_END' => $SUPPLY_HEAT_END,
            'DISPLAY_CONTENT' => $DISPLAY_CONTENT,
            'DN_STATE' => $DN_STATE,
            'TOTAL_TIME' => $TOTAL_TIME,
            'TOTAL_BALANCE' => $TOTAL_BALANCE
        );
        $this->db->where('ROOM_NO', $ROOM_NO)->update('room_info', $data);
        redirect('zkadmin/room');
    }
    
    /**
     * 删除
     */
    public function del(){
        $ROOM_NO = $this->input->post('ROOM_NO');
        //是否存在终端设备 - meter
        $meter_exist = $this->db->where('ROOM_NO', $ROOM_NO)->get('meter_info')->result_array();
        if($meter_exist){
            alert('该房间存在对应终端设备');
        }
        $this->db->where('ROOM_NO', $ROOM_NO)->delete('room_info');
        redirect('zkadmin/room');
    }
    
    /**
     * 添加
     */
    public function add(){
        $VILLAGE_NO = $this->input->post('VILLAGE_NO');
        $BUILDING_NO = $this->input->post('BUILDING_NO');
        $ROOM_NAME = $this->input->post('ROOM_NAME');
        $CITY_NAME = $this->input->post('CITY_NAME');
        $RATIO = $this->input->post('RATIO');
        $FLOOR_AREA = $this->input->post('FLOOR_AREA');
        $USABLE_AREA = $this->input->post('USABLE_AREA');
        $ROOM_TYPE = $this->input->post('ROOM_TYPE');
        $UNIT_NAME = $this->input->post('UNIT_NAME');
        $USER_NAME = $this->input->post('USER_NAME');
        $ID_CARD = $this->input->post('ID_CARD');
        $MOBILE = $this->input->post('MOBILE');
        $TELEPHONE = $this->input->post('TELEPHONE');
        $BALANCE_HEAT = $this->input->post('BALANCE_HEAT');
        $TOTAL_HEAT = $this->input->post('TOTAL_HEAT');
        $METERING_TYPE = $this->input->post('METERING_TYPE');
        $USABLE_TYPE = $this->input->post('USABLE_TYPE');
        $NOTES = $this->input->post('NOTES');
        $ARREARS_NUM = $this->input->post('ARREARS_NUM');
        $TEMP_UPPER = $this->input->post('TEMP_UPPER');
        $TEMP_LOWER = $this->input->post('TEMP_LOWER');
        $TEMP_ANTI = $this->input->post('TEMP_ANTI');
        $ANTI_NUM = $this->input->post('ANTI_NUM');
        $TEMP_SET = $this->input->post('TEMP_SET');
        $FT_CYCLE = $this->input->post('FT_CYCLE');
        $SAMPLE_CYCLE = $this->input->post('SAMPLE_CYCLE');
        $SUPPLY_HEAT_START = $this->input->post('SUPPLY_HEAT_START');
        $SUPPLY_HEAT_END = $this->input->post('SUPPLY_HEAT_END');
        $DISPLAY_CONTENT = $this->input->post('DISPLAY_CONTENT');
        $DN_STATE = $this->input->post('DN_STATE');
        $TOTAL_TIME = $this->input->post('TOTAL_TIME');
        $TOTAL_BALANCE = $this->input->post('TOTAL_BALANCE');
        
        if(empty($VILLAGE_NO) || empty($BUILDING_NO) || empty($ROOM_NAME)
            || empty($RATIO) || empty($FLOOR_AREA) || empty($USABLE_AREA)
            || empty($UNIT_NAME) || empty($BALANCE_HEAT) || empty($BALANCE_HEAT)
            || empty($TOTAL_HEAT) || empty($METERING_TYPE) || empty($USABLE_TYPE)
            || empty($ARREARS_NUM) || empty($TEMP_UPPER) || empty($TEMP_LOWER)
            || empty($TEMP_ANTI) || empty($ANTI_NUM) || empty($TEMP_SET)
            || empty($FT_CYCLE) || empty($SAMPLE_CYCLE) || empty($SUPPLY_HEAT_START)
            || empty($SUPPLY_HEAT_END) || empty($DISPLAY_CONTENT) || empty($TOTAL_TIME)
            || empty($TOTAL_BALANCE)){
            alert('输入信息有误');
        }
        
        $exist = $this->db->where('ROOM_NAME', $ROOM_NAME)->where('VILLAGE_NO', $VILLAGE_NO)
            ->where('BUILDING_NO', $BUILDING_NO)->get('room_info')->row_array();
        if($exist){
            alert('房间信息已存在');
        }
        
        $village = $this->db->where('VILLAGE_NO', $VILLAGE_NO)->get('village_info')->row_array();
        $building = $this->db->where('BUILDING_NO', $BUILDING_NO)->get('building_info')->row_array();
        //自定义自增编号，数据库唯一标示都没有定义自增
        $room_max = $this->db->where('VILLAGE_NO', $VILLAGE_NO)
            ->where('BUILDING_NO', $BUILDING_NO)->select_max('ROOM_NO')->get('room_info')->row_array();
        if($room_max['ROOM_NO'] == NULL){
            $room_max['ROOM_NO'] = $BUILDING_NO."000";
        }
        
        $data = array(
            'ROOM_NO' => $room_max['ROOM_NO']+1,
            'ROOM_NAME' => $ROOM_NAME,
            'BUILDING_NO' => $BUILDING_NO,
            'BUILDING_NAME' => $building['BUILDING_NAME'],
            'VILLAGE_NO' => $VILLAGE_NO,
            'VILLAGE_NAME' => $village['VILLAGE_NAME'],
            'CITY_NAME' => $CITY_NAME,
            'RATIO' => $RATIO,
            'FLOOR_AREA' => $FLOOR_AREA,
            'USABLE_AREA' => $USABLE_AREA,
            'ROOM_TYPE' => $ROOM_TYPE,
            'UNIT_NAME' => $UNIT_NAME,
            'USER_NAME' => $USER_NAME,
            'ID_CARD' => $ID_CARD,
            'MOBILE' => $MOBILE,
            'TELEPHONE' => $TELEPHONE,
            'BALANCE_HEAT' => $BALANCE_HEAT,
            'TOTAL_HEAT' => $TOTAL_HEAT,
            'METERING_TYPE' => $METERING_TYPE,
            'USABLE_TYPE' => $USABLE_TYPE,
            'NOTES' => $NOTES,
            'ARREARS_NUM' => $ARREARS_NUM,
            'TEMP_UPPER' => $TEMP_UPPER,
            'TEMP_LOWER' => $TEMP_LOWER,
            'TEMP_ANTI' => $TEMP_ANTI,
            'ANTI_NUM' => $ANTI_NUM,
            'TEMP_SET' => $TEMP_SET,
            'FT_CYCLE' => $FT_CYCLE,
            'SAMPLE_CYCLE' => $SAMPLE_CYCLE,
            'SUPPLY_HEAT_START' => $SUPPLY_HEAT_START,
            'SUPPLY_HEAT_END' => $SUPPLY_HEAT_END,
            'DISPLAY_CONTENT' => $DISPLAY_CONTENT,
            'DN_STATE' => $DN_STATE,
            'TOTAL_TIME' => $TOTAL_TIME,
            'TOTAL_BALANCE' => $TOTAL_BALANCE
        );
        $this->db->insert('room_info', $data);
        redirect('zkadmin/room');
    }

    /**
     * 详情
     */
    public function detail() {
        $room_no = $this->uri->segment(4);
        $data['room'] = $this->db->where('ROOM_NO', $room_no)->get('room_info')->row_array();
        $this->load->view('zkadmin/room_detail', $data);
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
}

?>