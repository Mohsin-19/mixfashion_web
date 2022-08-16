<?php

/**
 * Class User_model
 */
class User_model extends CI_Model
{
  /**
   * return user data
   * @access public
   * @param int
   */
  public function getUsersByCompanyId($company_id)
  {
    $this->db->select("tu.*,to.outlet_name, tr.name as role_name");
    $this->db->from("tbl_users tu");
    $this->db->join('tbl_outlets as to', 'to.id = tu.outlet_id', 'left');
    $this->db->join('tbl_roles as tr', 'tr.id = tu.role', 'left');
    $this->db->where("tu.company_id", $company_id);
    $this->db->order_by("tu.id", 'desc');
    $this->db->where("tu.del_status", 'Live');
    return $this->db->get()->result();
  }


  public function check_user_exist($id, array $name)
  {
    return $this->db->select("*")
      ->from('tbl_users')
      ->where('id !=', $id)
      ->where($name)
      ->get()->row();
  }

}

