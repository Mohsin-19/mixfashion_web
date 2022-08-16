<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    /**
     * return purchase paid amount
     * @access public
     * @param string
     */
    public function getPurchasePaidAmount($month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $ppaid = $this->db->query("SELECT IFNULL(SUM(p.paid),0) as ppaid
        FROM tbl_purchase p  
        WHERE p.outlet_id=$outlet_id AND p.del_status = 'Live'
        AND p.date LIKE '$month%' ")->row('ppaid');
        return $ppaid;
    }
    /**
     * return purchase amount
     * @access public
     * @param string
     */
    public function getPurchaseAmount($month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $totalPurchase = $this->db->query("SELECT IFNULL(SUM(p.grand_total),0) as totalPurchase
        FROM tbl_purchase p  
        WHERE p.outlet_id=$outlet_id AND p.del_status = 'Live'
        AND p.date LIKE '$month%' ")->row('totalPurchase');
        return $totalPurchase;
    }
    /**
     * return supplier paid amount
     * @access public
     * @param string
     */
    public function getSupplierPaidAmount($month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $partypaid = $this->db->query("SELECT IFNULL(SUM(p.amount),0) as partypaid
        FROM tbl_supplier_payments p  
        WHERE p.outlet_id=$outlet_id AND p.del_status = 'Live'
        AND p.date LIKE '$month%' ")->row('partypaid');
        return $partypaid;
    }
    /**
     * return product row details
     * @access public
     * @param string
     */
    public function getMenuByMenuName($menu_name){
      $this->db->select("*");
      $this->db->from('tbl_products');
      $this->db->where("tbl_products.name", $menu_name);
      $this->db->order_by('id', 'ASC');
      return $this->db->get()->row();      
    }
    /**
     * return products detials
     * @access public
     * @param string
     */
    public function getIngredientByIngredientName($menu_name){
      $this->db->select("*");
      $this->db->from('tbl_products');
      $this->db->where("tbl_products.name", $menu_name);
      $this->db->order_by('id', 'ASC');
      return $this->db->get()->row();      
    }
    /**
     * return waste amount
     * @access public
     * @param string
     */
    public function getWaste($month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $totalWaste = $this->db->query("SELECT IFNULL(SUM(w.total_loss),0) as totalWaste
        FROM tbl_damages w  
        WHERE w.outlet_id=$outlet_id AND w.del_status = 'Live'
        AND w.date LIKE '$month%'")->row('totalWaste');
        return $totalWaste;
    }
    /**
     * return expense amount
     * @access public
     * @param string
     */
    public function getExpense($month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $totalExpense = $this->db->query("SELECT IFNULL(SUM(w.amount),0) as totalExpense
        FROM tbl_expenses w  
        WHERE w.outlet_id=$outlet_id AND w.del_status = 'Live'
        AND w.date LIKE '$month%'")->row('totalExpense');
        return $totalExpense;
    }
    /**
     * return current amount
     * @access public
     * @param string
     */
    public function currentInventory() {
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');

        $result = $this->db->query("SELECT i.*,(select SUM(quantity_amount) from tbl_purchase_details where product_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_purchase, 
            (select SUM(damage_amount) from tbl_damage_details  where product_id=i.id AND outlet_id=$outlet_id AND tbl_damage_details.del_status='Live') total_damage,
          
                (select category_name from tbl_product_categories where id=i.category_id  AND del_status='Live') category_name,
                (select unit_name from tbl_units where id=i.unit_id AND del_status='Live') unit_name
                FROM tbl_products i WHERE i.del_status='Live' AND i.company_id= '$company_id' ORDER BY i.name ASC")->result();
        $grandTotal = 0;
        foreach ($result as $value) {
            $totalStock = $value->opening_stock + ($value->total_purchase*$value->conversion_rate)  - $value->total_damage;
            if ($totalStock >= 0) {
                $grandTotal = $grandTotal + $totalStock * getLastPurchaseAmount($value->id);
            }
        }
        return $grandTotal;
    }
    /**
     * return top ten order products with custom date
     * @access public
     * @param string
     * @param string
     */
    public function top_ten_food_menu($start_date, $end_date) {
        $this->db->select('sum(qty) as totalQty,product_id,tbl_products.name as menu_name,delivery_date as sale_date');
        $this->db->from('tbl_order_items');
        $this->db->join('tbl_orders', 'tbl_orders.id = tbl_order_items.order_id', 'left');
        $this->db->join('tbl_products', 'tbl_products.id = tbl_order_items.product_id', 'left');
        $this->db->where('delivery_date>=', $start_date);
        $this->db->where('delivery_date <=', $end_date);
        $this->db->order_by('totalQty desc');
        $this->db->where('tbl_order_items.del_status', 'Live');
        $this->db->group_by('product_id');
        $this->db->limit(10);
        return $this->db->get()->result();
    }
    /**
     * return top ten pruchase products with custom date
     * @access public
     * @param string
     * @param string
     */
    public function top_ten_food_menu_purchase($start_date, $end_date) {
        $this->db->select('sum(quantity_amount) as totalQty,product_id,tbl_products.name as menu_name,date');
        $this->db->from('tbl_purchase_details');
        $this->db->join('tbl_purchase', 'tbl_purchase.id = tbl_purchase_details.purchase_id', 'left');
        $this->db->join('tbl_products', 'tbl_products.id = tbl_purchase_details.product_id', 'left');
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->order_by('totalQty desc');
        $this->db->where('tbl_purchase_details.del_status', 'Live');
        $this->db->group_by('product_id');
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    /**
     * return top ten customer with custom date
     * @access public
     * @param string
     * @param string
     */
    public function top_ten_customer($start_date, $end_date) {
        $this->db->select('sum(tbl_orders.total_amount) as total_payable, tbl_orders.customer_id, tbl_customers.name, tbl_orders.delivery_date');
        $this->db->from('tbl_orders');
        $this->db->join('tbl_customers', 'tbl_orders.customer_id = tbl_customers.id', 'left');
        $this->db->where('tbl_orders.delivery_date>=', $start_date);
        $this->db->where('tbl_orders.delivery_date <=', $end_date);
        $this->db->order_by('total_payable desc');
        $this->db->where('tbl_orders.del_status', 'Live');
        $this->db->group_by('customer_id');
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    /**
     * return supplier payable list
     * @access public
     */
    public function supplier_payable() {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(due) as due, supplier_id, name,phone');
        $this->db->from('tbl_purchase');
        $this->db->join('tbl_suppliers', 'tbl_suppliers.id = tbl_purchase.supplier_id', 'left');
        $this->db->order_by('due desc');
        $this->db->where('tbl_purchase.outlet_id', $outlet_id);
        $this->db->where('tbl_purchase.del_status', 'Live');
        $this->db->group_by('tbl_purchase.supplier_id');
        return $this->db->get()->result();
    }
    /**
     * return custom date purchase sum
     * @access public
     * @param string
     * @param string
     */
    public function purchase_sum($first_day_this_month, $last_day_this_month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(paid) as purchase_sum');
        $this->db->from('tbl_purchase');  
        $this->db->where('tbl_purchase.date>=', $first_day_this_month);
        $this->db->where('tbl_purchase.date <=', $last_day_this_month);         
        $this->db->where('tbl_purchase.outlet_id', $outlet_id);
        $this->db->where('tbl_purchase.del_status', 'Live'); 
        $result = $this->db->get()->row();

        if (empty($result->purchase_sum)) {
            $result->purchase_sum = 0;
        }

        return $result;
    }
    /**
     * return custom date order sum
     * @access public
     * @param string
     * @param string
     */
    public function sale_online_sum($first_day_this_month, $last_day_this_month) {
        $this->db->select('sum(total_amount) as sale_sum');
        $this->db->from('tbl_orders');
        $this->db->where('tbl_orders.delivery_date>=', $first_day_this_month);
        $this->db->where('tbl_orders.delivery_date <=', $last_day_this_month);
        $this->db->where('tbl_orders.del_status', 'Live');
        $result = $this->db->get()->row();

        if (empty($result->sale_sum)) {
            $result->sale_sum = 0;
        }

        return $result;
    }
    /**
     * return custom date order cancel sum
     * @access public
     * @param string
     * @param string
     */
    public function sale_online_sum_cancel($first_day_this_month, $last_day_this_month) {
        $this->db->select('sum(total_amount) as sale_sum');
        $this->db->from('tbl_orders');
        $this->db->where('tbl_orders.delivery_date>=', $first_day_this_month);
        $this->db->where('tbl_orders.delivery_date <=', $last_day_this_month);
        $this->db->where('tbl_orders.del_status', 'Live');
        $this->db->where('tbl_orders.status', 'Cancel');
        $result = $this->db->get()->row();

        if (empty($result->sale_sum)) {
            $result->sale_sum = 0;
        }

        return $result;
    }
    /**
     * return custom date order delivered sum
     * @access public
     * @param string
     * @param string
     */
    public function sale_online_sum_delivered($first_day_this_month, $last_day_this_month) {
        $this->db->select('sum(total_amount) as sale_sum');
        $this->db->from('tbl_orders');
        $this->db->where('tbl_orders.delivery_date>=', $first_day_this_month);
        $this->db->where('tbl_orders.delivery_date <=', $last_day_this_month);
        $this->db->where('tbl_orders.del_status', 'Live');
        $this->db->where('tbl_orders.status', 'Delivered');
        $result = $this->db->get()->row();

        if (empty($result->sale_sum)) {
            $result->sale_sum = 0;
        }

        return $result;
    }
    /**
     * return custom date online new order sum
     * @access public
     * @param string
     * @param string
     */
    public function sale_online_sum_new($first_day_this_month, $last_day_this_month) {
        $this->db->select('sum(total_amount) as sale_sum');
        $this->db->from('tbl_orders');
        $this->db->where('tbl_orders.delivery_date>=', $first_day_this_month);
        $this->db->where('tbl_orders.delivery_date <=', $last_day_this_month);
        $this->db->where('tbl_orders.del_status', 'Live');
        $this->db->where('tbl_orders.status', 'New');
        $result = $this->db->get()->row();

        if (empty($result->sale_sum)) {
            $result->sale_sum = 0;
        }

        return $result;
    }
    /**
     * return custom date salary sum
     * @access public
     * @param string
     * @param string
     */
    public function salary_sum($first_day_this_month, $last_day_this_month) {
        $month =  date("F",strtotime($first_day_this_month));
        $year =  date("Y",strtotime($first_day_this_month));
        $this->db->select('sum(total_amount) as salary_sum');
        $this->db->from('tbl_salaries');
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->row();
        if (empty($result->salary_sum)) {
            $result->salary_sum = 0;
        }

        return $result;
    }
    /**
     * return custom date waste sum
     * @access public
     * @param string
     * @param string
     */
    public function waste_sum($first_day_this_month, $last_day_this_month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(total_loss) as waste_sum');
        $this->db->from('tbl_damages');
        $this->db->where('tbl_damages.date>=', $first_day_this_month);
        $this->db->where('tbl_damages.date <=', $last_day_this_month);
        $this->db->where('tbl_damages.outlet_id', $outlet_id);
        $this->db->where('tbl_damages.del_status', 'Live');
        $result = $this->db->get()->row(); 
        
        if (empty($result->waste_sum)) {
            $result->waste_sum = 0;
        }

        return $result;
    }
    /**
     * return custom date deposit sum
     * @access public
     * @param string
     * @param string
     */
    public function deposit_sum($first_day_this_month, $last_day_this_month) {
        $this->db->select('sum(amount) as deposit_sum');
        $this->db->from('tbl_deposit');
        $this->db->where('tbl_deposit.date>=', $first_day_this_month);
        $this->db->where('tbl_deposit.date <=', $last_day_this_month);
        $this->db->where('tbl_deposit.type', 'Deposit');
        $this->db->where('tbl_deposit.del_status', 'Live');
        $result = $this->db->get()->row();

        if (empty($result->deposit_sum)) {
            $result->deposit_sum = 0;
        }

        return $result;
    }
    /**
     * return custom date withdraw sum
     * @access public
     * @param string
     * @param string
     */
    public function withdraw_sum($first_day_this_month, $last_day_this_month) {
        $this->db->select('sum(amount) as withdraw_sum');
        $this->db->from('tbl_deposit');
        $this->db->where('tbl_deposit.date>=', $first_day_this_month);
        $this->db->where('tbl_deposit.date <=', $last_day_this_month);
        $this->db->where('tbl_deposit.type', 'Withdraw');
        $this->db->where('tbl_deposit.del_status', 'Live');
        $result = $this->db->get()->row();
        if (empty($result->withdraw_sum)) {
            $result->withdraw_sum = 0;
        }

        return $result;
    }
    /**
     * return custom date expense sum
     * @access public
     * @param string
     * @param string
     */
    public function expense_sum($first_day_this_month, $last_day_this_month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(amount) as expense_sum');
        $this->db->from('tbl_expenses');  
        $this->db->where('tbl_expenses.date>=', $first_day_this_month);
        $this->db->where('tbl_expenses.date <=', $last_day_this_month); 
        $this->db->where('tbl_expenses.outlet_id', $outlet_id);
        $this->db->where('tbl_expenses.del_status', 'Live');  
        $result = $this->db->get()->row();

        if (empty($result->expense_sum)) {
            $result->expense_sum = 0;
        }

        return $result;
    }

    /**
     * return custom date supplier due payment sum
     * @access public
     * @param string
     * @param string
     */
    public function supplier_due_payment_sum($first_day_this_month, $last_day_this_month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(amount) as supplier_due_payment_sum');
        $this->db->from('tbl_supplier_payments');  
        $this->db->where('tbl_supplier_payments.date>=', $first_day_this_month);
        $this->db->where('tbl_supplier_payments.date <=', $last_day_this_month);         
        $this->db->where('tbl_supplier_payments.outlet_id', $outlet_id);
        $this->db->where('tbl_supplier_payments.del_status', 'Live'); 
        $result = $this->db->get()->row();

        if (empty($result->supplier_due_payment_sum)) {
            $result->supplier_due_payment_sum = 0;
        }

        return $result;
    }

    /**
     * return supplier payable amount
     * @access public
     * @param int
     */
    public function getPayableAmountBySupplierId($id) {
        $this->load->model('Report_model', 'Report_model');
        $month = date('Y-m');
        $monthOnly = date('m', strtotime($month));
        $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($monthOnly);
        $temp = $month . '-' . $finalDayByMonth;
        $start_date = $month . '-' . '01';
        $end_date = $temp;
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(amount) as totalPayment,supplier_id,date');
        $this->db->from('tbl_supplier_payments');
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('supplier_id', $id);
        $this->db->where('del_status', 'Live');
        $this->db->group_by('supplier_id');
        $result = $this->db->get()->row();
        if (!empty($result)) {
            return $result->totalPayment;
        } else {
            return 0.0;
        }
    }
    /**
     * return total unorder
     * @access public
     */
    public function totalUnorderData() {
        $this->db->select('count(id) as total');
        $this->db->from('tbl_orders');
        $this->db->where('status!=', "Delivered");
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->row();
        if (!empty($result)) {
            return $result->total;
        } else {
            return 0;
        }
    }
    /**
     * return order comparison for chart view
     * @access public
     * @param string
     * @param string
     */
    public function comparison_sale_report($start_date, $end_date) {
        $query = $this->db->query("select year(delivery_date) as year, month(delivery_date) as month, sum(total_amount) as total_amount from tbl_orders WHERE `delivery_date` BETWEEN '$start_date' AND '$end_date' AND del_status='Live'  group by year(delivery_date), month(delivery_date)");
        return $query->row();
    }
    /**
     * set time zone
     * @access public
     */
    public function setDefaultTimezone() {
        $this->db->select("time_zone");
        $this->db->from('tbl_site_setting');
        $this->db->order_by('id', 'DESC');
        $zoneName = $this->db->get()->row();
        if ($zoneName)
            date_default_timezone_set($zoneName->time_zone);
    }
    /**
     * return custom row table data
     * @access public
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     */
    function get_row($table_name, $where_param, $select_param, $group = "", $limit = "") {
        if (!empty($select_param))
            $this->db->select($select_param);
        if (!empty($where_param))
            $this->db->where($where_param);
        $this->db->group_by($group);
        if (!empty($limit))
            $this->db->limit($limit);
        $result = $this->db->get($table_name);
        return $result->result();
    }
    /**
     * return custom array data
     * @access public
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     */
    function get_row_array($table_name, $where_param, $select_param, $group = "", $limit = "", $order_by = false, $order_value = false) {
        if (!empty($select_param))
            $this->db->select($select_param);
        if (!empty($where_param))
            $this->db->where($where_param);
        if (!empty($group))
            $this->db->group_by($group);
        if (!empty($order_by))
            $this->db->order_by($order_by, $order_value);
        if (!empty($limit))
            $this->db->limit($limit);
        $result = $this->db->get($table_name);
        return $result->result_array();
    }
    /**
     * return custom sql query data
     * @access public
     * @param string
     */
    function customeQuery($sql) {
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    /**
     * return total count custom table
     * @access public
     * @param string
     */
    function countData($table_name){
        return $data_count = $this->db->query("select count(*) as data_count from $table_name where del_status='Live'")->row();
    }

    /**
     * return total order amount
     * @access public
     * @param string
     * @param string
     */
    public function serviceSaleTotalAmount($startMonth,$endMonth) {
        $this->db->select('sum(total_amount) as sale_sum');
        $this->db->from('tbl_orders');

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
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->row();
        return $result;
    }
    /**
     * return product order amount
     * @access public
     * @param string
     * @param string
     */
    public function productSaleTotalAmount($startMonth,$endMonth) {
        $this->db->select('sum(paid_amount) as sale_sum');
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
        $this->db->where('tbl_order_items.del_status', 'Live');
        $this->db->where('tbl_products.type', '1');
        $this->db->order_by('code', 'ASC');
        $this->db->group_by('tbl_order_items.product_id');

        $result = $this->db->get()->row();
        if($result){
            return $result->sale_sum;
        }else{
            return 0;
        }

    }
    /**
     * return low stock item
     * @access public
     */
    public function getLowStockItem() {
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $result = $this->db->query("SELECT i.*,(select SUM(quantity_amount) from tbl_purchase_details where product_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_purchase, 
          
            (select SUM(damage_amount) from tbl_damage_details  where product_id=i.id AND outlet_id=$outlet_id AND tbl_damage_details.del_status='Live') total_damage,
        
            (select name from tbl_product_categories where id=i.category_id AND del_status='Live') category_name,
            (select unit_name from tbl_units where id=i.purchase_unit_id AND del_status='Live') purchse_unit_name,
            (select unit_name from tbl_units where id=i.sale_unit_id AND del_status='Live')  sale_unit_name
            FROM tbl_products i WHERE i.del_status='Live' AND i.alert_quantity IS NOT NULL AND i.type='1' AND i.company_id= '$company_id' ORDER BY i.name ASC")->result();
        return $result;
    }
} 
