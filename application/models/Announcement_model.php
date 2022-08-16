<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');


class Announcement_model extends CI_Model
{

  public function getAnnouncement()
  {
    $today = date('Y-m-d H:i:s');

    return $this->db->select('*')
      ->from('tbl_announcements')
      ->where('end_date >=', $today)
      ->where('active !=', null)
      ->where('del_status', 'Live')
      ->order_by('id', 'DESC')
      ->get()
      ->row();
  }

  public function getAllByCompanyId($company_id, $table_name)
  {
    $result = $this->db->select('*')
      ->from($table_name)
      ->where('del_status', 'Live')
      ->order_by('id', 'DESC')
      ->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  public function insertInformation($data, $table_name)
  {
    $this->db->insert($table_name, $data);
    return $this->db->insert_id();
  }

  public function updateInformation($data, $id, $table_name)
  {
    $this->db->where('id', $id);
    $this->db->update($table_name, $data);
  }

  public function getDataById($id, $table_name)
  {
    $this->db->select("*");
    $this->db->from($table_name);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function deleteStatusChange($id, $table_name)
  {
    $this->db->set('del_status', "Deleted");
    $this->db->where('id', $id);
    $this->db->update($table_name);
  }
}
