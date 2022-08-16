<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    check_permission(['add_supplier', 'show_supplier', 'edit_supplier', 'delete_supplier']);
  }

  /**
   * supplier
   * @access public
   * @return void
   */
  public function suppliers()
  {
    check_permission('show_supplier');
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['suppliers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_suppliers");
    $data['main_content'] = $this->load->view('master/supplier/suppliers', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete supplier
   * @access public
   * @param int
   * @return void
   */
  public function deleteSupplier($id)
  {
    check_permission('delete_supplier');
    if ($id == 1) {
      redirect('Supplier/suppliers');
    }
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');

    $this->Common_model->deleteStatusChange($id, "tbl_suppliers");

    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('Supplier/suppliers');
  }

  /**
   * add/edit supplier
   * @access public
   * @param int
   * @return void
   */
  public function addEditSupplier($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    if ($this->input->post('submit')) {

      check_permission(['add_supplier', 'edit_supplier']);

      $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
      $this->form_validation->set_rules('contact_person', lang('contact_person'), 'required|max_length[50]');
      $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[15]');
      $this->form_validation->set_rules('description', lang('description'), 'max_length[100]');
      $this->form_validation->set_rules('email', lang('email_address'), "valid_email");
      if ($this->form_validation->run() == TRUE) {
        $fmc_info = array();
        $fmc_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
        $fmc_info['contact_person'] = htmlspecialchars($this->input->post('contact_person'));
        $fmc_info['phone'] = htmlspecialchars($this->input->post('phone'));
        $fmc_info['email'] = $this->input->post($this->security->xss_clean('email'));
        $fmc_info['address'] = htmlspecialchars($this->input->post('address'));

        $fmc_info['description'] = htmlspecialchars($this->input->post('description'));
        $fmc_info['previous_due'] = $this->input->post($this->security->xss_clean('previous_due'));
        $fmc_info['user_id'] = $this->session->userdata('user_id');
        $fmc_info['company_id'] = $this->session->userdata('company_id');
        if ($id == "") {
          check_permission('add_supplier');
          $this->Common_model->insertInformation($fmc_info, "tbl_suppliers");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          check_permission('edit_supplier');
          $this->Common_model->updateInformation($fmc_info, $id, "tbl_suppliers");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('Supplier/suppliers');
      } else {
        $this->addEditSupplierForm($id, $encrypted_id);
      }
    } else {
      $this->addEditSupplierForm($id, $encrypted_id);
    }
  }

  function addEditSupplierForm($id, $encrypted_id)
  {
    if ($id == "") {
      check_permission('add_supplier');
      $data = array();
      $data['main_content'] = $this->load->view('master/supplier/addSupplier', $data, TRUE);
      $this->load->view('userHome', $data);
    } else {
      check_permission('edit_supplier');
      $data = array();
      $data['encrypted_id'] = $encrypted_id;
      $data['supplier_information'] = $this->Common_model->getDataById($id, "tbl_suppliers");
      $data['main_content'] = $this->load->view('master/supplier/editSupplier', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }


}
