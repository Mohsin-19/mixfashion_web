<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Cl_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Authentication_model');
    $this->load->model('Common_model');
    $this->load->model('Report_model');
    $this->load->model('Inventory_model');
    $this->load->model('Dashboard_model');
    $this->load->model('Supplier_payment_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();


  }

  /**
   * order report
   * @access public
   * @return void
   */
  public function orderReport()
  {
    $data = array();
    if ($this->input->post('submit')) {
      if ($this->input->post('startDate')) {
        $start_date = date("Y-m-d", strtotime($this->input->post('startDate')));
      } else {
        $start_date = '';
      }
      if ($this->input->post('endDate')) {
        $end_date = date("Y-m-d", strtotime($this->input->post('endDate')));
      } else {
        $end_date = '';
      }

      $area = $this->input->post('area');
      $status = $this->input->post('status');
      $data['orderReport'] = $this->Report_model->orderReport($start_date, $end_date, $area, $status);
      $data['area'] = $area;
      $data['status'] = $status;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
    }
    $data['arees'] = $this->Common_model->getAllByTable("tbl_areas");
    $data['main_content'] = $this->load->view('report/orderReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * sale report
   * @access public
   * @return void
   */
  public function saleReport()
  {
    $data = array();
    if ($this->input->post('submit')) {
      if ($this->input->post('startDate')) {
        $start_date = date("Y-m-d", strtotime($this->input->post('startDate')));
      } else {
        $start_date = '';
      }
      if ($this->input->post('endDate')) {
        $end_date = date("Y-m-d", strtotime($this->input->post('endDate')));
      } else {
        $end_date = '';
      }

      $area = $this->input->post('area');
      $status = $this->input->post('status');
      $data['orderReport'] = $this->Report_model->saleReport($start_date, $end_date, $area, $status);

//      dd($data['orderReport']);
      $data['area'] = $area;
      $data['status'] = $status;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
    }
//        dd($data['orderReport']);
    $data['arees'] = $this->Common_model->getAllByTable("tbl_areas");

    $data['main_content'] = $this->load->view('report/saleReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * most/less order report
   * @access public
   * @return void
   */
  public function mostLessOrderReport()
  {
    $data = array();
    if ($this->input->post('submit')) {
      if ($this->input->post('startDate')) {
        $start_date = date("Y-m-d", strtotime($this->input->post('startDate')));
      } else {
        $start_date = '';
      }
      if ($this->input->post('endDate')) {
        $end_date = date("Y-m-d", strtotime($this->input->post('endDate')));
      } else {
        $end_date = '';
      }
      $status = $this->input->post('status');
      $number_of_products = $this->input->post('number_of_products');
      $data['mostLessOrderReport'] = $this->Report_model->mostLessOrderReport($start_date, $end_date, $status, $number_of_products);

      $data['status'] = $status;
      $data['number_of_products'] = $number_of_products;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
    }
    $data['main_content'] = $this->load->view('report/mostLessOrderReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * product order report
   * @access public
   * @return void
   */
  public function productOrderReport()
  {
    $data = array();
    if ($this->input->post('submit')) {
      if ($this->input->post('startDate')) {
        $start_date = date("Y-m-d", strtotime($this->input->post('startDate')));
      } else {
        $start_date = '';
      }
      if ($this->input->post('endDate')) {
        $end_date = date("Y-m-d", strtotime($this->input->post('endDate')));
      } else {
        $end_date = '';
      }

      $product_id = $this->input->post('products_id');
      $deliver_person_id = $this->input->post('deliver_person_id');
      $status = $this->input->post('status');
      $data['productOrderReport'] = $this->Report_model->productOrderReport($start_date, $end_date, $product_id, $status, $deliver_person_id);
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['product_id'] = $product_id;
      $data['status'] = $status;
      $data['deliver_person_id'] = $deliver_person_id;
    }
    $data['delivery_persons'] = $this->Common_model->getDeliveryPersons();
    $data['products'] = $this->Common_model->getAllByTable("tbl_products");
    $data['main_content'] = $this->load->view('report/productOrderReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * customer order report
   * @access public
   * @return void
   */
  public function customerOrderReport()
  {
    $data = array();
    if ($this->input->post('submit')) {
      $customer_id = $this->input->post('customer_id');
      $data['orderReport'] = $this->Report_model->customerOrderReport($customer_id);
      $data['customer_id'] = $customer_id;
    }
    $data['customers'] = $this->Common_model->getAllByTable("tbl_customers");
    $data['main_content'] = $this->load->view('report/customerOrderReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * print daily summary report
   * @access public
   * @param string
   * @return void
   */
  public function printDailySummaryReport($selectedDate = '')
  {
    $data = array();
    $data['result'] = $this->Report_model->dailySummaryReport($selectedDate);
    $data['selectedDate'] = $selectedDate;
    $this->load->view('report/printDailySummaryReport', $data);
  }

  /**
   * daily summary report
   * @access public
   * @return void
   */
  public function dailySummaryReport()
  {
    $data = array();

    if ($this->input->post('submit')) {
      if ($this->input->post('date')) {
        $selectedDate = date("Y-m-d", strtotime($this->input->post('date')));
      } else {
        $selectedDate = '';
      }
      $data['result'] = $this->Report_model->dailySummaryReport($selectedDate);
      $data['selectedDate'] = $selectedDate;

    } else {
      $selectedDate = date("Y-m-d");

      $data['result'] = $this->Report_model->dailySummaryReport($selectedDate);
      $data['selectedDate'] = $selectedDate;
    }


    $data['main_content'] = $this->load->view('report/dailySummaryReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * daily consumption report
   * @access public
   * @return void
   */
  public function dailyConsumptionReport()
  {
    $data = array();

    if ($this->input->post('submit')) {
      if ($this->input->post('date')) {
        $selectedDate = date("Y-m-d", strtotime($this->input->post('date')));
      } else {
        $selectedDate = '';
      }
      $data['result'] = $this->Report_model->dailyConsumptionReport($selectedDate);
      $data['selectedDate'] = $selectedDate;

    } else {
      $selectedDate = date("Y-m-d");
      $data['result'] = $this->Report_model->dailyConsumptionReport($selectedDate);
      $data['selectedDate'] = $selectedDate;
    }


    $data['main_content'] = $this->load->view('report/dailyConsumptionReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * today report
   * @access public
   * @return void
   */
  public function todayReport()
  {
    $data = array();
    $data['dailySummaryReport'] = $this->Report_model->todaySummaryReport('');
    echo json_encode($data['dailySummaryReport']);
  }

  /**
   * today cash status report
   * @access public
   * @return void
   */
  public function todayReportCashStatus()
  {
    $data = $this->Report_model->todayReportCashStatus('');
    echo json_encode($data);
  }

  /**
   * inventory/stock report
   * @access public
   * @return void
   */
  public function inventoryReport()
  {
    $data = array();
    $product_id = $this->input->post('product_id');
    $category_id = $this->input->post('category_id');
    $food_id = $this->input->post('food_id');
    $data['product_id'] = $product_id;
    $data['category_id'] = $category_id;
    $data['food_id'] = $food_id;
    $company_id = $this->session->userdata('company_id');
    $data['product_categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_product_categories");
    $data['products'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_products");
    $data['foodMenus'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_products");
    $data['inventory'] = $this->Report_model->getInventory($category_id, $product_id, $food_id);
    $data['main_content'] = $this->load->view('report/inventoryReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * sale report by month
   * @access public
   * @return void
   */
  public function saleReportByMonth()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startMonth'));
      $end_date = htmlspecialchars($this->input->post('endMonth'));
      $user_id = htmlspecialchars($this->input->post('user_id'));
      $data['user_id'] = $user_id;
      if ($start_date && $end_date) {
        $start_date = date('Y-m', strtotime(htmlspecialchars($this->input->post('startMonth'))));
        $start_date = $start_date . '-' . '01';
        $data['start_date'] = $start_date;
        $end_date = date('Y-m', strtotime(htmlspecialchars($this->input->post('endMonth'))));
        $month = date('m', strtotime(htmlspecialchars($this->input->post('endMonth'))));
        $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
        $end_date = $end_date . '-' . $finalDayByMonth;
        $data['end_date'] = $end_date;
      }
      if ($start_date && !$end_date) {
        $start_date = date('Y-m', strtotime(htmlspecialchars($this->input->post('startMonth'))));
        $month = date('m', strtotime(htmlspecialchars($this->input->post('startMonth'))));
        $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
        $temp = $start_date . '-' . $finalDayByMonth;
        $start_date = $start_date . '-' . '01';
        $end_date = $temp;
        $data['start_date'] = $start_date;
        $data['end_date'] = $temp;
      }
      if (!$start_date && $end_date) {
        $end_date = date('Y-m', strtotime(htmlspecialchars($this->input->post('endMonth'))));
        $temp = $end_date . '-' . '01';
        $start_date = $temp;
        $month = date('m', strtotime(htmlspecialchars($this->input->post('endMonth'))));
        $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
        $end_date = $end_date . '-' . $finalDayByMonth;
        $data['start_date'] = $temp;
        $data['end_date'] = $end_date;
      }
      $data['saleReportByMonth'] = $this->Report_model->saleReportByMonth($start_date, $end_date, $user_id);
    }


    $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
    $data['main_content'] = $this->load->view('report/saleReportByMonth', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * tax report
   * @access public
   * @return void
   */
  public function taxReport()
  {
    $data = array();
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $data['start_date'] = $start_date;
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $data['end_date'] = $end_date;
      $data['taxReportOrder'] = $this->Report_model->taxReportOrder($start_date, $end_date);
    }

    $data['main_content'] = $this->load->view('report/taxReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * sale report by date
   * @access public
   * @return void
   */
  public function saleReportByDate()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $data['start_date'] = $start_date;
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $data['end_date'] = $end_date;
      $user_id = htmlspecialchars($this->input->post('user_id'));
      $data['user_id'] = $user_id;
      $data['saleReportByDate'] = $this->Report_model->saleReportByDate($start_date, $end_date, $user_id);
    }
    $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
    $data['main_content'] = $this->load->view('report/saleReportByDate', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * profit loss report
   * @access public
   * @return void
   */
  public function profitLossReport()
  {
    $company_id = $this->session->userdata('company_id');
    $outlet_id = $this->session->userdata('outlet_id');
    $data = array();
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $product_id = htmlspecialchars($this->input->post('product_id'));
      $data['product_id'] = $product_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      if ($start_date || $end_date) {
        // $data['saleReportByDate'] = $this->Report_model->profitLossReport($start_date, $end_date);
        if (!empty($product_id)) {
          if (!empty($start_date) && !empty($end_date)) {
            $sql = "select tbl_sales_details.*,tbl_sales.sale_no,tbl_sales.sale_date,tbl_products.name from tbl_sales_details left join tbl_sales on tbl_sales_details.sales_id=tbl_sales.id left join tbl_products on tbl_sales_details.food_menu_id=tbl_products.id  where tbl_sales_details.food_menu_id=$product_id and tbl_sales_details.outlet_id=" . $outlet_id . " and tbl_sales.order_status=3 and sale_date>='$start_date' and sale_date<='$end_date'";
          } else if (!empty($start_date)) {
            $sql = "select tbl_sales_details.*,tbl_sales.sale_no,tbl_sales.sale_date,tbl_products.name from tbl_sales_details left join tbl_sales on tbl_sales_details.sales_id=tbl_sales.id left join tbl_products on tbl_sales_details.food_menu_id=tbl_products.id  where tbl_sales_details.food_menu_id=$product_id and tbl_sales_details.outlet_id=" . $outlet_id . " and tbl_sales.order_status=3 and sale_date='$start_date' ";
          } else if (!empty($end_date)) {
            $sql = "select tbl_sales_details.*,tbl_sales.sale_no,tbl_sales.sale_date,tbl_products.name from tbl_sales_details left join tbl_sales on tbl_sales_details.sales_id=tbl_sales.id left join tbl_products on tbl_sales_details.food_menu_id=tbl_products.id  where tbl_sales_details.food_menu_id=$product_id and tbl_sales_details.outlet_id=" . $outlet_id . " and tbl_sales.order_status=3 and sale_date>='$start_date' and sale_date<='$end_date'";
          } else {
            $sql = "select tbl_sales_details.*,tbl_sales.sale_no,tbl_sales.sale_date,tbl_products.name from tbl_sales_details left join tbl_sales on tbl_sales_details.sales_id=tbl_sales.id left join tbl_products on tbl_sales_details.food_menu_id=tbl_products.id  where tbl_sales_details.food_menu_id=$product_id and tbl_sales_details.outlet_id=" . $outlet_id . " and tbl_sales.order_status=3 and sale_date>='$start_date' and sale_date<='$end_date'";
          }
        } else {
          if (!empty($start_date) && !empty($end_date)) {
            $sql = "select tbl_sales_details.*,tbl_sales.sale_no,tbl_sales.sale_date,tbl_products.name from tbl_sales_details left join tbl_sales on tbl_sales_details.sales_id=tbl_sales.id left join tbl_products on tbl_sales_details.food_menu_id=tbl_products.id  where  tbl_sales_details.outlet_id=" . $outlet_id . " and tbl_sales.order_status=3 and sale_date>='$start_date' and sale_date<='$end_date'";
          } else if (!empty($start_date)) {
            $sql = "select tbl_sales_details.*,tbl_sales.sale_no,tbl_sales.sale_date,tbl_products.name from tbl_sales_details left join tbl_sales on tbl_sales_details.sales_id=tbl_sales.id left join tbl_products on tbl_sales_details.food_menu_id=tbl_products.id  where  tbl_sales_details.outlet_id=" . $outlet_id . " and tbl_sales.order_status=3 and sale_date='$start_date' ";
          } else if (!empty($end_date)) {
            $sql = "select tbl_sales_details.*,tbl_sales.sale_no,tbl_sales.sale_date,tbl_products.name from tbl_sales_details left join tbl_sales on tbl_sales_details.sales_id=tbl_sales.id left join tbl_products on tbl_sales_details.food_menu_id=tbl_products.id  where  tbl_sales_details.outlet_id=" . $outlet_id . " and tbl_sales.order_status=3 and sale_date>='$start_date' and sale_date<='$end_date'";
          } else {
            $sql = "select tbl_sales_details.*,tbl_sales.sale_no,tbl_sales.sale_date,tbl_products.name from tbl_sales_details left join tbl_sales on tbl_sales_details.sales_id=tbl_sales.id left join tbl_products on tbl_sales_details.food_menu_id=tbl_products.id  where  tbl_sales_details.outlet_id=" . $outlet_id . " and tbl_sales.order_status=3 and sale_date>='$start_date' and sale_date<='$end_date'";
          }

        }
        $sales = $this->Common_model->customeQuery($sql);
        $data['sales'] = $sales;
      }
      if ($start_date || $end_date) {
        if (!empty($product_id)) {
          if (!empty($start_date) && !empty($end_date)) {
            $sql_order = "select tbl_order_items.*,tbl_orders.order_number,tbl_orders.delivery_date,tbl_products.name from tbl_order_items left join tbl_orders on tbl_order_items.order_id=tbl_orders.id left join tbl_products on tbl_order_items.product_id=tbl_products.id  where tbl_order_items.product_id=$product_id  and tbl_orders.status='Delivered' and delivery_date>='$start_date' and delivery_date<='$end_date'";
          } else if (!empty($start_date)) {
            $sql_order = "select tbl_order_items.*,tbl_orders.order_number,tbl_orders.delivery_date,tbl_products.name from tbl_order_items left join tbl_orders on tbl_order_items.order_id=tbl_orders.id left join tbl_products on tbl_order_items.product_id=tbl_products.id  where tbl_order_items.product_id=$product_id  and tbl_orders.status='Delivered' and delivery_date='$start_date'";
          } else if (!empty($end_date)) {
            $sql_order = "select tbl_order_items.*,tbl_orders.order_number,tbl_orders.delivery_date,tbl_products.name from tbl_order_items left join tbl_orders on tbl_order_items.order_id=tbl_orders.id left join tbl_products on tbl_order_items.product_id=tbl_products.id  where tbl_order_items.product_id=$product_id  and tbl_orders.status='Delivered' and delivery_date>='$start_date' and delivery_date<='$end_date'";
          } else {
            $sql_order = "select tbl_order_items.*,tbl_orders.order_number,tbl_orders.delivery_date,tbl_products.name from tbl_order_items left join tbl_orders on tbl_order_items.order_id=tbl_orders.id left join tbl_products on tbl_order_items.product_id=tbl_products.id  where tbl_order_items.product_id=$product_id  and tbl_orders.status='Delivered' and delivery_date>='$start_date' and delivery_date<='$end_date'";
          }
        } else {
          if (!empty($start_date) && !empty($end_date)) {
            $sql_order = "select tbl_order_items.*,tbl_orders.order_number,tbl_orders.status,tbl_orders.delivery_date,tbl_products.name,tbl_products.purchase_price from tbl_order_items left join tbl_orders on tbl_order_items.order_id=tbl_orders.id left join tbl_products on tbl_order_items.product_id=tbl_products.id  where  tbl_orders.status='Delivered' and delivery_date>='$start_date' and delivery_date<='$end_date'";
          } else if (!empty($start_date)) {
            $sql_order = "select tbl_order_items.*,tbl_orders.order_number,tbl_orders.status,tbl_orders.delivery_date,tbl_products.name,tbl_products.purchase_price from tbl_order_items left join tbl_orders on tbl_order_items.order_id=tbl_orders.id left join tbl_products on tbl_order_items.product_id=tbl_products.id  where  tbl_orders.status='Delivered' and delivery_date='$start_date'";
          } else if (!empty($end_date)) {
            $sql_order = "select tbl_order_items.*,tbl_orders.order_number,tbl_orders.status,tbl_orders.delivery_date,tbl_products.name,tbl_products.purchase_price from tbl_order_items left join tbl_orders on tbl_order_items.order_id=tbl_orders.id left join tbl_products on tbl_order_items.product_id=tbl_products.id  where  tbl_orders.status='Delivered' and delivery_date>='$start_date' and delivery_date<='$end_date'";
          } else {
            $sql_order = "select tbl_order_items.*,tbl_orders.order_number,tbl_orders.status,tbl_orders.delivery_date,tbl_products.name,tbl_products.purchase_price from tbl_order_items left join tbl_orders on tbl_order_items.order_id=tbl_orders.id left join tbl_products on tbl_order_items.product_id=tbl_products.id  where  tbl_orders.status='Delivered' and delivery_date>='$start_date' and delivery_date<='$end_date'";
          }

        }
        $sales = $this->Common_model->customeQuery($sql);
        $orders = $this->Common_model->customeQuery($sql_order);
        $data['orders'] = $orders;
        $data['sales'] = $sales;
      }
    }
    $data['products'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_products');
    $data['main_content'] = $this->load->view('report/profitLossReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * product prfit report
   * @access public
   * @return void
   */
  public function productProfitReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $product_id = htmlspecialchars($this->input->post('product_id'));
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['productProfitReport'] = $this->Report_model->productProfitReport($product_id, date("Y-m-d", strtotime($start_date)), date('Y-m-d', strtotime($end_date)));
      $data['lastPurchase'] = getLastPurchaseAmount($product_id);
    }
    $data['products'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_products");
    $data['main_content'] = $this->load->view('report/productProfitReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * customer profit report
   * @access public
   * @return void
   */
  public function customerProfitReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $customer_id = htmlspecialchars($this->input->post('customer_id'));
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['customerProfitReport'] = $this->Report_model->customerProfitReport($customer_id, date("Y-m-d", strtotime($start_date)), date('Y-m-d', strtotime($end_date)));
    }
    $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_customers");
    $data['main_content'] = $this->load->view('report/customerProfitReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * supplier report
   * @access public
   * @return void
   */
  public function supplierReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');

    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $supplier_id = htmlspecialchars($this->input->post('supplier_id'));
      $data['supplier_id'] = $supplier_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['supplierReport'] = $this->Report_model->supplierReport($start_date, $end_date, $supplier_id);
      $data['supplierDuePaymentReport'] = $this->Report_model->supplierDuePaymentReport($start_date, $end_date, $supplier_id);
    }
    $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
    $data['main_content'] = $this->load->view('report/supplierReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * customer report
   * @access public
   * @return void
   */
  public function customerReport()
  {

    $data = array();
    $company_id = $this->session->userdata('company_id');

    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $customer_id = htmlspecialchars($this->input->post('customer_id'));
      $data['customer_id'] = $customer_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['customerReport'] = $this->Report_model->customerReport($start_date, $end_date, $customer_id);
      $data['customerOrderReport'] = $this->Report_model->customerOrderByDateReport($start_date, $end_date, $customer_id);
    }
    $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
    $data['main_content'] = $this->load->view('report/customerReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }


  /**
   * service sale report
   * @access public
   * @return void
   */
  public function serviceSaleReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['serviceSaleReport'] = $this->Report_model->serviceSaleReport($start_date, $end_date);
    }
    $data['main_content'] = $this->load->view('report/serviceSaleReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * consumption report
   * @access public
   * @return void
   */
  public function consumptionReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      // echo "<pre>";var_dump($this->input->post());echo "</pre>";
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      // $data['consumptionReport'] = $this->Report_model->consumptionReport($start_date, $end_date);
      $data['consumptionMenus'] = $this->Report_model->consumptionMenus($start_date, $end_date);
      $data['consumptionModifiers'] = $this->Report_model->consumptionModifiers($start_date, $end_date);
    }
    $data['main_content'] = $this->load->view('report/consumptionReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * details sale report
   * @access public
   * @return void
   */
  public function detailedSaleReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $user_id = htmlspecialchars($this->input->post('user_id'));
      $data['user_id'] = $user_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['detailedSaleReport'] = $this->Report_model->detailedSaleReport($start_date, $end_date, $user_id);
      foreach ($data['detailedSaleReport'] as $key => $value) {
        $data['detailedSaleReport'][$key]->products = $this->Common_model->getDataCustomName("tbl_sales_details", "sales_id", $value->id);
      }
    }
    $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
    $data['main_content'] = $this->load->view('report/detailedSaleReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * purchase report by month
   * @access public
   * @return void
   */
  public function purchaseReportByMonth()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startMonth'));
      $end_date = htmlspecialchars($this->input->post('endMonth'));
      $user_id = htmlspecialchars($this->input->post('user_id'));
      $data['user_id'] = $user_id;
      if ($start_date && $end_date) {
        $start_date = date('Y-m', strtotime(htmlspecialchars($this->input->post('startMonth'))));
        $start_date = $start_date . '-' . '01';
        $data['start_date'] = $start_date;
        $end_date = date('Y-m', strtotime(htmlspecialchars($this->input->post('endMonth'))));
        $month = date('m', strtotime(htmlspecialchars($this->input->post('endMonth'))));
        $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
        $end_date = $end_date . '-' . $finalDayByMonth;
        $data['end_date'] = $end_date;
      }
      if ($start_date && !$end_date) {
        $start_date = date('Y-m', strtotime(htmlspecialchars($this->input->post('startMonth'))));
        $month = date('m', strtotime(htmlspecialchars($this->input->post('startMonth'))));
        $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
        $temp = $start_date . '-' . $finalDayByMonth;
        $start_date = $start_date . '-' . '01';
        $end_date = $temp;
        $data['start_date'] = $start_date;
        $data['end_date'] = $temp;
      }
      if (!$start_date && $end_date) {
        $end_date = date('Y-m', strtotime(htmlspecialchars($this->input->post('endMonth'))));
        $temp = $end_date . '-' . '01';
        $start_date = $temp;
        $month = date('m', strtotime(htmlspecialchars($this->input->post('endMonth'))));
        $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($month);
        $end_date = $end_date . '-' . $finalDayByMonth;
        $data['start_date'] = $temp;
        $data['end_date'] = $end_date;
      }
      $data['purchaseReportByMonth'] = $this->Report_model->purchaseReportByMonth($start_date, $end_date, $user_id);
    }


    $data['users'] = $this->Common_model->getAllByOutletIdForDropdown($company_id, 'tbl_users');
    $data['main_content'] = $this->load->view('report/purchaseReportByMonth', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * purchase report by date
   * @access public
   * @return void
   */
  public function purchaseReportByDate()
  {
    $data = array();
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $data['start_date'] = $start_date;
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $data['end_date'] = $end_date;
      $data['purchaseReportByDate'] = $this->Report_model->purchaseReportByDate($start_date, $end_date);
    }
    $data['main_content'] = $this->load->view('report/purchaseReportByDate', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * purchase report by ingredient report
   * @access public
   * @return void
   */
  public function purchaseReportByIngredient()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $products_id = htmlspecialchars($this->input->post('products_id'));
      $data['products_id'] = $products_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['purchaseReportByIngredient'] = $this->Report_model->purchaseReportByIngredient($start_date, $end_date, $products_id);
    }
    /* print('<pre>');
      print_r($data['taxReport']);exit; */
    $data['products'] = $this->Inventory_model->getAllByCompanyIdForDropdown($company_id, 'tbl_products');
    $data['main_content'] = $this->load->view('report/purchaseReportByIngredient', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * product purchase report
   * @access public
   * @return void
   */
  public function productPurchaseReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $products_id = htmlspecialchars($this->input->post('products_id'));
      $supplier_id = htmlspecialchars($this->input->post('supplier_id'));
      $data['products_id'] = $products_id;
      $data['supplier_id'] = $supplier_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['productPurchaseReport'] = $this->Report_model->productPurchaseReport($start_date, $end_date, $products_id, $supplier_id);
    }

    $data['products'] = $this->Inventory_model->getAllByCompanyIdForDropdown($company_id, 'tbl_products');
    $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
    $data['main_content'] = $this->load->view('report/productPurchaseReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * product sale report
   * @access public
   * @return void
   */
  public function productSaleReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $products_id = htmlspecialchars($this->input->post('products_id'));
      $customer_id = htmlspecialchars($this->input->post('customer_id'));
      $data['products_id'] = $products_id;
      $data['customer_id'] = $customer_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['productSaleReport'] = $this->Report_model->productSaleReport($start_date, $end_date, $products_id, $customer_id);
      $data['productOrder1Report'] = $this->Report_model->productOrder1Report($start_date, $end_date, $products_id, $customer_id);
    }

    $data['products'] = $this->Inventory_model->getAllByCompanyIdForDropdown($company_id, 'tbl_products');
    $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
    $data['main_content'] = $this->load->view('report/productSaleReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * detailed purchase report
   * @access public
   * @return void
   */
  public function detailedPurchaseReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $user_id = htmlspecialchars($this->input->post('user_id'));
      $data['user_id'] = $user_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['detailedPurchaseReport'] = $this->Report_model->detailedPurchaseReport($start_date, $end_date, $user_id);
    }
    $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
    $data['main_content'] = $this->load->view('report/detailedPurchaseReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * damage report
   * @access public
   * @return void
   */
  public function damageReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $customer_id = htmlspecialchars($this->input->post('customer_id'));
      $reference_no = htmlspecialchars($this->input->post('reference_no'));
      $user_id = htmlspecialchars($this->input->post('user_id'));

      $data['damageReport'] = $this->Report_model->damageReport($customer_id, $reference_no, $user_id);
    }
    $data['users'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_users');
    $data['main_content'] = $this->load->view('report/damageReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * expense report
   * @access public
   * @return void
   */
  public function expenseReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('startDate'))));
      $end_date = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('endDate'))));
      $expense_product_id = htmlspecialchars($this->input->post('expense_product_id'));
      $data['expense_product_id'] = $expense_product_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['expenseReport'] = $this->Report_model->expenseReport($start_date, $end_date, $expense_product_id);
    }
    $data['expense_products'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_expense_products');
    $data['main_content'] = $this->load->view('report/expenseReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * purchase return report
   * @access public
   * @return void
   */
  public function purchaseReturnReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('startDate'))));
      $end_date = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('endDate'))));
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['purchaseReturnReport'] = $this->Report_model->purchaseReturnReport($start_date, $end_date);
    }
    $data['main_content'] = $this->load->view('report/purchaseReturnReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * supplier due report
   * @access public
   * @return void
   */
  public function supplierDueReport()
  {
    $data = array();

    $data['supplierDueReport'] = $this->Report_model->supplierDueReport();
    if (isset($data['supplierDueReport']) && $data['supplierDueReport']) {
      foreach ($data['supplierDueReport'] as $key => $value) {
        $paid_amount = $this->Report_model->getDuePaid($value->supplier_id);
        $data['supplierDueReport'][$key]->due_paid = isset($paid_amount) && $paid_amount->totalPaid ? $paid_amount->totalPaid : 0;
      }
    }
    $data['main_content'] = $this->load->view('report/supplierDueReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * supplier ledger report
   * @access public
   * @return void
   */
  public function supplierLedgerReport()
  {
    $company_id = $this->session->userdata('company_id');
    $data = array();


    if ($this->input->post('submit')) {
      $start_date = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('startDate'))));
      $end_date = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('endDate'))));
      $supplier_id = htmlspecialchars($this->input->post('supplier_id'));

      $data['supplier_id'] = $supplier_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $remaining_due = $this->Supplier_payment_model->getSupplierOpeningDueByDate($supplier_id, $start_date);
      $key = 0;
      $data['supplierLedger'][$key]['title'] = "Opening Due";
      $data['supplierLedger'][$key]['date'] = "N/A";
      $data['supplierLedger'][$key]['grant_total'] = "N/A";

      $data['supplierLedger'][$key]['credit'] = "";
      if (!empty($remaining_due)) {
        $data['supplierLedger'][$key]['debit'] = $remaining_due;
        $data['supplierLedger'][$key]['balance'] = "-" . $remaining_due;
        $balance = -$remaining_due;
      } else {
        $data['supplierLedger'][$key]['debit'] = '';
        $data['supplierLedger'][$key]['balance'] = '';
        $balance = '';
      }
      //$balance=-$remaining_due;
      for ($i = $start_date; $i <= $end_date; $i = date('Y-m-d', strtotime("+1 day", strtotime($i)))) {
        $purchase_grant_total = $this->Supplier_payment_model->getSupplierGrantTotalByDate($supplier_id, $i);
        if (!empty($purchase_grant_total->total)) {
          $key++;
          if ($balance < 0) {
            $balance = $balance + (-$purchase_grant_total->due);
          } else {
            $balance = $balance - $purchase_grant_total->due;
          }

          $data['supplierLedger'][$key]['title'] = "Purchase Due Amount";
          $data['supplierLedger'][$key]['date'] = $i;
          if ($purchase_grant_total->due > 0) {
            $data['supplierLedger'][$key]['grant_total'] = $purchase_grant_total->total;
            $data['supplierLedger'][$key]['debit'] = $purchase_grant_total->due;
          } else {
            $data['supplierLedger'][$key]['grant_total'] = '';
            $data['supplierLedger'][$key]['debit'] = '';
          }
          // $data['supplierLedger'][$key]['credit']=$purchase_grant_total->paid;
          $data['supplierLedger'][$key]['credit'] = '';
          if ($balance != 0) {
            $data['supplierLedger'][$key]['balance'] = $balance;
          } else {
            $data['supplierLedger'][$key]['balance'] = '';
          }
        }
        $supplier_due_payment = $this->Supplier_payment_model->getSupplierDuePaymentByDate($supplier_id, $i);
        if (!empty($supplier_due_payment)) {
          $key++;

          $balance = $balance + $supplier_due_payment;

          $data['supplierLedger'][$key]['title'] = "Supplier Due Payment";
          $data['supplierLedger'][$key]['date'] = $i;
          $data['supplierLedger'][$key]['grant_total'] = "";
          $data['supplierLedger'][$key]['debit'] = '';
          $data['supplierLedger'][$key]['credit'] = $supplier_due_payment;
          if ($balance != 0) {
            $data['supplierLedger'][$key]['balance'] = $balance;
          } else {
            $data['supplierLedger'][$key]['balance'] = '';
          }


        }

      }
    }
    $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_suppliers");
    $data['main_content'] = $this->load->view('report/supplierLedgerReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }
  /**
   * customer due receive report
   * @access public
   * @return void
   */
  // create customer due recceive report
  public function customerDueReceiveReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('startDate'))));
      $end_date = date('Y-m-d', strtotime(htmlspecialchars($this->input->post('endDate'))));
      $customer_id = htmlspecialchars($this->input->post('customer_id'));

      $data['customer_id'] = $customer_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['customerDueReceive'] = $this->Report_model->customerDueReceiveReport($start_date, $end_date, $customer_id);
    }
    $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
    $data['main_content'] = $this->load->view('report/customerDueReceive', $data, TRUE);

    $this->load->view('userHome', $data);
  }

  /**
   * balance sheet report
   * @access public
   * @return void
   */
  public function balanceSheet()
  {
    $company_id = $this->session->userdata('company_id');
    $data = array();
    $data['accounts'] = $this->Common_model->getAll($company_id, "tbl_payment_methods");
    $data['supplier_payable'] = $this->Dashboard_model->supplier_payable();
    $data['main_content'] = $this->load->view('report/balanceSheet', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * inventory/stock alert list report
   * @access public
   * @return void
   */
  public function getInventoryAlertList()
  {
    $data = array();
    $data['inventory'] = $this->Report_model->getInventoryAlertList();
    $data['main_content'] = $this->load->view('report/inventoryAlertList', $data, TRUE);
    $this->load->view('userHome', $data);
  }

  /**
   * attendance report
   * @access public
   * @return void
   */
  public function attendanceReport()
  {
    $data = array();
    $company_id = $this->session->userdata('company_id');
    if ($this->input->post('submit')) {
      $start_date = htmlspecialchars($this->input->post('startDate'));
      $end_date = htmlspecialchars($this->input->post('endDate'));
      $employee_id = htmlspecialchars($this->input->post('employee_id'));
      $data['employee_id'] = $employee_id;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;
      $data['attendanceReport'] = $this->Report_model->attendanceReport($start_date, $end_date, $employee_id);
    }
    $data['employees'] = $this->Common_model->getAllByTable("tbl_users");
    $data['main_content'] = $this->load->view('report/attendanceReport', $data, TRUE);
    $this->load->view('userHome', $data);
  }

}
