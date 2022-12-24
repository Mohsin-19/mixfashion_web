<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */

defined('BASEPATH') or exit('No direct script access allowed');

class OrderManagement extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');
    check_permission(['show_order', 'print_invoice', 'print_package_slip', 'process_order', 'dispatch_order', 'complete_order', 'return_order', 'cancel_order', 'assign_delivery', 'add_note', 'product_purchase']);
  }

  /**
   * order list printable view show
   * @access public
   * @return void
   */
  public function printAll()
  {
    $data = array();
    $data['employees'] = $this->Common_model->getDeliveryPersons();

    $role = $this->session->userdata('role');
    $assign_id = '';
    if ($role != "Admin") {
      $assign_id = $this->session->userdata('user_id');
    }
    if ($this->input->post('submit')) {
      $date = htmlspecialchars($this->input->post('date'));
      $area = htmlspecialchars($this->input->post('area'));
      $phone = htmlspecialchars($this->input->post('phone'));
      $status = htmlspecialchars($this->input->post('status'));
      $data['orders'] = $this->Common_model->getCustomOrderList($date, $area, $phone, $status, $assign_id);
    } else {
      $data['orders'] = $this->Common_model->getCustomOrderList('', '', '', '', $assign_id);
    }
    $data['arees'] = $this->Common_model->getAllByTable("tbl_areas");
    $data['main_content'] = $this->load->view('order_management/printAll', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * order list view page
   * @access public
   * @return void
   */
  public function orders()
  {
    $data = array();
    $data['employees'] = $this->Common_model->getDeliveryPersons();

    if ($this->input->post('submit')) {
      $date = htmlspecialchars($this->input->post('date'));
      $area = htmlspecialchars($this->input->post('area'));
      $phone = htmlspecialchars($this->input->post('phone'));
      $status = htmlspecialchars($this->input->post('status'));
      $data['orders'] = $this->Common_model->getCustomOrderList($date, $area, $phone, $status);
    } else {
      $data['orders'] = $this->Common_model->getCustomOrderList();
    }

    // dd($data['orders']);

    // assign_activity([
    //   'activity ' => "Browse all Order Data",
    //   'link ' => 'orderManagement/addOrder',
    //   'controller ' => 'OrderManagement'
    // ]);


    $data['areas'] = $this->Common_model->getAllByTable("tbl_areas");
    $data['main_content'] = $this->load->view('order_management/orders', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * product purchase page
   * @access public
   * @return void
   */
  public function productPurchase()
  {
    check_permission('product_purchase');
    $data = array();
    $date = htmlspecialchars($this->input->post('date'));
    $data['items'] = $this->Common_model->getProductPurchase($date);
    $data['main_content'] = $this->load->view('order_management/productPurchase', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * order print invoice page
   * @access public
   * @param int
   * @return void
   */
  public function print_invoice($id)
  {
    check_permission('print_invoice');
    $data['order'] = $this->Common_model->getOrderData($id);
    $data['items'] = $this->Common_model->getOrderItems($id);
    $data['outlet_information'] = $this->Common_model->getDataById($this->session->userdata('outlet_id'), "tbl_outlets");
    $this->load->view('order_management/print_invoice', $data);
  }

  /**
   * order print invoice page
   * @access public
   * @param int
   * @return void
   */
  public function print_packing_slip($id)
  {
    check_permission('print_package_slip');
    $data['order'] = $this->Common_model->getOrderData($id);
    $data['items'] = $this->Common_model->getOrderItems($id);
    $data['outlet_information'] = $this->Common_model->getDataById($this->session->userdata('outlet_id'), "tbl_outlets");
    $this->load->view('order_management/print_packing_slip', $data);
  }
}
