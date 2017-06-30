<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class register extends CI_Controller {

    public function __construct(){
        parent::__construct();
//        islogin();
        //已登录 应该跳转到主页面
        $CI =& get_instance();
        if($CI->session->userdata('room') == true){
            redirect("mapp/equipment");
        }
        $this->load->model("mapp/register_mod");
        //$this->load->helper(array('form', 'url'));
    }

	
	public function yzm(){
		$this->load->library('captcha_code');
		$this->captcha_code->render();
		//$this->session->set_userdata('yzm',$this->captcha->getCaptcha());
	}
	
	//用户注册页面
	public function index(){
	    $data['dicts'] = $this->register_mod->dictResult();
	    $data['villages'] = $this->register_mod->villageResult();
        $data['buildings'] = $this->register_mod->buildingResult();
        $data['rooms'] = $this->register_mod->roomResult();
        $this->load->view('app/register',$data);

	}

	public function save(){
        $dict = $this->input->post("dict", TRUE);
        $village = $this->input->post("village", TRUE);
        $building = $this->input->post("building", TRUE);
        $room = $this->input->post("room", TRUE);
        $meter = $this->input->post("meter", TRUE);
        $password = $this->input->post("password", TRUE);
        $com_password = $this->input->post("com_password", TRUE);
        $read = $this->input->post("read", TRUE);
        
        if($read == FALSE || $read != 'on'){
            alert("请认真阅读《使用条款和隐私政策》并同意！");
        }
        
        if($password != $com_password){
            alert("密码与确认密码不一致！");
        }

        //验证表单是否为空
        if($dict == "" ||$village == ""||$building == ""||$room == ""|| $password == ""){
            alert("地址或者密码不可以为空");
            exit;
        }

        //验证表单数据
        $this->db->where('METER_ID',$meter)->where('VILLAGE_NO',$village)
            ->where('BUILDING_NO',$building)->where('ROOM_NO',$room);
        $query = $this->db->get('meter_info');
        $dictArray = $query->row_array();

        if($dictArray){
            //注册成功
            $passwordMD5 = md5($password);
            $data=array(
                'PASSWD'=>$passwordMD5
            );
            $this->db->where('VILLAGE_NO',$village)
                ->where('BUILDING_NO',$building)->where('ROOM_NO',$room)->update('room_info',$data);
            alert("注册成功", "../login");
            //redirect("main");
        }else{
            alert("注册失败，请重新确认输入信息是否正确", "mapp/register");
            //redirect("admin/login");
        }
    }
	
	/**
	 * 
	 * 注册页面
	 */
	public function reg(){
		
		//如果已经登陆了就直接去到首页
		$CI =& get_instance();
		if($CI->session->userdata('isvip') != false){
			redirect("../main");
			exit;
		}
		
		$seo['seo'] = $this->seo_mod->get_seo();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', '用户名', 'required');
		
		if ($this->form_validation->run() == FALSE){
			$this->load->view('login_reg',$seo);
		}else{
		
			//接收表单提交数据
			$name = $this->input->post("username", TRUE);
			$phone = $this->input->post("phone", TRUE);
			
		/* 	$power=$this->input->post("kk_power",TRUE); */
			
			$passwd = $this->input->post("passwd", TRUE);
			$password = $this->input->post("password", TRUE);
			$passwd_md5 = md5($passwd);
			$password_md5 = md5($password);
			$numbercode = $this->input->post("numbercode", TRUE);
			//$remember = $this->input->post("remember", TRUE);
			//$check = strtolower($_SESSION['captcha']);
			
			//统计字符的长度
			//$ximicd = strlen($name);
			$mimacd = strlen($passwd);

			//验证密码是否一致
			if($passwd != $password){
				alert("前后两次密码不一致");
				exit;
			}
			
			//验证表单是否为空
			if($name == "" || $phone == "" || $passwd == "" || $password == ""){	
				alert("必填字段不可以为空", "reg");
				exit;
			}
			
			//长度不能太小也不能过大
			if($mimacd < 6 || $mimacd > 16){
				alert("密码长度是6~16个字符");
				exit;
			}
			
			//验证用户名是否存在
			$name_query = $this->db->query("select * from kk_vip where vip_name='$name'");
			if(count($name_query->result()) > 0){
				alert("该用户名已存在");
				exit;
			}
			
			//验证手机号是否存在
// 			$phone_query = $this->db->query("select * from kk_vip where vip_phone='$phone'");
// 			if(count($phone_query->result()) > 0){
// 				alert("该手机号码已被注册");
// 				exit;
// 			}

			//获取这个手机验证码
			/*   $is_yzma = $this->seo_mod->get_verify($phone,1);
			$timesj = time();
			$expire = $timesj - $is_yzma['verify_stime'];
			//如果没有获取到验证码的数据
			if(empty($is_yzma)){
				alert("手机或验证码错误");
				exit;
			}elseif ($is_yzma['verify_status']==1 || $expire > 3600) {
				alert("验证码已经超过有效期");
				exit;
			}elseif ($is_yzma['verify_number']!=$numbercode) {
				alert("验证码输入错误");
				exit;
			}   */
			
			//修改好验证码状态
			$update_data = array(
            	'verify_status' => 1,
            );
			$this->db->where('verify_phone', $phone);
			$this->db->where('leixing_id', 1);
			$this->db->update('kk_verify', $update_data); 	
			
			//记录注册信息
			$data = array(
				'vip_company' => "空",
				'vip_bm' => "空",
				'vip_rename' => $phone,
				'vip_name' => $name,
				'vip_pass' => $password_md5,
				'vip_thumb' => "avatar.jpg",
				'vip_email' => "空",
				'vip_phone' => $phone,
				'vip_qq' => "空",
				'vip_jobyear' => "空",
				'vip_hyxz' => "空",
				'vip_addr' => "空",
				'login_visits' => 1,
				'login_time' => time(),
				'is_honorable' => 0,
				'vip_close' => 0,			
            	'vip_stime' => time(),
				'vip_etime' => time(),
					
					'vip_power'=>0,
					
            );
			$this->db->insert('kk_vip', $data);
			
			//注册的话，直接登陆
			$this->db->where("vip_phone", $phone);
			$this->db->where("vip_pass", $password_md5);
			$query = $this->db->get("kk_vip");
			$user = $query->row_array();
			
			if($user){
				$this->session->set_userdata('isvip', 1);
				$this->session->set_userdata('vipid', $user['vip_id']);
				$this->session->set_userdata('vipname', $user['vip_name']);
				$this->session->set_userdata('viprename', $user['vip_rename']);
				$this->session->set_userdata('vipimages', $user['vip_thumb']);
				$this->session->set_userdata('viphonorable', $user['is_honorable']);
				alert("恭喜注册成功", "../login/success");
				//redirect("admin/paone");
			}else{
				alert("登陆失败，请重新登陆", "../login");
				//redirect("admin/login");
			}
			
		}
	}
	

	
	/**
	 * 
	 * 密码验证修改
	 */
	public function forget(){
		
		//如果已经登陆了就直接去到首页
		$CI =& get_instance();
		if($CI->session->userdata('isvip') != false){
			redirect("../main");
			exit;
		}
		
		$seo['seo'] = $this->seo_mod->get_seo();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('phone', '手机号', 'required');
		
		if ($this->form_validation->run() == FALSE){
			$this->load->view('login_forget',$seo);
		}else{
		
			//接收表单提交数据
			//$name = $this->input->post("username", TRUE);
			$phone = $this->input->post("phone", TRUE);
			$passwd = $this->input->post("passwd", TRUE);
			$password = $this->input->post("password", TRUE);
			$passwd_md5 = md5($passwd);
			$password_md5 = md5($password);
			$numbercode = $this->input->post("numbercode", TRUE);
			//$remember = $this->input->post("remember", TRUE);
			//$check = strtolower($_SESSION['captcha']);
			
			//统计字符的长度
			//$ximicd = strlen($name);
			$mimacd = strlen($passwd);

			//验证密码是否一致
			if($passwd != $password){
				alert("前后两次密码不一致");
				exit;
			}
			
			//验证表单是否为空
			if($phone == "" || $passwd == "" || $password == ""){	
				alert("必填字段不可以为空", "forget");
				exit;
			}
			
			//长度不能太小也不能过大
			if($mimacd < 6 || $mimacd > 16){
				alert("密码长度是6~16个字符");
				exit;
			}
			
			//获取这个手机验证码  1注册2取回3修改
			$is_yzma = $this->seo_mod->get_verify($phone,3);
			$timesj = time();
			$expire = $timesj - $is_yzma['verify_stime'];
			//如果没有获取到验证码的数据
			if(empty($is_yzma)){
				alert("手机或验证码错误");
				exit;
			}elseif ($is_yzma['verify_status']==1 || $expire > 3600) {
				alert("验证码已经超过有效期");
				exit;
			}elseif ($is_yzma['verify_number']!=$numbercode) {
				alert("验证码输入错误");
				exit;
			}
			
			//修改好验证码状态
			$update_data = array(
            	'verify_status' => 1,
            );
			$this->db->where('verify_phone', $phone);
			$this->db->where('leixing_id', 3);
			$this->db->update('kk_verify', $update_data);
			
			//修改会员密码
			$miss_data = array(
            	'vip_pass' => $password_md5,
            );
			$this->db->where('vip_phone', $phone);
			$this->db->update('kk_vip', $miss_data); 	
			
			alert("密码修改成功,请重新登录", "../login");
			
		}
	}
	
	
	/**
	 *
	 * 注册成功页面
	 */
	public function success(){
	
		$seo['seo'] = $this->seo_mod->get_seo();
	
		$this->load->view('login_success',$seo);
	
	}
	
	
	
	//退出清空登陆信息
	public function logout(){
		$this->session->unset_userdata('isvip');
		$this->session->unset_userdata('vipid');
		$this->session->unset_userdata('vipname');
		$this->session->unset_userdata('vipimages');
		redirect("login");
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
