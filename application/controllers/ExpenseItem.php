<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class ExpenseItem extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();
    check_permission(['add_expense_category', 'show_expense_category', 'edit_expense_category', 'delete_expense_category']);
  }

  /**
   * expense items list view
   * @access public
   * @return void
   */
  public function expenseItems()
  {
    $company_id = $this->session->userdata('company_id');

    $data = array();
    $data['expenseItems'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_expense_products");
    $data['main_content'] = $this->load->view('master/expenseItem/expenseItems', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete expense items
   * @access public
   * @param int
   * @return void
   */
  public function deleteExpenseItem($id)
  {
    check_permission('delete_expense_category');
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->deleteStatusChange($id, "tbl_expense_products");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('ExpenseItem/expenseItems');
  }

  /**
   * expense item list
   * @access public
   * @param int
   * @return void
   */
  public function addEditExpenseItem($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    if ($this->input->post('submit')) {
      check_permission(['add_expense_category', 'edit_expense_category']);

      $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
      $this->form_validation->set_rules('description', lang('description'), 'max_length[50]');
      if ($this->form_validation->run() == TRUE) {
        $fmc_info = array();
        $fmc_info['name'] = htmlspecialchars($this->input->post($this->security->xss_clean('name')));
        $fmc_info['description'] = htmlspecialchars($this->input->post('description'));
        $fmc_info['user_id'] = $this->session->userdata('user_id');
        $fmc_info['company_id'] = $this->session->userdata('company_id');
        if ($id == "") {
          check_permission('add_expense_category');
          $this->Common_model->insertInformation($fmc_info, "tbl_expense_products");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          check_permission('edit_expense_category');
          $this->Common_model->updateInformation($fmc_info, $id, "tbl_expense_products");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('ExpenseItem/expenseItems');
      } else {
        $this->add_edit_form_view($id, $encrypted_id);
      }
    } else {
      $this->add_edit_form_view($id, $encrypted_id);
    }
  }

  public function add_edit_form_view($id, $encrypted_id)
  {
    if ($id == "") {
      check_permission('add_expense_category');
      $data = array();
      $data['main_content'] = $this->load->view('master/expenseItem/addExpenseItem', $data, TRUE);
      $this->load->view('userHome', $data);
    } else {
      check_permission('edit_expense_category');
      $data = array();
      $data['encrypted_id'] = $encrypted_id;
      $data['expense_product_information'] = $this->Common_model->getDataById($id, "tbl_expense_products");
      $data['main_content'] = $this->load->view('master/expenseItem/editExpenseItem', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }
}
