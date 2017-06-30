<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Login extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("zkadmin/main_mod");
		session_start();
	}
	
	//获取验证码
	public function captcha(){
		$this->load->library('captcha_code');
		$this->captcha_code->render();
// 		$this->session->set_userdata('yzm',$this->captcha->getCaptcha());
	}
	
	//登录
	public function index(){
	    
		$this->load->library('session');
		if(!empty($_POST)){
		
			//接收表单提交数据
			$username = $this->input->post("username", TRUE);
			$passwd = $this->input->post("password", TRUE);
			$passwd_md5 = md5($passwd);
			$imgcode = strtolower($this->input->post("imgcode", TRUE));
// 			$remember = $this->input->post("remember", TRUE);
        	$check = strtolower($_SESSION['captcha']);
			
			//验证验证码，为空或者没输入就提示
// 			if($imgcode == "" || $imgcode != $check){	
// 				alert("验证码错误", "login");
// 			}
			
			//验证表单数据
			$this->db->where("username", $username);
			$this->db->where("password", $passwd_md5);
			$query = $this->db->get("admin_info");
			$user = $query->row_array();
			
			
			if($user){
				//file_put_contents('./sid.txt',$this->session->userdata('session_id'));
				if($user['status'] == 1){
				    alert("该账号未启用", "zkadmin/login");
				}else{
    				//记录登录状态
    				$this->session->set_userdata('islogin', 1);
    				$this->session->set_userdata('userid', $user['id']);
    				$this->session->set_userdata('username', $user['username']);
    				$this->session->set_userdata('userrole', $user['role_id']);
    				
    				//是否记住用户名和密码
//     				if($remember == 1){
//     					setcookie('username',$username,time()+604800);
//     					setcookie('passwd',$passwd,time()+604800);
//     					setcookie('remember',$remember,time()+604800);
//     				}else{
//     					setcookie('username',$username,time()-604800);
//     					setcookie('passwd',$passwd,time()-604800);
//     					setcookie('remember',$remember,time()-604800);
//     				}
    				
    				redirect("zkadmin/main");
				}
			}else{
				alert("账号或密码不正确", "zkadmin/login");
			}
		}else{
		    $this->load->view('zkadmin/login');
		}
			
	}
	
	//退出清空登陆信息
	public function logout(){
		$this->session->unset_userdata('islogin');
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('userrole');
		redirect("zkadmin/login");
	}
	
}