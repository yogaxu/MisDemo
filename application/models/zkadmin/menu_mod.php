<?php

class Menu_mod extends CI_Model {
	
	//=======================================================================================================//
	/**
	 * 
	 * 获取主导航列表  关键词
	 */
	public function get_list(){
		$this->db->order_by("menu_id", "ASC");
		$query = $this->db->get("kk_menu");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取主导航内容信息  关键词
	 */
	public function get_edit($id){
		$this->db->where("menu_id", $id);
		$query = $this->db->get("kk_menu");
		return $query->row_array();
	}
	
	//=======================================================================================================//
	/**
	 * 
	 * 获取主导航列表  主导航
	 */
	public function get_list_nav(){
		$this->db->order_by("menu_id", "ASC");
		$query = $this->db->get("kk_menu_nav");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取主导航内容信息  主导航
	 */
	public function get_edit_nav($id){
		$this->db->where("menu_id", $id);
		$query = $this->db->get("kk_menu_nav");
		return $query->row_array();
	}
	
	//=======================================================================================================//
	/**
	 * 
	 * 获取主导航列表  友情链接
	 */
	public function get_list_links(){
		$this->db->order_by("links_id", "DESC");
		$query = $this->db->get("kk_links");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取主导航内容信息  友情链接
	 */
	public function get_edit_links($id){
		$this->db->where("links_id", $id);
		$query = $this->db->get("kk_links");
		return $query->row_array();
	}
	
	//=======================================================================================================//
	/**
	 * 
	 * 获取主导航列表  团队图片
	 */
	public function get_list_team(){
		$this->db->order_by("team_id", "DESC");
		$query = $this->db->get("kk_about_team");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取主导航内容信息  团队图片
	 */
	public function get_edit_team($id){
		$this->db->where("team_id", $id);
		$query = $this->db->get("kk_about_team");
		return $query->row_array();
	}
	
	//=======================================================================================================//
	/**
	 * 
	 * 获取主导航列表  荣誉图片
	 */
	public function get_list_honor(){
		$this->db->order_by("honor_id", "DESC");
		$query = $this->db->get("kk_about_honor");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 获取主导航内容信息  荣誉图片
	 */
	public function get_edit_honor($id){
		$this->db->where("honor_id", $id);
		$query = $this->db->get("kk_about_honor");
		return $query->row_array();
	}

}