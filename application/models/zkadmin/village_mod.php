<?php

/**
 * @author 你哥
 *
 */
class Village_mod extends CI_Model {
	
	/**
	 * 
	 * 获取小区列表
	 */
	public function get_list($search, $start=0, $limit=10){
	    if(strcmp($search, "") != 0){
	        $this->db->like("VILLAGE_NAME", $search);
	    }
	    $this->db->limit($limit, $start);
		$this->db->order_by("VILLAGE_NO", "ASC");
		$query = $this->db->get("village_info");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取小区总数
	 */
	public function count_all($search){
		if(strcmp($search, "") != 0){
	        $this->db->like("VILLAGE_NAME", $search);
	    }
		$query = $this->db->get("village_info");
		return count($query->result_array());
	}
}