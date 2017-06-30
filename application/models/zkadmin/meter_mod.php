<?php

/**
 * @author 你哥
 *
 */
class Meter_mod extends CI_Model {
	
	/**
	 * 
	 * 获取终端设备列表
	 */
	public function get_list($search, $start=0, $limit=10){
	    if(strcmp($search, "") != 0){
	        $this->db->like("METER_ID", $search);
	    }
	    $this->db->limit($limit, $start);
		$this->db->order_by("METER_ID", "ASC");
		$query = $this->db->from("meter_info")
		  ->join('meter_type', 'meter_info.MODEL_ID = meter_type.MODEL_ID')->get();
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取终端设备总数
	 */
	public function count_all($search){
		if(strcmp($search, "") != 0){
	        $this->db->like("METER_ID", $search);
	    }
		$query = $this->db->from("meter_info")
		  ->join('meter_type', 'meter_info.MODEL_ID = meter_type.MODEL_ID')->get();
		return count($query->result_array());
	}
}