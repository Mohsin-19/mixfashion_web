<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{
  /**
   * product order report
   * @access public
   * @param string
   * @param string
   * @param int
   * @param string
   * @param int
   */
  public function productOrderReport($startMonth = '', $endMonth = '', $product_id = '', $status = '', $deliver_person_id = '')
  {
    if ($startMonth || $endMonth || $product_id || $status || $deliver_person_id) :
      $this->db->select('tbl_orders.order_number, sum(qty) as totalQuantity_amount,product_id,tbl_products.name,tbl_products.code,delivery_date,tbl_orders.delivery_person_id,tbl_users.full_name as delivery_person_name,tbl_customers.name as customer_name, tbl_customers.phone as customer_phone');
      $this->db->from('tbl_order_items');
      $this->db->join('tbl_orders', 'tbl_orders.id = tbl_order_items.order_id', 'left');
      $this->db->join('tbl_customers', 'tbl_customers.id = tbl_orders.customer_id', 'left');
      $this->db->join('tbl_products', 'tbl_products.id = tbl_order_items.product_id', 'left');
      $this->db->join('tbl_users', 'tbl_users.id = tbl_orders.delivery_person_id', 'left');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('delivery_date>=', $startMonth);
        $this->db->where('delivery_date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('delivery_date', $startMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('delivery_date', $endMonth);
      }
      if ($deliver_person_id != '') {
        $this->db->where('tbl_orders.delivery_person_id', $deliver_person_id);
      }
      if ($product_id != '') {
        $this->db->where('tbl_order_items.product_id', $product_id);
      }
      if ($status != '') {
        $this->db->where('tbl_orders.status', $status);
      }

      $this->db->where('tbl_order_items.del_status', 'Live');
      $this->db->order_by('delivery_date', 'ASC');
      $this->db->group_by('tbl_order_items.product_id');
      $this->db->group_by('order_id');
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * most/less order report
   * @access public
   * @param string
   * @param string
   * @param string
   * @param int
   */
  public function mostLessOrderReport($startMonth = '', $endMonth = '', $status = '', $number_of_products = '')
  {
    if ($startMonth || $endMonth || $status || $number_of_products) :
      $this->db->select('sum(qty) as totalQuantity_amount,tbl_products.name,tbl_products.code');
      $this->db->from('tbl_order_items');
      $this->db->join('tbl_orders', 'tbl_orders.id = tbl_order_items.order_id', 'left');
      $this->db->join('tbl_products', 'tbl_products.id = tbl_order_items.product_id', 'left');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('delivery_date>=', $startMonth);
        $this->db->where('delivery_date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('delivery_date', $startMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('delivery_date', $endMonth);
      }

      if ($status && $status == "Most") {
        $this->db->order_by('totalQuantity_amount', "DESC");
      } else {
        $this->db->order_by('totalQuantity_amount', "ASC");
      }
      if ($number_of_products != '') {
        $this->db->limit($number_of_products);
      } else {
        $this->db->limit(10);
      }
      $this->db->where('tbl_order_items.del_status', 'Live');
      $this->db->group_by('tbl_order_items.product_id');
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * daily summary report
   * @access public
   * @param string
   */
  public function dailySummaryReport($selectedDate)
  {
    $outlet_id = $this->session->userdata('outlet_id');

    //daily purchases
    $this->db->select('*');
    $this->db->from('tbl_purchase');
    if ($selectedDate != '') {
      $this->db->where('date =', $selectedDate);
    } else {
      $today = date('Y-m-d');
      $this->db->where('date =', $today);
    }
    $this->db->where('outlet_id', $outlet_id);
    $this->db->where("del_status", 'Live');
    $purchases = $this->db->get()->result();

    //daily orders
    $this->db->select('*');
    $this->db->from('tbl_orders');
    if ($selectedDate != '') {
      $this->db->where('delivery_date =', $selectedDate);
    } else {
      $today = date('Y-m-d');
      $this->db->where('delivery_date =', $today);
    }
    $this->db->where('status', "Delivered");
    $this->db->where("del_status", 'Live');
    $orders = $this->db->get()->result();


    //daily supplier due payments
    $this->db->select('*');
    $this->db->from('tbl_supplier_payments');
    if ($selectedDate != '') {
      $this->db->where('date =', $selectedDate);
    } else {
      $today = date('Y-m-d');
      $this->db->where('date =', $today);
    }
    $this->db->where('outlet_id', $outlet_id);
    $this->db->where("del_status", 'Live');
    $supplier_due_payments = $this->db->get()->result();

    //daily expenses
    $this->db->select('*');
    $this->db->from('tbl_expenses');
    if ($selectedDate != '') {
      $this->db->where('date =', $selectedDate);
    } else {
      $today = date('Y-m-d');
      $this->db->where('date =', $today);
    }
    $this->db->where('outlet_id', $outlet_id);
    $this->db->where("del_status", 'Live');
    $expenses = $this->db->get()->result();

    //daily wastes
    $this->db->select('*');
    $this->db->from('tbl_damages');
    if ($selectedDate != '') {
      $this->db->where('date =', $selectedDate);
    } else {
      $today = date('Y-m-d');
      $this->db->where('date =', $today);
    }
    $this->db->where('outlet_id', $outlet_id);
    $this->db->where("del_status", 'Live');
    $wastes = $this->db->get()->result();

    $result = array();
    $result['purchases'] = $purchases;
    $result['orders'] = $orders;
    $result['supplier_due_payments'] = $supplier_due_payments;
    $result['expenses'] = $expenses;
    $result['wastes'] = $wastes;

    return $result;
  }

  /**
   * today summary report
   * @access public
   * @param string
   */
  public function todaySummaryReport($selectedDate)
  {
    $outlet_id = $this->session->userdata('outlet_id');

    //purchase report
    $this->db->select('sum(paid) as total_purchase_amount');
    $this->db->from('tbl_purchase');
    if ($selectedDate != '') {
      $this->db->where('date =', $selectedDate);
    } else {
      $today = date('Y-m-d');
      $this->db->where('date =', $today);
    }
    $this->db->where('outlet_id', $outlet_id);
    $this->db->where("del_status", 'Live');
    $purchase = $this->db->get()->result();
    //end purchase report

    //Waste report
    $this->db->select('sum(total_loss) as total_loss_amount');
    $this->db->from('tbl_damages');
    if ($selectedDate != '') {
      $this->db->where('date =', $selectedDate);
    } else {
      $today = date('Y-m-d');
      $this->db->where('date =', $today);
    }
    $this->db->where('outlet_id', $outlet_id);
    $this->db->where("del_status", 'Live');
    $waste = $this->db->get()->result();
    //end Waste report
    //Expense report
    $this->db->select('sum(amount) as expense_amount');
    $this->db->from('tbl_expenses');
    if ($selectedDate != '') {
      $this->db->where('date =', $selectedDate);
    } else {
      $today = date('Y-m-d');
      $this->db->where('date =', $today);
    }
    $this->db->where('outlet_id', $outlet_id);
    $this->db->where("del_status", 'Live');
    $expense = $this->db->get()->result();

    //end expense report
    //Supplier payment report
    $this->db->select('sum(amount) as supplier_payment_amount');
    $this->db->from('tbl_supplier_payments');
    if ($selectedDate != '') {
      $this->db->where('date =', $selectedDate);
    } else {
      $today = date('Y-m-d');
      $this->db->where('date =', $today);
    }
    $this->db->where('outlet_id', $outlet_id);
    $this->db->where("del_status", 'Live');
    $supplier_payment = $this->db->get()->result();
    //end expense report


    //end Supplier payment report
    $allTotal = 0;
    $allTotal = $purchase[0]->total_purchase_amount + $sales[0]->total_sales_amount + $waste[0]->total_loss_amount + $expense[0]->expense_amount + $supplier_payment[0]->supplier_payment_amount;
    $result['total_purchase_amount'] = isset($purchase[0]->total_purchase_amount) && $purchase[0]->total_purchase_amount ? $purchase[0]->total_purchase_amount : '0.0';
    $result['total_sales_amount'] = isset($sales[0]->total_sales_amount) && $sales[0]->total_sales_amount ? $sales[0]->total_sales_amount : '0.0';
    $result['total_sales_vat'] = isset($total_vat) && $total_vat ? $total_vat : '0.0';
    $result['total_loss_amount'] = isset($waste[0]->total_loss_amount) && $waste[0]->total_loss_amount ? $waste[0]->total_loss_amount : '0.0';
    $result['expense_amount'] = isset($expense[0]->expense_amount) && $expense[0]->expense_amount ? $expense[0]->expense_amount : '0.0';
    $result['supplier_payment_amount'] = isset($supplier_payment[0]->supplier_payment_amount) && $supplier_payment[0]->supplier_payment_amount ? $supplier_payment[0]->supplier_payment_amount : '0.0';

    $result['allTotal'] = isset($allTotal) && $allTotal ? $allTotal : '0.0';
    $balance = (($result['total_sales_amount'] + $result['customer_receive_amount']) - ($result['total_purchase_amount'] + $result['supplier_payment_amount'] + $result['expense_amount']));
    $result['balance'] = isset($balance) && $balance ? $balance : '0.0';
    return $result;
  }

  /**
   * inventory/stock report
   * @access public
   * @param int
   * @param int
   * @param int
   */
  public function getInventory($category_id = "", $product_id = "", $food_id = "")
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $company_id = $this->session->userdata('company_id');
    $where = '';
    if ($food_id != '') {
      $where .= " AND i.food_menu_id = '$food_id'";
    }
    if ($category_id != '') {
      $where .= " AND i.category_id = '$category_id'";
    }
    if ($product_id != '') {
      $where .= "  AND i.id = '$product_id'";
    }
    $result = $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live'  $where ORDER BY i.name ASC")->result();
    return $result;
  }

  /**
   * inventory/stock alert report
   * @access public
   */
  public function getInventoryAlertList()
  {
    $result = $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' ORDER BY i.name ASC")->result();
    return $result;
  }

  /**
   * order report
   * @access public
   * @param string
   * @param string
   * @param string
   * @param string
   */
  public function orderReport($startDate = '', $endDate = '', $area = '', $status = '')
  {
    if ($startDate || $endDate) :
      $this->db->select('tbl_orders.*,tbl_customers.name as customer_name, tbl_customers.phone as customer_phone');
      $this->db->from('tbl_orders');
      $this->db->join('tbl_customers', 'tbl_customers.id = tbl_orders.customer_id', 'left');
      if ($startDate != '' && $endDate != '') {
        $this->db->where('delivery_date>=', $startDate);
        $this->db->where('delivery_date <=', $endDate);
      }
      if ($startDate != '' && $endDate == '') {
        $this->db->where('delivery_date', $startDate);
      }
      if ($startDate == '' && $endDate != '') {
        $this->db->where('delivery_date', $endDate);
      }
      if ($area != '') {
        $this->db->where('tbl_orders.area', $area);
      }

      if ($status != '') {
        $this->db->where('tbl_orders.status', $status);
      }

      $this->db->where('tbl_orders.del_status', "Live");
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * sale report
   * @access public
   * @param string
   * @param string
   * @param string
   * @param string
   */
  public function saleReport($startDate = '', $endDate = '', $area = '', $status = '')
  {
    if ($startDate || $endDate) :
      $this->db->select('to.*,tc.name as customer_name, tc.phone as customer_phone,
             toi.qty as qty,
             toi.discount_amount as discount,
             toi.price as price,
             units.unit_name as unit,
             product.name as product_name,
             product.opening_stock,
             product.purchase_price,                   

             (SELECT sum(order_items.price * order_items.qty - order_items.discount_amount) as order_value FROM tbl_order_items as order_items 
               where order_items.order_id = to.id group by order_items.order_id ) as order_value,  
             
            (SELECT sum(tpd.total) FROM tbl_purchase_details as tpd where tpd.product_id=toi.product_id group by tpd.product_id)  as avg_total,
            (SELECT sum(tpd.quantity_amount) FROM tbl_purchase_details as tpd where tpd.product_id=toi.product_id group by tpd.product_id)  as avg_quantity
            ');


      $this->db->from('tbl_orders to');
      $this->db->join('tbl_customers as tc', 'tc.id = to.customer_id', 'left');
      $this->db->join('tbl_order_items as toi', 'toi.order_id = to.id', 'inner');
      $this->db->join('tbl_products as product', 'toi.product_id = product.id', 'inner');
      $this->db->join('tbl_units as units', 'product.sale_unit_id = units.id', 'inner');

      if ($startDate != '' && $endDate != '') {
        $this->db->where('to.delivery_date>=', $startDate);
        $this->db->where('to.delivery_date <=', $endDate);
      }
      if ($startDate != '' && $endDate == '') {
        $this->db->where('to.delivery_date', $startDate);
      }
      if ($startDate == '' && $endDate != '') {
        $this->db->where('to.delivery_date', $endDate);
      }
      if ($area != '') {
        $this->db->where('to.area', $area);
      }

      if ($status != '') {
        $this->db->where('to.status', $status);
      }
      $this->db->where('to.del_status', "Live");
      $this->db->order_by('to.id', "desc");
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * customer order report
   * @access public
   * @param int
   */
  public function customerOrderReport($customer_id)
  {
    if ($customer_id) :
      $this->db->select('tbl_orders.*,tbl_customers.name as customer_name, tbl_customers.phone as customer_phone');
      $this->db->from('tbl_orders');
      $this->db->join('tbl_customers', 'tbl_customers.id = tbl_orders.customer_id', 'left');
      $this->db->where('tbl_orders.customer_id', $customer_id);
      $this->db->where('tbl_orders.del_status', "Live");
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * customer order report by date
   * @access public
   * @param string
   * @param string
   * @param int
   */
  public function customerOrderByDateReport($startMonth = '', $endMonth = '', $customer_id = '')
  {
    if ($customer_id) :
      $this->db->select('tbl_orders.*,tbl_customers.name as customer_name, tbl_customers.phone as customer_phone');
      $this->db->from('tbl_orders');
      $this->db->join('tbl_customers', 'tbl_customers.id = tbl_orders.customer_id', 'left');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('delivery_date>=', $startMonth);
        $this->db->where('delivery_date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('delivery_date', $startMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('delivery_date', $endMonth);
      }

      if ($customer_id != '') {
        $this->db->where('customer_id', $customer_id);
      }
      $this->db->where('tbl_orders.del_status', "Live");
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * tax order report
   * @access public
   * @param string
   * @param string
   */
  public function taxReportOrder($startDate = '', $endDate = '')
  {
    if ($startDate || $endDate) :
      $this->db->select('order_number, delivery_date as sale_date,sum(total_amount) as total_payable,sum(total_tax) as total_vat');
      $this->db->from('tbl_orders');

      if ($startDate != '' && $endDate != '') {
        $this->db->where('delivery_date>=', $startDate);
        $this->db->where('delivery_date <=', $endDate);
      }
      if ($startDate != '' && $endDate == '') {
        $this->db->where('delivery_date', $startDate);
      }
      if ($startDate == '' && $endDate != '') {
        $this->db->where('delivery_date', $endDate);
      }
      $this->db->group_by('id');
      $this->db->where('del_status', "Live");
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * profit loss report
   * @access public
   * @param string
   * @param string
   */
  public function profitLossReport($start_date, $end_date)
  {

    if ($start_date || $end_date) :
      $outlet_id = $this->session->userdata('outlet_id');

      //purchase report
      $this->db->select('sum(paid) as total_purchase_amount');
      $this->db->from('tbl_purchase');
      if ($start_date != '' && $end_date != '') {
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
      }
      if ($start_date != '' && $end_date == '') {
        $this->db->where('date', $start_date);
      }
      if ($start_date == '' && $end_date != '') {
        $this->db->where('date', $end_date);
      }
      $this->db->where('outlet_id', $outlet_id);
      $this->db->where("del_status", 'Live');
      $purchase = $this->db->get()->result();


      //end purchase report
      //Sales report
      $this->db->select('sum(paid_amount) as total_sales_amount,sum(vat) as total_sales_vat');
      $this->db->from('tbl_sales');
      if ($start_date != '' && $end_date != '') {
        $this->db->where('sale_date>=', $start_date);
        $this->db->where('sale_date <=', $end_date);
      }
      if ($start_date != '' && $end_date == '') {
        $this->db->where('sale_date', $start_date);
      }
      if ($start_date == '' && $end_date != '') {
        $this->db->where('sale_date', $end_date);
      }

      $this->db->where('outlet_id', $outlet_id);
      $this->db->where("del_status", 'Live');
      $sales = $this->db->get()->result();
      ///for vat calculate
      $this->db->select('sale_vat_objects');
      $this->db->from('tbl_sales');
      if ($start_date != '' && $end_date != '') {
        $this->db->where('sale_date>=', $start_date);
        $this->db->where('sale_date <=', $end_date);
      }
      if ($start_date != '' && $end_date == '') {
        $this->db->where('sale_date', $start_date);
      }
      if ($start_date == '' && $end_date != '') {
        $this->db->where('sale_date', $end_date);
      }

      $this->db->where('outlet_id', $outlet_id);
      $this->db->where("del_status", 'Live');
      $sales_vats = $this->db->get()->result();

      $total_vat = 0;
      foreach ($sales_vats as $v) {
        $val = json_decode($v->sale_vat_objects);
        if (isset($val) && $val) {
          foreach ($val as $v1) {
            $total_vat += $v1->tax_field_amount;
          }
        }
      }

      //end Sales report
      //Waste report
      $this->db->select('sum(total_loss) as total_loss_amount');
      $this->db->from('tbl_damages');

      if ($start_date != '' && $end_date != '') {
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
      }
      if ($start_date != '' && $end_date == '') {
        $this->db->where('date', $start_date);
      }
      if ($start_date == '' && $end_date != '') {
        $this->db->where('date', $end_date);
      }

      $this->db->where('outlet_id', $outlet_id);
      $this->db->where("del_status", 'Live');
      $waste = $this->db->get()->result();


      //end Waste report
      //Expense report
      $this->db->select('sum(amount) as expense_amount');
      $this->db->from('tbl_expenses');
      if ($start_date != '' && $end_date != '') {
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
      }
      if ($start_date != '' && $end_date == '') {
        $this->db->where('date', $start_date);
      }
      if ($start_date == '' && $end_date != '') {
        $this->db->where('date', $end_date);
      }
      $this->db->where('outlet_id', $outlet_id);
      $this->db->where("del_status", 'Live');
      $expense = $this->db->get()->result();
      //end expense report
      //Supplier payment report
      $this->db->select('sum(amount) as supplier_payment_amount');
      $this->db->from('tbl_supplier_payments');
      if ($start_date != '' && $end_date != '') {
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
      }
      if ($start_date != '' && $end_date == '') {
        $this->db->where('date', $start_date);
      }
      if ($start_date == '' && $end_date != '') {
        $this->db->where('date', $end_date);
      }
      $this->db->where('outlet_id', $outlet_id);
      $this->db->where("del_status", 'Live');
      $supplier_payment = $this->db->get()->result();
      //end expense report

      //end Supplier payment report
      $allTotal = 0;
      $collect_tax = $this->session->userdata('collect_tax');
      $vat_amount_tmp = 0;
      if (isset($collect_tax) && $collect_tax == "Yes") {
        $vat_amount_tmp = $total_vat;
      }

      $allTotal = $purchase[0]->total_purchase_amount + $sales[0]->total_sales_amount + $waste[0]->total_loss_amount + $expense[0]->expense_amount + $supplier_payment[0]->supplier_payment_amount;

      $gross_profit = (($sales[0]->total_sales_amount) - ($purchase[0]->total_purchase_amount + $waste[0]->total_loss_amount + $expense[0]->expense_amount + $supplier_payment[0]->supplier_payment_amount));

      $net_profit = (($sales[0]->total_sales_amount - ($purchase[0]->total_purchase_amount + $waste[0]->total_loss_amount + $expense[0]->expense_amount + $supplier_payment[0]->supplier_payment_amount) - $vat_amount_tmp));

      $result['total_purchase_amount'] = isset($purchase[0]->total_purchase_amount) && $purchase[0]->total_purchase_amount ? $purchase[0]->total_purchase_amount : '0.0';
      $result['total_sales_amount'] = isset($sales[0]->total_sales_amount) && $sales[0]->total_sales_amount ? $sales[0]->total_sales_amount : '0.0';
      $result['total_sales_vat'] = isset($vat_amount_tmp) && $vat_amount_tmp ? $vat_amount_tmp : '0.0';
      $result['total_loss_amount'] = isset($waste[0]->total_loss_amount) && $waste[0]->total_loss_amount ? $waste[0]->total_loss_amount : '0.0';
      $result['expense_amount'] = isset($expense[0]->expense_amount) && $expense[0]->expense_amount ? $expense[0]->expense_amount : '0.0';
      $result['supplier_payment_amount'] = isset($supplier_payment[0]->supplier_payment_amount) && $supplier_payment[0]->supplier_payment_amount ? $supplier_payment[0]->supplier_payment_amount : '0.0';

      $result['net_profit'] = isset($net_profit) && $net_profit ? $net_profit : '0.0';
      $result['gross_profit'] = isset($gross_profit) && $gross_profit ? $gross_profit : '0.0';
      $result['allTotal'] = isset($allTotal) && $allTotal ? $allTotal : '0.0';
      return $result;
    endif;
  }

  /**
   * supplier report
   * @access public
   * @param string
   * @param string
   * @param int
   */
  public function supplierReport($startMonth = '', $endMonth = '', $supplier_id = '')
  {
    if ($startMonth || $endMonth || $supplier_id) :
      $outlet_id = $this->session->userdata('outlet_id');
      $this->db->select('date,grand_total,paid,due,reference_no');
      $this->db->from('tbl_purchase');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('date>=', $startMonth);
        $this->db->where('date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('date', $startMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('date', $endMonth);
      }

      if ($supplier_id != '') {
        $this->db->where('supplier_id', $supplier_id);
      }
      $this->db->where('outlet_id', $outlet_id);
      $this->db->where('del_status', "Live");
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * supplier due payment report
   * @access public
   * @param string
   * @param string
   * @param int
   */
  public function supplierDuePaymentReport($startMonth = '', $endMonth = '', $supplier_id = '')
  {
    if ($startMonth || $endMonth || $supplier_id) :
      $outlet_id = $this->session->userdata('outlet_id');
      $this->db->select('date,amount,note');
      $this->db->from('tbl_supplier_payments');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('date>=', $startMonth);
        $this->db->where('date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('date', $startMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('date', $endMonth);
      }

      if ($supplier_id != '') {
        $this->db->where('supplier_id', $supplier_id);
      }
      $this->db->where('outlet_id', $outlet_id);
      $this->db->where('del_status', "Live");
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   *  return last date day depend on month
   * @access public
   * @param string
   */
  function getLastDayInDateMonth($month)
  {
    $returnValue = 0;
    if ($month == "02") {
      $returnValue = "28";
    } elseif ($month == "01" || $month == "03" || $month == "05" || $month == "07" || $month == "08" || $month == "10" || $month == "12") {
      $returnValue = "31";
    } else {
      $returnValue = "30";
    }
    return $returnValue;
  }

  /**
   * purchase report
   * @access public
   * @param string
   * @param string
   * @param int
   */
  public function purchaseReportByMonth($startMonth = '', $endMonth = '', $user_id = '')
  {
    if ($startMonth || $endMonth || $user_id) :
      $outlet_id = $this->session->userdata('outlet_id');
      $this->db->select('date,sum(grand_total) as total_payable');
      $this->db->from('tbl_purchase');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('date>=', $startMonth);
        $this->db->where('date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('date>=', $startMonth);
        $this->db->where('date <=', $endMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('date>=', $startMonth);
        $this->db->where('date <=', $endMonth);
      }

      if ($user_id != '') {
        $this->db->where('user_id', $user_id);
      }
      $this->db->where('outlet_id', $outlet_id);
      $this->db->group_by('month(date)');
      $this->db->where('del_status', "Live");
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * purchase report
   * @access public
   * @param string
   * @param string
   */
  public function purchaseReportByDate($startDate = '', $endDate = '')
  {
    if ($startDate || $endDate) :
      $outlet_id = $this->session->userdata('outlet_id');
      $this->db->select('*');
      $this->db->from('tbl_purchase');

      if ($startDate != '' && $endDate != '') {
        $this->db->where('date>=', $startDate);
        $this->db->where('date <=', $endDate);
      }
      if ($startDate != '' && $endDate == '') {
        $this->db->where('date', $startDate);
      }
      if ($startDate == '' && $endDate != '') {
        $this->db->where('date', $endDate);
      }
      $this->db->where('outlet_id', $outlet_id);
      // $this->db->group_by('date(date)');
      $this->db->where('del_status', "Live");
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * purchase product report
   * @access public
   * @param string
   * @param string
   * @param int
   */
  public function purchaseReportByIngredient($startMonth = '', $endMonth = '', $product_id = '')
  {
    if ($startMonth || $endMonth || $product_id) :
      $outlet_id = $this->session->userdata('outlet_id');
      $this->db->select('sum(quantity_amount) as totalQuantity_amount,product_id,tbl_products.name,tbl_products.code,date');
      $this->db->from('tbl_purchase_products');
      $this->db->join('tbl_purchase', 'tbl_purchase.id = tbl_purchase_products.purchase_id', 'left');
      $this->db->join('tbl_products', 'tbl_products.id = tbl_purchase_products.product_id', 'left');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('date>=', $startMonth);
        $this->db->where('date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('date', $startMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('date', $endMonth);
      }

      if ($product_id != '') {
        $this->db->where('product_id', $product_id);
      }
      $this->db->where('tbl_purchase.outlet_id', $outlet_id);
      $this->db->where('tbl_purchase_products.del_status', 'Live');
      $this->db->order_by('date', 'ASC');
      $this->db->group_by('tbl_purchase_products.product_id');
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * product purchase report
   * @access public
   * @param string
   * @param string
   * @param int
   * @param int
   */
  public function productPurchaseReport($startMonth = '', $endMonth = '', $product_id = '', $supplier_id = '')
  {
    if ($startMonth || $endMonth || $product_id || $supplier_id) :
      $outlet_id = $this->session->userdata('outlet_id');

      $this->db->select('sum(quantity_amount) as totalQuantity_amount,tbl_purchase_details.unit_price,product_id,tbl_products.name,tbl_products.code,date,tbl_purchase.supplier_id');
      $this->db->from('tbl_purchase_details');
      $this->db->join('tbl_purchase', 'tbl_purchase.id = tbl_purchase_details.purchase_id', 'left');
      $this->db->join('tbl_products', 'tbl_products.id = tbl_purchase_details.product_id', 'left');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('date>=', $startMonth);
        $this->db->where('date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('date', $startMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('date', $endMonth);
      }
      $this->db->where('tbl_purchase.supplier_id', $supplier_id);
      $this->db->where('tbl_purchase_details.product_id', $product_id);
      $this->db->where('tbl_purchase.outlet_id', $outlet_id);
      $this->db->where('tbl_purchase_details.del_status', 'Live');
      $this->db->order_by('date', 'ASC');
      $this->db->group_by('tbl_purchase_details.product_id');
      $this->db->group_by('date');
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * product order report
   * @access public
   * @param string
   * @param string
   * @param int
   * @param int
   */
  public function productOrder1Report($startMonth = '', $endMonth = '', $product_id = '', $customer_id = '')
  {
    if ($startMonth || $endMonth || $product_id || $customer_id) :
      $this->db->select('tbl_orders.order_number, sum(qty) as totalQuantity_amount,product_id,tbl_products.name,tbl_products.code,delivery_date,tbl_orders.delivery_person_id,tbl_users.full_name as delivery_person_name,tbl_customers.name as customer_name, tbl_customers.phone as customer_phone,tbl_order_items.price');
      $this->db->from('tbl_order_items');
      $this->db->join('tbl_orders', 'tbl_orders.id = tbl_order_items.order_id', 'left');
      $this->db->join('tbl_customers', 'tbl_customers.id = tbl_orders.customer_id', 'left');
      $this->db->join('tbl_products', 'tbl_products.id = tbl_order_items.product_id', 'left');
      $this->db->join('tbl_users', 'tbl_users.id = tbl_orders.delivery_person_id', 'left');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('delivery_date>=', $startMonth);
        $this->db->where('delivery_date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('delivery_date', $startMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('delivery_date', $endMonth);
      }
      if ($customer_id != '') {
        $this->db->where('tbl_sales.customer_id', $customer_id);
      }
      if ($product_id != '') {
        $this->db->where('tbl_order_items.product_id', $product_id);
      }

      $this->db->where('tbl_order_items.del_status', 'Live');
      $this->db->order_by('delivery_date', 'ASC');
      $this->db->group_by('tbl_order_items.product_id');
      $this->db->group_by('delivery_date');
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * details purchase  report
   * @access public
   * @param string
   * @param string
   * @param int
   */
  public function detailedPurchaseReport($startMonth = '', $endMonth = '', $user_id = '')
  {
    if ($startMonth || $endMonth || $user_id) :
      $outlet_id = $this->session->userdata('outlet_id');
      $this->db->select('tbl_purchase.*,tbl_users.full_name');
      $this->db->from('tbl_purchase');
      $this->db->join('tbl_users', 'tbl_users.id = tbl_purchase.user_id', 'left');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('date>=', $startMonth);
        $this->db->where('date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('date', $startMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('date', $endMonth);
      }

      if ($user_id != '') {
        $this->db->where('user_id', $user_id);
      }
      $this->db->where('tbl_purchase.outlet_id', $outlet_id);
      $this->db->where('tbl_purchase.del_status', 'Live');
      $this->db->order_by('date', 'ASC');
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * damage report
   * @access public
   * @param string
   * @param string
   * @param int
   */
  public function damageReport($startMonth = '', $endMonth = '', $user_id = '')
  {
    if ($startMonth || $endMonth || $user_id) :
      $outlet_id = $this->session->userdata('outlet_id');
      $this->db->select('tbl_damages.*,emp.full_name as EmployeedName');
      $this->db->from('tbl_damages');
      $this->db->join('tbl_users as emp', 'emp.id = tbl_damages.employee_id', 'left');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('date>=', $startMonth);
        $this->db->where('date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('date', $startMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('date', $endMonth);
      }

      if ($user_id != '') {
        $this->db->where('tbl_damages.user_id', $user_id);
      }
      $this->db->where('tbl_damages.outlet_id', $outlet_id);
      $this->db->where('tbl_damages.del_status', 'Live');
      $this->db->order_by('date', 'ASC');
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * supplier due report
   * @access public
   */
  public function supplierDueReport()
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $this->db->select('sum(due) as totalDue,supplier_id,date,name,tbl_suppliers.previous_due');
    $this->db->from('tbl_purchase');
    $this->db->join('tbl_suppliers', 'tbl_suppliers.id = tbl_purchase.supplier_id', 'left');
    $this->db->order_by('totalDue desc');
    $this->db->where('tbl_purchase.outlet_id', $outlet_id);
    $this->db->where('tbl_purchase.del_status', 'Live');
    $this->db->group_by('tbl_purchase.supplier_id');
    return $this->db->get()->result();
  }

  /**
   * supplier due paid report
   * @access public
   * @param int
   */
  public function getDuePaid($id)
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $this->db->select('sum(amount) as totalPaid');
    $this->db->from('tbl_supplier_payments');
    $this->db->where('supplier_id', $id);
    $this->db->where('outlet_id', $outlet_id);
    $this->db->where('del_status', 'Live');
    return $this->db->get()->row();
  }

  /**
   * return users
   * @access public
   * @param string
   * @param string
   * @param int
   */
  public function getUsers($outlet_id)
  {
    $this->db->select("*");
    $this->db->from('tbl_users');
    $this->db->where("outlet_id", $outlet_id);
    return $this->db->get()->result();
  }

  /**
   * expense report
   * @access public
   * @param string
   * @param string
   * @param int
   */
  public function expenseReport($startMonth = '', $endMonth = '', $category_id = '')
  {
    if ($startMonth || $endMonth || $category_id) :
      $outlet_id = $this->session->userdata('outlet_id');
      $this->db->select('tbl_expenses.*,emp.full_name as EmployeedName,tbl_expense_products.name as categoryName');
      $this->db->from('tbl_expenses');
      $this->db->join('tbl_users as emp', 'emp.id = tbl_expenses.employee_id', 'left');
      $this->db->join('tbl_expense_products', 'tbl_expense_products.id = tbl_expenses.category_id', 'left');

      if ($startMonth != '' && $endMonth != '') {
        $this->db->where('date>=', $startMonth);
        $this->db->where('date <=', $endMonth);
      }
      if ($startMonth != '' && $endMonth == '') {
        $this->db->where('date', $startMonth);
      }
      if ($startMonth == '' && $endMonth != '') {
        $this->db->where('date', $endMonth);
      }

      if ($category_id != '') {
        $this->db->where('tbl_expenses.category_id', $category_id);
      }
      $this->db->where('tbl_expenses.outlet_id', $outlet_id);
      $this->db->where('tbl_expenses.del_status', 'Live');
      $this->db->order_by('date', 'ASC');
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;
    endif;
  }

  /**
   * attendance report
   * @access public
   * @param string
   * @param string
   * @param int
   */
  public function attendanceReport($start_date = '', $end_date = '', $employee_id = '')
  {
    if ($start_date || $end_date || $employee_id) :
      $outlet_id = $this->session->userdata('outlet_id');
      $this->db->select('tbl_attendance.*, emp.full_name as employee_name');
      $this->db->from('tbl_attendance');
      $this->db->join('tbl_users as emp', 'emp.id = tbl_attendance.employee_id', 'left');

      if ($start_date != '' && $end_date != '') {
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
      }
      if ($start_date != '' && $end_date == '') {
        $this->db->where('date', $start_date);
      }
      if ($start_date == '' && $end_date != '') {
        $this->db->where('date', $end_date);
      }

      if ($employee_id != '') {
        $this->db->where('tbl_attendance.employee_id', $employee_id);
      }

      $this->db->where('tbl_attendance.del_status', 'Live');
      $this->db->order_by('date', 'ASC');
      $query_result = $this->db->get();
      $result = $query_result->result();
      return $result;

    endif;
  }
}
