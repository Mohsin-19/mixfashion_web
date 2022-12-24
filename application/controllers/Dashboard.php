<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->model('Dashboard_model');
    $this->load->model('Inventory_model');
    $this->load->model('Report_model');
    $this->Common_model->setDefaultTimezone();
    $this->load->library('form_validation');

    if (!$this->session->has_userdata('user_id')) {
      redirect('Authentication/index');
    }

  }

  /**
   * dashboard view page
   * @access public
   * @return void
   */
  public function dashboard()
  {
    check_permission('show_dashboard');

    $company_id = $this->session->userdata('company_id');
    $first_day_this_month = date('Y-m-01');
    $last_day_this_month = date('Y-m-t');

    $data['total_unorder_order'] = $this->Dashboard_model->totalUnorderData();
    $data['total_order'] = $this->Dashboard_model->countData('tbl_orders');
    $data['customer_count'] = $this->Dashboard_model->countData('tbl_customers');
    $data['item_count'] = $this->Dashboard_model->countData('tbl_products');

    $data['low_stock_products'] = $this->Dashboard_model->getLowStockItem();
    $data['top_ten_food_menu'] = $this->Dashboard_model->top_ten_food_menu($first_day_this_month, $last_day_this_month);
    $data['top_ten_food_menu_purchase'] = $this->Dashboard_model->top_ten_food_menu_purchase($first_day_this_month, $last_day_this_month);
    $data['top_ten_customer'] = $this->Dashboard_model->top_ten_customer($first_day_this_month, $last_day_this_month);
    $data['supplier_payable'] = $this->Dashboard_model->supplier_payable();

    $data['purchase_sum'] = $this->Dashboard_model->purchase_sum($first_day_this_month, $last_day_this_month);
    $data['sale_online_sum'] = $this->Dashboard_model->sale_online_sum($first_day_this_month, $last_day_this_month);
    $data['sale_online_sum_new'] = $this->Dashboard_model->sale_online_sum_new($first_day_this_month, $last_day_this_month);
    $data['sale_online_sum_delivered'] = $this->Dashboard_model->sale_online_sum_delivered($first_day_this_month, $last_day_this_month);
    $data['sale_online_sum_cancel'] = $this->Dashboard_model->sale_online_sum_cancel($first_day_this_month, $last_day_this_month);

    $data['salary_sum'] = $this->Dashboard_model->salary_sum($first_day_this_month, $last_day_this_month);
    $data['deposit_sum'] = $this->Dashboard_model->deposit_sum($first_day_this_month, $last_day_this_month);
    $data['withdraw_sum'] = $this->Dashboard_model->withdraw_sum($first_day_this_month, $last_day_this_month);

    $data['waste_sum'] = $this->Dashboard_model->waste_sum($first_day_this_month, $last_day_this_month);
    $data['expense_sum'] = $this->Dashboard_model->expense_sum($first_day_this_month, $last_day_this_month);

    $data['supplier_due_payment_sum'] = $this->Dashboard_model->supplier_due_payment_sum($first_day_this_month, $last_day_this_month);

    $data['paymentMethods'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
    $data['main_content'] = $this->load->view('dashboard/dashboard', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * operation comparison by ajax for chart view
   * @access public
   * @return json
   */
  function operation_comparision_by_date_ajax()
  {
    $from_this_day = $this->input->post('from_this_day');
    $to_this_day = $this->input->post('to_this_day');

    $data = array();

    $data['purchase_sum'] = $this->Dashboard_model->purchase_sum($from_this_day, $to_this_day);
    $data['sale_sum'] = $this->Dashboard_model->sale_sum($from_this_day, $to_this_day);
    $data['waste_sum'] = $this->Dashboard_model->waste_sum($from_this_day, $to_this_day);
    $data['expense_sum'] = $this->Dashboard_model->expense_sum($from_this_day, $to_this_day);

    $data['supplier_due_payment_sum'] = $this->Dashboard_model->supplier_due_payment_sum($from_this_day, $to_this_day);
    $data['supplier_due_payment_sum'] = $this->Dashboard_model->supplier_due_payment_sum($from_this_day, $to_this_day);
    $data['from_this_day'] = $from_this_day;
    $data['to_this_day'] = $to_this_day;
    echo json_encode($data);
  }


  /* ----------------------Dashboard Menu End-------------------------- */
}
