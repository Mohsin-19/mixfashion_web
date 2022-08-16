<?php

class Role_model extends CI_Model
{

  public function getRolesByCompanyId($company_id)
  {
    $this->db->select("tr.*,to.outlet_name, tu.full_name")
      ->from("tbl_roles tr")
      ->join('tbl_outlets as to', 'to.id = tr.company_id', 'left')
      ->join('tbl_users as tu', 'tu.id = tr.user_id', 'left')
      ->where("tr.company_id", $company_id)
      ->where("tr.delete_at", null)
      ->order_by("tr.id", 'asc');
    return $this->db->get()->result();
  }

  public function getRolesByCompanyForOptions($company_id)
  {
    return $this->db->select("tr.id, tr.slug, tr.name")
      ->from("tbl_roles tr")
      ->join('tbl_outlets as company', 'company.id = tr.company_id', 'left')
      ->where("tr.company_id", $company_id)
      ->where("tr.name !=", 'administrator')
      ->where("tr.delete_at", null)
      ->order_by("tr.id", 'desc')
      ->get()->result();
  }

}

