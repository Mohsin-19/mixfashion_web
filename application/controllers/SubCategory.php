<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class SubCategory extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->model('Category_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    check_permission(['add_sub_category', 'show_sub_category', 'edit_sub_category', 'sort_sub_category', 'delete_sub_category']);
  }


  /**
   * product sub category views
   * @access public
   * @param int
   * @return void
   */
  public function productSubCategories()
  {
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['productSubCategory'] = $this->Category_model->get_sub_categories();
    $data['main_content'] = $this->load->view('master/productSubCategory/productSubCategories', $data, TRUE);
    $this->load->view('userHome', $data);
  }


  /**
   * delete product sub category
   * @access public
   * @param int
   * @return void
   */
  public function deleteItemSubCategory($id)
  {
    check_permission('delete_sub_category');
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->permanentDelete($id, "tbl_product_sub_categories");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('SubCategory/productSubCategories');
  }

  /**
   * add/edit product sub category
   * @access public
   * @param int
   * @return void
   */
  public function addEditItemSubCategory($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $company_id = $this->session->userdata('company_id');

    if ($this->input->post('submit')) {

      check_permission(['add_sub_category', 'edit_sub_category']);

      $validation = $this->checkValidation($id);
      if ($validation) {
        $fmc_info = [
          'cat_id' => htmlspecialchars($this->input->post('cat_id')),
          'name' => htmlspecialchars($this->input->post('name')),
          'slug' => str_slug($this->input->post('name')),
          'description' => $this->input->post('description'),
          'user_id' => $this->session->userdata('user_id'),
          'company_id' => $this->session->userdata('company_id'),
        ];

        if ($_FILES['icon']['name'] != "") {
          $fmc_info['icon'] = $this->session->userdata('icon');;
          $this->session->unset_userdata('icon');
          @unlink("./images/" . $this->input->post('old_icon'));
        } else {
          $fmc_info['icon'] = $this->input->post('old_icon');
        }
        if ($id == "") {
          check_permission('add_sub_category');
          $this->Common_model->insertInformation($fmc_info, "tbl_product_sub_categories");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          check_permission('edit_sub_category');
          $this->Common_model->updateInformation($fmc_info, $id, "tbl_product_sub_categories");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('SubCategory/productSubCategories');
      } else {
        $data['encrypted_id'] = $encrypted_id;
        $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_product_categories");
        $data['SubCategory_information'] = $this->Common_model->getDataById($id, "tbl_product_sub_categories");
        $data['main_content'] = $this->load->view('master/productSubCategory/editItemSubCategory', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      if ($id == "") {
        check_permission('add_sub_category');
        $data = array();
        $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_product_categories");
        $data['main_content'] = $this->load->view('master/productSubCategory/addItemSubCategory', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        check_permission('edit_sub_category');
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_product_categories");
        $data['SubCategory_information'] = $this->Common_model->getDataById($id, "tbl_product_sub_categories");
        $data['main_content'] = $this->load->view('master/productSubCategory/editItemSubCategory', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }


  public function checkValidation($id = '')
  {
    $is_unique = '';
    if ($id) {
      $name = $this->input->post($this->security->xss_clean('name'));
      $check = $this->Category_model->check_for_update($id, trim($name), 'tbl_product_sub_categories');
      if ($check) {
        $this->session->set_flashdata('flashExists', $name . ' already exists on the database');
        return false;
      }
    } else {
      $is_unique = '|is_unique[tbl_product_sub_categories.name]';
    }

    $this->form_validation->set_rules('name', lang('name'), 'required|max_length[155]' . $is_unique);
    $this->form_validation->set_rules('description', lang('description'));

    if ($_FILES['icon']['name'] != "") {
      $this->form_validation->set_rules('icon', lang('Icon'), 'callback_validate_top_icon');
    }

    return $this->form_validation->run();
  }


  public function validate_top_icon()
  {
    if ($_FILES['icon']['name'] != "") {
      $config['upload_path'] = './images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '5000';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("icon")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/' . $photo;
        /*$config['maintain_ratio'] = FALSE;
        $config['width'] = "230";
        $config['height'] = "50";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('icon', $photo);
      } else {
        $this->form_validation->set_message('validate_top_icon', $this->upload->display_errors());
        return FALSE;
      }
    }
  }
}
