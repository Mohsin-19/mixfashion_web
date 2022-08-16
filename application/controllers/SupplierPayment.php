<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class SupplierPayment extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->model('Supplier_payment_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    check_permission(['add_due_payment', 'show_due_payment', 'delete_due_payment']);
  }

  /**
   * supplier payments
   * @access public
   * @return void
   */
  public function supplierPayments()
  {
    check_permission('show_due_payment');
    $outlet_id = $this->session->userdata('outlet_id');
    $data = array();
    $data['supplierPayments'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_supplier_payments");
    $data['main_content'] = $this->load->view('supplierPayment/supplierPayments', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete supplier payments
   * @access public
   * @param int
   * @return void
   */
  public function deleteSupplierPayment($id)
  {
    check_permission('delete_due_payment');
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->deleteStatusChange($id, "tbl_supplier_payments");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('SupplierPayment/supplierPayments');
  }

  /**
   * add supplier payments
   * @access public
   * @return void
   */
  public function addSupplierPayment()
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $company_id = $this->session->userdata('company_id');

    if ($this->input->post('submit')) {
      check_permission('add_due_payment');
      $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
      $this->form_validation->set_rules('amount', lang('amount'), 'required|max_length[50]');
      $this->form_validation->set_rules('supplier_id', lang('supplier'), 'required|max_length[10]');
      $this->form_validation->set_rules('payment_method_id', lang('payment_methods'), 'required');
      $this->form_validation->set_rules('note', lang('note'), 'max_length[200]');
      if ($this->form_validation->run() == TRUE) {
        $splr_payment_info = array();
        $splr_payment_info['date'] = date("Y-m-d", strtotime(htmlspecialchars($this->input->post('date'))));
        $splr_payment_info['amount'] = htmlspecialchars($this->input->post('amount'));
        $splr_payment_info['supplier_id'] = htmlspecialchars($this->input->post('supplier_id'));
        $splr_payment_info['payment_method_id'] = htmlspecialchars($this->input->post('payment_method_id'));
        $splr_payment_info['note'] = htmlspecialchars($this->input->post('note'));
        $splr_payment_info['user_id'] = $this->session->userdata('user_id');
        $splr_payment_info['outlet_id'] = $this->session->userdata('outlet_id');

        $this->Common_model->insertInformation($splr_payment_info, "tbl_supplier_payments");
        $this->session->set_flashdata('exception', lang('insertion_success'));

        redirect('SupplierPayment/supplierPayments');
      } else {
        $data = array();
        $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
        $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_suppliers");
        $data['main_content'] = $this->load->view('supplierPayment/addSupplierPayment', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    } else {
      $data = array();
      $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
      $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_suppliers");
      $data['main_content'] = $this->load->view('supplierPayment/addSupplierPayment', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

  /**
   * supplier due
   * @access public
   * @return null
   */
  public function getSupplierDue()
  {
    $supplier_id = $_GET['supplier_id'];

    $remaining_due = $this->Supplier_payment_model->getSupplierDue($supplier_id);

    echo escape_output($remaining_due);
  }

  /* ----------------------Expense End-------------------------- */
}
