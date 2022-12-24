<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_model extends CI_Model {
    /**
     * return all area data
     * @access public
     * @param int
     */
    public function getAreaByCompanyId($company_id) {
        $this->db->select("tbl_areas.*,tbl_outlets.outlet_name");
        $this->db->from("tbl_areas");
        $this->db->join('tbl_outlets', 'tbl_outlets.id = tbl_areas.outlet_id', 'left');
        $this->db->where("tbl_areas.company_id", $company_id);
        $this->db->where("tbl_areas.del_status", 'Live');
        $this->db->order_by("tbl_areas.id", 'DESC');
        return $this->db->get()->result();
    }
    /**
     * return all area data
     * @access public
     * @param int
     */
    public function getAreaByOrder($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_areas");
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", 'Live');
        $this->db->order_by("order_by", 'ASC');
        return $this->db->get()->result();
    }
    /**
     * return true if total active less then 4 otherwise return false
     * @access public
     */
    public function checkActive() {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_areas");
        $this->db->where("active_status", 'Active');
        $this->db->where("del_status", 'Live');
        $total =  $this->db->get()->row()->total;
        if($total<4){
            return false;
        }else{
            return true;
        }
    }

}

