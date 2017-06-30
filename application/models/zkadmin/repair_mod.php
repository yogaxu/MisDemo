<?php

class Repair_mod extends CI_Model {
    
	/**
	 *
	 * 报修单详情
	 */
	public function get_repair($id){
		$this->db->where("id", $id);
		$query = $this->db->get("repair_pending");
		return $query->row_array();
	}
	
	/**
	 *
	 * 维修历史详情
	 */
	public function get_repairs($id){
		$this->db->where("id", $id);
		$query = $this->db->get("repair_complete");
		return $query->row_array();
	}
	
	/**
	 *
	 * 提交报修单
	 *
	 */
	public function get_delete($id){
		$this->db->where("id", $id);
		$query = $this->db->get("repair_pending")->row_array();
		unset($query['id']);
		$query['repair_time'] = date('y-m-d H:i:s',time());
		$this->db->insert('repair_complete', $query);
		
 		$this->db->delete('repair_pending',array('id'=>$id));
	}

	/**
	 *
	 * 获取内容
	 */
	public function get_keys($times){
		$this->db->where("report_time", $times);
		$query = $this->db->get("repair_pending");
		return $query->result_array();
	}
	
	/**
	 *
	 * 获取维修历史列表
	 */
	public function get_list($search, $start=0, $limit=10){
		if(strcmp($search, "") != 0){
			$this->db->like("report_time",$search);
		}
		$this->db->limit($limit, $start);
		$this->db->order_by("report_time", "DESC");
		$query = $this->db->get("repair_complete");
		return $query->result_array();
	}
	
	/**
	 *
	 * 获取维修历史总数
	 */
	public function count_all($search){
		if(strcmp($search, "") != 0){
			$this->db->like("report_time",$search);
		}
	    $query = $this->db->get("repair_complete");
		return count($query->result_array());
	}
	
	/**
	 *
	 * 获取报修单总数
	 */
	public function count_repair($search){
		if(strcmp($search, "") != 0){
			$this->db->like("report_time",$search);
		}
	    $query = $this->db->get("repair_pending");
		return count($query->result_array());
	}
	
	/**
	 *
	 * 获取报修单列表
	 */
	public function get_lists($search, $start=0, $limit=10){
		if(strcmp($search, "") != 0){
			$this->db->like("report_time",$search);
		}
		$this->db->limit($limit, $start);
		$this->db->order_by("report_time", "DESC");
		$query = $this->db->get("repair_pending");
		return $query->result_array();
	}
	
	/**
	 *
	 * 删除记录
	 */
	public function get_deletes($id){
		$this->db->where("id", $id);
		$this->db->delete('repair_complete',array('id'=>$id));
		$query = $this->db->get("repair_complete");
		return $query->result_array();
	}
}