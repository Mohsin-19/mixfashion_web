<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class SizeController extends Cl_Controller
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
    $data['sizes'] = $this->AttributeModel->getSizesWithUser($company_id, "tbl_sizes");
    // dd($data['sizes']);
    $data['main_content'] = $this->load->view('master/sizes/index', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete unit
   * @access public
   * @param int
   * @return void
   */
  public function deleteSize($id)
  {
    check_permission('delete_size');
    $this->Common_model->permanentDelete($id, "tbl_sizes");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('admin/size');
  }

  /**
   * add/edit unit
   * @access public
   * @param int
   * @return void
   */
  public function addEditSize($id = "")
  {
    if ($this->input->post('submit')) {

      check_permission(['add_size', 'edit_size']);

      $validate = $this->validateUnit($id);
      if ($validate) {
        $current = date('Y-m-d H:i:s');
        $data['name'] = $this->input->post('name');
        $data['active'] = $this->input->post('active') ? $current : null;
        $data['user_id'] = $this->session->userdata('user_id');
        $data['updated_at'] = $current;
        $data['description'] = $this->input->post('description');

        if ($id == "") {
          $data['created_at'] = $current;
          $this->Common_model->insertInformation($data, "tbl_sizes");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          $this->Common_model->updateInformation($data, $id, "tbl_sizes");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('admin/size');
      } else {
        if ($id == "") {
          check_permission('add_size');
          $data = [];
          $data['main_content'] = $this->load->view('master/sizes/addEditSize', $data, TRUE);
          $this->load->view('userHome', $data);
        } else {
          check_permission('edit_size');
          $data['size'] = $this->Common_model->getDataById($id, "tbl_sizes");
          $data['main_content'] = $this->load->view('master/sizes/addEditSize', $data, TRUE);
          $this->load->view('userHome', $data);
        }
      }
    } else {
      if ($id == "") {
        check_permission('add_size');
        $data = [];
        $data['main_content'] = $this->load->view('master/sizes/addEditSize', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        check_permission('edit_size');
        $data = array();
        $data['size'] = $this->Common_model->getDataById($id, "tbl_sizes");
        $data['main_content'] = $this->load->view('master/sizes/addEditSize', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }


  public function validateUnit($id = '')
  {
    $is_unique = '';
    if ($id) {
      $name = htmlspecialchars($this->input->post('name'));
      $check = $this->AttributeModel->check_for_update_color($id, trim($name), 'tbl_sizes');
      if ($check) {
        $this->session->set_flashdata('flashExists', $name . ' already exists on the database');
        return false;
      }
    } else {
      $is_unique = '|is_unique[tbl_sizes.name]';
    }

    $this->form_validation->set_rules('name', 'Name', 'required' . $is_unique);


    return $this->form_validation->run();
  }
}
