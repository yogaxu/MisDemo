<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Elec_meter extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/elec_meter_mod");
    }

    /**
     *
     * 电表
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
		$limit = 1;
		$start = ($page-1) * $limit;
		$count_all = $this->elec_meter_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/elec_meter/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/elec_meter/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->elec_meter_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
		
		//电表
		$data['meter_info'] = $this->db->where('METER_TYPE', 2)->get('meter_info')->result_array();
		
		$this->load->view('zkadmin/elec_meter_list', $data);
    }
    
    /**
     * 修改
     */
    public function update(){
        $CMR_ID = $this->input->post('CMR_ID');
        $ELEC_METER_ID = $this->input->post('ELEC_METER_ID');
        $BATCH_NO = $this->input->post('BATCH_NO');
        $SERIAL_NO = $this->input->post('SERIAL_NO');
        $VOLTAGE = $this->input->post('VOLTAGE');
        $CURRENT = $this->input->post('CURRENT');
        $A_VOLTAGE = $this->input->post('A_VOLTAGE');
        $B_VOLTAGE = $this->input->post('B_VOLTAGE');
        $C_VOLTAGE = $this->input->post('C_VOLTAGE');
        $A_CURRENT = $this->input->post('A_CURRENT');
        $B_CURRENT = $this->input->post('B_CURRENT');
        $C_CURRENT = $this->input->post('C_CURRENT');
        $ACTIVE_ENERGY = $this->input->post('ACTIVE_ENERGY');
        $ACTIVE_ENERGY1 = $this->input->post('ACTIVE_ENERGY1');
        $ACTIVE_ENERGY2 = $this->input->post('ACTIVE_ENERGY2');
        $ACTIVE_ENERGY3 = $this->input->post('ACTIVE_ENERGY3');
        $ACTIVE_ENERGY4 = $this->input->post('ACTIVE_ENERGY4');
        $REACTIVE_ENERGY = $this->input->post('REACTIVE_ENERGY');
        $REACTIVE_ENERGY1 = $this->input->post('REACTIVE_ENERGY1');
        $REACTIVE_ENERGY2 = $this->input->post('REACTIVE_ENERGY2');
        $REACTIVE_ENERGY3 = $this->input->post('REACTIVE_ENERGY3');
        $REACTIVE_ENERGY4 = $this->input->post('REACTIVE_ENERGY4');
        $ACTIVE_POWER = $this->input->post('ACTIVE_POWER');
        $ACTIVE_POWER_A = $this->input->post('ACTIVE_POWER_A');
        $ACTIVE_POWER_B = $this->input->post('ACTIVE_POWER_B');
        $ACTIVE_POWER_C = $this->input->post('ACTIVE_POWER_C');
        $REACTIVE_POWER = $this->input->post('REACTIVE_POWER');
        $REACTIVE_POWER_A = $this->input->post('REACTIVE_POWER_A');
        $REACTIVE_POWER_B = $this->input->post('REACTIVE_POWER_B');
        $REACTIVE_POWER_C = $this->input->post('REACTIVE_POWER_C');
        $POWER_FACTOR = $this->input->post('POWER_FACTOR');
        $POWER_FACTOR_A = $this->input->post('POWER_FACTOR_A');
        $POWER_FACTOR_B = $this->input->post('POWER_FACTOR_B');
        $POWER_FACTOR_C = $this->input->post('POWER_FACTOR_C');
        $ACTIVE_ENERGY_REVERSE = $this->input->post('ACTIVE_ENERGY_REVERSE');
        $ACTIVE_ENERGY_REVERSE1 = $this->input->post('ACTIVE_ENERGY_REVERSE1');
        $ACTIVE_ENERGY_REVERSE2 = $this->input->post('ACTIVE_ENERGY_REVERSE2');
        $ACTIVE_ENERGY_REVERSE3 = $this->input->post('ACTIVE_ENERGY_REVERSE3');
        $ACTIVE_ENERGY_REVERSE4 = $this->input->post('ACTIVE_ENERGY_REVERSE4');
        $REACTIVE_ENERGY_REVERSE = $this->input->post('REACTIVE_ENERGY_REVERSE');
        $REACTIVE_ENERGY_REVERSE1 = $this->input->post('REACTIVE_ENERGY_REVERSE1');
        $REACTIVE_ENERGY_REVERSE2 = $this->input->post('REACTIVE_ENERGY_REVERSE2');
        $REACTIVE_ENERGY_REVERSE3 = $this->input->post('REACTIVE_ENERGY_REVERSE3');
        $REACTIVE_ENERGY_REVERSE4 = $this->input->post('REACTIVE_ENERGY_REVERSE4');
        $QUADRANT_REACTIVE_POWER1 = $this->input->post('QUADRANT_REACTIVE_POWER1');
        $QUADRANT_REACTIVE_POWER2 = $this->input->post('QUADRANT_REACTIVE_POWER2');
        $QUADRANT_REACTIVE_POWER3 = $this->input->post('QUADRANT_REACTIVE_POWER3');
        $QUADRANT_REACTIVE_POWER4 = $this->input->post('QUADRANT_REACTIVE_POWER4');
        $FRE = $this->input->post('FRE');
        $CT = $this->input->post('CT');
        $ELEC_STATE = $this->input->post('ELEC_STATE');
        $TIME_SAMPLE = $this->input->post('TIME_SAMPLE');
        $TIME_UPLOAD = $this->input->post('TIME_UPLOAD');
        $REALTIME = $this->input->post('REALTIME');
        
        if(empty($BATCH_NO) || empty($SERIAL_NO) || empty($VOLTAGE)
            || empty($CURRENT) || empty($A_VOLTAGE) || empty($B_VOLTAGE)
            || empty($C_VOLTAGE) || empty($A_CURRENT) || empty($B_CURRENT)
            || empty($C_CURRENT) || empty($ACTIVE_ENERGY) || empty($ACTIVE_ENERGY1)
            || empty($ACTIVE_ENERGY2) || empty($ACTIVE_ENERGY3) || empty($ACTIVE_ENERGY4)
            || empty($REACTIVE_ENERGY) || empty($REACTIVE_ENERGY1) || empty($REACTIVE_ENERGY2)
            || empty($REACTIVE_ENERGY3) || empty($REACTIVE_ENERGY4) || empty($ACTIVE_POWER)
            || empty($ACTIVE_POWER_A) || empty($ACTIVE_POWER_B) || empty($ACTIVE_POWER_C)
            || empty($REACTIVE_POWER) || empty($REACTIVE_POWER_A) || empty($REACTIVE_POWER_B)
            || empty($REACTIVE_POWER_C) || empty($POWER_FACTOR) || empty($POWER_FACTOR_A)
            || empty($POWER_FACTOR_B) || empty($POWER_FACTOR_C) || empty($ACTIVE_ENERGY_REVERSE)
            || empty($ACTIVE_ENERGY_REVERSE1) || empty($ACTIVE_ENERGY_REVERSE2) || empty($ACTIVE_ENERGY_REVERSE3)
            || empty($ACTIVE_ENERGY_REVERSE4) || empty($REACTIVE_ENERGY_REVERSE) || empty($REACTIVE_ENERGY_REVERSE1)
            || empty($REACTIVE_ENERGY_REVERSE2) || empty($REACTIVE_ENERGY_REVERSE3) || empty($REACTIVE_ENERGY_REVERSE4)
            || empty($QUADRANT_REACTIVE_POWER1) || empty($QUADRANT_REACTIVE_POWER2) || empty($QUADRANT_REACTIVE_POWER3)
            || empty($QUADRANT_REACTIVE_POWER4) || empty($FRE) || empty($CT)
            || empty($TIME_SAMPLE) || empty($TIME_UPLOAD) || empty($REALTIME)){
            alert('信息填写有误');
        }
        
        $data = $this->input->post();
        
        $this->db->where('CMR_ID', $CMR_ID)->where('ELEC_METER_ID', $ELEC_METER_ID)->update('elec_meter_data_last', $data);
        redirect('zkadmin/elec_meter');
    }
    
    /**
     * 删除
     */
    public function del(){
        $meter_id = $this->input->post('meter_id');
        $cmr_id = $this->input->post('cmr_id');
        $this->db->where('ELEC_METER_ID', $meter_id)->where('CMR_ID', $cmr_id)->delete('elec_meter_data_last');
        redirect('zkadmin/elec_meter');
    }
    
    /**
     * 添加
     */
    public function add(){
        $ELEC_METER_ID = $this->input->post('ELEC_METER_ID');
        $BATCH_NO = $this->input->post('BATCH_NO');
        $SERIAL_NO = $this->input->post('SERIAL_NO');
        $VOLTAGE = $this->input->post('VOLTAGE');
        $CURRENT = $this->input->post('CURRENT');
        $A_VOLTAGE = $this->input->post('A_VOLTAGE'); 
        $B_VOLTAGE = $this->input->post('B_VOLTAGE');
        $C_VOLTAGE = $this->input->post('C_VOLTAGE');
        $A_CURRENT = $this->input->post('A_CURRENT');
        $B_CURRENT = $this->input->post('B_CURRENT');
        $C_CURRENT = $this->input->post('C_CURRENT');
        $ACTIVE_ENERGY = $this->input->post('ACTIVE_ENERGY');
        $ACTIVE_ENERGY1 = $this->input->post('ACTIVE_ENERGY1');
        $ACTIVE_ENERGY2 = $this->input->post('ACTIVE_ENERGY2');
        $ACTIVE_ENERGY3 = $this->input->post('ACTIVE_ENERGY3');
        $ACTIVE_ENERGY4 = $this->input->post('ACTIVE_ENERGY4');
        $REACTIVE_ENERGY = $this->input->post('REACTIVE_ENERGY');
        $REACTIVE_ENERGY1 = $this->input->post('REACTIVE_ENERGY1');
        $REACTIVE_ENERGY2 = $this->input->post('REACTIVE_ENERGY2');
        $REACTIVE_ENERGY3 = $this->input->post('REACTIVE_ENERGY3');
        $REACTIVE_ENERGY4 = $this->input->post('REACTIVE_ENERGY4');
        $ACTIVE_POWER = $this->input->post('ACTIVE_POWER');
        $ACTIVE_POWER_A = $this->input->post('ACTIVE_POWER_A');
        $ACTIVE_POWER_B = $this->input->post('ACTIVE_POWER_B');
        $ACTIVE_POWER_C = $this->input->post('ACTIVE_POWER_C');
        $REACTIVE_POWER = $this->input->post('REACTIVE_POWER');
        $REACTIVE_POWER_A = $this->input->post('REACTIVE_POWER_A');
        $REACTIVE_POWER_B = $this->input->post('REACTIVE_POWER_B');
        $REACTIVE_POWER_C = $this->input->post('REACTIVE_POWER_C');
        $POWER_FACTOR = $this->input->post('POWER_FACTOR');
        $POWER_FACTOR_A = $this->input->post('POWER_FACTOR_A');
        $POWER_FACTOR_B = $this->input->post('POWER_FACTOR_B');
        $POWER_FACTOR_C = $this->input->post('POWER_FACTOR_C');
        $ACTIVE_ENERGY_REVERSE = $this->input->post('ACTIVE_ENERGY_REVERSE');
        $ACTIVE_ENERGY_REVERSE1 = $this->input->post('ACTIVE_ENERGY_REVERSE1');
        $ACTIVE_ENERGY_REVERSE2 = $this->input->post('ACTIVE_ENERGY_REVERSE2');
        $ACTIVE_ENERGY_REVERSE3 = $this->input->post('ACTIVE_ENERGY_REVERSE3');
        $ACTIVE_ENERGY_REVERSE4 = $this->input->post('ACTIVE_ENERGY_REVERSE4');
        $REACTIVE_ENERGY_REVERSE = $this->input->post('REACTIVE_ENERGY_REVERSE');
        $REACTIVE_ENERGY_REVERSE1 = $this->input->post('REACTIVE_ENERGY_REVERSE1');
        $REACTIVE_ENERGY_REVERSE2 = $this->input->post('REACTIVE_ENERGY_REVERSE2');
        $REACTIVE_ENERGY_REVERSE3 = $this->input->post('REACTIVE_ENERGY_REVERSE3');
        $REACTIVE_ENERGY_REVERSE4 = $this->input->post('REACTIVE_ENERGY_REVERSE4');
        $QUADRANT_REACTIVE_POWER1 = $this->input->post('QUADRANT_REACTIVE_POWER1');
        $QUADRANT_REACTIVE_POWER2 = $this->input->post('QUADRANT_REACTIVE_POWER2');
        $QUADRANT_REACTIVE_POWER3 = $this->input->post('QUADRANT_REACTIVE_POWER3');
        $QUADRANT_REACTIVE_POWER4 = $this->input->post('QUADRANT_REACTIVE_POWER4');
        $FRE = $this->input->post('FRE');
        $CT = $this->input->post('CT');
        $ELEC_STATE = $this->input->post('ELEC_STATE');
        $TIME_SAMPLE = $this->input->post('TIME_SAMPLE');
        $TIME_UPLOAD = $this->input->post('TIME_UPLOAD');
        $REALTIME = $this->input->post('REALTIME');
        
        if(empty($BATCH_NO) || empty($SERIAL_NO) || empty($VOLTAGE)
            || empty($CURRENT) || empty($A_VOLTAGE) || empty($B_VOLTAGE)
            || empty($C_VOLTAGE) || empty($A_CURRENT) || empty($B_CURRENT)
            || empty($C_CURRENT) || empty($ACTIVE_ENERGY) || empty($ACTIVE_ENERGY1)
            || empty($ACTIVE_ENERGY2) || empty($ACTIVE_ENERGY3) || empty($ACTIVE_ENERGY4)
            || empty($REACTIVE_ENERGY) || empty($REACTIVE_ENERGY1) || empty($REACTIVE_ENERGY2)
            || empty($REACTIVE_ENERGY3) || empty($REACTIVE_ENERGY4) || empty($ACTIVE_POWER)
            || empty($ACTIVE_POWER_A) || empty($ACTIVE_POWER_B) || empty($ACTIVE_POWER_C)
            || empty($REACTIVE_POWER) || empty($REACTIVE_POWER_A) || empty($REACTIVE_POWER_B)
            || empty($REACTIVE_POWER_C) || empty($POWER_FACTOR) || empty($POWER_FACTOR_A)
            || empty($POWER_FACTOR_B) || empty($POWER_FACTOR_C) || empty($ACTIVE_ENERGY_REVERSE)
            || empty($ACTIVE_ENERGY_REVERSE1) || empty($ACTIVE_ENERGY_REVERSE2) || empty($ACTIVE_ENERGY_REVERSE3)
            || empty($ACTIVE_ENERGY_REVERSE4) || empty($REACTIVE_ENERGY_REVERSE) || empty($REACTIVE_ENERGY_REVERSE1)
            || empty($REACTIVE_ENERGY_REVERSE2) || empty($REACTIVE_ENERGY_REVERSE3) || empty($REACTIVE_ENERGY_REVERSE4)
            || empty($QUADRANT_REACTIVE_POWER1) || empty($QUADRANT_REACTIVE_POWER2) || empty($QUADRANT_REACTIVE_POWER3)
            || empty($QUADRANT_REACTIVE_POWER4) || empty($FRE) || empty($CT)
            || empty($TIME_SAMPLE) || empty($TIME_UPLOAD) || empty($REALTIME)){
            alert('信息填写有误');
        }
        
        $meter_used = $this->db->where('ELEC_METER_ID', $ELEC_METER_ID)->get('elec_meter_data_last')->row_array();
        if(!empty($meter_used)){
            alert('该电表信息已存在');
        }
        
        $meter = $this->db->where('METER_ID', $ELEC_METER_ID)->from('meter_info')
            ->join('meter_type', 'meter_info.METER_TYPE = meter_type.METER_TYPE and meter_info.MODEL_ID = meter_type.MODEL_ID')->get()->row_array();
        
        $data = $this->input->post();
        $data['CMR_ID'] = $meter['CMR_ID'];
        $data['CH'] = $meter['CH'];
        $data['ELEC_METER_TYPE'] = $meter['METER_TYPE'];
        $data['ELEC_METER_ID'] = $meter['METER_ID'];
        $data['STATE'] = $meter['STATE'];
        $data['NOTES'] = $meter['NOTES'];
        
        $this->db->insert('elec_meter_data_last', $data);
        redirect('zkadmin/elec_meter');
    }

    /**
     * 详情
     */
    public function detail() {
        $id = $this->uri->segment(4);
        $data['elec_meter'] = $this->db->where('ELEC_METER_ID', $id)->from("elec_meter_data_last")
            ->join('meter_info', 'meter_info.METER_ID = elec_meter_data_last.ELEC_METER_ID')
            ->join('room_info', 'room_info.ROOM_NO = meter_info.ROOM_NO')
            ->join('meter_type', 'meter_type.MODEL_ID = meter_info.MODEL_ID')->get()->row_array();
        $this->load->view('zkadmin/elec_meter_detail', $data);
    }
}

?>