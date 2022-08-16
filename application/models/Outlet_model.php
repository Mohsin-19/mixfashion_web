<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet_model extends CI_Model {
    /**
     * generate code and return
     * @access public
     */
    public function generateOutletCode() {
        $count = $this->db->query("SELECT count(id) as count
               FROM tbl_outlets")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }
    /**
     * return total taxes data
     * @access public
     * @param string
     */
    public function getTaxesByOutletId($outlet_id)
    {
        $this->db->select("*");
        $this->db->from("tbl_outlet_taxes");
        $this->db->where("outlet_id", $outlet_id);
        return $this->db->get()->result();   
    }

}

