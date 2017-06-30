<?php

class Pay_mod extends CI_Model {
	
	/**
	 * 
	 * 缴费管理列表
	 */
	public function get_list($search, $start=0, $limit=10){
	    if(strcmp($search, "") != 0){
	        $this->db->like("DEPOSIT_TIME", $search);
	    }
		$this->db->limit($limit, $start);
		$this->db->order_by("DEPOSIT_TIME", "DESC");
		$query = $this->db->get("deposits");
		return $query->result_array();
	}
	/**
	 *
	 * 缴费详情
	 */
	public function get_banner($id){
		$this->db->where("ID", $id);
		$query = $this->db->get("deposits");
		return $query->row_array();
	}

	/**
	 *
	 * 获取总数
	 */
	public function count_all($search){
	    if(strcmp($search, "") != 0){
	        $this->db->like("DEPOSIT_TIME", $search);
	    }
		$query = $this->db->get('deposits');
		return count($query->result_array());
	}
	
}