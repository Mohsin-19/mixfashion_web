<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_model extends CI_Model
{
  /**
   * return all user data
   * @access public
   * @param string
   * @param string
   */
  public function getUserInformation($email_address, $password)
  {
    $this->db->select("*");
    $this->db->from("tbl_users");
    $this->db->where("email_address", $email_address);
    $this->db->where("password", $password);
    $this->db->where("active_status", 'Active');
    $this->db->where("del_status", 'Live');
    return $this->db->get()->row();
  }


  public function checkCustomerValidAddress($customer_id, $name, $phone_one, $area, $address)
  {
    $this->db->select("*");
    $this->db->from("tbl_customer_address");
    $this->db->where("customer_id", $customer_id);
    $this->db->where("name", $name);
    $this->db->where("phone_one", $phone_one);
    $this->db->where("area", $area);
    $this->db->where("address", $address);
    $this->db->where("del_status", 'Live');
    return $this->db->get()->row();
  }

  public function get_customer_address($customer_id)
  {
    return $this->db->select("*")
      ->from("tbl_customer_address")
      ->where("customer_id", $customer_id)
      ->where("del_status", 'Live')
      ->order_by('id')
      ->get()
      ->result();
  }

  public function get_customer_first_address($customer_id)
  {
    return $this->db->select("*")
      ->from("tbl_customer_address")
      ->where("customer_id", $customer_id)
      ->where("del_status", 'Live')
      ->order_by('id')
      ->get()
      ->row();
  }

  // public function get_customer_default_address($cid, $default_id)
  // {
  //   return $this->db->select("*")
  //     ->from("tbl_customer_address")
  //     ->where("id", $default_id)
  //     ->where("customer_id", $cid)
  //     ->where("del_status", 'Live')
  //     ->order_by('id')
  //     ->get()
  //     ->row();
  // }

  
  public function get_customer_default_address($cid, $default_id)
  {
    return $this->db->select("tca.*, ta.delivery_charge, ta.name as area")
      ->from("tbl_customer_address as tca")
      ->join('tbl_areas as ta', 'ta.name = tca.area', 'inner')
      ->where("tca.id", $default_id)
      ->where("tca.customer_id", $cid)
      ->where("tca.del_status", 'Live')
      ->order_by('tca.id')
      ->get()
      ->row();
  }

  public function get_customer_deli_charge($area)
  {
    return $this->db->select("*")
      ->from("tbl_areas")
      ->where("name", $area)
      ->where("del_status", 'Live')
      ->order_by('id')
      ->get()
      ->row();
  }

  public function findCustomerValidAddress($id, $customer_id)
  {
    return $this->db->select("*")
      ->from("tbl_customer_address")
      ->where("id", $id)
      ->where("customer_id", $customer_id)
      ->where("del_status", 'Live')
      ->get()
      ->row();
  }

  public function deleteCustomerValidAddress($id, $customer_id)
  {
    return $this->db->where('id', $id)
      ->where('customer_id', $customer_id)
      ->delete('tbl_customer_address');
  }


  public function updateAddressInformation($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update("tbl_customer_address", $data);
  }
}
