<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Slideshow_model extends CI_Model {
    /**
     * return slideshow data
     * @access public
     * @param int
     */
    public function getSlideshowByCompanyId($company_id) {
        $this->db->select("tbl_slideshows.*,tbl_outlets.outlet_name");
        $this->db->from("tbl_slideshows");
        $this->db->join('tbl_outlets', 'tbl_outlets.id = tbl_slideshows.outlet_id', 'left');
        $this->db->where("tbl_slideshows.company_id", $company_id);
        $this->db->where("tbl_slideshows.del_status", 'Live');
        $this->db->order_by("tbl_slideshows.id", 'DESC');
        return $this->db->get()->result();
    }
    /**
     * check total active slide row, if more then 4 active available this function return false otherwise true
     * @access public
     */
    public function checkActive() {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_slideshows");
        $this->db->where("active_status", 'Active');
        $this->db->where("del_status", 'Live');
        $total =  $this->db->get()->row()->total;
        if($total<5){
            return false;
        }else{
            return true;
        }
    }

}

