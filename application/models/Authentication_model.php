<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    //check session set language, if available then set this language in session otherwise default english language set
    if ($this->session->has_userdata('language')) {
      $language = $this->session->userdata('language');
    } else {
      $language = 'english';
    }
    //load the language
    $this->lang->load("$language", "$language");
    if ($language == 'spanish') {
      $this->config->set_item('language', 'spanish');
    }
  }

  /**
   * return user information
   * @access public
   * @param string
   * @param string
   */
  public function getUserInformation($email, $password)
  {
    return $this->db->select("tu.*, tr.name as role_name, tr.slug as role_slug")
      ->from("tbl_users tu")
      ->join("tbl_roles as tr", 'tr.id = tu.role', 'inner')
      ->where("tu.email_address", $email)
      ->where("tu.password", md5($password))
      ->where("tu.active_status", 'Active')
      ->where("tr.delete_at", null)
      ->where("tu.del_status", 'Live')
      ->get()
      ->row();
  }


  public function check_remember_me_user($token)
  {
    return $this->db->select("tu.*, tr.name as role_name, tr.slug as role_slug")
      ->from("tbl_users tu")
      ->join("tbl_roles as tr", 'tr.id = tu.role', 'inner')
      ->where("tu.remember_me", $token)
      ->where("tu.active_status", 'Active')
      ->where("tr.delete_at", null)
      ->where("tu.del_status", 'Live')
      ->get()
      ->row();
  }

  /**
   * update user information
   * @access public
   * @param int
   * @param int
   */
  public function updateUserInfo($company_id, $user_id)
  {
    $this->db->set('company_id', $company_id);
    $this->db->where('id', $user_id);
    $this->db->update('tbl_users');
  }

  /**
   * save company information
   * @access public
   * @param array
   */
  public function saveCompanyInfo($company_info)
  {
    $this->db->insert('tbl_companies', $company_info);
    return $this->db->insert_id();
  }

  /**
   * return user information
   * @access public
   * @param string
   */
  public function getAccountByMobileNo($email_address)
  {
    $this->db->select("*");
    $this->db->from("tbl_users");
    $this->db->where("email_address", $email_address);
    $this->db->where("del_status", 'Live');
    return $this->db->get()->row();
  }

  /**
   * return companies data
   * @access public
   * @param int
   */
  public function getCompanyInformation($company_id)
  {
    $this->db->select("*");
    $this->db->from("tbl_companies");
    $this->db->where("id", $company_id);
    return $this->db->get()->row();
  }

  /**
   * save user information
   * @access public
   * @param array
   */
  public function saveUserInfo($user_info)
  {
    $this->db->insert('tbl_users', $user_info);
    return $this->db->insert_id();
  }

  /**
   * check password before change
   * @access public
   * @param string
   * @param int
   */
  public function passwordCheck($old_password, $user_id)
  {
    $row = $this->db->query("SELECT * FROM tbl_users WHERE id=$user_id AND password='$old_password'")->row();
    return $row;
  }

  /**
   * update password
   * @access public
   * @param string
   * @param int
   */
  public function updatePassword($new_password, $user_id)
  {
    $this->db->set('password', $new_password);
    $this->db->where('id', $user_id);
    $this->db->update('tbl_users');
  }

  /**
   * return setting information
   * @access public
   * @param int
   */
  public function getSettingInformation($company_id)
  {
    $this->db->select("*");
    $this->db->from("tbl_settings");
    $this->db->where("company_id", $company_id);
    return $this->db->get()->row();
  }

  /**
   * return site setting data
   * @access public
   * @param int
   */
  public function getSiteSetting($company_id)
  {
    $this->db->select("*");
    $this->db->from("tbl_site_setting");
    $this->db->where("company_id", $company_id);
    return $this->db->get()->row();
  }

  /**
   * return sms information setting data
   * @access public
   * @param int
   */
  public function getSMSInformation($company_id)
  {
    $this->db->select("*");
    $this->db->from("tbl_sms_settings");
    $this->db->where("company_id", $company_id);
    return $this->db->get()->row();
  }

  /**
   * return profile data
   * @access public
   * @param int
   */
  public function getProfileInformation()
  {
    $user_id = $this->session->userdata('user_id');
    $this->db->select("*");
    $this->db->from("tbl_users");
    $this->db->where("id", $user_id);
    return $this->db->get()->row();
  }
}
