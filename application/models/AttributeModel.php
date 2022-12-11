<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class AttributeModel extends CI_Model
{


  public function check_for_update_color($id, $name, $table)
  {
    return $this->db->select("*")
      ->from($table)
      ->where('id !=', $id)
      ->where('name', $name)
      ->get()->row();
  }


  public function getItemsWithUser()
  {
    $result = $this->db->select('tc.*, tu.full_name')
      ->from("tbl_colors tc")
      ->join('tbl_users as tu', 'tu.id = tc.user_id', 'left')
      ->where('tc.del_status', 'Live')
      ->order_by('tc.id', 'DESC')
      ->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  public function getSizesWithUser()
  {
    $result = $this->db->select('tc.*, tu.full_name')
      ->from("tbl_sizes tc")
      ->join('tbl_users as tu', 'tu.id = tc.user_id', 'left')
      ->where('tc.del_status', 'Live')
      ->order_by('tc.id', 'DESC')
      ->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }


  public function updateOrInsertAttributes(array $attributes, $product_id)
  {

    $user_id = $this->session->userdata('user_id');
    $attributes_id = [];
    foreach ($attributes as $attribute) {
      $size_id = key_exists('size', $attribute) ? $attribute['size'] : null;
      $color_id = key_exists('color', $attribute) ? $attribute['color'] : null;
      $product_price = key_exists('price', $attribute) ? $attribute['price'] : 0;
      $product_qty = key_exists('qty', $attribute) ? $attribute['qty'] : 0;

      if ($size_id || $color_id) {
        $data = [
          'product_id' => $product_id,
          'size_id' => $size_id,
          'color_id' => $color_id,
          'product_price' => $product_price,
          'product_qty' => $product_qty,
          'user_id' => $user_id,
          'del_status' => 'Live',
        ];
        $check = $this->db->select("*")
          ->from('tbl_attributes')
          ->where('product_id', $product_id)
          ->where('size_id', $size_id)
          ->where('color_id', $color_id)
          ->get()
          ->row_array();
        if (!empty($check)) {
          $attr_id = $check['id'];
          $this->db->where('id', $attr_id)
            ->update('tbl_attributes', $data);
          array_push($attributes_id, $attr_id);
        } else {
          $this->db->insert('tbl_attributes', $data);
          $attr_id = $this->db->insert_id();
          array_push($attributes_id, $attr_id);
        }
      }
    }

    if (!empty($attributes_id)) {
      $this->db->where('product_id', $product_id)
        ->where_not_in('id', $attributes_id)
        ->delete('tbl_attributes');
    } else {
      $this->db->where('product_id', $product_id)
        ->delete('tbl_attributes');
    }
  }



  public function product_attributes($product_id)
  {
    $result = $this->db->select('ta.*, tu.full_name, tc.id as color_id,tc.name as color_name, tc.color_image, tc.color_code, tc.color_option, ts.id as size_id, ts.name as size_name')
      ->from("tbl_attributes ta")
      ->join('tbl_users as tu', 'tu.id = ta.user_id', 'left')
      ->join('tbl_colors as tc', 'tc.id = ta.color_id', 'left')
      ->join('tbl_sizes as ts', 'ts.id = ta.size_id', 'left')
      ->where('ta.product_id', $product_id)
      ->where('ta.del_status', 'Live')
      ->order_by('ta.id', 'ASC')
      ->get();

    if ($result != false) {
      return $result->result_array();
    } else {
      return [];
    }
  }
}
