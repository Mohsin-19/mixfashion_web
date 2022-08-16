<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model
{
  /**
   * return generated code
   * @access public
   */
  public function generateItemCode()
  {
    $company_id = $this->session->userdata('company_id');
    $product_count = $this->db->query("SELECT id as product_count
             FROM tbl_products where company_id='$company_id' ORDER BY id DESC")->row('product_count');
    $food_menu_code = str_pad($product_count + 1, 3, '0', STR_PAD_LEFT);
    return $food_menu_code;
  }
  /**
   * return products
   * @access public
   * @param int
   */
  public function getIngredientListWithUnit($company_id)
  {
    $result = $this->db->query("SELECT tbl_products.id, tbl_products.name, tbl_products.code, tbl_units.unit_name 
          FROM tbl_products 
          JOIN tbl_units ON tbl_products.unit_id = tbl_units.id
          WHERE tbl_products.company_id=$company_id AND tbl_products.del_status = 'Live'  
          ORDER BY tbl_products.name ASC")->result();
    return $result;
  }

  /**
   * check validation and upload image file
   * @access public
   * @param int
   * @param string
   */
  public function mulit_featured_photo($width = '', $sessionName = '')
  {
    $config['upload_path'] = './assets/uploads/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = '2048';
    $config['encrypt_name'] = TRUE;
    $config['detect_mime'] = TRUE;
    $this->load->library('upload', $config);
    $this->load->library('image_lib', $config);
    if ($this->upload->do_upload("featured_photo")) {
      $upload_info = $this->upload->data();
      $pc_thumb = $upload_info['file_name'];
      $config['image_library'] = 'gd2';
      $config['source_image'] = './assets/uploads/' . $pc_thumb;
      $config['maintain_ratio'] = TRUE;
      $config['width'] = $width;
      $this->image_lib->clear();
      $this->image_lib->initialize($config);
      $this->image_lib->resize();
      $this->session->set_userdata($sessionName, $pc_thumb);
    }
  }

  /**
   * image file configuration before upload
   * @access public
   */
  public function getImageUploadConfiguaration()
  {
    // $config['upload_path']       =       $this->gallery_path.'/upload';
    $config['upload_path']      =       realpath(APPPATH . '../assets') . 'POS';
    $config['allowed_types']    =       'gif|png|jpg|jpeg';
    $config['max_size']         =       '6000';
    $config['max_width']        =       '0';
    $config['max_height']       =       '0';
    return $config;
  }
  /**
   * upload image file
   * @access public
   * @param int
   * @param string
   */
  public function uploadImage($config, $photoFieldName = '')
  {
    $this->load->library('upload');
    $this->upload->initialize($config);
    $photoFieldName = ($photoFieldName != '') ? $photoFieldName : 'photo';
    if (!$this->upload->do_upload($photoFieldName)) {
      $error      =       array(
        'error'     =>      $this->upload->display_error()
      );
      echo $error['error'];
    } else {
      return $this->upload->data();
    }
    // $image_data=$this->upload->data();
  }
  /**
   * return categories
   * @access public
   * @param string
   */
  public function getCategoryId($category)
  {
    $slug = str_slug($category);
    $company_id = $this->session->userdata('company_id');
    $user_id = $this->session->userdata('user_id');
    $this->db->select('*');
    $this->db->from('tbl_product_categories');
    $this->db->where('company_id', $company_id);
    $this->db->where('name', $category);
    $this->db->where('slug', $slug);
    $value =  $this->db->get()->row();
    if ($value) {
      return $value->id;
    } else {
      $data =  array('name' => $category, 'slug' => $slug, 'company_id' => $company_id, 'user_id' => $user_id);
      $this->db->insert('tbl_product_categories', $data);
      $id = $this->db->insert_id();
      return $id;
    }
  }
  /**
   * return sub categories
   * @access public
   * @param int
   * @param string
   */
  public function getSubCategoryId($cat_id, $category)
  {
    $slug = str_slug($category);
    $company_id = $this->session->userdata('company_id');
    $user_id = $this->session->userdata('user_id');
    $this->db->select('*');
    $this->db->from('tbl_product_sub_categories');
    $this->db->where('company_id', $company_id);
    $this->db->where('name', $category);
    $this->db->where('slug', $slug);
    $this->db->where('cat_id', $cat_id);
    $value =  $this->db->get()->row();
    if ($value) {
      return $value->id;
    } else {
      $data =  array('cat_id' => $cat_id, 'name' => $category, 'slug' => $slug, 'company_id' => $company_id, 'user_id' => $user_id);
      $this->db->insert('tbl_product_sub_categories', $data);
      $id = $this->db->insert_id();
      return $id;
    }
  }

    /**
     * send email
     * @access public
     * @param string
     * @param string
     * @param string
     * @return bool
     */
  public function sendEmail($to, $subject, $msg)
  {
    mail($to, $subject, $msg);
    return true;
  }
  public function sendSMS($numbers, $message, $sender)
  {
    $credentials = $this->Common_model->getDataById(1, 'tbl_sms_settings');
    require(APPPATH . 'libraries/Textlocal.php');
    $textlocal = new Textlocal($credentials->email_address, $credentials->password);

    $textlocal->sendSms($numbers, $message, $sender);
    return true;
  }

  /**
   * custom table data return
   * @access public
   * @param int
   * @param int
   * @param int
   * @param int
   */
  public function make_query($company_id, $category_id = '', $subcategory_id = '', $supplier_id = '')
  {
    $this->db->select("tbl_products.*,tbl_users.full_name");
    $this->db->from('tbl_products');
    $this->db->join('tbl_users', 'tbl_users.id = tbl_products.user_id', 'left');
    if ($_POST["search"]["value"]) {
      $this->db->like("name", $_POST["search"]["value"]);
      $this->db->or_like("available", $_POST["search"]["value"]);
      $this->db->or_like("code", $_POST["search"]["value"]);
      $this->db->or_like("name_for_your", $_POST["search"]["value"]);
      $this->db->or_like("name_for_people", $_POST["search"]["value"]);
      $this->db->or_like("has_offer", $_POST["search"]["value"]);
      $this->db->or_like("offer", $_POST["search"]["value"]);
      $this->db->or_like("description", $_POST["search"]["value"]);
      $this->db->or_like("tbl_users.full_name", $_POST["search"]["value"]);
    }

    if ($category_id != '') {
      $this->db->where("tbl_products.category_id", $category_id);
    }
    if ($subcategory_id != '') {
      $this->db->where("tbl_products.subcategory_id", $subcategory_id);
    }
    if ($supplier_id != '') {
      $this->db->where("tbl_products.supplier_id", $supplier_id);
    }
    $this->db->where("tbl_products.company_id", $company_id);
    $this->db->where("tbl_products.del_status", "Live");
    $this->db->order_by('tbl_products.id', 'DESC');
  }
  /**
   * return table limit row
   * @access public
   * @param int
   * @param int
   * @param int
   * @param int
   */
  public function make_datatables($company_id, $category_id, $subcategory_id, $supplier_id)
  {
    $this->make_query($company_id, $category_id, $subcategory_id, $supplier_id);
    if ($_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }
    return $this->db->get()->result();
  }
  /**
   * draw the datatable
   * @access public
   * @param string
   */
  public function getDrawData()
  {
    return $_POST["draw"];
  }
  /**
   * filtered the ajax datatable
   * @access public
   * @param int
   * @param int
   * @param int
   * @param int
   */
  public function get_filtered_data($company_id, $category_id = '', $subcategory_id = '', $supplier_id = '')
  {
    $this->make_query($company_id, $category_id, $subcategory_id, $supplier_id);
    $result = $this->db->get();
    return $result->num_rows();
  }
  /**
   * return all data
   * @access public
   * @param int
   * @param int
   * @param int
   * @param int
   */
  public function get_all_data($company_id, $category_id = '', $subcategory_id = '', $supplier_id = '')
  {
    $this->db->select("*");
    $this->db->from('tbl_products');
    $this->db->where("company_id", $company_id);
    if ($category_id != '') {
      $this->db->where("category_id", $category_id);
    }
    if ($subcategory_id != '') {
      $this->db->where("subcategory_id", $subcategory_id);
    }
    if ($supplier_id != '') {
      $this->db->where("supplier_id", $supplier_id);
    }
    $this->db->where("del_status", "Live");
    return $this->db->count_all_results();
  }
}
