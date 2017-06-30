<?php
require_once dirname(__FILE__)."/../../libraries/wechat/lib/WxPay.Api.php";
require_once dirname(__FILE__)."/../../libraries/wechat/example/WxPay.JsApiPay.php";
require_once dirname(__FILE__)."/../../libraries/wechat/lib/WxPay.Notify.php";
require_once dirname(__FILE__)."/../../libraries/wechat/example/notify.php";

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/29
 * Time: 14:42
 */
class pay extends CI_Controller {

    public function __construct(){
        parent::__construct();
        user_islogin();
        $this->load->model("mapp/user_mod");
    }

    public function index(){
        $data = $this->input->post();
        $this->load->view("app/pay", $data);
    }

}