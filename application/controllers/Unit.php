<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    check_permission(['add_unit', 'show_unit', 'edit_unit', 'delete_unit']);
  }


  public function Units()
  {
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['Units'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_units");
    $data['main_content'] = $this->load->view('master/Unit/Units', $data, TRUE);
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
    check_permission('delete_unit');
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->permanentDelete($id, "tbl_units");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('Unit/Units');
  }

  /**
   * add/edit unit
   * @access public
   * @param int
   * @return void
   */
  public function addEditUnit($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    if ($this->input->post('submit')) {

      check_permission(['add_unit', 'edit_unit']);

      $validate = $this->validateUnit($id);
      if ($validate) {
        $vat = array();
        $vat['unit_name'] = htmlspecialchars($this->input->post($this->security->xss_clean('unit_name')));
        $vat['description'] = htmlspecialchars($this->input->post('description'));
        $vat['company_id'] = $this->session->userdata('company_id');
        if ($id == "") {
          $this->Common_model->insertInformation($vat, "tbl_units");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          $this->Common_model->updateInformation($vat, $id, "tbl_units");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('Unit/Units');
      } else {
        if ($id == "") {
          check_permission('add_unit');
          $data = array();
          $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
          $this->load->view('userHome', $data);
        } else {
          check_permission('edit_unit');
          $data = array();
          $data['encrypted_id'] = $encrypted_id;
          $data['Units'] = $this->Common_model->getDataById($id, "tbl_units");
          $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
          $this->load->view('userHome', $data);
        }
      }
    } else {
      if ($id == "") {
        check_permission('add_unit');
        $data = array();
        $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        check_permission('edit_unit');
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['Units'] = $this->Common_model->getDataById($id, "tbl_units");
        $data['main_content'] = $this->load->view('master/Unit/addEditUnit', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }


  public function validateUnit($id = '')
  {
    $is_unique = '';
    if ($id) {
      $name = htmlspecialchars($this->input->post('unit_name'));
      $check = $this->Common_model->check_for_update_unit($id, trim($name), 'tbl_units');
      if ($check) {
        $this->session->set_flashdata('flashExists', $name . ' already exists on the database');
        return false;
      }
    } else {
      $is_unique = '|is_unique[tbl_units.unit_name]';
    }

    $this->form_validation->set_rules('unit_name', lang('unit_name'), 'required' . $is_unique);

    return $this->form_validation->run();
  }

}
