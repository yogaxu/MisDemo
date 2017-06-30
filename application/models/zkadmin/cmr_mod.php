<?php

/**
 * @author 你哥
 *
 */
class Cmr_mod extends CI_Model {
	
	/**
	 * 
	 * 获取采集器列表
	 */
	public function get_list($search, $start=0, $limit=10){
	    if(strcmp($search, "") != 0){
	        $this->db->like("CMR_ID", $search);
	    }
	    $this->db->where('DAU_TYPE', 1); //类型1
	    $this->db->limit($limit, $start);
		$this->db->order_by("TIME_ENTRY", "DESC");
		$query = $this->db->get("cmr_info");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取采集器总数
	 */
	public function count_all($search){
		if(strcmp($search, "") != 0){
	        $this->db->like("CMR_ID", $search);
	    }
	    $this->db->where('DAU_TYPE', 1); //类型1
		$query = $this->db->get("cmr_info");
		return count($query->result_array());
	}
}