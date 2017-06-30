<?php

/**
 * @author 你哥
 *
 */
class Heat_meter_mod extends CI_Model {
	
	/**
	 * 
	 * 获取楼栋总表
	 */
	public function get_list($search, $start=0, $limit=10){
	    if(strcmp($search, "") != 0){
	        $this->db->like("HEAT_METER_ID", $search);
	    }
	    $this->db->limit($limit, $start);
		$this->db->order_by("TIME_HEAT_METER", "DESC");
		$query = $this->db->from("heat_meter_data_last")
		  ->join('meter_info', 'meter_info.METER_ID = heat_meter_data_last.HEAT_METER_ID and meter_info.CMR_ID = heat_meter_data_last.CMR_ID')
		  ->join('room_info', 'room_info.ROOM_NO = meter_info.ROOM_NO')->get();
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取楼栋总表总数
	 */
	public function count_all($search){
		if(strcmp($search, "") != 0){
	        $this->db->like("HEAT_METER_ID", $search);
	    }
		$query = $this->db->from("heat_meter_data_last")
		  ->join('meter_info', 'meter_info.METER_ID = heat_meter_data_last.HEAT_METER_ID and meter_info.CMR_ID = heat_meter_data_last.CMR_ID')
		  ->join('room_info', 'room_info.ROOM_NO = meter_info.ROOM_NO')->get();
		return count($query->result_array());
	}
}