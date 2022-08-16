<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class ColorController extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->model('AttributeModel');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    // check_permission(['add_unit', 'show_unit', 'edit_unit', 'delete_unit']);
  }


  public function index()
  {
    $company_id = $this->session->userdata('company_id');
    $data['colors'] = $this->AttributeModel->getItemsWithUser($company_id, "tbl_colors");
    // dd($data['colors']);
    $data['main_content'] = $this->load->view('master/colors/index', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete unit
   * @access public
   * @param int
   * @return void
   */
  public function deleteUnit($id)
  {
    check_permission('delete_color');
    $this->Common_model->permanentDelete($id, "tbl_colors");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('admin/color');
  }

  /**
   * add/edit unit
   * @access public
   * @param int
   * @return void
   */
  public function addEditColor($id = "")
  {
    if ($this->input->post('submit')) {

      check_permission(['add_color', 'edit_color']);

      $validate = $this->validateUnit($id);
      if ($validate) {
        $current = date('Y-m-d H:i:s');
        $data['name'] = $this->input->post('name');
        $data['active'] = $this->input->post('active') ? $current : null;
        $data['color_option'] = $this->input->post('color_option');
        $data['color_code'] = $this->input->post('color_code');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['updated_at'] = $current;
        $data['description'] = $this->input->post('description');

        if ($_FILES['color_image']['name'] != "") {
          $data['color_image'] = $this->session->userdata('color_image');;
          $this->session->unset_userdata('color_image');
          @unlink("./images/" . $this->input->post('old_color_image'));
        } else {
          $data['color_image'] = $this->input->post('old_color_image');
        }

        if ($id == "") {
          $data['created_at'] = $current;
          $this->Common_model->insertInformation($data, "tbl_colors");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          $this->Common_model->updateInformation($data, $id, "tbl_colors");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('admin/color');
      } else {
        if ($id == "") {
          check_permission('add_color');
          $data = [];
          $data['main_content'] = $this->load->view('master/colors/addEditColor', $data, TRUE);
          $this->load->view('userHome', $data);
        } else {
          check_permission('edit_color');
          $data['color'] = $this->Common_model->getDataById($id, "tbl_colors");
          $data['main_content'] = $this->load->view('master/colors/addEditColor', $data, TRUE);
          $this->load->view('userHome', $data);
        }
      }
    } else {
      if ($id == "") {
        check_permission('add_color');
        $data = [];
        $data['main_content'] = $this->load->view('master/colors/addEditColor', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        check_permission('edit_color');
        $data = array();
        $data['color'] = $this->Common_model->getDataById($id, "tbl_colors");
        $data['main_content'] = $this->load->view('master/colors/addEditColor', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }


  public function validateUnit($id = '')
  {
    $is_unique = '';
    if ($id) {
      $name = htmlspecialchars($this->input->post('name'));
      $check = $this->AttributeModel->check_for_update_color($id, trim($name), 'tbl_colors');
      if ($check) {
        $this->session->set_flashdata('flashExists', $name . ' already exists on the database');
        return false;
      }
    } else {
      $is_unique = '|is_unique[tbl_colors.name]';
    }

    $this->form_validation->set_rules('name', 'Name', 'required' . $is_unique);

    if ($_FILES['color_image']['name'] != "") {
      $this->form_validation->set_rules('color_image', 'Image', 'callback_validate_color_image');
    }

    return $this->form_validation->run();
  }

  public function validate_color_image()
  {
    if ($_FILES['color_image']['name'] != "") {
      $config['upload_path'] = './images/';
      $config['allowed_types'] = 'jpg|jpeg|png|webp';
      $config['max_size'] = '5048';
      $config['encrypt_name'] = TRUE;
      $config['detect_mime'] = TRUE;
      $this->load->library('upload', $config);
      if ($this->upload->do_upload("color_image")) {
        $upload_info = $this->upload->data();
        $photo = $upload_info['file_name'];
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/' . $photo;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->session->set_userdata('color_image', $photo);
      } else {
        $this->form_validation->set_message('validate_color_image', $this->upload->display_errors());
        return FALSE;
      }
    }
  }
}
