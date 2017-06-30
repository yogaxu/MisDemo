<?php


/**
 * @author 你哥
 *
 */
class evaluate extends CI_Controller {

    public function __construct(){
        parent::__construct();
        user_islogin();
        //        $this->load->model("mapp/register_mod");
        //$this->load->helper(array('form', 'url'));
    }

    public function index(){
        $data['id'] = $this->uri->segment(4);
        $this->load->view("app/evaluate", $data);
    }
    
    /**
     * 用户评价
     */
    public function star(){
        $id = $this->uri->segment(4);
        $user_star_rate = $this->input->post('user_star_rate');
        $user_service_rate = $this->input->post('user_service_rate');
        $data = array(
            'user_star_rate' => $user_star_rate,
            'user_service_rate' =>$user_service_rate
        );
        $result = $this->db->where('id', $id)->update('repair_complete', $data);
        if($result){
            alert('评价成功', '../../repair');
        }else{
            alert('评价失败', '../../repair');
        }
    }
}

?>