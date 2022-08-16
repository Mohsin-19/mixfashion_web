<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Category_model extends CI_Model
{

  public function get_categories($company_id)
  {
    $this->db->select("tpc.*, (select count(tp.id) from tbl_products as tp where tp.category_id = tpc.id and tp.del_status='Live') as totalProducts");
    $this->db->from('tbl_product_categories as tpc');
    $this->db->where('tpc.company_id', $company_id);
    $this->db->where('tpc.del_status', 'Live');
    $this->db->order_by('tpc.id', 'DESC');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  public function get_sub_categories()
  {
    $this->db->select("tpc.*, (select count(tp.id) from tbl_products as tp where tp.subcategory_id = tpc.id and tp.del_status='Live') as totalProducts");
    $this->db->from('tbl_product_sub_categories as tpc');
    $this->db->where('tpc.del_status', 'Live');
    $this->db->order_by('tpc.id', 'DESC');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  public function check_for_update($id, $name, $table)
  {
    $this->db->select("*");
    $this->db->from($table);
    $this->db->where('id !=', $id);
    $this->db->where('name', $name);
    $this->db->where('del_status', 'Live');
    return $this->db->get()->row();
  }
}
