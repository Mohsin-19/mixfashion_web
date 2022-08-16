<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class PaymentMethod extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    check_permission(['add_payment_method', 'show_payment_method', 'edit_payment_method', 'delete_payment_method']);
  }

  /**
   * payment methods view page
   * @access public
   * @return void
   */
  public function paymentMethods()
  {
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
    $data['main_content'] = $this->load->view('master/paymentMethod/paymentMethods', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete payment method
   * @access public
   * @param int
   * @return void
   */
  public function deletePaymentMethod($id)
  {
    check_permission('delete_payment_method');
    if ($id > 5) {
      $id = $this->custom->encrypt_decrypt($id, 'decrypt');
      $this->Common_model->deleteStatusChange($id, "tbl_payment_methods");
      $this->session->set_flashdata('exception', lang('delete_success'));
      redirect('PaymentMethod/paymentMethods');
    }
  }

  /**
   * add/edit payment method
   * @access public
   * @param int
   * @return void
   */
  public function addEditPaymentMethod($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    if ($this->input->post('submit')) {

      check_permission(['add_payment_method', 'edit_payment_method']);

      $this->form_validation->set_rules('name', lang('account_name'), 'required|max_length[50]');
      $this->form_validation->set_rules('description', lang('description'), 'max_length[50]');
      if ($this->form_validation->run() == TRUE) {
        $fmc_info = array();
        $fmc_info['name'] = htmlspecialchars($this->input->post('name'));
        $fmc_info['description'] = htmlspecialchars($this->input->post('description'));
        $fmc_info['current_balance'] = htmlspecialchars($this->input->post('current_balance'));
        $fmc_info['user_id'] = $this->session->userdata('user_id');
        $fmc_info['company_id'] = $this->session->userdata('company_id');
        if ($id == "") {
          check_permission('add_payment_method');

          $this->Common_model->insertInformation($fmc_info, "tbl_payment_methods");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          check_permission('edit_payment_method');

          $this->Common_model->updateInformation($fmc_info, $id, "tbl_payment_methods");
          $this->session->set_flashdata('exception', lang('delete_success'));
        }
        redirect('PaymentMethod/paymentMethods');
      } else {
        $this->add_edit_view($id, $encrypted_id);
      }
    } else {
      $this->add_edit_view($id, $encrypted_id);
    }
  }

  function add_edit_view($id, $encrypted_id)
  {
    if ($id == "") {
      check_permission('add_payment_method');
      $data = array();
      $data['main_content'] = $this->load->view('master/paymentMethod/addPaymentMethod', $data, TRUE);
      $this->load->view('userHome', $data);
    } else {
      check_permission('edit_payment_method');
      $data = array();
      $data['encrypted_id'] = $encrypted_id;
      $data['payment_method_information'] = $this->Common_model->getDataById($id, "tbl_payment_methods");
      $data['main_content'] = $this->load->view('master/paymentMethod/editPaymentMethod', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }
}
