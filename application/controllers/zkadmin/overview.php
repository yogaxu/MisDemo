<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author 你哥
 *
 */
class Overview extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		islogin();
	}
	
	public function index(){
	    $this->load->view("zkadmin/overview");
	}
}