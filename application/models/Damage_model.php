<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Damage_model extends CI_Model {
    /**
     * return item list
     * @access public
     */
    public function getItemList() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select("tbl_products.id, tbl_products.name, tbl_products.code, tbl_products.purchase_price as sale_price, tbl_units.unit_name");
        $this->db->from("tbl_products");
        $this->db->join("tbl_units", 'tbl_units.id = tbl_products.sale_unit_id', 'left');
        $this->db->order_by("tbl_products.name", "ASC");
        $this->db->where("tbl_products.company_id", $company_id);
        $this->db->where("tbl_products.del_status", 'Live');
        $result = $this->db->get()->result();
        return $result;
    }
    /**
     * return damage item
     * @access public
     * @param int
     */
    public function getDamageItems($id) {
        $this->db->select("*");
        $this->db->from("tbl_damage_details");
        $this->db->order_by('id', 'ASC');
        $this->db->where("damage_id", $id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }
    /**
     * generate reference id and return
     * @access public
     * @param int
     */
    public function generateDamageRefNo($outlet_id) {
        $damage_count = $this->db->query("SELECT count(id) as damage_count
               FROM tbl_damages where outlet_id=$outlet_id")->row('damage_count');
        $product_code = str_pad($damage_count + 1, 6, '0', STR_PAD_LEFT);
        return $product_code;
    }

}

