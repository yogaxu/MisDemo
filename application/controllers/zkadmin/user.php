<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class User extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		islogin();
		$this->load->model("zkadmin/user_mod");
		//$this->load->helper(array('form', 'url'));
	}

	/**
	 * 
	 * 用户列表
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
		$count_all = $this->user_mod->count_all($search);
		
		//生成分页链接,分页配置在libraries文件夹里
		$this->load->library('pages');
		$config['base_url'] = base_url("zkadmin/user/index?keywords=".$search);
		$config['first_url'] = base_url("zkadmin/user/index?keywords=".$search."&per_page=1.html");
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
		$data['list'] = $this->user_mod->get_list($search, $start, $limit);
		$data['keywords'] = $search;
		
		//小区
		$data['village_info'] = $this->db->get('village_info')->result_array();
		
		$this->load->view('zkadmin/user_list', $data);
	}
	
	/**
	 * 
	 * 用户详情
	 */
	public function detail(){
		$card_no = $this->uri->segment(4);
		$data['user'] = $this->user_mod->get_user($card_no);
		$this->load->view('zkadmin/user_detail', $data);
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
	    $rooms = $this->db->where('room_info.BUILDING_NO', $building_no)
	       ->where('PASSWD =', '')->from('room_info')
	       ->join('meter_info', 'meter_info.VILLAGE_NO = room_info.VILLAGE_NO and meter_info.BUILDING_NO = room_info.BUILDING_NO and meter_info.ROOM_NO = room_info.ROOM_NO')
	       ->get()->result_array();
	     
	    //防中文乱码
	    foreach ( $rooms as $room => $v) {
	        foreach ($rooms[$room] as $key => $value){
	            $rooms[$room][$key] = urlencode($value);
	        }
	    }
	     
	    echo urldecode(json_encode($rooms));
	    exit;
	}
	
	/**
	 * 添加用户信息
	 */
	public function add(){
	    $METER_ID = $this->input->post('METER_ID');
	    $VILLAGE_NO = $this->input->post('VILLAGE_NO');
	    $BUILDING_NO = $this->input->post('BUILDING_NO');
	    $ROOM_NO = $this->input->post('ROOM_NO');
	    $USER_NAME = $this->input->post('USER_NAME');
	    $ID_CARD = $this->input->post('ID_CARD');
	    $MOBILE = $this->input->post('MOBILE');
	    $TELEPHONE = $this->input->post('TELEPHONE');
	    $PASSWD = $this->input->post('PASSWD');
	    $REPASSWD = $this->input->post('REPASSWD');
	    
	    $result = array();
	    
	    if(empty($PASSWD) || empty($REPASSWD)){
	        $result['ret'] = 'fail';
	        $result['msg'] = '信息输入有误';
	        echo json_encode($result);
	        exit;
	    }
	    
	    if(strcmp($PASSWD, $REPASSWD) != 0){
	        $result['ret'] = 'fail';
	        $result['msg'] = '请确认两次输入密码相同';
	        echo json_encode($result);
	        exit;
	    }
	    
	    $data = array(
	        'USER_NAME' => $USER_NAME,
	        'ID_CARD' => $ID_CARD,
	        'MOBILE' => $MOBILE,
	        'TELEPHONE' => $TELEPHONE,
	        'PASSWD' => md5($PASSWD)
	    );
	    $this->db->where('VILLAGE_NO', $VILLAGE_NO)->where('BUILDING_NO', $BUILDING_NO)
	       ->where('ROOM_NO', $ROOM_NO)->update('room_info', $data);
	    
	    $meter_data = array(
	        'USER_NAME' => $USER_NAME
	    );
	    $this->db->where('METER_ID', $METER_ID)->update('meter_info', $meter_data);
        $result['ret'] = 'succ';
        $result['msg'] = $METER_ID;
        echo json_encode($result);
        exit;
	}
	
	/**
	 * 修改用户信息
	 */
	public function update(){
	    $METER_ID = $this->input->post('METER_ID');
	    $OLD_METER_ID = $this->input->post('OLD_METER_ID');
	    $VILLAGE_NO = $this->input->post('VILLAGE_NO');
	    $BUILDING_NO = $this->input->post('BUILDING_NO');
	    $ROOM_NO = $this->input->post('ROOM_NO');
	    $USER_NAME = $this->input->post('USER_NAME');
	    $ID_CARD = $this->input->post('ID_CARD');
	    $MOBILE = $this->input->post('MOBILE');
	    $TELEPHONE = $this->input->post('TELEPHONE');
	    $OLD_PASSWD = $this->input->post('OLD_PASSWD');
	    $PASSWD = $this->input->post('PASSWD');
	    $REPASSWD = $this->input->post('REPASSWD');
	    
	    $result = array();
	    
	    if(!empty($OLD_PASSWD) && !empty($PASSWD) 
	        && !empty($REPASSWD) && strcmp($PASSWD, $REPASSWD) != 0){
	        $result['ret'] = 'fail';
	        $result['msg'] = '请确认两次输入密码相同';
	        echo json_encode($result);
	        exit;
	    }
	    
	    $meter_old = $this->db->where('METER_ID', $OLD_METER_ID)->get('meter_info')->row_array();
	    $room_old = $this->db->where('VILLAGE_NO', $meter_old['VILLAGE_NO'])
	       ->where('BUILDING_NO', $meter_old['BUILDING_NO'])->where('ROOM_NO', $meter_old['ROOM_NO'])
	       ->get('room_info')->row_array();
	    
	    if(!empty($OLD_PASSWD) && !empty($PASSWD) 
	        && !empty($REPASSWD) && strcmp($room_old['PASSWD'], $OLD_PASSWD) != 0){
	        $result['ret'] = 'fail';
	        $result['msg'] = '原密码输入有误';
	        echo json_encode($result);
	        exit;
	    }
	    
	    if(strcmp($METER_ID, $OLD_METER_ID) == 0){
    	    $data = array(
    	        'USER_NAME' => $USER_NAME,
    	        'ID_CARD' => $ID_CARD,
    	        'MOBILE' => $MOBILE,
    	        'TELEPHONE' => $TELEPHONE,
    	        'PASSWD' => md5($PASSWD)
    	    );
    	    $this->db->where('VILLAGE_NO', $VILLAGE_NO)->where('BUILDING_NO', $BUILDING_NO)
    	       ->where('ROOM_NO', $ROOM_NO)->update('room_info', $data);
    	    
    	    $meter_data = array(
    	        'USER_NAME' => $USER_NAME
    	    );
    	    $this->db->where('METER_ID', $METER_ID)->update('meter_info', $meter_data);
            $result['ret'] = 'succ';
            $result['msg'] = $METER_ID;
            echo json_encode($result);
            exit;
	    }else{
	        $data_remove = array(
    	        'USER_NAME' => '',
    	        'ID_CARD' => '',
    	        'MOBILE' => '',
    	        'TELEPHONE' => '',
    	        'PASSWD' => ''
	        );
	        $this->db->where('VILLAGE_NO', $room_old['VILLAGE_NO'])->where('BUILDING_NO', $room_old['BUILDING_NO'])
	           ->where('ROOM_NO', $room_old['ROOM_NO'])->update('room_info', $data_remove);
	        
	        $meter_data_remove = array(
	            'USER_NAME' => ''
	        );
	        $this->db->where('METER_ID', $OLD_METER_ID)->update('meter_info', $meter_data_remove);
	        
    	    $data = array(
    	        'USER_NAME' => $USER_NAME,
    	        'ID_CARD' => $ID_CARD,
    	        'MOBILE' => $MOBILE,
    	        'TELEPHONE' => $TELEPHONE
    	    );
	        if(!empty($PASSWD) && !empty($REPASSWD)){
                $data['PASSWD'] = md5($PASSWD);
	        }else{
                $data['PASSWD'] = md5($OLD_PASSWD);
	        }
    	    $this->db->where('VILLAGE_NO', $VILLAGE_NO)->where('BUILDING_NO', $BUILDING_NO)
    	       ->where('ROOM_NO', $ROOM_NO)->update('room_info', $data);
    	    
    	    $meter_data = array(
    	        'USER_NAME' => $USER_NAME
    	    );
    	    $this->db->where('METER_ID', $METER_ID)->update('meter_info', $meter_data);
            $result['ret'] = 'succ';
            $result['msg'] = $METER_ID;
            echo json_encode($result);
            exit;
	    }
	}
	
	/**
	 * 删除
	 */
	public function del() {
	    $vid = $this->input->post('vid');
	    $bid = $this->input->post('bid');
	    $rid = $this->input->post('rid');
	    
	    $data_remove = array(
	        'USER_NAME' => '',
	        'ID_CARD' => '',
	        'MOBILE' => '',
	        'TELEPHONE' => '',
	        'PASSWD' => ''
	    );
	    $this->db->where('VILLAGE_NO', $vid)->where('BUILDING_NO', $bid)
	    ->where('ROOM_NO', $rid)->update('room_info', $data_remove);
	     
	    $meter_data_remove = array(
	        'USER_NAME' => ''
	    );
	    $this->db->where('VILLAGE_NO', $vid)->where('BUILDING_NO', $bid)
	       ->where('ROOM_NO', $rid)->update('meter_info', $meter_data_remove);
	    redirect('zkadmin/user');
	}
}