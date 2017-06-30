<?php

class Main_mod extends CI_Model {
	
	/**
	 * 
	 * 登录页获取用户登录次数 
	 */
	public function get_login($user_id){
		$this->db->where("admin_id", $user_id);
		$query = $this->db->get("kk_admin");
		return $query->row_array();
	}
	
	/**
	 * 
	 * 获取产品总数
	 */
	public function product_all($web){
		$this->db->where("product_web", $web);
		$this->db->where("product_close", 0);
		$this->db->from('kk_product');
		return $this->db->count_all_results();
	}
	
	/**
	 * 
	 * 获取新闻总数
	 */
	public function article_all($web){
		$this->db->where("article_web", $web);
		$this->db->from('kk_article');
		return $this->db->count_all_results();
	}
	/*
	public function article_all(){
		return $this->db->count_all("kk_article");
	}
	*/
	
	/**
	 * 
	 * 获取模板总数
	 */
	public function ztemplate_all(){
		$this->db->where("ztemplate_close", 0);
		$this->db->from('kk_ztemplate');
		return $this->db->count_all_results();
	}
	
	/**
	 * 
	 * 获取留言表总数
	 */
	public function message_all($web){
		$this->db->where("message_web", $web);
		$this->db->from('kk_message');
		return $this->db->count_all_results();
	}
	
	/**
	 * 
	 * 获取网站访问总次数 
	 */
	public function visitors_all($web){
		$this->db->where("seo_web", $web);
		$query = $this->db->get("kk_seo");
		return $query->row_array();
	}
	
	
	/**
	 * 
	 * 1月 - 12月总访问数   年份读取当前年份
	 */
	public function get_visitors($years,$web,$month){
		$this->db->where("year(FROM_UNIXTIME(`visitors_etime`))",$years);
		$this->db->where("month(FROM_UNIXTIME(`visitors_etime`))",$month);
		$this->db->where("visitors_web", $web);
		$query = $this->db->get("kk_visitors");
		return $query->num_rows();
	}
	
	/**
	 * 
	 * 这个是按季度查询  1,2,3,4
	 */
	public function get_visitors_target($years,$web,$target){
		//$this->db->select('sum(client_money) as count_mon');
		$this->db->where("year(FROM_UNIXTIME(`visitors_etime`))",$years);
		$this->db->where("quarter(FROM_UNIXTIME(`visitors_etime`))",$target);
		$this->db->where("visitors_web", $web);
		$query = $this->db->get("kk_visitors");
		return $query->num_rows();
	}	
	
	/**
	 * 
	 * 年份读取当前年份  获取今天的总数  年 月 日
	 */
	public function get_today($web){
		$this->db->where("FROM_UNIXTIME(`visitors_etime`,'%Y-%m-%d')=CURDATE()");
		$this->db->where("visitors_web", $web);
		$query = $this->db->get('kk_visitors');
		return $query->num_rows();
	}
	
	
	/**
	 * 
	 * 年份读取当前年份  获取昨天的总数
	 */
	public function get_Yesterday($yesterday,$web){
		$this->db->where("FROM_UNIXTIME(`visitors_etime`,'%Y-%m-%d')='$yesterday'");
		$this->db->where("visitors_web", $web);
		$query = $this->db->get("kk_visitors");
		return $query->num_rows();
	}
	
	
	/**
	 * 
	 * 最新留言的前5名
	 */
	public function get_message($web){
		$this->db->limit(5);
		$this->db->where("message_web", $web);
		$this->db->order_by("message_stime", "DESC");
		$query = $this->db->get("kk_message");
		return $query->result_array();
	}
	
	/**
	 * 
	 * 客户看到的广告新闻
	 */
	public function get_news(){
		$this->db->limit(1);
		$this->db->where("article_admin", 1);
		$this->db->where("article_close", 0);
		$this->db->where("article_show", 1);
		$this->db->order_by("article_stime", "DESC");
		$query = $this->db->get("kk_article");
		return $query->row_array();
	}
	
	/**
	 * 
	 * 客户看到的banner专题
	 */
	public function get_banner(){
		$this->db->limit(5);
		$this->db->where("banner_admin", 1);
		$this->db->where("banner_close", 0);
		$this->db->order_by("banner_abc", "ASC");
		$this->db->order_by("banner_stime", "DESC");
		$query = $this->db->get("kk_banner");
		return $query->result_array();
	}
	
	
	/*
	 * 
	 * 获取文章总数
	 *
	public function count_all(){
		return $this->db->count_all("kk_article");
	}
	*/
	


}