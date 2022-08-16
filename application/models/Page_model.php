<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model {

    /**
     * return all table data
     * @access public
     * @param int
     */
    public function getPageByCompanyId($company_id) {
        $this->db->select("tbl_pages.*,tbl_outlets.outlet_name");
        $this->db->from("tbl_pages");
        $this->db->join('tbl_outlets', 'tbl_outlets.id = tbl_pages.outlet_id', 'left');
        $this->db->where("tbl_pages.company_id", $company_id);
        $this->db->where("tbl_pages.del_status", 'Live');
        $this->db->order_by("tbl_pages.id", 'DESC');
        return $this->db->get()->result();
    }
    /**
     * return all table data
     * @access public
     * @param int
     */
    public function getPageByOrder($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_pages");
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", 'Live');
        $this->db->order_by("order_by", 'ASC');
        return $this->db->get()->result();
    }
    /**
     * check total 4 active table row
     * @access public
     * @param int
     */
    public function checkActive() {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_pages");
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

