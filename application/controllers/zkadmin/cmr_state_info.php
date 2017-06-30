<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Cmr_state_info extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/cmr_state_mod");
    }

    /**
     *
     * 集中器列表
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
		$count_all = $this->cmr_state_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/cmr_state_info/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/cmr_state_info/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->cmr_state_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
        $data['village_info'] = $this->db->get("village_info")->result_array();
        $data['building_info'] = $this->db->get("building_info")->result_array();
//         $data['room_info'] = $this->db->get("room_info")->result_array();
		$this->load->view('zkadmin/cmr_state_list', $data);
    }
    
    /**
     * 修改
     */
    public function update(){
        $CMR_ID = $this->input->post('CMR_ID');
        $CMR_HW = $this->input->post('CMR_HW');
        $CMR_SW = $this->input->post('CMR_SW');
        $NETWORK_TYPE = $this->input->post('NETWORK_TYPE');
        $CONNECT_TYPE = $this->input->post('CONNECT_TYPE');
        $IP = $this->input->post('IP');
        $PORT = $this->input->post('PORT');
        $STATE = $this->input->post('STATE');
        $SIM_IMSI = $this->input->post('SIM_IMSI');
        $PHONE = $this->input->post('PHONE');
        $CONFIG_CH1 = $this->input->post('CONFIG_CH1');
        $CONFIG_CH2 = $this->input->post('CONFIG_CH2');
        $CONFIG_CH3 = $this->input->post('CONFIG_CH2');
        $CONFIG_CH4 = $this->input->post('CONFIG_CH4');
        $CONFIG_CH5 = $this->input->post('CONFIG_CH5');
        $CONFIG_CH6 = $this->input->post('CONFIG_CH6');
        $CONFIG_CH7 = $this->input->post('CONFIG_CH7');
        $CONFIG_CH8 = $this->input->post('CONFIG_CH8');
        $CONFIG_RS485 = $this->input->post('CONFIG_RS485');
        $VILLAGE_NO = $this->input->post('VILLAGE_NO');
        $BUILDING_NO = $this->input->post('BUILDING_NO');
        $TIME_ENTRY = $this->input->post('TIME_ENTRY');
        $TIME_INSTALL = $this->input->post('TIME_INSTALL');
        $NOTES = $this->input->post('NOTES');
        $CYCLE_STORAGE = $this->input->post('CYCLE_STORAGE');
        $CYCLE_REF = $this->input->post('CYCLE_REF');
        $METER_NUM = $this->input->post('METER_NUM');
        $BOARD_TYPE = $this->input->post('BOARD_TYPE');
        $LOGIN_CYCLE = $this->input->post('LOGIN_CYCLE');
        $HEARTBEAT_CYCLE = $this->input->post('HEARTBEAT_CYCLE');
        
        if(empty($CMR_ID) || empty($CONFIG_CH1) || empty($CONFIG_CH2)
            || empty($CONFIG_CH1) || empty($CONFIG_CH1) || empty($CONFIG_CH1)
            || empty($CONFIG_CH3) || empty($CONFIG_CH4) || empty($CONFIG_CH5)
            || empty($CONFIG_CH6) || empty($CONFIG_CH7) || empty($CONFIG_CH8)
            || empty($CONFIG_RS485) || empty($TIME_ENTRY) || empty($TIME_INSTALL)
            || empty($CYCLE_STORAGE) || empty($CYCLE_REF) || empty($METER_NUM)
            || empty($LOGIN_CYCLE) || empty($HEARTBEAT_CYCLE)){
            alert('信息填写有误');
        }
        
        $data = $this->input->post();
        switch ($STATE){
            case '1':
                $data['STATE'] = '使用中'; break;
            case '2':
                $data['STATE'] = '空闲中'; break;
            case '3':
                $data['STATE'] = '维修中'; break;
            default:
                $data['STATE'] = '报损';
        }
        
        $this->db->where('CMR_ID', $CMR_ID)->update('cmr_info', $data);
        redirect('zkadmin/cmr_state_info');
        
    }
    
    /**
     * 删除
     */
    public function del(){
        $CMR_ID = $this->input->post('CMR_ID');
        //未被使用的，才能删除
        $result = $this->db->where('CMR_ID', $CMR_ID)->where('DAU_TYPE', 0)->where('STATE !=', '使用中')->get('cmr_info')->row_array();
        if(empty($result)){
            alert('设备正被使用.');
        }
        $this->db->where('CMR_ID', $CMR_ID)->where('DAU_TYPE', 0)->delete('cmr_info');
        redirect('zkadmin/cmr_state_info');
    }
    
    /**
     * 添加
     */
    public function add(){
        $CMR_ID = $this->input->post('CMR_ID');
        $CMR_HW = $this->input->post('CMR_HW');
        $CMR_SW = $this->input->post('CMR_SW');
        $NETWORK_TYPE = $this->input->post('NETWORK_TYPE');
        $CONNECT_TYPE = $this->input->post('CONNECT_TYPE');
        $IP = $this->input->post('IP');
        $PORT = $this->input->post('PORT');
        $STATE = $this->input->post('STATE');
        $SIM_IMSI = $this->input->post('SIM_IMSI');
        $PHONE = $this->input->post('PHONE'); 
        $CONFIG_CH1 = $this->input->post('CONFIG_CH1');
        $CONFIG_CH2 = $this->input->post('CONFIG_CH2');
        $CONFIG_CH3 = $this->input->post('CONFIG_CH2');
        $CONFIG_CH4 = $this->input->post('CONFIG_CH4');
        $CONFIG_CH5 = $this->input->post('CONFIG_CH5');
        $CONFIG_CH6 = $this->input->post('CONFIG_CH6');
        $CONFIG_CH7 = $this->input->post('CONFIG_CH7');
        $CONFIG_CH8 = $this->input->post('CONFIG_CH8');
        $CONFIG_RS485 = $this->input->post('CONFIG_RS485'); 
        $VILLAGE_NO = $this->input->post('VILLAGE_NO');
        $BUILDING_NO = $this->input->post('BUILDING_NO');
        $TIME_ENTRY = $this->input->post('TIME_ENTRY');
        $TIME_INSTALL = $this->input->post('TIME_INSTALL');
        $NOTES = $this->input->post('NOTES');
        $CYCLE_STORAGE = $this->input->post('CYCLE_STORAGE');
        $CYCLE_REF = $this->input->post('CYCLE_REF');
        $METER_NUM = $this->input->post('METER_NUM');
        $BOARD_TYPE = $this->input->post('BOARD_TYPE');
        $LOGIN_CYCLE = $this->input->post('LOGIN_CYCLE');
        $HEARTBEAT_CYCLE = $this->input->post('HEARTBEAT_CYCLE');
        
        if(empty($CMR_ID) || empty($CONFIG_CH1) || empty($CONFIG_CH2)
            || empty($CONFIG_CH1) || empty($CONFIG_CH1) || empty($CONFIG_CH1)
            || empty($CONFIG_CH3) || empty($CONFIG_CH4) || empty($CONFIG_CH5)
            || empty($CONFIG_CH6) || empty($CONFIG_CH7) || empty($CONFIG_CH8)
            || empty($CONFIG_RS485) || empty($TIME_ENTRY) || empty($TIME_INSTALL)
            || empty($CYCLE_STORAGE) || empty($CYCLE_REF) || empty($METER_NUM)
            || empty($LOGIN_CYCLE) || empty($HEARTBEAT_CYCLE)){
            alert('信息填写有误');
        }
        
        $cmr_exist = $this->db->where('CMR_ID', $CMR_ID)->get('cmr_info')->row_array();
        if(!empty($cmr_exist)){
            alert('该设备ID已存在');
        }
        
        
        $data = $this->input->post();
        $data['DAU_TYPE'] = 0;
        switch ($STATE){
            case '1':
                $data['STATE'] = '使用中'; break;
            case '2':
                $data['STATE'] = '空闲中'; break;
            case '3':
                $data['STATE'] = '维修中'; break;
            default:
                $data['STATE'] = '报损';
        }
        
        $this->db->insert('cmr_info', $data);
        redirect('zkadmin/cmr_state_info');
    }

    /**
     * 详情
     */
    public function detail() {
        $cmr_id = $this->uri->segment(4);
        $data['cmr_state'] = $this->db->where('CMR_ID', $cmr_id)->where('DAU_TYPE', 0)->get('cmr_info')->row_array();
        $this->load->view('zkadmin/cmr_state_detail', $data);
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