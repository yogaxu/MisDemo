<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/29
 * Time: 13:10
 * 报修
 */
class repair extends CI_Controller {

    public function __construct(){
        parent::__construct();
        user_islogin();
        $this->load->model("mapp/register_mod");
        //$this->load->helper(array('form', 'url'));
    }

    /**
     * 报修单页面
     */
    public function index(){
        $info = get_info();
        //用户信息
        $this->db->where('VILLAGE_NO',$info['village'])->where('BUILDING_NO',$info['building'])
            ->where('ROOM_NO',$info['room']);
        $data = $this->db->get('meter_info')->row_array();
        $data['faluts'] = $this->db->get("fault_cause")->result_array(); //设备故障信息
        $pre = $this->db->where('card_no', $data['METER_ID'])->get('v_bs_user_realtime_data')->row_array(); //系统预判
        $data['predict'] = $pre['fault_message'];
        
        //待处理工单
        $data['repair_wait'] = $this->db->where('meter_id', $data['METER_ID'])
            ->order_by('report_time', 'DESC')->get('repair_pending')->result_array();
        
        //报修历史
        $data['history'] = $this->db->where('meter_id', $data['METER_ID'])
            ->order_by('repair_time', 'DESC')->get('repair_complete')->result_array();
        
        $this->load->view("app/repair",$data);
    }

    /**
     * 报修单保存--待处理
     */
    public function save(){
        $info = get_info();
        $this->db->where('VILLAGE_NO',$info['village'])->where('BUILDING_NO',$info['building'])
            ->where('ROOM_NO',$info['room']);
        $meter = $this->db->get('meter_info')->row_array();
        $url_path="";

        //文件上传配置
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|xlsx|xls|txt|csv|pdf|docx|doc|ppt|rar';
        $config['max_size'] = '85120';
        $config['max_width']  = '0';
        $config['max_height']  = '0';

        //缩略图配置
        $imgconfig = array();
        $imgconfig['image_library'] = 'gd2';
        $imgconfig['new_image'] = './uploads/'.date("Ym",time()).'/';
        $imgconfig['create_thumb'] = TRUE;
        $imgconfig['master_dim'] = 'width';    //宽和高  以宽为准来进行调整
        $imgconfig['width'] = 265;
        $imgconfig['height'] = 200;
        $imgconfig['maintain_ratio'] = TRUE;   //设置为 FALSE  不保持纵横比， TRUE 保持纵横比

        //判断是否有上传图片，如果没有就提示
        foreach ($_FILES as $key=>$img){
            if($img['error'] != 4){
                //一切都没问题，就开始创建以日期形式的文件夹
                $pasth = setPath("uploads");
                //图片上传，图片配置在config文件夹
                $this->load->library('upload');
                $config['file_name'] = date("YmdHis").rand(00, 99);
                $this->upload->initialize($config);
                if($this->upload->do_upload($key)){
                    $data = $this->upload->data();
                    $images = $data['file_name'];
                    //图片上传以后，创建一个缩略图，配置在 system/libraries  里
                    $this->load->library('image_lib');
                    $imgconfig['source_image'] = './uploads/'.$images;
                    $this->image_lib->initialize($imgconfig);
                    $this->image_lib->resize();
                    //把上传的图片删掉只保留缩略图
                    $fileimg = 'uploads/'.$images;
                    if(!unlink($fileimg)){}
                    //获取缩略图的文件名，然后保存到数据库，把前面的日期也带上，方便到时删除
                    $image_path = date("Ym",time()).'/'.$data["raw_name"]."_thumb".$data["file_ext"];
                    $url_path .= $image_path.',';
                }else{
                    alert('上传失败！');
                }
            }
        }

        if($url_path !="") {
            $url_path=substr($url_path, 0, -1);
        }


        $user_name = $this->input->post("user_name", TRUE);
        $user_tel = $this->input->post("user_tel", TRUE);
        $beginTime = $this->input->post("beginTime", TRUE);
        $endTime = $this->input->post("endTime", TRUE);
        $falut = $this->input->post("falut", TRUE);
        $predict = $this->input->post("predict", TRUE);
        $user_description = $this->input->post("user_description", TRUE);
//         $pend = $this->db->query('SELECT max(id) id FROM  repair_pending')->row_array();
        $today = date('ymd', time());
        $order_id = $today.'0001';
        $pend = $this->db->like('order_id', $today)->select_max('order_id')->get('repair_pending')->row_array();
        if($pend['order_id'] != NULL){
            $order_id = $pend['order_id'] + 1;
        }
        
        //获取维修员信息
        $repair_man = $this->db->where('village_no', $info['village'])
            ->where('building_no', $info['building'])->get('repairman_info')->row_array();
        
        $data=array(
            'order_id'=>$order_id,
            'village_name'=>$meter['VILLAGE_NAME'],
            'building_name'=>$meter['BUILDING_NAME'],
            'room_name'=>$meter['ROOM_NAME'],
            'meter_id'=>$meter['METER_ID'],
            'user_name'=>$user_name,
            'user_tel'=>$user_tel,
            'fault_description'=>$falut,
            'system_predicts'=>$predict,
            'user_description'=>$user_description,
            'appointment_start'=>$beginTime,
            'appointment_end'=>$endTime,
            'image_path'=>$url_path,
            'report_time'=>date('y-m-d H:i:s',time()),
            'repairman'=> $repair_man['repairman'],
            'repairman_tel'=> $repair_man['repairman_tel']
        );
        $this->db->insert('repair_pending',$data);
        alert("提交成功！", "../repair");
    }

    /**
     * 待处理详情
     */
    public function pending_detail(){
        //本单详情
        $id = $this->uri->segment(4);
        $data['pending'] = $this->db->where('id', $id)->get('repair_pending')->row_array();
        
        if(!$data['pending']){
            alert('此报修单已在处理中');
        }
        
        //近3单详情
        $info = get_info();
        $this->db->where('VILLAGE_NO',$info['village'])->where('BUILDING_NO',$info['building'])
        ->where('ROOM_NO',$info['room']);
        $meter = $this->db->get('meter_info')->row_array();
        $data['last'] = $this->db->where('meter_id', $meter['METER_ID'])->order_by('repair_time', 'DESC')
            ->limit(3, 0)->get('repair_complete')->result_array();
        
        $this->load->view('app/repair_pending_detail',$data);
    }
    
    /**
     * 取消报修单
     */
    public function cancel_order(){
        $id = $this->input->post('id');
        $result = $this->db->where('id', $id)->delete('repair_pending');
        if(!$result){
            echo 'del_fail';
        }else{
            echo 'del_succ';
        }
    }

    /**
     * 报修历史详情
     */
    public function history_detail(){
        $id = $this->uri->segment(4);
        $data['history'] = $this->db->where('id', $id)->get('repair_complete')->row_array();
    
        $this->load->view('app/repair_history_detail',$data);
    }
}