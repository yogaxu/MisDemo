<?php

/**
 * @author 你哥
 *
 */
class Role_mod extends CI_Model {
	
	/**
	 * 
	 * 获取角色列表
	 */
	public function get_list($search, $start=0, $limit=10){
	    if(strcmp($search, "") != 0){
	        $this->db->like("name", $search);
	    }
	    $this->db->limit($limit, $start);
		$this->db->order_by("id", "ASC");
		$query = $this->db->get("admin_role");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取角色总数
	 */
	public function count_all($search){
		if(strcmp($search, "") != 0){
	        $this->db->like("name", $search);
	    }
		$query = $this->db->get("admin_role");
		return count($query->result_array());
	}
}