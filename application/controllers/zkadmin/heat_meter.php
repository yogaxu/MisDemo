<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Heat_meter extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/heat_meter_mod");
    }

    /**
     *
     * 楼栋总表 - 热表
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
		$count_all = $this->heat_meter_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/heat_meter/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/heat_meter/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->heat_meter_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
		
		//热表
		$data['meter_info'] = $this->db->where('METER_TYPE', 1)->get('meter_info')->result_array();
		
		$this->load->view('zkadmin/heat_meter_list', $data);
    }
    
    /**
     * 修改
     */
    public function update(){
        $CMR_ID = $this->input->post('CMR_ID');
        $HEAT_METER_ID = $this->input->post('HEAT_METER_ID');
        $BATCH_NO = $this->input->post('BATCH_NO');
        $SERIAL_NO = $this->input->post('SERIAL_NO');
        $HEAT_QUANTITY_REAL = $this->input->post('HEAT_QUANTITY_REAL');
        $HEAT_QUANTITY_UNIT = $this->input->post('HEAT_QUANTITY_UNIT');
        $VOLUME = $this->input->post('VOLUME');
        $VOLUME_UNIT = $this->input->post('VOLUME_UNIT');
        $HEAT_POWER = $this->input->post('HEAT_POWER');
        $HEAT_POWER_UNIT = $this->input->post('HEAT_POWER_UNIT');
        $FLOWRATE_REAL = $this->input->post('FLOWRATE_REAL');
        $FLOWRATE_UNIT = $this->input->post('FLOWRATE_UNIT');
        $TEMP_INTAKE = $this->input->post('TEMP_INTAKE');
        $TEMP_RETURN = $this->input->post('TEMP_RETURN');
        $HOURS_OPERATING = $this->input->post('HOURS_OPERATING');
        $HOURS_FAILURE = $this->input->post('HOURS_FAILURE');
        $TIME_SAMPLE = $this->input->post('TIME_SAMPLE');
        $TIME_UPLOAD = $this->input->post('TIME_UPLOAD');
        $TIME_HEAT_METER = $this->input->post('TIME_HEAT_METER');
        
        if(empty($BATCH_NO) || empty($SERIAL_NO) || empty($HEAT_QUANTITY_REAL)
            || empty($VOLUME) || empty($HEAT_POWER)
            || empty($FLOWRATE_REAL) || empty($TEMP_INTAKE) || empty($TEMP_RETURN)
            || empty($HOURS_OPERATING) || empty($HOURS_FAILURE) || empty($TIME_SAMPLE)
            || empty($TIME_UPLOAD) || empty($TIME_HEAT_METER)){
            alert('信息填写有误');
        }
        
        //默认单位
        if(empty($HEAT_QUANTITY_UNIT)) $HEAT_QUANTITY_UNIT = "kWh";
        if(empty($VOLUME_UNIT)) $VOLUME_UNIT = "m^3";
        if(empty($HEAT_POWER_UNIT)) $HEAT_POWER_UNIT = "kW";
        if(empty($FLOWRATE_UNIT)) $FLOWRATE_UNIT = "l/h";
        
        $data = array(
            'BATCH_NO' => $BATCH_NO,
            'SERIAL_NO' => $SERIAL_NO,
            'HEAT_QUANTITY' => $HEAT_QUANTITY_REAL,
            'HEAT_QUANTITY_REAL' => $HEAT_QUANTITY_REAL,
            'HEAT_QUANTITY_UNIT' => $HEAT_QUANTITY_UNIT,
            'VOLUME' => $VOLUME,
            'VOLUME_UNIT' => $VOLUME_UNIT,
            'HEAT_POWER' => $HEAT_POWER,
            'HEAT_POWER_UNIT' => $HEAT_POWER_UNIT,
            'FLOWRATE' => $FLOWRATE_REAL,
            'FLOWRATE_REAL' => $FLOWRATE_REAL,
            'FLOWRATE_UNIT' => $FLOWRATE_UNIT,
            'TEMP_INTAKE' => $TEMP_INTAKE,
            'TEMP_RETURN' => $TEMP_RETURN,
            'HOURS_OPERATING' => $HOURS_OPERATING,
            'HOURS_FAILURE' => $HOURS_FAILURE,
            'TIME_SAMPLE' => $TIME_SAMPLE,
            'TIME_UPLOAD' => $TIME_UPLOAD,
            'TIME_HEAT_METER' => $TIME_HEAT_METER
        );
        
        $this->db->where('CMR_ID', $CMR_ID)->where('HEAT_METER_ID', $HEAT_METER_ID)->update('heat_meter_data_last', $data);
        redirect('zkadmin/heat_meter');
    }
    
    /**
     * 删除
     */
    public function del(){
        $meter_id = $this->input->post('meter_id');
        $cmr_id = $this->input->post('cmr_id');
        $this->db->where('HEAT_METER_ID', $meter_id)->where('CMR_ID', $cmr_id)->delete('heat_meter_data_last');
        redirect('zkadmin/heat_meter');
    }
    
    /**
     * 添加
     */
    public function add(){
        $HEAT_METER_ID = $this->input->post('HEAT_METER_ID');
        $BATCH_NO = $this->input->post('BATCH_NO');
        $SERIAL_NO = $this->input->post('SERIAL_NO');
        $HEAT_QUANTITY_REAL = $this->input->post('HEAT_QUANTITY_REAL');
        $HEAT_QUANTITY_UNIT = $this->input->post('HEAT_QUANTITY_UNIT');
        $VOLUME = $this->input->post('VOLUME');
        $VOLUME_UNIT = $this->input->post('VOLUME_UNIT'); 
        $HEAT_POWER = $this->input->post('HEAT_POWER');
        $HEAT_POWER_UNIT = $this->input->post('HEAT_POWER_UNIT');
        $FLOWRATE_REAL = $this->input->post('FLOWRATE_REAL');
        $FLOWRATE_UNIT = $this->input->post('FLOWRATE_UNIT');
        $TEMP_INTAKE = $this->input->post('TEMP_INTAKE');
        $TEMP_RETURN = $this->input->post('TEMP_RETURN');
        $HOURS_OPERATING = $this->input->post('HOURS_OPERATING');
        $HOURS_FAILURE = $this->input->post('HOURS_FAILURE');
        $TIME_SAMPLE = $this->input->post('TIME_SAMPLE');
        $TIME_UPLOAD = $this->input->post('TIME_UPLOAD');
        $TIME_HEAT_METER = $this->input->post('TIME_HEAT_METER');
        
        if(empty($BATCH_NO) || empty($SERIAL_NO) || empty($HEAT_QUANTITY_REAL)
            || empty($VOLUME) || empty($HEAT_POWER)
            || empty($FLOWRATE_REAL) || empty($TEMP_INTAKE) || empty($TEMP_RETURN)
            || empty($HOURS_OPERATING) || empty($HOURS_FAILURE) || empty($TIME_SAMPLE)
            || empty($TIME_UPLOAD) || empty($TIME_HEAT_METER)){
            alert('信息填写有误');
        }
        
        //默认单位
        if(empty($HEAT_QUANTITY_UNIT)) $HEAT_QUANTITY_UNIT = "kWh";
        if(empty($VOLUME_UNIT)) $VOLUME_UNIT = "m^3";
        if(empty($HEAT_POWER_UNIT)) $HEAT_POWER_UNIT = "kW";
        if(empty($FLOWRATE_UNIT)) $FLOWRATE_UNIT = "l/h";
        
        $heat_meter_used = $this->db->where('HEAT_METER_ID', $HEAT_METER_ID)->get('heat_meter_data_last')->row_array();
        if(!empty($heat_meter_used)){
            alert('该热表信息已存在');
        }
        
        $meter = $this->db->where('METER_ID', $HEAT_METER_ID)->from('meter_info')
            ->join('meter_type', 'meter_info.METER_TYPE = meter_type.METER_TYPE and meter_info.MODEL_ID = meter_type.MODEL_ID')->get()->row_array();
        
        $data = array(
            'CMR_ID' => $meter['CMR_ID'],
            'HEAT_METER_ID' => $HEAT_METER_ID,
            'BATCH_NO' => $BATCH_NO,
            'SERIAL_NO' => $SERIAL_NO,
            'CH' => $meter['CH'],
            'MBUS_ADDR' => $meter['MBUS_ADDR'],
            'HEAT_METER_TYPE' => $meter['METER_TYPE'],
            'HEAT_QUANTITY' => $HEAT_QUANTITY_REAL,
            'HEAT_QUANTITY_REAL' => $HEAT_QUANTITY_REAL,
            'HEAT_QUANTITY_UNIT' => $HEAT_QUANTITY_UNIT,
            'VOLUME' => $VOLUME,
            'VOLUME_UNIT' => $VOLUME_UNIT,
            'HEAT_POWER' => $HEAT_POWER,
            'HEAT_POWER_UNIT' => $HEAT_POWER_UNIT,
            'FLOWRATE' => $FLOWRATE_REAL,
            'FLOWRATE_REAL' => $FLOWRATE_REAL,
            'FLOWRATE_UNIT' => $FLOWRATE_UNIT,
            'TEMP_INTAKE' => $TEMP_INTAKE,
            'TEMP_RETURN' => $TEMP_RETURN,
            'HOURS_OPERATING' => $HOURS_OPERATING,
            'HOURS_FAILURE' => $HOURS_FAILURE,
            'TIME_SAMPLE' => $TIME_SAMPLE,
            'TIME_UPLOAD' => $TIME_UPLOAD,
            'TIME_HEAT_METER' => $TIME_HEAT_METER,
            'STATE' => $meter['STATE'],
            'NOTES' => $meter['BOTES']
        );
        
        $this->db->insert('heat_meter_data_last', $data);
        redirect('zkadmin/heat_meter');
    }

    /**
     * 详情
     */
    public function detail() {
        $id = $this->uri->segment(4);
        $data['heat_meter'] = $this->db->where('HEAT_METER_ID', $id)->from("heat_meter_data_last")
		  ->join('meter_info', 'meter_info.METER_ID = heat_meter_data_last.HEAT_METER_ID')
		  ->join('room_info', 'room_info.ROOM_NO = meter_info.ROOM_NO')->get()->row_array();
        $this->load->view('zkadmin/heat_meter_detail', $data);
    }
}

?>