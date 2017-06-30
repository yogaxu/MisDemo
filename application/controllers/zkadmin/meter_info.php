<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Meter_info extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/meter_mod");
        //$this->load->helper(array('form', 'url'));
    }

    /**
     *
     * 终端设备列表
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
		$count_all = $this->meter_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/meter_info/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/meter_info/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->meter_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
        $data['village_info'] = $this->db->get("village_info")->result_array();
        $data['building_info'] = $this->db->get("building_info")->result_array();
        $data['room_info'] = $this->db->get("room_info")->result_array();
		$this->load->view('zkadmin/meter_list', $data);
    }
    
    /**
     * 修改
     */
    public function update(){
        $meter_id = $this->input->post('meter_id');
        $meter_name = $this->input->post('meter_name');
        $notes = $this->input->post('notes');
        $village_no = $this->input->post('village_no');
        $building_no = $this->input->post('building_no');
        $room_no = $this->input->post('room_no');
        $usable_type = $this->input->post('usable_type');
        $use_card = $this->input->post('use_card');
        $sharing_type = $this->input->post('sharing_type');
        $STATE = $this->input->post('STATE');
        
        //检验业主信息 -> 门牌是否存在
        $room_info = $this->db->where('VILLAGE_NO', $village_no)->where('BUILDING_NO', $building_no)
            ->where('ROOM_NO', $room_no)->get('room_info')->row_array();
        if(empty($room_info)){
            alert('业主信息不匹配');
        }
        
        $data = array(
            'METER_NAME' => $meter_name,
            'NOTES' => $notes,
            'VILLAGE_NO' => $village_no,
            'BUILDING_NO' => $building_no,
            'ROOM_NO' => $room_no,
            'VILLAGE_NAME' => $room_info['VILLAGE_NAME'],
            'BUILDING_NAME' => $room_info['BUILDING_NAME'],
            'ROOM_NAME' => $room_info['ROOM_NAME'],
            'USABLE_TYPE' => $usable_type,
            'USE_CARD' => $use_card,
            'SHARING_TYPE' => $sharing_type,
            'STATE' => $STATE
        );
        
        $this->db->where('METER_ID', $meter_id)->update('meter_info', $data);
        redirect('zkadmin/meter_info');
    }
    
    /**
     * 删除
     */
    public function del_meter(){
        $meter_id = $this->input->post('meter_id');
        //未被使用的，才能删除
        $result = $this->db->where('METER_ID', $meter_id)->where('STATE !=', 0)->get('meter_info')->row_array();
        if(empty($result)){
            alert('设备正被使用.');
        }
        $this->db->where('METER_ID', $meter_id)->delete('meter_info');
        redirect('zkadmin/meter_info');
    }
    
    /**
     * 添加
     */
    public function add(){
        $METER_ID = $this->input->post('METER_ID');
        $METER_NAME = $this->input->post('METER_NAME');
        $METER_TYPE = $this->input->post('METER_TYPE');
        $MODEL_ID = $this->input->post('MODEL_ID');
        $CH = $this->input->post('CH');
        $PRODUCT_DATE = $this->input->post('PRODUCT_DATE');
        $TIME_INSTALL = $this->input->post('TIME_INSTALL');
        $TIME_CALIBRATION = $this->input->post('TIME_CALIBRATION');
        $UNIT_NAME = $this->input->post('UNIT_NAME');
        $USER_NAME = $this->input->post('USER_NAME'); //选填
        $CMR_ID = $this->input->post('CMR_ID');
        $MBUS_ADDR = $this->input->post('MBUS_ADDR');
        $NOTES = $this->input->post('NOTES'); //选填
        $STATE = $this->input->post('STATE');
        $USE_CARD = $this->input->post('USE_CARD');
        $USABLE_TYPE = $this->input->post('USABLE_TYPE');
        $SHARING_TYPE = $this->input->post('SHARING_TYPE');
        $VILLAGE_NO = $this->input->post('VILLAGE_NO');
        $BUILDING_NO = $this->input->post('BUILDING_NO');
        $ROOM_NO = $this->input->post('ROOM_NO');
        
        if(strcmp($METER_NAME, '') == 0 || strcmp($METER_TYPE, '') == 0
            || strcmp($MODEL_ID, '') == 0 || strcmp($CH, '') == 0
            || strcmp($PRODUCT_DATE, '') == 0 || strcmp($TIME_INSTALL, '') == 0
            || strcmp($TIME_CALIBRATION, '') == 0 || strcmp($UNIT_NAME, '') == 0
            || strcmp($CMR_ID, '') == 0 || strcmp($MBUS_ADDR, '') == 0
            || strcmp($STATE, '') == 0 || strcmp($USE_CARD, '') == 0
            || strcmp($USABLE_TYPE, '') == 0 || strcmp($SHARING_TYPE, '') == 0
            || strcmp($VILLAGE_NO, '') == 0 || strcmp($BUILDING_NO, '') == 0
            || strcmp($ROOM_NO, '') == 0){
            alert('信息填写有误');
        }
        
        $meter_used = $this->db->where('VILLAGE_NO', $VILLAGE_NO)->where('BUILDING_NO', $BUILDING_NO)
            ->where('ROOM_NO', $ROOM_NO)->get('meter_info')->row_array();
        if(!empty($meter_used)){
            alert('该房间已存在终端设备');
        }
        
        $meter_exist = $this->db->where('METER_ID', $METER_ID)->get('meter_info')->row_array();
        if(!empty($meter_exist)){
            alert('该终端号已存在');
        }
        
        $village = $this->db->where('VILLAGE_NO', $VILLAGE_NO)->get('village_info')->row_array();
        $building = $this->db->where('BUILDING_NO', $BUILDING_NO)->get('building_info')->row_array();
        $room = $this->db->where('ROOM_NO', $ROOM_NO)->get('room_info')->row_array();
        
        $data = array(
            'METER_ID' => $METER_ID,
            'METER_NAME' => $METER_NAME,
            'METER_TYPE' => $METER_TYPE,
            'MODEL_ID' => $MODEL_ID,
            'CH' => $CH,
            'PRODUCT_DATE' => $PRODUCT_DATE,
            'TIME_INSTALL' => $TIME_INSTALL,
            'TIME_CALIBRATION' => $TIME_CALIBRATION,
            'UNIT_NAME' => $UNIT_NAME,
            'USER_NAME' => $USABLE_TYPE,
            'CMR_ID' => $CMR_ID,
            'MBUS_ADDR' => $MBUS_ADDR,
            'NOTES' => $NOTES,
            'STATE' => $STATE,
            'USE_CARD' => $USE_CARD,
            'USABLE_TYPE' => $USABLE_TYPE,
            'SHARING_TYPE' => $SHARING_TYPE,
            'VILLAGE_NO' => $VILLAGE_NO,
            'BUILDING_NO' => $BUILDING_NO,
            'ROOM_NO' => $ROOM_NO,
            'VILLAGE_NAME' => $village['VILLAGE_NAME'],
            'BUILDING_NAME' => $building['BUILDING_NAME'],
            'ROOM_NAME' => $room['ROOM_NAME']
        );
        
        $this->db->insert('meter_info', $data);
        redirect('zkadmin/meter_info');
    }

    /**
     * 详情
     */
    public function detail() {
        $meter_id = $this->uri->segment(4);
        $data['meter'] = $this->db->where('METER_ID', $meter_id)->from("meter_info")
		  ->join('meter_type', 'meter_info.MODEL_ID = meter_type.MODEL_ID')->get()->row_array();
        $this->load->view('zkadmin/meter_detail', $data);
    }
    
    /**
     * 获取meter对应model
     */
    public function get_models(){
        $meter_type = $this->input->post('meter_type');
        $models = $this->db->where('METER_TYPE', $meter_type)->get('meter_type')->result_array();
         
        //防中文乱码
        foreach ( $models as $model => $v) {
            foreach ($models[$model] as $key => $value){
                $models[$model][$key] = urlencode($value);
            }
        }
         
        echo urldecode(json_encode($models));
        exit;
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
     * 获取楼栋房间 ajax
     */
    public function get_rooms(){
        $building_no = $this->input->post('building_no');
        $rooms = $this->db->where('BUILDING_NO', $building_no)->get('room_info')->result_array();
         
        //防中文乱码
        foreach ( $rooms as $room => $v) {
            foreach ($rooms[$room] as $key => $value){
                $rooms[$room][$key] = urlencode($value);
            }
        }
         
        echo urldecode(json_encode($rooms));
        exit;
    }
}

?>