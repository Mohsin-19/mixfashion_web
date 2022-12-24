<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class AjaxOrderController extends Cl_Controller
{
  /**
   * load constructor
   * @access public
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_model');
    $this->load->model('Ajax_model');
    $this->load->model('Inventory_model');
    $this->load->model('Frontend');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    //    if (!$this->session->has_userdata('user_id')) {
    //      redirect('Authentication/index');
    //    }
  }


  public function get_order_edit_modal()
  {
    $order_id = $this->input->post('order_id');
    $result = $this->Common_model->getOrderData($order_id);
    $areas = $this->Common_model->getAllByTable("tbl_areas");
    $this->load->view('order_management/ajax_component/edit_modal', ['order' => $result, 'areas' => $areas]);
  }

  public function updateOrderQuickInfo()
  {
    $id = $this->input->post('id');
    $data['delivery_date'] = $this->input->post('delivery_date');
    $data['delivery_time'] = $this->input->post('delivery_time');
    $data['checkout_name'] = $this->input->post('checkout_name');
    $data['checkout_phone'] = $this->input->post('checkout_phone');
    $data['checkout_email'] = $this->input->post('checkout_email');
    $data['area'] = $this->input->post('area');
    $data['address'] = $this->input->post('address');
    $activityData = implode('| ', $data);
    // assign_activity([
    //   'activity ' => "Update quick information! {$activityData} . Order id #{$id}",
    //   'link ' => '',
    //   'controller ' => 'Ajax'
    // ]);

    $this->Common_model->updateInformation($data, $id, "tbl_orders");
    $data['id'] = $id;

    return responseJson($data);
  }


  public function getSearchProduct()
  {
    $keyword = $this->input->post('keyword');
    $products = $this->Frontend->getSearchProducts(200, $keyword, 0);

    $productData = '<ul>';
    foreach ($products as $key => $product) {
      $process = rawurlencode(json_encode($product));
      $active = $key === 0 ? 'active' : '';
      $productData .= '<li class="' . $active . '" data-item="' . $process . '">' . $product->name . '</li>';
    }
    $productData .= '</ul>';

    echo $productData;
  }

  public function order_mark_complete($id)
  {
    $data['del_status'] = 'Live';
    $this->Common_model->updateInformation($data, $id, "tbl_orders");
    $order = $this->Common_model->getOrderData($id);
    $phone = $order->cus_phone ?? null;
    $email = $order->cus_email ?? null;

    $txt = "Hello Sir/ Madam. Thank you for placing your order at http://mixfashionhouse.com/ . Your order " . $order->order_number . " & order amount BDT " . $order->total_amount . ".";
    // $data['notifications_details'] = $txt;
    // $data['order_id'] = $id;
    // $data['date'] = date("Y-m-d", strtotime('today'));
    // $this->Common_model->insertInformation($data, "tbl_notifications");

    // continue order notification send
    if ($phone) {
      $status = mim_sms($txt, $phone);
    }

    if ($email) {
      $data['txt'] = $txt;
      $data['order'] = $this->Common_model->getOrderData($id);
      $data['items'] = $this->Common_model->getOrderItems($id);
      $data['outlet_information'] = $this->Common_model->getDataById(customer('outlet_id'), "tbl_outlets");
      $html = $this->load->view('order_management/invoice_email.php', $data, true);
      sendEmail($html, $email, "", 1);
    }

    $data['id'] = $id;
    $data['order'] = $order;

    return responseJson($data);
  }
}
