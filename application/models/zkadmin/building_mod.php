<?php

/**
 * @author 你哥
 *
 */
class Building_mod extends CI_Model {
	
	/**
	 * 
	 * 获取列表
	 */
	public function get_list($search, $start=0, $limit=10){
	    if(strcmp($search, "") != 0){
	        $this->db->like("BUILDING_NAME", $search);
	    }
	    $this->db->limit($limit, $start);
		$this->db->order_by("BUILDING_NO", "ASC");
		$query = $this->db->get("building_info");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取总数
	 */
	public function count_all($search){
		if(strcmp($search, "") != 0){
	        $this->db->like("BUILDING_NAME", $search);
	    }
		$query = $this->db->get("building_info");
		return count($query->result_array());
	}
}