<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends Cl_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->model('Category_model');
    $this->load->library('form_validation');

    $this->Common_model->setDefaultTimezone();

    check_permission(['add_category', 'show_category', 'edit_category', 'sort_category', 'delete_category']);
  }

  /**
   * product categories list
   * @access public
   * @return void
   */
  public function productCategories()
  {
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['productCategories'] = $this->Category_model->get_categories($company_id);
    $data['main_content'] = $this->load->view('master/productCategory/productCategories', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * sorting the category
   * @access public
   * @return void
   */
  public function orderCategory()
  {
    check_permission('sort_category');
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['productCategories'] = $this->Common_model->getCustomCat($company_id);
    $data['main_content'] = $this->load->view('master/productCategory/sort_categories', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete category
   * @access public
   * @param int
   * @return void
   */
  public function deleteItemCategory($id)
  {
    check_permission('delete_category');
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->permanentDelete($id, "tbl_product_categories");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('Category/productCategories');
  }

  /**
   * add/edit category
   * @access public
   * @param int
   * @return void
   */
  public function addEditItemCategory($encrypted_id = "")
  {
   
    $id = $encrypted_id ? $this->custom->encrypt_decrypt($encrypted_id, 'decrypt') : '';
    if ($this->input->post('submit')) {

      check_permission(['add_category', 'edit_category']);

      $validation = $this->checkValidation($id);

      if ($validation) {
        $fmc_info = array();
        $fmc_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
        $fmc_info['slug'] = str_slug($fmc_info['name']);
        $fmc_info['special_category'] = htmlspecialchars($this->input->post('special_category'));
        $fmc_info['order_b'] = htmlspecialchars($this->input->post('order_b'));
        $fmc_info['description'] = $this->input->post('description');
        $fmc_info['user_id'] = $this->session->userdata('user_id');
        $fmc_info['company_id'] = $this->session->userdata('company_id');

        if ($_FILES['icon']['name'] != "") {
          $fmc_info['icon'] = $this->session->userdata('icon');;
          $this->session->unset_userdata('icon');
          @unlink("./images/" . $this->input->post('old_icon'));
        } else {
          $fmc_info['icon'] = $this->input->post('old_icon');
        }

        if ($_FILES['top_banner']['name'] != "") {
          $fmc_info['top_banner'] = $this->session->userdata('top_banner');;
          $this->session->unset_userdata('top_banner');
          @unlink("./images/" . $this->input->post('old_top_banner'));
        } else {
          $fmc_info['top_banner'] = $this->input->post('old_top_banner');
        }

        if ($_FILES['bottom_left_banner']['name'] != "") {
          $fmc_info['bottom_left_banner'] = $this->session->userdata('bottom_left_banner');;
          $this->session->unset_userdata('bottom_left_banner');
          @unlink("./images/" . $this->input->post('old_bottom_left_banner'));
        } else {
          $fmc_info['bottom_left_banner'] = $this->input->post('old_bottom_left_banner');
        }

        // if ($_FILES['bottom_top_banner']['name'] != "") {
        //   $fmc_info['bottom_top_banner'] = $this->session->userdata('bottom_top_banner');;
        //   $this->session->unset_userdata('bottom_top_banner');
        //   @unlink("./images/" . $this->input->post('old_bottom_top_banner'));
        // } else {
        //   $fmc_info['bottom_top_banner'] = $this->input->post('old_bottom_top_banner');
        // }

        // if ($_FILES['bottom_right_banner']['name'] != "") {
        //   $fmc_info['bottom_right_banner'] = $this->session->userdata('bottom_right_banner');;
        //   $this->session->unset_userdata('bottom_right_banner');
        //   @unlink("./images/" . $this->input->post('old_bottom_right_banner'));
        // } else {
        //   $fmc_info['bottom_right_banner'] = $this->input->post('old_bottom_right_banner');
        // }

        if ($id == "") {
          check_permission('add_category');
          $this->Common_model->insertInformation($fmc_info, "tbl_product_categories");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          check_permission('edit_category');
          $this->Common_model->updateInformation($fmc_info, $id, "tbl_product_categories");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('Category/productCategories');
      } else {
        $data['encrypted_id'] = $encrypted_id;
        $data['category_information'] = $this->Common_model->getDataById($id, "tbl_product_categories");
        $data['main_content'] = $this->load->view('master/productCategory/editItemCategory', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      if ($id == "") {
        check_permission('add_category');
        $data = array();
        $data['main_content'] = $this->load->view('master/productCategory/addItemCategory', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        check_permission('edit_category');
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['category_information'] = $this->Common_model->getDataById($id, "tbl_product_categories");
        $data['main_content'] = $this->load->view('master/productCategory/editItemCategory', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }

  public function checkValidation($id = '')
  {
    $is_unique = '';
    if ($id) {
      $name = $this->input->post($this->security->xss_clean('name'));
      $check = $this->Category_model->check_for_update($id, trim($name), 'tbl_product_categories');
      if ($check) {
        $this->session->set_flashdata('flashExists', $name . ' already exists on the database');
        return false;
      }
    } else {
      $is_unique = '|is_unique[tbl_product_categories.name]';
    }

    $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]' . $is_unique);
    $this->form_validation->set_rules('description', lang('description'));

    if ($_FILES['icon']['name'] != "") {
      $this->form_validation->set_rules('icon', lang('Icon'), 'callback_validate_top_icon');
    }
    if ($_FILES['top_banner']['name'] != "") {
      $this->form_validation->set_rules('top_banner', lang('top_banner'), 'callback_validate_top_banner');
    }
    if ($_FILES['bottom_left_banner']['name'] != "") {
      $this->form_validation->set_rules('bottom_left_banner', lang('bottom_left_banner'), 'callback_validate_bottom_left_banner');
    }
    // if ($_FILES['bottom_top_banner']['name'] != "") {
    //   $this->form_validation->set_rules('bottom_top_banner', lang('bottom_top_banner'), 'callback_validate_bottom_top_banner');
    // }
    // if ($_FILES['bottom_right_banner']['name'] != "") {
    //   $this->form_validation->set_rules('bottom_right_banner', lang('bottom_right_banner'), 'callback_validate_bottom_right_banner');
    // }

    return $this->form_validation->run();
  }


  public function validate_top_icon()
  {
    if ($_FILES['icon']['name'] != "") {
      $config['upload_path'] = './images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '500';
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

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_top_banner()
  {
    if ($_FILES['top_banner']['name'] != "") {
      $config['upload_path'] = './images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '5048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("top_banner")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/' . $photo;
        /*$config['maintain_ratio'] = FALSE;
        $config['width'] = "230";
        $config['height'] = "50";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('top_banner', $photo);
      } else {
        $this->form_validation->set_message('validate_top_banner', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_bottom_left_banner()
  {
    if ($_FILES['bottom_left_banner']['name'] != "") {
      $config['upload_path'] = './images/';
      $config['allowed_types'] = 'jpg|jpeg|png|ico';
      $config['max_size'] = '6048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;

      $this->load->library('upload', $config);
      if ($this->upload->do_upload("bottom_left_banner")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/' . $photo;
        /* $config['maintain_ratio'] = FALSE;
         $config['width'] = "128";
         $config['height'] = "49";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('bottom_left_banner', $photo);
      } else {
        $this->form_validation->set_message('validate_bottom_left_banner', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_bottom_top_banner()
  {
    if ($_FILES['bottom_top_banner']['name'] != "") {
      $config['upload_path'] = './images/';
      $config['allowed_types'] = 'jpg|jpeg|png|ico';
      $config['max_size'] = '6048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;

      $this->load->library('upload', $config);
      if ($this->upload->do_upload("bottom_top_banner")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/' . $photo;
        /* $config['maintain_ratio'] = FALSE;
         $config['width'] = "128";
         $config['height'] = "49";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('bottom_top_banner', $photo);
      } else {
        $this->form_validation->set_message('validate_bottom_top_banner', $this->upload->display_errors());
        return FALSE;
      }
    }
  }

  /**
   * validate check and upload image
   * @access public
   * @return boolean
   */
  public function validate_bottom_right_banner()
  {
    if ($_FILES['bottom_right_banner']['name'] != "") {
      $config['upload_path'] = './images/';
      $config['allowed_types'] = 'jpg|jpeg|png';
      $config['max_size'] = '6048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;

      $this->load->library('upload', $config);
      if ($this->upload->do_upload("bottom_right_banner")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/' . $photo;
        /* $config['maintain_ratio'] = FALSE;
         $config['width'] = "128";
         $config['height'] = "49";*/
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('bottom_right_banner', $photo);
      } else {
        $this->form_validation->set_message('validate_bottom_right_banner', $this->upload->display_errors());
        return FALSE;
      }
    }
  }
}
