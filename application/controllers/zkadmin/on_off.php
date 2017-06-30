<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class On_off extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/on_off_mod");
    }

    /**
     *
     * 室温表
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
		$count_all = $this->on_off_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/on_off/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/on_off/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->on_off_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
		
		//室温表
		$data['meter_info'] = $this->db->where('METER_TYPE', 6)->get('meter_info')->result_array();
		
		$this->load->view('zkadmin/on_off_list', $data);
    }
    
    /**
     * 修改
     */
    public function update(){
        $METER_ID = $this->input->post('CTRL_ID');
        $CMR_ID = $this->input->post('FTQ_ID');
        $SERIAL_NO = $this->input->post('SERIAL_NO');
        $ON_TIME = $this->input->post('ON_TIME');
        $OFF_TIME = $this->input->post('OFF_TIME');
        $TRUE_TEMP = $this->input->post('TRUE_TEMP');
        $SET_TEMP = $this->input->post('SET_TEMP');
        $CTRL_MODE = $this->input->post('CTRL_MODE');
        $TEMP_INTAKE = $this->input->post('TEMP_INTAKE');
        $TEMP_RETURN = $this->input->post('TEMP_RETURN');
        $TIME_MEASURE = $this->input->post('TIME_MEASURE');
        $TIME_SAMPLE = $this->input->post('TIME_SAMPLE');
        $OP_COUNT = $this->input->post('OP_COUNT');
        $VOLTAGE = $this->input->post('VOLTAGE');
        $DT_STATE = $this->input->post('DT_STATE');
        $TIME_UPLOAD = $this->input->post('TIME_UPLOAD');
        $AVG_TEMP = $this->input->post('AVG_TEMP');
        $VALVE_STATE = $this->input->post('VALVE_STATE');
        $HUMIDITY = $this->input->post('HUMIDITY');
        $SIGNAL_VALUE = $this->input->post('SIGNAL_VALUE');
        
        if(empty($SERIAL_NO) || empty($ON_TIME) || empty($OFF_TIME)
            || empty($TRUE_TEMP) || empty($SET_TEMP) || empty($CTRL_MODE)
            || empty($TEMP_INTAKE) || empty($TEMP_RETURN) || empty($TIME_MEASURE)
            || empty($TIME_SAMPLE) || empty($OP_COUNT) || empty($VOLTAGE)
            || empty($TIME_UPLOAD) || empty($AVG_TEMP)
            || empty($HUMIDITY) || empty($SIGNAL_VALUE)){
            alert('信息填写有误');
        }
        
        $data = $this->input->post();
        
        $this->db->where('CTRL_ID', $METER_ID)->where('FTQ_ID', $CMR_ID)->update('on_off_data_last', $data);
        redirect('zkadmin/on_off');
    }
    
    /**
     * 删除
     */
    public function del(){
        $meter_id = $this->input->post('meter_id');
        $cmr_id = $this->input->post('cmr_id');
        $this->db->where('CTRL_ID', $meter_id)->where('FTQ_ID', $cmr_id)->delete('on_off_data_last');
        redirect('zkadmin/on_off');
    }
    
    /**
     * 添加
     */
    public function add(){
        $METER_ID = $this->input->post('CTRL_ID');
        $SERIAL_NO = $this->input->post('SERIAL_NO');
        $ON_TIME = $this->input->post('ON_TIME');
        $OFF_TIME = $this->input->post('OFF_TIME');
        $TRUE_TEMP = $this->input->post('TRUE_TEMP');
        $SET_TEMP = $this->input->post('SET_TEMP');
        $CTRL_MODE = $this->input->post('CTRL_MODE');
        $TEMP_INTAKE = $this->input->post('TEMP_INTAKE'); 
        $TEMP_RETURN = $this->input->post('TEMP_RETURN');
        $TIME_MEASURE = $this->input->post('TIME_MEASURE');
        $TIME_SAMPLE = $this->input->post('TIME_SAMPLE');
        $OP_COUNT = $this->input->post('OP_COUNT');
        $VOLTAGE = $this->input->post('VOLTAGE');
        $DT_STATE = $this->input->post('DT_STATE');
        $TIME_UPLOAD = $this->input->post('TIME_UPLOAD');
        $AVG_TEMP = $this->input->post('AVG_TEMP');
        $VALVE_STATE = $this->input->post('VALVE_STATE');
        $HUMIDITY = $this->input->post('HUMIDITY');
        $SIGNAL_VALUE = $this->input->post('SIGNAL_VALUE');
        
        if(empty($SERIAL_NO) || empty($ON_TIME) || empty($OFF_TIME)
            || empty($TRUE_TEMP) || empty($SET_TEMP) || empty($CTRL_MODE)
            || empty($TEMP_INTAKE) || empty($TEMP_RETURN) || empty($TIME_MEASURE)
            || empty($TIME_SAMPLE) || empty($OP_COUNT) || empty($VOLTAGE)
            || empty($TIME_UPLOAD) || empty($AVG_TEMP)
            || empty($HUMIDITY) || empty($SIGNAL_VALUE)){
            alert('信息填写有误');
        }
        
        $on_off_used = $this->db->where('FTQ_ID', $METER_ID)->get('on_off_data_last')->row_array();
        if(!empty($on_off_used)){
            alert('该室温表信息已存在');
        }
        
        $meter = $this->db->where('METER_ID', $METER_ID)->from('meter_info')
            ->join('meter_type', 'meter_info.METER_TYPE = meter_type.METER_TYPE and meter_info.MODEL_ID = meter_type.MODEL_ID')->get()->row_array();
        
        $data = $this->input->post();
        $data['FTQ_ID'] = $meter['CMR_ID'];
        $data['CTRL_STATE'] = $meter['STATE'];
        
        $this->db->insert('on_off_data_last', $data);
        redirect('zkadmin/on_off');
    }

    /**
     * 详情
     */
    public function detail() {
        $id = $this->uri->segment(4);
        $data['on_off'] = $this->db->where('CTRL_ID', $id)->from("on_off_data_last")
		  ->join('meter_info', 'meter_info.METER_ID = on_off_data_last.CTRL_ID')
		  ->join('room_info', 'room_info.ROOM_NO = meter_info.ROOM_NO')
          ->join('meter_type', 'meter_type.MODEL_ID = meter_info.MODEL_ID')->get()->row_array();
        $this->load->view('zkadmin/on_off_detail', $data);
    }
}

?>