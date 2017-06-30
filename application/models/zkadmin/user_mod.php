<?php

/**
 * @author 你哥
 *
 */
class User_mod extends CI_Model {
	
	/**
	 * 
	 * 获取用户列表
	 */
	public function get_list($search, $start=0, $limit=10){
	    if(strcmp($search, "") != 0){
	        $this->db->like("METER_ID",$search);
	    }
	    $this->db->limit($limit, $start);
		$this->db->order_by("METER_ID", "ASC");
		$this->db->where('PASSWD !=','');
		$this->db->join("meter_info","room_info.ROOM_NO=meter_info.ROOM_NO");
		$query = $this->db->get("room_info");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取用户总数
	 */
	public function count_all($search){
	    if(strcmp($search, "") != 0){
	        $this->db->like("METER_ID",$search);
	    }
		$this->db->where('PASSWD !=','');
		$this->db->join("meter_info","room_info.ROOM_NO=meter_info.ROOM_NO");
		$query = $this->db->get("room_info");
		return count($query->result_array());
	} 
	
	/**
	 * 
	 * 获取用户详情
	 */
	public function get_user($card_no){
		$this->db->where("METER_ID", $card_no);
		$this->db->join("meter_info","room_info.ROOM_NO=meter_info.ROOM_NO");
		$room_array = $this->db->get("room_info")->row_array();
		
		$this->db->where("card_no", $card_no);
		$real_array = $this->db->get("v_bs_user_realtime_data")->row_array();
		$all = array_merge($room_array, $real_array);
		return $all;
	}
	
}