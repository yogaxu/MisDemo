<?php

class Comment_mod extends CI_Model {
	
	/**
	 * 
	 * 评论管理列表
	 */
	public function get_list($search, $start=0, $limit=10){
		if(strcmp($search, "") != 0){
			$this->db->like("order_id",$search);
		}
		$this->db->where('user_star_rate !=', '');
		$this->db->limit($limit, $start);
		$this->db->order_by("repair_time", "DESC");
		$query = $this->db->get("repair_complete");
		return $query->result_array();
	}
	
	/**
	 *
	 * 评论详情
	 */
	public function get_comment($id){
		$this->db->where("id", $id);
		$query = $this->db->get("repair_complete");
		return $query->row_array();
	}
     /**
	 *
	 * 获取总数
	 */
        public function count_all($search){
	    if(strcmp($search, "") != 0){
	        $this->db->like("order_id",$search);
	    }
		$this->db->where('user_star_rate !=', '');
		$query = $this->db->get("repair_complete");
		return count($query->result_array());
	} 
	/**
	 *
	 * 删除记录
	 *
	 */
	public function get_deletes($id){
		$this->db->where("id", $id);
		$this->db->delete('repair_complete',array('id'=>$id));
		$query = $this->db->get("repair_complete");
		return $query->result_array();
	}
}