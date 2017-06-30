<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Gas_meter extends CI_Controller {

    public function __construct(){
        parent::__construct();
        islogin();
        $this->load->model("zkadmin/gas_meter_mod");
    }

    /**
     *
     * 燃气表
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
		$count_all = $this->gas_meter_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/gas_meter/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/gas_meter/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->gas_meter_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
		
		//燃气表
		$data['meter_info'] = $this->db->where('METER_TYPE', 5)->get('meter_info')->result_array();
		
		$this->load->view('zkadmin/gas_meter_list', $data);
    }
    
    /**
     * 修改
     */
    public function update(){
        $CMR_ID = $this->input->post('CMR_ID');
        $METER_ID = $this->input->post('METER_ID');
        $BATCH_NO = $this->input->post('BATCH_NO');
        $SERIAL_NO = $this->input->post('SERIAL_NO');
        $CUR_TOTAL_FLOW = $this->input->post('CUR_TOTAL_FLOW');
        $UNIT_CUR_TOTAL_FLOW = $this->input->post('UNIT_CUR_TOTAL_FLOW');
        $DAY_TOTAL_FLOW = $this->input->post('DAY_TOTAL_FLOW');
        $UNIT_DAY_TOTAL_FLOW = $this->input->post('UNIT_DAY_TOTAL_FLOW');
        $MONTH_TOTAL_FLOW = $this->input->post('MONTH_TOTAL_FLOW');
        $UNIT_MONTH_TOTAL_FLOW = $this->input->post('UNIT_MONTH_TOTAL_FLOW');
        $IN_FLOW = $this->input->post('IN_FLOW');
        $UNIT_IN_FLOW = $this->input->post('UNIT_IN_FLOW');
        $TIME_SAMPLE = $this->input->post('TIME_SAMPLE');
        $TIME_UPLOAD = $this->input->post('TIME_UPLOAD');
        $REALTIME = $this->input->post('REALTIME');
        
        if(empty($BATCH_NO) || empty($SERIAL_NO) || empty($CUR_TOTAL_FLOW)
            || empty($TIME_SAMPLE) || empty($DAY_TOTAL_FLOW)
            || empty($TIME_UPLOAD) || empty($REALTIME) || empty($IN_FLOW)
            || empty($MONTH_TOTAL_FLOW)){
            alert('信息填写有误');
        }
        
        //默认单位
        if(empty($UNIT_CUR_TOTAL_FLOW)) $UNIT_CUR_TOTAL_FLOW = "m^3";
        if(empty($UNIT_DAY_TOTAL_FLOW)) $UNIT_DAY_TOTAL_FLOW = "m^3";
        if(empty($UNIT_IN_FLOW)) $UNIT_IN_FLOW = "m^3";
        if(empty($UNIT_MONTH_TOTAL_FLOW)) $UNIT_MONTH_TOTAL_FLOW = "m^3";
        
        $data = $this->input->post();
        $data['UNIT_CUR_TOTAL_FLOW'] = $UNIT_CUR_TOTAL_FLOW;
        $data['UNIT_DAY_TOTAL_FLOW'] = $UNIT_DAY_TOTAL_FLOW;
        $data['UNIT_IN_FLOW'] = $UNIT_IN_FLOW;
        $data['UNIT_MONTH_TOTAL_FLOW'] = $UNIT_MONTH_TOTAL_FLOW;
        
        $this->db->where('CMR_ID', $CMR_ID)->where('METER_ID', $METER_ID)->update('gas_meter_data_last', $data);
        redirect('zkadmin/gas_meter');
    }
    
    /**
     * 删除
     */
    public function del(){
        $meter_id = $this->input->post('meter_id');
        $cmr_id = $this->input->post('cmr_id');
        $this->db->where('METER_ID', $meter_id)->where('CMR_ID', $cmr_id)->delete('gas_meter_data_last');
        redirect('zkadmin/gas_meter');
    }
    
    /**
     * 添加
     */
    public function add(){
        $METER_ID = $this->input->post('METER_ID');
        $BATCH_NO = $this->input->post('BATCH_NO');
        $SERIAL_NO = $this->input->post('SERIAL_NO');
        $CUR_TOTAL_FLOW = $this->input->post('CUR_TOTAL_FLOW'); 
        $UNIT_CUR_TOTAL_FLOW = $this->input->post('UNIT_CUR_TOTAL_FLOW');
        $DAY_TOTAL_FLOW = $this->input->post('DAY_TOTAL_FLOW');
        $UNIT_DAY_TOTAL_FLOW = $this->input->post('UNIT_DAY_TOTAL_FLOW');
        $MONTH_TOTAL_FLOW = $this->input->post('MONTH_TOTAL_FLOW');
        $UNIT_MONTH_TOTAL_FLOW = $this->input->post('UNIT_MONTH_TOTAL_FLOW');
        $IN_FLOW = $this->input->post('IN_FLOW');
        $UNIT_IN_FLOW = $this->input->post('UNIT_IN_FLOW');
        $TIME_SAMPLE = $this->input->post('TIME_SAMPLE');
        $TIME_UPLOAD = $this->input->post('TIME_UPLOAD');
        $REALTIME = $this->input->post('REALTIME');
        
        if(empty($BATCH_NO) || empty($SERIAL_NO) || empty($CUR_TOTAL_FLOW)
            || empty($TIME_SAMPLE) || empty($DAY_TOTAL_FLOW)
            || empty($TIME_UPLOAD) || empty($REALTIME) || empty($IN_FLOW)
            || empty($MONTH_TOTAL_FLOW)){
            alert('信息填写有误');
        }
        
        //默认单位
        if(empty($UNIT_CUR_TOTAL_FLOW)) $UNIT_CUR_TOTAL_FLOW = "m^3";
        if(empty($UNIT_DAY_TOTAL_FLOW)) $UNIT_DAY_TOTAL_FLOW = "m^3";
        if(empty($UNIT_IN_FLOW)) $UNIT_IN_FLOW = "m^3";
        if(empty($UNIT_MONTH_TOTAL_FLOW)) $UNIT_MONTH_TOTAL_FLOW = "m^3";
        
        $gas_meter_used = $this->db->where('METER_ID', $METER_ID)->get('gas_meter_data_last')->row_array();
        if(!empty($gas_meter_used)){
            alert('该燃气表信息已存在');
        }
        
        $meter = $this->db->where('METER_ID', $METER_ID)->from('meter_info')
            ->join('meter_type', 'meter_info.METER_TYPE = meter_type.METER_TYPE and meter_info.MODEL_ID = meter_type.MODEL_ID')->get()->row_array();
        
        $data = $this->input->post();
        $data['CMR_ID'] = $meter['CMR_ID'];
        $data['CH'] = $meter['CH'];
        $data['METER_TYPE'] = $meter['METER_TYPE'];
        $data['STATE'] = $meter['STATE'];
        $data['NOTES'] = $meter['NOTES'];
        $data['UNIT_CUR_TOTAL_FLOW'] = $UNIT_CUR_TOTAL_FLOW;
        $data['UNIT_DAY_TOTAL_FLOW'] = $UNIT_DAY_TOTAL_FLOW;
        $data['UNIT_IN_FLOW'] = $UNIT_IN_FLOW;
        $data['UNIT_MONTH_TOTAL_FLOW'] = $UNIT_MONTH_TOTAL_FLOW;
        
        $this->db->insert('gas_meter_data_last', $data);
        redirect('zkadmin/gas_meter');
    }

    /**
     * 详情
     */
    public function detail() {
        $id = $this->uri->segment(4);
        $data['gas_meter'] = $this->db->where('gas_meter_data_last.METER_ID', $id)->from("gas_meter_data_last")
		  ->join('meter_info', 'meter_info.METER_ID = gas_meter_data_last.METER_ID')
		  ->join('room_info', 'room_info.ROOM_NO = meter_info.ROOM_NO')
          ->join('meter_type', 'meter_type.MODEL_ID = meter_info.MODEL_ID')->get()->row_array();
        $this->load->view('zkadmin/gas_meter_detail', $data);
    }
}

?>