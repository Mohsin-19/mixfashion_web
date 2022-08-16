<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->library('form_validation');
    $this->load->library('excel'); //load PHPExcel library
    $this->Common_model->setDefaultTimezone();

    check_permission(['add_customer', 'show_customer', 'edit_customer', 'delete_customer']);
  }

  /**
   * customer bulk upload
   * @access public
   * @return void
   */
  public function uploadCustomer()
  {
    check_permission('edit_customer');
    $data = array();
    $data['main_content'] = $this->load->view('master/customer/uploadsCustomer', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * customer list
   * @access public
   * @param string
   * @param int
   * @return void
   */
  public function customers()
  {
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['customers'] = $this->Common_model->get_customers($company_id);
    $data['main_content'] = $this->load->view('master/customer/customers', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete customer
   * @access public
   * @param int
   * @return void
   */
  public function deleteCustomer($id)
  {
    check_permission('delete_customer');
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->deleteStatusChange($id, "tbl_customers");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('Customer/customers');
  }

  /**
   * add/edit customer
   * @access public
   * @param int
   * @return void
   */
  public function addEditCustomer($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {

      check_permission(['add_customer', 'edit_customer']);

      $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
      $this->form_validation->set_rules('phone', lang('phone'), 'required');
      $this->form_validation->set_rules('email', lang('email_address'), "required|valid_email");
      $this->form_validation->set_rules('address', lang('address'), "required");
      if ($this->form_validation->run() == TRUE) {
        $customer_info = array();
        $customer_info['name'] = escapeQuot(htmlspecialchars($this->input->post('name')));
        $customer_info['photo'] = escapeQuot(htmlspecialchars($this->input->post('sc_photo')));
        $customer_info['phone'] = escapeQuot(htmlspecialchars($this->input->post('phone')));
        $customer_info['email'] = htmlspecialchars($this->input->post('email'));
        $c_address = htmlspecialchars($this->input->post('address')); #clean the address
        $customer_info['address'] = preg_replace("/[\n\r]/", " ", escapeQuot($c_address)); #remove new line from address
        $customer_info['user_id'] = $this->session->userdata('user_id');
        $customer_info['company_id'] = $this->session->userdata('company_id');
        if ($id == "") {
          check_permission('add_customer');
          $this->Common_model->insertInformation($customer_info, "tbl_customers");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          check_permission('edit_customer');
          $this->Common_model->updateInformation($customer_info, $id, "tbl_customers");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('Customer/customers');
      } else {
        $this->add_or_edit($id, $encrypted_id);
      }
    } else {
      $this->add_or_edit($id, $encrypted_id);
    }
  }


  function add_or_edit($id = "", $encrypted_id = "")
  {
    if ($id == "") {
      check_permission('add_customer');
      $data = array();
      $data['main_content'] = $this->load->view('master/customer/addCustomer', $data, TRUE);
      $this->load->view('userHome', $data);
    } else {
      check_permission('edit_customer');
      $data = array();
      $data['encrypted_id'] = $encrypted_id;
      $data['customer_information'] = $this->Common_model->getDataById($id, "tbl_customers");
      $data['main_content'] = $this->load->view('master/customer/editCustomer', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }


  /**
   * check email validation
   * @access public
   * @return void
   */
  function validateEmail($email)
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  /**
   * check email validation
   * @access public
   * @return boolean
   */
  function isValidDate($date)
  {
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
      return true;
    } else {
      return false;
    }
  }
}
