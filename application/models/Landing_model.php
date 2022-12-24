<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');


class Landing_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    //check session set language, if available then set this language in session otherwise default english language set
    if ($this->session->has_userdata('language')) {
      $language = $this->session->userdata('language');
    } else {
      $getSiteSetting = getSiteSetting();
      if ($getSiteSetting->default_language_frontend) {
        $language = $getSiteSetting->default_language_frontend;
      } else {
        $language = 'english';
      }
    }
    //load the language
    $this->lang->load("$language", "$language");
    if ($language == 'spanish') {
      $this->config->set_item('language', 'spanish');
    }
  }

  /**
   * return inventory/stock data by id
   * @access public
   */
  public function getProductsWithStock()
  {
    return $this->db->query("SELECT i.*,i.name as product_name, i.order_limit, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.available='Yes' GROUP BY i.id")->result();
  }

  /**
   * return products by category id
   * @access public
   * @param int
   */
  public function getCatItems($id)
  {
    return $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.available='Yes' AND category_id = $id GROUP BY i.id  ORDER BY RAND() LIMIT 8")->result();
  }

  /**
   * return offer product with stock
   * @access public
   */
  public function getOfferProductsWithStock()
  {
    $result = $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.available='Yes' AND i.has_offer='Yes' GROUP BY i.id")->result();
    return $result;
  }

  /**
   * return New product of all categories
   * @access public
   */
  public function categoryNewProduct()
  {
    $result = $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.available='Yes' GROUP BY i.id ORDER BY i.id DESC limit 10")->result();
    return $result;
  }

  /**
   * return product of all Women categories
   * @access public
   */
  public function categoryProducts($id)
  {
    $result = $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.available='Yes' AND i.category_id={$id} GROUP BY i.id ORDER BY i.id DESC limit 10")->result();
    return $result;
  }




  public function relatedProducts($cat_id)
  {
    return $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.available='Yes' AND i.category_id={$cat_id} GROUP BY i.id ORDER BY i.id DESC limit 10")->result();
  }


  public function checkCustomerRememberMeToken($token)
  {
    return $this->db->select('*')
      ->from("tbl_customers")
      ->where("remember_token", $token)
      // ->where("is_otp_verified", 1)
      ->where("del_status", 'Live')
      ->get()
      ->row();
  }


  /**
   * return offer product with stock
   * @access public
   */
  public function getOfferProduct()
  {
    $this->db->select('*');
    $this->db->from('tbl_products');
    $this->db->where("has_offer", "Yes");
    $this->db->where("available", "Yes");
    $this->db->where("del_status", "Live");
    return $this->db->get()->result();
  }

  /**
   * return all products
   * @access public
   * @param int
   */
  public function getAllProducts()
  {
    $this->db->select('*');
    $this->db->from('tbl_products');
    $this->db->where("available", "Yes");
    $this->db->where("del_status", "Live");
    return $this->db->get()->result();
  }

  /**
   * return pages
   * @access public
   */
  public function pages()
  {
    $this->db->select('*');
    $this->db->from('tbl_pages');
    $this->db->order_by("order_by", "ASC");
    $this->db->where("del_status", "Live");
    return $this->db->get()->result();
  }

  /**
   * return orders
   * @access public
   */
  public function getOrders()
  {
    $c_id = $this->session->userdata('c_id');
    return $this->db->select('*')
      ->from('tbl_orders')
      ->where("customer_id", $c_id)
      ->order_by("id", "DESC")
      ->where("del_status", "Live")
      ->get()->result();
  }

  /**
   * return active slides
   * @access public
   * @param int
   */
  public function getActiveSlides()
  {
    return $this->db->select('*')
      ->from('tbl_slideshows')
      ->where("active_status", "Active")
      ->where("del_status", "Live")
      ->get()
      ->result();
  }

  /**
   * return categories
   * @access public
   */
  public function getCategories()
  {
    $this->db->select('*');
    $this->db->from('tbl_product_categories');
    $this->db->order_by("order_b", "ASC");
    $this->db->where("special_category <>", "Yes");
    $this->db->where("del_status", "Live");
    return $this->db->get()->result();
  }

  public function getSidebarCategories()
  {
    return $this->db->select('tpc.*, tpsc.name as child_name, tpsc.slug as child_slug, tpsc.id as child_id, tpsc.icon as child_icon, tpsc.cat_id as child_parent_id')
      ->from('tbl_product_categories as tpc')
      ->join('tbl_product_sub_categories as tpsc', 'tpsc.cat_id = tpc.id', 'left')
      ->where("tpc.special_category <>", "Yes")
      ->where("tpc.del_status", "Live")
      ->order_by("tpc.order_b", "ASC")
      ->get()
      ->result_array();
  }

  public function specialCategories()
  {
    $this->db->select('*');
    $this->db->from('tbl_product_categories');
    $this->db->order_by("order_b", "ASC");
    // $this->db->where("special_category <>", "Yes");
    $this->db->where("del_status", "Live");
    $this->db->where("special_category", "No");
    return $this->db->get()->result();
  }

  /**
   * return special categories
   * @access public
   * @param int
   */
  public function getSpecialCategories()
  {
    $this->db->select('*');
    $this->db->from('tbl_product_categories');
    $this->db->order_by("order_b", "ASC");
    $this->db->where("special_category <>", "No");
    $this->db->where("del_status", "Live");
    return $this->db->get()->result();
  }

  public function product_details($id)
  {
    return $this->db->select('tp.*, tpc.name as cat_name, tpc.slug cat_slug, tpsc.name as subcat_name, tpsc.slug subcat_slug')
      ->from('tbl_products as tp')
      ->join('tbl_product_categories as tpc', 'tpc.id = tp.category_id', 'left')
      ->join('tbl_product_sub_categories as tpsc', 'tpsc.id = tp.subcategory_id', 'left')
      ->where("tp.id", $id)
      ->get()
      ->row();
  }

  public function category_details($id)
  {
    $category =  $this->db->select('tpc.*')
      ->from('tbl_product_categories as tpc')
      ->where("tpc.del_status", "Live")
      ->where("tpc.id", $id)
      ->get()
      ->row();

    if ($category) {
      return $category;
    }
    return $this->db->select('tpsc.*')
      ->from('tbl_product_sub_categories as tpsc')
      ->where("tpsc.del_status", "Live")
      ->where("tpsc.id", $id)
      ->get()
      ->row();
  }
}
