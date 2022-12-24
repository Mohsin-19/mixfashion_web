<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends CI_Model {

    /**
     * generate code and return
     * @access public
     * @param int
     */
    public function generatePurRefNo($outlet_id) {
        $count = $this->db->query("SELECT count(id) as count
               FROM tbl_purchase where outlet_id=$outlet_id")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }

    /**
     * return product list
     * @access public
     * @param int
     */
    public function getItemListWithUnitAndPrice($company_id) {
        $result = $this->db->query("SELECT tbl_products.id, tbl_products.name, tbl_products.code, tbl_products.purchase_price,tbl_products.conversion_rate,tbl_units.unit_name
          FROM tbl_products 
          LEFT JOIN tbl_units ON tbl_products.purchase_unit_id = tbl_units.id
          WHERE tbl_products.company_id=$company_id AND tbl_products.type = '1'  AND  tbl_products.del_status = 'Live'  
          ORDER BY tbl_products.name ASC")->result();
        return $result;
    }
    /**
     * return purchase products by purchase id
     * @access public
     * @param int
     */
    public function getPurchaseItems($id) {
        $this->db->select("*");
        $this->db->from("tbl_purchase_details");
        $this->db->order_by('id', 'ASC');
        $this->db->where("purchase_id", $id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }

}

