<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Coupon extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();

    check_permission(['add_coupon', 'show_coupon', 'edit_coupon', 'delete_coupon', 'show_coupon_customer']);
  }

  /**
   * payment methods view page
   * @access public
   * @return void
   */
  public function coupons()
  {
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['coupons'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_coupons");
    $data['main_content'] = $this->load->view('master/coupon/coupons', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  public function couponsCustomers()
  {
    check_permission('show_coupon_customer');
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['coupon_customers'] = $this->Common_model->getCouponCustomers();
    $data['main_content'] = $this->load->view('master/couponsCustomers/couponsCustomers', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * delete payment method
   * @access public
   * @param int
   * @return void
   */
  public function deleteCoupon($id)
  {
    check_permission('delete_coupon');
    if ($id > 5) {
      $id = $this->custom->encrypt_decrypt($id, 'decrypt');
      $this->Common_model->permanentDelete($id, "tbl_coupons");
      $this->session->set_flashdata('exception', lang('delete_success'));
      redirect('Coupon/coupons');
    }
  }

  /**
   * add/edit payment method
   * @access public
   * @param int
   * @return void
   */
  public function addEditCoupon($encrypted_id = "")
  {
    $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');

    if ($this->input->post('submit')) {

      check_permission(['add_coupon', 'edit_coupon']);

      $this->form_validation->set_rules('code', lang('code'), 'required|max_length[50]');
      $this->form_validation->set_rules('coupon_option', 'Coupon Option', 'required|max_length[155]');
      $this->form_validation->set_rules('amount', lang('amount'), 'required|max_length[50]');
      $this->form_validation->set_rules('expired_date', lang('expired_date'), 'required|max_length[50]');
      if ($this->form_validation->run() == false) {
        $this->add_or_edit($id, $encrypted_id);
      } else {
        $cData = [
          'code' => htmlspecialchars($this->input->post('code')),
          'coupon_option' => htmlspecialchars($this->input->post('coupon_option')),
          'amount' => htmlspecialchars($this->input->post('amount')),
          'expired_date' => htmlspecialchars($this->input->post('expired_date')),
          'user_id' => $this->session->userdata('user_id'),
          'company_id' => $this->session->userdata('company_id'),
        ];
        if ($id == "") {
          check_permission('add_coupon');
          $this->Common_model->insertInformation($cData, "tbl_coupons");
          $this->session->set_flashdata('exception', lang('insertion_success'));
        } else {
          check_permission('edit_coupon');
          $this->Common_model->updateInformation($cData, $id, "tbl_coupons");
          $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('Coupon/coupons');
      }

    } else {
      $this->add_or_edit($id, $encrypted_id);
    }
  }


  function add_or_edit($id = "", $encrypted_id = "")
  {
    if ($id == "") {
      check_permission('add_coupon');
      $data = array();
      $data['main_content'] = $this->load->view('master/coupon/addCoupon', $data, TRUE);
      $this->load->view('userHome', $data);
    } else {
      check_permission('edit_coupon');
      $data = array();
      $data['encrypted_id'] = $encrypted_id;
      $data['coupon'] = $this->Common_model->getDataById($id, "tbl_coupons");
      $data['main_content'] = $this->load->view('master/coupon/editCoupon', $data, TRUE);
      $this->load->view('userHome', $data);
    }
  }

}