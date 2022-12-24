<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Purchase_model');

    $this->load->model('Inventory_model');
    $this->load->model('Common_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');

    check_permission(['add_purchase', 'show_purchase', 'view_details', 'edit_purchase', 'delete_purchase']);
  }

  /**
   * purchase list
   * @access public
   * @return void
   */
  public function purchases()
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $data = array();
    $data['purchases'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_purchase");
    $data['main_content'] = $this->load->view('purchase/purchases', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete purchase
   * @access public
   * @param int
   * @return void
   */
  public function deletePurchase($id)
  {
    check_permission('delete_purchase');
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_purchase", "tbl_purchase_details", 'id', 'purchase_id');
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('Purchase/purchases');
  }

  /**
   * add/edit purchase
   * @access public
   * @param int
   * @return void
   */
  public function addEditPurchase($encrypted_id = "")
  {

    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $outlet_id = $this->session->userdata('outlet_id');

    $purchase_info = array();

    if ($id == "") {
      $purchase_info['reference_no'] = $this->Purchase_model->generatePurRefNo($outlet_id);
    } else {
      $purchase_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_purchase")->reference_no;
    }

    if ($this->input->post('submit')) {

      check_permission(['add_purchase', 'edit_purchase']);

      $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
      $this->form_validation->set_rules('supplier_id', lang('supplier'), 'required|max_length[50]');
      //  $this->form_validation->set_rules('payment_method_id',lang('payment_methods'), 'required');
      $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
      $this->form_validation->set_rules('note', lang('note'), 'max_length[200]');
      //$this->form_validation->set_rules('subtotal', 'Subtotal', 'required|numeric|max_length[50]');
      //$this->form_validation->set_rules('other', 'Other', 'required|numeric|max_length[50]');
      //$this->form_validation->set_rules('grand_total', 'Grand Total', 'required|numeric|max_length[50]');
      $this->form_validation->set_rules('paid', lang('paid_amount'), 'required|numeric|max_length[50]');
      //$this->form_validation->set_rules('due', 'Due Amount', 'required|numeric|max_length[50]');
      if ($this->form_validation->run() == TRUE) {

        $purchase_info['reference_no'] = $this->input->post('reference_no');
        $purchase_info['invoice_no'] = htmlspecialchars($this->input->post('invoice_no'));
        $purchase_info['supplier_id'] = htmlspecialchars($this->input->post('supplier_id'));
        $purchase_info['payment_method_id'] = htmlspecialchars($this->input->post('payment_method_id'));
        $purchase_info['date'] = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('date'))));
        $purchase_info['note'] = htmlspecialchars($this->input->post('note'));
        $purchase_info['grand_total'] = htmlspecialchars($this->input->post('grand_total'));
        $purchase_info['paid'] = htmlspecialchars($this->input->post('paid'));
        $purchase_info['due'] = htmlspecialchars($this->input->post('due'));
        $purchase_info['user_id'] = $this->session->userdata('user_id');
        $purchase_info['outlet_id'] = $this->session->userdata('outlet_id');

        if ($id == "") {
          check_permission('add_purchase');
          $purchase_id = $this->Common_model->insertInformation($purchase_info, "tbl_purchase");
          $this->savePurchaseDetails($_POST['product_id'], $purchase_id, 'tbl_purchase_details');
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          check_permission('edit_purchase');
          $this->Common_model->updateInformation($purchase_info, $id, "tbl_purchase");
          $this->Common_model->deletingMultipleFormData('purchase_id', $id, 'tbl_purchase_details');
          $this->savePurchaseDetails($_POST['product_id'], $id, 'tbl_purchase_details');
          $this->session->set_flashdata('exception', lang('update_success'));
        }

        redirect('Purchase/purchases');
      } else {
        $this->add_edit_purchase_view($id, $encrypted_id);
      }
    } else {
      $this->add_edit_purchase_view($id, $encrypted_id);
    }
  }


  public function add_edit_purchase_view($id, $encrypted_id)
  {
    $company_id = $this->session->userdata('company_id');
    $outlet_id = $this->session->userdata('outlet_id');
    if ($id == "") {
      check_permission('add_purchase');
      $data = array();
      $data['pur_ref_no'] = $this->Purchase_model->generatePurRefNo($outlet_id);
      $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
      $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
      $data['products'] = $this->Purchase_model->getItemListWithUnitAndPrice($company_id);
      $data['main_content'] = $this->load->view('purchase/addPurchase', $data, TRUE);
      $this->load->view('userHome', $data);
    } else {
      check_permission('edit_purchase');
      $data = array();
      $data['encrypted_id'] = $encrypted_id;
      $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
      $data['purchase_details'] = $this->Common_model->getDataById($id, "tbl_purchase");
      $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
      $data['products'] = $this->Purchase_model->getItemListWithUnitAndPrice($company_id);
      $data['purchase_products'] = $this->Purchase_model->getPurchaseItems($id);
      $data['main_content'] = $this->load->view('purchase/editPurchase', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }


  /**
   * save purchase details data
   * @access public
   * @param array
   * @param int
   * @param string
   * @return void
   */
  public function savePurchaseDetails($purchase_products, $purchase_id, $table_name)
  {
    foreach ($purchase_products as $row => $product_id):
      $fmi = array();
      $fmi['product_id'] = $_POST['product_id'][$row];
      $fmi['unit_price'] = $_POST['unit_price'][$row];

      if (!empty($_POST['conversion_rate'][$row])) {
        $fmi['divided_price'] = round(($_POST['unit_price'][$row] / $_POST['conversion_rate'][$row]), 2);
      } else {
        $fmi['divided_price'] = $_POST['unit_price'][$row] / 1;
      }
      $fmi['quantity_amount'] = $_POST['quantity_amount'][$row];
      $fmi['total'] = $_POST['total'][$row];
      $fmi['purchase_id'] = $purchase_id;
      $fmi['outlet_id'] = $this->session->userdata('outlet_id');
      $this->Common_model->insertInformation($fmi, "tbl_purchase_details");
    endforeach;
  }

  /**
   * purhcase details view
   * @access public
   * @param int
   * @return void
   */
  public function purchaseDetails($id)
  {
    check_permission('view_details');
    $encrypted_id = $id;
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');

    $data = array();
    $data['encrypted_id'] = $encrypted_id;
    $data['purchase_details'] = $this->Common_model->getDataById($id, "tbl_purchase");
    $data['purchase_products'] = $this->Purchase_model->getPurchaseItems($id);
    $data['main_content'] = $this->load->view('purchase/purchaseDetails', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * add supplier by ajax
   * @access public
   * @return json
   */
  public function addNewSupplierByAjax()
  {
    $data['name'] = $_GET['name'];
    $data['contact_person'] = $_GET['contact_person'];
    $data['phone'] = $_GET['phone'];
    $data['email'] = $_GET['emailAddress'];
    $data['previous_due'] = $_GET['previous_due'];
    $data['address'] = $_GET['supAddress'];
    $data['description'] = $_GET['description'];
    $data['user_id'] = $this->session->userdata('user_id');
    $data['company_id'] = $this->session->userdata('company_id');
    $this->db->insert('tbl_suppliers', $data);
    $supplier_id = $this->db->insert_id();
    $data1 = array('supplier_id' => $supplier_id);
    echo json_encode($data1);
  }

  /**
   * supplier list by ajax
   * @access public
   * @return json
   */
  public function getSupplierList()
  {
    $company_id = $this->session->userdata('company_id');
    $data1 = $this->db->query("SELECT * FROM tbl_suppliers 
              WHERE company_id=$company_id")->result();
    echo '<option value="">Select</option>';
    foreach ($data1 as $value) {
      echo '<option value="' . $value->id . '" >' . $value->name . '</option>';
    }
    exit;
  }
  /* ----------------------Purchase End-------------------------- */
}
