<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation_model extends CI_Model {

    /**
     * generate purchase reference no and returen
     * @access public
     * @param int
     */
    public function generatePurRefNo($outlet_id) {
        $count = $this->db->query("SELECT count(id) as count
               FROM tbl_quotations where outlet_id=$outlet_id")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }
    /**
     * return product list
     * @access public
     * @param int
     */
    public function getItemListWithUnitAndPrice($company_id) {
        $result = $this->db->query("SELECT tbl_products.id, tbl_products.name, tbl_products.code, tbl_products.purchase_price, tbl_products.sale_price, tbl_units.unit_name
          FROM tbl_products 
          LEFT JOIN tbl_units ON tbl_products.sale_unit_id = tbl_units.id
          WHERE tbl_products.company_id=$company_id  AND tbl_products.del_status = 'Live'  
          ORDER BY tbl_products.name ASC")->result();
        return $result;
    }
    /**
     * return quotation product
     * @access public
     * @param int
     */
    public function getQuotationItems($id) {
        $this->db->select("tbl_quotation_details.*,tbl_products.name,tbl_products.code");
        $this->db->from("tbl_quotation_details");
        $this->db->join('tbl_products', 'tbl_products.id = tbl_quotation_details.product_id', 'left');
        $this->db->order_by('id', 'ASC');
        $this->db->where("quotation_id", $id);
        $this->db->where("tbl_quotation_details.del_status", 'Live');
        return $this->db->get()->result();
    }

}

