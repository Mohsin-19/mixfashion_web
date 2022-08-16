<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class DeliveryPerson extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    check_permission('show_cash');
  }

  /**
   * delivery person items view
   * @access public
   * @return void
   */
  public function deliveryPersonItems()
  {
    $role = $this->session->userdata('role_name');
    $data = array();
    $data['items'] = $this->Common_model->getAllDeliveryItemsRow();
    $data['main_content'] = $this->load->view('delivery/del_items', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete delivery items
   * @access public
   * @param int
   * @return void
   */
  public function deleteDeliveryItems($id)
  {
    $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    $this->Common_model->deleteStatusChange($id, "tbl_delivery_persons");
    $this->Common_model->deleteCustomRow($id, "del_p_id", "tbl_delivery_person_items");
    $this->session->set_flashdata('exception', lang('delete_success'));
    redirect('deliveryPerson/deliveryPersonItems');
  }

  /**
   * Close cash
   * @access public
   * @return void
   */
  public function closeCash($id)
  {
    $getClosingAmount = getClosingAmount($id);
    $data = array();
    $data['close_by'] = $this->session->userdata('user_id');
    $data['closing_time'] = date('h:i A');
    $data['closing_amount'] = $getClosingAmount;
    $data['close_status'] = 2;
    $this->Common_model->updateInformation($data, $id, "tbl_delivery_persons");
    $this->session->set_flashdata('exception', lang('close_success'));
    redirect('deliveryPerson/deliveryPersonItems');
  }

  /**
   * add delivery person items
   * @access public
   * @param int
   * @return void
   */
  public function addDeliveryPersonItems($encrypted_id = "")
  {

    $role = $this->session->userdata('role');
    $delivery_person_id = '';
    if ($role == "Delivery Person" && $encrypted_id) {
      $delivery_person_id = $this->session->userdata('user_id');
      if (!checkDelData($encrypted_id, $delivery_person_id)) {

        redirect('deliveryPerson/deliveryPersonItems');
      }
    }
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
    $outlet_id = $this->session->userdata('outlet_id');
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $data = array();
      $data['current_balance'] = $this->input->post('current_balance');
      $data['opening_amount'] = $this->input->post('opening_amount');
      $data['outlet_id'] = $this->session->userdata('outlet_id');
      $data['company_id'] = $this->session->userdata('company_id');

      if ($id == "") {
        $data['open_by'] = $this->session->userdata('user_id');
        $data['delivery_person_id'] = htmlspecialchars($this->input->post('delivery_person_id'));
        $data['date'] = htmlspecialchars($this->input->post('date'));
        $data['opening_time'] = htmlspecialchars($this->input->post('opening_time'));
        $id = $this->Common_model->insertInformation($data, "tbl_delivery_persons");
        $this->session->set_flashdata('exception', lang('insertion_success'));
      } else {
        $this->Common_model->updateInformation($data, $id, "tbl_delivery_persons");
        $this->session->set_flashdata('exception', lang('update_success'));
      }

      $value_row = $this->input->post('value_row');
      $delete_id = $this->input->post('delete_id');

      if ($role == "Admin" && $encrypted_id) {
        $this->Common_model->deleteCustomRow($id, "del_p_id", "tbl_delivery_person_items");
      } else {
        if (isset($delete_id) && $delete_id) {
          foreach ($delete_id as $key => $value) {
            $this->Common_model->deleteStatusChange($value, "tbl_delivery_person_items");
          }
        }

      }

      foreach ($value_row as $key => $value) {
        $item_name = $this->input->post('item_' . $value);
        if ($role == "Delivery Person" && $encrypted_id && ($item_name == "Opening Cash")) {

        } else {
          if ($item_name) {
            $data = array();
            $data['item_name'] = $this->input->post('item_' . $value);
            $data['order_id'] = $this->input->post('order_number_' . $value);
            $data['amount'] = $this->input->post('amount_' . $value);
            $data['description'] = htmlspecialchars($this->input->post('description_' . $value));
            $data['del_p_id'] = $id;
            $this->Common_model->insertInformation($data, "tbl_delivery_person_items");
          }
        }
      }
      redirect('deliveryPerson/deliveryPersonItems');
    } else {
      if ($id == "") {
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['orders'] = $this->Common_model->getAllByTableDESC("tbl_orders");
        $data['delivery_persons'] = $this->Common_model->getDeliveryPersons();
        $data['main_content'] = $this->load->view('delivery/deliveryPersonItems', $data, TRUE);
        $this->load->view('userHome', $data);
      } else {
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['orders'] = $this->Common_model->getAllByTableDESC("tbl_orders");
        $data['delivery_person'] = $this->Common_model->getDataById($id, "tbl_delivery_persons");
        $data['delivery_persons'] = $this->Common_model->getDeliveryPersons();
        $data['items'] = $this->Common_model->getAllByCustomId($id, "del_p_id", "tbl_delivery_person_items", "ASC");
        $data['main_content'] = $this->load->view('delivery/deliveryPersonItems', $data, TRUE);
        $this->load->view('userHome', $data);
      }
    }
  }
}
