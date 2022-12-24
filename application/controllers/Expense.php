<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    check_permission(['add_expense', 'show_expense', 'edit_expense', 'delete_expense']);

  }

  /**
   * expense view
   * @access public
   * @return void
   */
  public function expenses()
  {
    check_permission('show_expense');
    $outlet_id = $this->session->userdata('outlet_id');
    $data = array();
    $data['expenses'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_expenses");
    $data['main_content'] = $this->load->view('expense/expenses', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * return  data for ajax datatable
   * @access public
   * @return json
   */
  public function getAjaxData()
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $expenses = $this->Common_model->getAllByOutletIdExpense($outlet_id);
    $expenses_num_rows = $this->Common_model->getAllByOutletIdNumRows($outlet_id);
    $expenses_Total = $this->Common_model->getAllByOutletId($outlet_id, "tbl_expenses");
    $data = array();
    foreach ($expenses as $row) {
      $sub_array = array();
      $sub_array[] = $row->date;
      $sub_array[] = $row->amount;
      $data[] = $sub_array;
    }
    $output = array(
      "draw" => intval($_POST['draw']),
      "recordsTotal" => sizeof($expenses_Total),
      "recordsFiltered" => $expenses_num_rows,
      "data" => $data
    );
    echo json_encode($output);
  }

  /**
   * delete expense
   * @access public
   * @param int
   * @return void
   */
  public function deleteExpense($id)
  {
    check_permission('delete_expense');
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->deleteStatusChange($id, "tbl_expenses");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('Expense/expenses');
  }

  /**
   * add/edit expense
   * @access public
   * @param int
   * @return void
   */
  public function addEditExpense($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    if ($this->input->post('submit')) {
      check_permission(['add_expense', 'edit_expense']);

      $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
      $this->form_validation->set_rules('amount', lang('amount'), 'required|max_length[50]');
      $this->form_validation->set_rules('category_id', lang('category'), 'required|max_length[10]');
      $this->form_validation->set_rules('payment_method_id', lang('payment_methods'), 'required');
      $this->form_validation->set_rules('employee_id', lang('responsible_person'), 'required|max_length[10]');
      $this->form_validation->set_rules('note', lang('note'), 'max_length[200]');
      if ($this->form_validation->run() == TRUE) {
        $expnse_info = array();

        $expnse_info['date'] = date("Y-m-d", strtotime(htmlspecialchars($this->input->post('date'))));
        $expnse_info['amount'] = htmlspecialchars($this->input->post('amount'));
        $expnse_info['category_id'] = htmlspecialchars($this->input->post('category_id'));
        $expnse_info['payment_method_id'] = htmlspecialchars($this->input->post('payment_method_id'));
        $expnse_info['employee_id'] = htmlspecialchars($this->input->post('employee_id'));
        $expnse_info['note'] = htmlspecialchars($this->input->post('note'));
        $expnse_info['user_id'] = $this->session->userdata('user_id');
        $expnse_info['outlet_id'] = $this->session->userdata('outlet_id');

        if ($id == "") {
          check_permission('add_expense');
          $this->Common_model->insertInformation($expnse_info, "tbl_expenses");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          check_permission('edit_expense');
          $this->Common_model->updateInformation($expnse_info, $id, "tbl_expenses");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('Expense/expenses');
      } else {
        $this->add_edit_expence_view($id, $encrypted_id);
      }
    } else {
      $this->add_edit_expence_view($id, $encrypted_id);
    }
  }

  public function add_edit_expence_view($id, $encrypted_id)
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $company_id = $this->session->userdata('company_id');
    if ($id == "") {
      check_permission('add_expense');
      $data = array();
      $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
      $data['expense_categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_expense_products");
      $data['employees'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
      $data['main_content'] = $this->load->view('expense/addExpense', $data, TRUE);
      $this->load->view('userHome', $data);
    } else {
      check_permission('edit_expense');
      $data = array();
      $data['encrypted_id'] = $encrypted_id;
      $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
      $data['expense_categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_expense_products");
      $data['employees'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
      $data['expense_information'] = $this->Common_model->getDataById($id, "tbl_expenses");
      $data['main_content'] = $this->load->view('expense/editExpense', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }
}
