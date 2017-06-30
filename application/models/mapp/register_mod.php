<?php

/**
 * Created by PhpStorm.
 * User: fanghh
 * Date: 2017/5/28
 * Time: 21:32
 */
class register_mod extends CI_Model{

    /**
     * 查询城市
     * @return mixed
     */
    public function dictResult(){
        $query = $this->db->get("dict_city");
        return $query->result_array();
    }

    /**
     * 查询小区
     * @return mixed
     */
    public function villageResult(){
        $query = $this->db->get("village_info");
        return $query->result_array();
    }

    /**
     * 查询楼号
     * @return mixed
     */
    public function buildingResult(){
        $query = $this->db->get("building_info");
        return $query->result_array();
    }

    /**
     * 查询门牌号
     * @return mixed
     */
    public function roomResult(){
        $query = $this->db->get("room_info");
        return $query->result_array();
    }

}