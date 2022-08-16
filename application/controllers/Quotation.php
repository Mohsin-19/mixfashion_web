<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Quotation_model');

    $this->load->model('Common_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');

    if (!$this->session->has_userdata('user_id')) {
      redirect('Authentication/index');
    }


    /*-------------Protect Delete and Edit for other users than Admin------------------*/

    if ($this->session->has_userdata('role') != 'Admin') {

      $get_second_uri = $this->uri->segment(2);
      $first_six_letter = substr($get_second_uri, 0, 6);
      if ($first_six_letter == "delete") {
        echo "<h2 style='color: red; margin-top: 15%; text-align: center;'>Deleting is allowed only for admin!</h2>";
        echo "<p style='color: red; text-align: center;'><a href='" . base_url() . "Authentication/userProfile'</a>Click to Return</p>";
        exit;
      }

      $get_third_uri = $this->uri->segment(3);
      $first_seven_letter = substr($get_second_uri, 0, 7);
      $last_four_letter = substr($first_seven_letter, 3);
      if ($last_four_letter == "Edit" && $get_third_uri != '') {
        echo "<h2 style='color: red; margin-top: 15%; text-align: center;'>Modifying is allowed only for admin!</h2>";
        echo "<p style='color: red; text-align: center;'><a href='" . base_url() . "Authentication/userProfile'</a>Click to Return</p>";
        exit;
      }

    }
    /*-------------Protect Delete and Edit for other users than Admin------------------*/
  }

  /**
   * Quotation view page
   * @access public
   * @return void
   */
  public function quotations()
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $data = array();
    $data['quotations'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_quotations");
    $data['main_content'] = $this->load->view('quotation/quotations', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete quotation
   * @access public
   * @param int
   * @return void
   */
  public function deleteQuotation($id)
  {
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_quotations", "tbl_quotation_details", 'id', 'quotation_id');
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('Quotation/quotations');
  }

  /**
   * add/edit Quotation
   * @access public
   * @param int
   * @param string
   * @return void
   */
  public function addEditQuotation($encrypted_id = "", $action = '')
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $outlet_id = $this->session->userdata('outlet_id');
    $company_id = $this->session->userdata('company_id');

    $quotation_info = array();

    if ($id == "") {
      $quotation_info['reference_no'] = $this->Quotation_model->generatePurRefNo($outlet_id);
    } else {
      $quotation_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_quotations")->reference_no;
    }
    if ($this->input->post('submit')) {
      $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
      $this->form_validation->set_rules('customer_id', lang('customer'), 'required|max_length[50]');
      $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
      $this->form_validation->set_rules('note', lang('Remark'), 'max_length[200]');
      $this->form_validation->set_rules('subtotal', lang('sub_total'), 'required|numeric|max_length[50]');
      $this->form_validation->set_rules('grand_total', lang('g_total'), 'required|numeric|max_length[50]');
      $this->form_validation->set_rules('other', lang('other'), 'numeric|max_length[50]');
      $this->form_validation->set_rules('discount', lang('discount'), 'max_length[50]');
      if ($this->form_validation->run() == TRUE) {

        $quotation_info['reference_no'] = htmlspecialchars($this->input->post('reference_no'));
        $quotation_info['customer_id'] = htmlspecialchars($this->input->post('customer_id'));
        $quotation_info['date'] = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('date'))));
        $quotation_info['note'] = htmlspecialchars($this->input->post('note'));
        $quotation_info['grand_total'] = htmlspecialchars($this->input->post('grand_total'));
        $quotation_info['subtotal'] = htmlspecialchars($this->input->post('subtotal'));
        $quotation_info['other'] = htmlspecialchars($this->input->post('other'));
        $quotation_info['discount'] = htmlspecialchars($this->input->post('discount'));
        $quotation_info['user_id'] = $this->session->userdata('user_id');
        $quotation_info['outlet_id'] = $this->session->userdata('outlet_id');


        if ($id == "" || $action == "copy") {
          $quotation_id = $this->Common_model->insertInformation($quotation_info, "tbl_quotations");
          $this->saveQuotationDetails($_POST['product_id'], $quotation_id, 'tbl_quotation_details');
          $baseUrl = base_url() . "Quotation/quotationDetails/$quotation_id/print";
          $this->session->set_flashdata('exception', lang('insertion_success') . "  <a target='_blank' href='$baseUrl'>, click here to print this quotation</a>");
        } else {
          $baseUrl = base_url() . "Quotation/quotationDetails/$id/print";
          $this->Common_model->updateInformation($quotation_info, $id, "tbl_quotations");
          $this->Common_model->deletingMultipleFormData('quotation_id', $id, 'tbl_quotation_details');
          $this->saveQuotationDetails($_POST['product_id'], $id, 'tbl_quotation_details');
          $this->session->set_flashdata('exception', lang('update_success') . "  <a target='_blank' href='$baseUrl'>, click here to print this quotation</a>");
        }
        redirect('Quotation/quotations');
      } else {
        if ($id == "") {
          $data = array();
          $data['pur_ref_no'] = $this->Quotation_model->generatePurRefNo($outlet_id);
          $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
          $data['products'] = $this->Quotation_model->getItemListWithUnitAndPrice($company_id);
          $data['main_content'] = $this->load->view('quotation/addQuotation', $data, TRUE);
          $this->load->view('userHome', $data);
        } else {
          $data = array();
          $data['encrypted_id'] = $encrypted_id;
          $data['action'] = $action;
          $data['pur_ref_no'] = $this->Quotation_model->generatePurRefNo($outlet_id);
          $data['quotation_details'] = $this->Common_model->getDataById($id, "tbl_quotations");
          $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
          $data['products'] = $this->Quotation_model->getItemListWithUnitAndPrice($company_id);
          $data['quotation_products'] = $this->Quotation_model->getQuotationItems($id);
          $data['main_content'] = $this->load->view('quotation/editQuotation', $data, TRUE);
          $this->load->view('userHome', $data);
        }
      }
    } else {
      if ($id == "") {
        $data = array();
        $data['pur_ref_no'] = $this->Quotation_model->generatePurRefNo($outlet_id);
        $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
        $data['products'] = $this->Quotation_model->getItemListWithUnitAndPrice($company_id);
        $data['main_content'] = $this->load->view('quotation/addQuotation', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['action'] = $action;
        $data['pur_ref_no'] = $this->Quotation_model->generatePurRefNo($outlet_id);
        $data['quotation_details'] = $this->Common_model->getDataById($id, "tbl_quotations");
        $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
        $data['products'] = $this->Quotation_model->getItemListWithUnitAndPrice($company_id);

        $data['quotation_products'] = $this->Quotation_model->getQuotationItems($id);
        $data['main_content'] = $this->load->view('quotation/editQuotation', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }

  /**
   * save quotation details
   * @access public
   * @param array
   * @param int
   * @param string
   * @return void
   */
  public function saveQuotationDetails($quotation_products, $quotation_id, $table_name)
  {
    foreach ($quotation_products as $row => $product_id):
      $fmi = array();
      $fmi['product_id'] = $_POST['product_id'][$row];
      $fmi['unit_price'] = $_POST['unit_price'][$row];
      $fmi['quantity_amount'] = $_POST['quantity_amount'][$row];
      $fmi['total'] = $_POST['total'][$row];
      $fmi['description'] = $_POST['description'][$row];
      $fmi['quotation_id'] = $quotation_id;
      $fmi['outlet_id'] = $this->session->userdata('outlet_id');
      $this->Common_model->insertInformation($fmi, "tbl_quotation_details");
    endforeach;
  }

  /**
   * Quotation details view page
   * @access public
   * @param int
   * @param string
   * @return void
   */
  public function quotationDetails($id, $action = '')
  {
    $encrypted_id = $id;
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');

    $data = array();
    $data['encrypted_id'] = $encrypted_id;
    $data['quotation_details'] = $this->Common_model->getDataById($id, "tbl_quotations");
    $data['quotation_products'] = $this->Quotation_model->getQuotationItems($id);
    if ($action == "print") {
      $data['main_content'] = $this->load->view('quotation/quotationDetailPrint', $data, TRUE);
    } else {
      $data['main_content'] = $this->load->view('quotation/quotationDetails', $data, TRUE);
    }

    $this->load->view('userHome', $data);
  }

  /**
   * email send for quotation
   * @access public
   * @param int
   * @return void
   */
  public function quotationSendEmail($id)
  {
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $quotation_details = $this->Common_model->getDataById($id, "tbl_quotations");
    $customer_details = $this->Common_model->getDataById($id, "tbl_customers");

    if ($customer_details) {
      if (isset($customer_details->email) && $customer_details->email) {
        $outletName = $this->session->userdata('outlet_name');
        $currency = $this->session->userdata('currency');
        $quotation_date_time = $quotation_details->date;
        $msg = "Dear " . $customer_details->name . ",
Your quotation from " . $outletName . " amount is " . $quotation_details->grand_total . " " . $currency . ".
On " . $quotation_date_time . ". Thank you for shopping with us!";
        $this->Master_model->sendEmail($customer_details->email, "Quotation Invoice", $msg);
      }
    }
    $this->session->set_flashdata('exception', lang('email_success'));
    redirect('Quotation/quotations');

  }

  /* ----------------------Quotation End-------------------------- */
}
