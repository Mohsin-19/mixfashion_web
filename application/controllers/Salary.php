<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

  }

  /**
   * delete salary
   * @access public
   * @param int
   * @return void
   */
  public function deleteSalary($id)
  {
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->deleteStatusChange($id, "tbl_salaries");

    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('salary/generate');
  }

  /**
   * print salary
   * @access public
   * @param int
   * @return void
   */

  public function printSalary($encrypted_id)
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $data['getSelectedRow'] = $this->Common_model->getDataById($id, 'tbl_salaries');
    $this->load->view('salary/print_salary', $data);
  }

  /**
   * generate salary view
   * @access public
   * @param int
   * @return void
   */
  public function generate($id = '')
  {
    check_permission('show_payroll');
    if ($this->input->post('submit')) {
      $this->form_validation->set_rules('month', lang('month'), 'required|max_length[50]');
      $this->form_validation->set_rules('year', lang('year'), 'required|max_length[50]');
      if ($this->form_validation->run() == TRUE) {
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $data = array();
        $data['month'] = $month;
        $data['year'] = $year;
        $checkExistingSalary = checkExistingSalary($month, $year);
        if ($checkExistingSalary) {
          $this->session->set_flashdata('exception_r', lang('salary_exist'));
          redirect('salary/generate');
        } else {
          $data['getSalaryUsers'] = $this->Common_model->getSalaryUsers();
          $data['main_content'] = $this->load->view('salary/addEditSalary', $data, TRUE);
          $this->load->view('userHome', $data);
        }

      } else {
        $data = array();
        $data['salaries'] = $this->Common_model->getAllByTable("tbl_salaries");
        $data['main_content'] = $this->load->view('salary/salaries', $data, TRUE);
        $this->load->view('userHome', $data);
      }

    } else {
      $data = array();
      $data['salaries'] = $this->Common_model->getAllByTable("tbl_salaries");
      $data['main_content'] = $this->load->view('salary/salaries', $data, TRUE);
      $this->load->view('userHome', $data);
    }

  }

  /**
   * add/edit salary
   * @access public
   * @param int
   * @return void
   */
  public function addEditSalary($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $month = $this->input->post('month');
    $year = $this->input->post('year');
    $user_id = $this->input->post('user_id');
    $salary = $this->input->post('salary');
    $additional = $this->input->post('additional');
    $subtraction = $this->input->post('subtraction');
    $total = $this->input->post('total');
    $notes = $this->input->post('notes');
    if ($this->input->post('submit')) {
      check_permission(['add_salary', 'edit_salary']);
      $final_arr = array();
      $total_amount = 0;
      for ($i = 0; $i < sizeof($user_id); $i++) {
        $txt = "product_id" . $user_id[$i];
        $tmp_v = $this->input->post($txt);
        $tmp = array();
        $tmp['p_status'] = isset($tmp_v) && $tmp_v ? 1 : '';
        $tmp['user_id'] = $user_id[$i];
        $tmp['name'] = userName($user_id[$i]);
        $tmp['salary'] = $salary[$i];
        $tmp['additional'] = $additional[$i];
        $tmp['subtraction'] = $subtraction[$i];
        $tmp['total'] = $total[$i];
        $tmp['notes'] = $notes[$i];
        $total_amount += $total[$i];
        $final_arr[] = $tmp;
      }

      $data = array();
      $data['month'] = $month;
      $data['year'] = $year;
      $data['date'] = date("Y-m-d", strtotime('today'));
      $data['total_amount'] = $total_amount;
      $data['details_info'] = json_encode($final_arr);
      if ($id == '') {
        check_permission('add_salary');
        $this->Common_model->insertInformation($data, "tbl_salaries");
      } else {
        check_permission('edit_salary');
        $this->Common_model->updateInformation($data, $id, "tbl_salaries");
      }
      redirect('salary/generate');
    } else {
      if ($id == '') {
        check_permission('add_salary');
        redirect('salary/generate');
      } else {
        $data['getSelectedRow'] = $this->Common_model->getDataById($id, 'tbl_salaries');
        $data['main_content'] = $this->load->view('salary/addEditSalaryEdit', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }

  /* ----------------------Expense End-------------------------- */
}
