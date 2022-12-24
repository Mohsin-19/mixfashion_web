<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Frontend extends CI_Model
{

  function getCategoryById($id)
  {
    return $this->db->select('*')
      ->from('tbl_product_categories')
      ->where("id", $id)
      ->order_by("id", "DESC")
      ->get()
      ->row();
  }


  function getSubCategoriesById($id)
  {
    return $this->db->select('*')
      ->from('tbl_product_sub_categories')
      ->where("cat_id", $id)
      ->order_by("id", "DESC")
      ->get()
      ->result();
  }

  function getSubCategoryById($id)
  {
    return $this->db->select('*')
      ->from('tbl_product_sub_categories')
      ->where("id", $id)
      ->order_by("id", "DESC")
      ->get()
      ->row();
  }

  public function getSubCategoryParent($cat_id)
  {
    return $this->db->select('*')->from('tbl_product_categories')
      ->where("id", $cat_id)
      ->where("del_status", "Live")
      ->get()->row();
  }

  public function getSubCategoryProducts($cat_id, $type, $limit, $offset)
  {
    $condition = $type == 1 ? "i.category_id = {$cat_id}" : "i.subcategory_id = {$cat_id}";
    return $this->db->query("SELECT i.*,i.name as product_name, i.order_limit, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.available='Yes' AND {$condition} GROUP BY i.id  ORDER BY i.id DESC LIMIT {$limit} OFFSET {$offset}")->result();
  }

  public function getSearchProducts($limit, $search, $offset)
  {
    $condition = "concat(i.name,i.name_for_your,i.name_for_people,i.code) LIKE '%{$search}%'";

    return $this->db->query("SELECT i.*,i.name as product_name, i.order_limit, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.available='Yes' AND {$condition} GROUP BY i.id  ORDER BY i.id DESC LIMIT {$limit} OFFSET {$offset}")->result();
  }


  function getCategoryBySlug($slug, $type)
  {
    $tbl = $type == 1 ? 'tbl_product_categories' : 'tbl_product_sub_categories';
    return $this->db->select('*')
      ->from($tbl)
      ->where("slug", $slug)
      ->order_by("id", "DESC")
      ->get()
      ->row();
  }


  public function get_product_xml()
  {
    return $this->db->query("SELECT i.*,i.`type`, cat_tbl.name as cat_name, sub_cat_tbl.name as sub_cat_name, unit.unit_name
    FROM tbl_products i
    LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
    LEFT JOIN (select id,name from tbl_product_sub_categories where del_status='Live') sub_cat_tbl ON sub_cat_tbl.id = i.subcategory_id
    LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit ON unit.id = i.sale_unit_id
    WHERE i.del_status='Live' AND i.available='Yes' GROUP BY i.id ")->result();
  }
}
