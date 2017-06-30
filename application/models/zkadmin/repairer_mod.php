<?php

class Repairer_mod extends CI_Model {
	
	/**
	 *
	 * 获取维修员
	 */
	public function get_list($search, $start=0, $limit=10){
		if(strcmp($search, "") != 0){
			$this->db->like("repairman",$search);
		}
		$this->db->limit($limit, $start);
		$this->db->order_by("repairman_id", "ASC");
		$query = $this->db->get("repairman_info");
		return $query->result_array();
	}
	
	/**
	 *
	 * 获取维修员总数
	 */
	public function count_all($search){
		if(strcmp($search, "") != 0){
			$this->db->like("repairman",$search);
		}
		$query = $this->db->get("repairman_info");
		return count($query->result_array());
	}
	
	
	/**
	 *
	 * 获取维修组列表
	 */
	public function get_group_list($search, $start=0, $limit=10){
		if(strcmp($search, "") != 0){
			$this->db->like("group_name",$search);
		}
		$this->db->limit($limit, $start);
		$this->db->order_by("group_id", "ASC");
		$query = $this->db->get("repair_group_info");
		return $query->result_array();
	}
	
	/**
	 *
	 * 获取维修组总数
	 */
	public function count_group_all($search){
		if(strcmp($search, "") != 0){
			$this->db->like("group_name",$search);
		}
		$query = $this->db->get("repair_group_info");
		return count($query->result_array());
	}
	
}