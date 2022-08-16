<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model
{
  /**
   * return custom table data
   * @access public
   * @param int
   * @param string
   */
  public function getDataByCatId($cat_id, $table_name)
  {
    $this->db->select("id,name,code");
    $this->db->from($table_name);
    $this->db->where("category_id", $cat_id);
    $this->db->order_by("name", "ASC");
    $this->db->where("del_status", 'Live');
    return $this->db->get()->result();
  }

  /**
   * return inventory/stock data
   * @access public
   * @param int
   * @param int
   * @param int
   */
  public function getInventory($category_id = "", $product_id = "", $supplier_id = '')
  {
    $where = '';
    if ($category_id != '') {
      $where .= " AND i.category_id = '$category_id'";
    }
    if ($product_id != '') {
      $where .= "  AND i.id = '$product_id'";
    }
    if ($supplier_id != '') {
      $where .= "  AND i.supplier_id = '$supplier_id'";
    }
    $result = $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND  tbl_order_items.order_status not in ('c','1','Return')  group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live'  $where ORDER BY i.name ASC")->result();
    return $result;
  }

  /**
   * return inventory/stock data by id
   * @access public
   * @param int
   */
  public function getInventoryByItem($product_id = "")
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $company_id = $this->session->userdata('company_id');
    $where = '';
    if ($product_id != '') {
      $where .= "  AND i.id = '$product_id'";
    }
    $result = $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live'  $where ORDER BY i.name ASC")->row();
    return $result;
  }

  /**
   * return inventory/stock alert data by id
   * @access public
   */
  public function getInventoryAlertList()
  {
    $result = $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' ORDER BY i.name ASC")->result();
    return $result;
  }

  /**
   * return inventory/stock data for purchase
   * @access public
   * @param int
   */
  public function getInventoryAlertListForPurchase($supplier_id = '')
  {
    $where = " ";
    if ($supplier_id != '') {
      $where = "AND i.supplier_id =" . $supplier_id;
    }
    $result = $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.alert_quantity IS NOT NULL AND i.type='1' $where ORDER BY i.name ASC")->result();
    return $result;
  }

  public function getAllByCompanyIdForDropdown($company_id, $table_name)
  {
    $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE company_id=$company_id AND del_status = 'Live'  
          ORDER BY name ASC")->result();
    return $result;
  }

}

?>
