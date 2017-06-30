<?php

/**
 * @author 你哥
 *
 */
class Admin_mod extends CI_Model {
	
	/**
	 * 
	 * 获取管理员列表
	 */
	public function get_list($search, $start=0, $limit=10){
	    if(strcmp($search, "") != 0){
	        $this->db->like("username", $search);
	    }
	    $this->db->limit($limit, $start);
		$this->db->order_by("reg_time", "DESC");
		$this->db->where('role_id !=', 0);
		$query = $this->db->get("admin_info");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取管理员总数
	 */
	public function count_all($search){
		if(strcmp($search, "") != 0){
	        $this->db->like("username", $search);
	    }
		$this->db->where('role_id !=', 0);
		$query = $this->db->get("admin_info");
		return count($query->result_array());
	}
}