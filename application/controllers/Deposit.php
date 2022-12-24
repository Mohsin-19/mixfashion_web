<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposit extends Cl_Controller
{

  public function __construct()
  {

    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Deposit_model');
    $this->load->model('Common_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();


  }

  /**
   * deposits view
   * @access public
   * @return void
   */
  public function deposits()
  {

    $outlet_id = $this->session->userdata('outlet_id');
    $data = array();
    $data['deposit_lists'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_deposit");
    $data['main_content'] = $this->load->view('master/deposit/deposits', $data, TRUE);
    $this->load->view('userHome', $data);

  }

  /**
   * delete deposit
   * @access public
   * @param int
   * @return void
   */
  public function deleteDeposit($id)
  {
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');

    $this->Common_model->deleteStatusChange($id, "tbl_deposit");

    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('Deposit/deposits');
  }

  /**
   * add/edit deposit
   * @access public
   * @param int
   * @return void
   */
  public function addEditDeposit($encrypted_id = "")
  {
    $company_id = $this->session->userdata('company_id');
    $outlet_id = $this->session->userdata('outlet_id');
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    if ($this->input->post('submit')) {
      $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
      $this->form_validation->set_rules('amount', lang('amount'), 'required|min_length[1]');
      $this->form_validation->set_rules('payment_method_id', lang('payment_methods'), 'required');
      $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
      $this->form_validation->set_rules('type', lang('deposit_or_withdraw'), 'required');
      $this->form_validation->set_rules('note', lang('note'), 'max_length[200]');
      if ($this->form_validation->run() == TRUE) {
        $fmc_info = array();
        $fmc_info['reference_no'] = htmlspecialchars($this->input->post('reference_no'));
        $fmc_info['date'] = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('date'))));
        $fmc_info['type'] = htmlspecialchars($this->input->post('type'));
        $fmc_info['note'] = htmlspecialchars($this->input->post('note'));
        $fmc_info['amount'] = htmlspecialchars($this->input->post('amount'));
        $fmc_info['payment_method_id'] = htmlspecialchars($this->input->post('payment_method_id'));
        $fmc_info['user_id'] = $this->session->userdata('user_id');
        $fmc_info['outlet_id'] = $this->session->userdata('outlet_id');
        if ($id == "") {
          $this->Common_model->insertInformation($fmc_info, "tbl_deposit");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          $this->Common_model->updateInformation($fmc_info, $id, "tbl_deposit");
          $this->session->set_flashdata('exception', lang('delete_success'));
        }
        redirect('Deposit/deposits');
      } else {
        if ($id == "") {
          $data = array();
          $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
          $data['deposit_ref_no'] = $this->Deposit_model->generatePurRefNo($outlet_id);
          $data['main_content'] = $this->load->view('master/deposit/addDeposit', $data, TRUE);
          $this->load->view('userHome', $data);
        } else {
          $data = array();
          $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
          $data['encrypted_id'] = $encrypted_id;
          $data['deposit_information'] = $this->Common_model->getDataById($id, "tbl_deposit");
          $data['main_content'] = $this->load->view('master/deposit/editDeposit', $data, TRUE);
          $this->load->view('userHome', $data);
        }
      }
    } else {
      if ($id == "") {
        $data = array();
        $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
        $data['deposit_ref_no'] = $this->Deposit_model->generatePurRefNo($outlet_id);
        $data['main_content'] = $this->load->view('master/deposit/addDeposit', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        $data = array();
        $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
        $data['encrypted_id'] = $encrypted_id;
        $data['deposit_information'] = $this->Common_model->getDataById($id, "tbl_deposit");
        $data['main_content'] = $this->load->view('master/deposit/editDeposit', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }

}
