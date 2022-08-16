<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Common_model extends CI_Model
{
  /**
   * return purchase ammount
   * @access public
   * @param int
   * @param int
   */
  public function getPurchaseAmountByUserAndOutletId($user_id, $outlet_id)
  {
    $this->db->select('SUM(paid) as total_purchase_amount');
    $this->db->from('tbl_purchase');
    $this->db->where("DATE(date)", date('Y-m-d'));
    $this->db->where("user_id", $user_id);
    $this->db->where("outlet_id", $outlet_id);
    return $this->db->get()->row();
  }

  /**
   * return product purchase data
   * @access public
   * @param string
   */
  public function getProductPurchase($date)
  {
    if ($date) :
      $this->db->select('sum(qty) as totalQuantity_amount,tbl_order_items.name,product_id');
      $this->db->from('tbl_order_items');
      $this->db->join('tbl_orders', 'tbl_orders.id = tbl_order_items.order_id', 'left');
      $this->db->where('delivery_date', $date);
      $this->db->where('tbl_orders.del_status', 'Live');
      $this->db->group_by('tbl_order_items.product_id');
      $this->db->group_by('delivery_date');
      $result = $this->db->get();

      if ($result != false) {
        return $result->result();
      } else {
        return false;
      }
    endif;
  }

  /**
   * return custom table data
   * @access public
   * @param string
   * @param string
   * @param string
   */
  public function getDataCustomName($tbl, $db_field, $search_value)
  {
    $this->db->select('*');
    $this->db->from($tbl);
    $this->db->where($db_field, $search_value);
    $this->db->where("del_status", 'Live');
    return $this->db->get()->result();
  }

  public function getOrderData($order_id)
  {
    $this->db->select("to.*, tpm.name as paymentName, tc.name as cus_name, tc.email as cus_email, tc.phone as cus_phone");
    $this->db->from('tbl_orders to');
    $this->db->join('tbl_payment_methods as tpm', 'tpm.id = to.payment_id', 'left');
    $this->db->join('tbl_customers as tc', 'tc.id = to.customer_id', 'left');
    $this->db->where("to.id", $order_id);
    return $this->db->get()->row();
  }


  public function getOrderItems($order_id)
  {
    return $this->db->select("toi.*, tp.description, tp.photo, tp.category_id as category_id")
      ->from('tbl_order_items toi')
      ->join('tbl_products as tp', 'tp.id = toi.product_id', 'left')
      ->where('toi.order_id', $order_id)
      ->where('toi.del_status', 'Live')
      ->get()
      ->result();
  }

  /**
   * return salary user
   * @access public
   * @param int
   */
  public function getSalaryUsers()
  {
    $this->db->select('*');
    $this->db->from("tbl_users");
    $this->db->where("role", "User");
    $this->db->where("del_status", 'Live');
    return $this->db->get()->result();
  }

  /**
   * check existing account
   * @access public
   * @param string
   * @param string
   */
  public function checkExistingAccount($mobile, $password = '')
  {
    $this->db->select('*');
    $this->db->from("tbl_customers");
    $this->db->where("phone", $mobile);
    if ($password != '') {
      $this->db->where("password", md5($password));
    }
    $this->db->where("del_status", 'Live');
    return $this->db->get()->row();
  }

  public function checkPhoneNumberForOTP($mobile)
  {
    return $this->db->select('*')
      ->from("tbl_customers")
      ->where("phone", $mobile)
      ->where("del_status", 'Live')
      ->get()
      ->row();
  }

  public function checkPhoneNumberForOTP2($mobile)
  {
    $c_id = $this->session->userdata('c_id');
    $this->db->select('*');
    $this->db->from("tbl_customers");
    $this->db->where("id", $c_id);
    $this->db->where("del_status", 'Live');
    return $this->db->get()->row();
  }

  public function checkCouponNewCustomer($customer_id)
  {
    return $this->db->select('*')
      ->from("tbl_coupon_customer")
      ->where("customer", $customer_id)
      ->get()
      ->row();
  }

  public function checkCouponUse($coupon, $customer_id)
  {
    return $this->db->select('*')
      ->from("tbl_coupon_customer")
      ->where("customer", $customer_id)
      ->where("coupon_id", $coupon)
      ->get()
      ->row();
  }

  public function checkCoupon($code, $date = null)
  {
    $this->db->select('*')
      ->from("tbl_coupons")
      ->where("code", $code);
    if ($date) {
      $this->db->where("expired_date >=", $date);
    }
    return $this->db->where("del_status", 'Live')->get()->row();
  }

  /**
   * check existing account by email
   * @access public
   * @param string
   * @return mixed
   */
  public function checkExistingAccountByEmail($email)
  {
    return $this->db->select('*')
      ->from("tbl_customers")
      ->where("email", $email)
      ->where("del_status", 'Live')
      ->get()
      ->row();
  }

  /**
   * return custom table data
   * @access public
   * @param string
   * @return array|bool
   */
  public function getAllByTable($table_name)
  {
    $this->db->select("*");
    $this->db->from($table_name);
    if ($table_name == 'tbl_units') {
      $this->db->order_by('unit_name', 'ASC');
    } elseif ($table_name == 'tbl_admin_user_menus') {
      $this->db->order_by('id', 'ASC');
    } elseif ($table_name == 'tbl_areas') {
      $this->db->order_by('id', 'ASC');
    } else {
      $this->db->order_by(2, 'ASC');
    }
    $this->db->where("del_status", 'Live');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return custom table data
   * @access public
   * @param string
   */
  public function getAllByTableDESC($table_name)
  {
    $this->db->select("*");
    $this->db->from($table_name);
    $this->db->order_by('id', 'DESC');
    $this->db->where("del_status", 'Live');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return delivery person data only from tbl_users table
   * @access public
   */
  public function getDeliveryPersons()
  {
    return $this->db->select("tu.*, tr.name")
      ->from("tbl_users tu")
      ->join('tbl_roles as tr', 'tr.id = tu.role', 'INNER')
      ->where("tu.del_status", 'Live')
      ->where("tr.slug", 'delivery-man')
      ->order_by('tu.id', 'DESC')
      ->get()
      ->result();
  }

  /**
   * return all delivery items
   * @access public
   * @param int
   */
  public function getAllDeliveryItemsRow($id = '')
  {
    $this->db->select("*");
    $this->db->from("tbl_delivery_persons");
    $this->db->order_by('id', 'DESC');
    $this->db->where("del_status", 'Live');
    if ($id != '') {
      $this->db->where("delivery_person_id", $id);
    }
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param string
   * @param string
   * @param string
   */
  public function getAllByCustomId($id, $filed, $tbl, $order = '')
  {
    $this->db->select('*');
    $this->db->from($tbl);
    $this->db->where($filed, $id);
    if ($order != '') {
      $this->db->order_by('id', $order);
    }
    $this->db->where("del_status", 'Live');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param string
   * @param string
   * @param string
   */
  public function getAllByCustomRowId($id, $filed, $tbl, $order = '')
  {
    $this->db->select('*');
    $this->db->from($tbl);
    $this->db->where($filed, $id);
    if ($order != '') {
      $this->db->order_by('id', $order);
    }
    $this->db->where("del_status", 'Live');
    return $this->db->get()->row();
  }

  /**
   * return all custom table data
   * @access public
   * @param string
   * @param string
   * @param string
   * @param string
   */
  public function getAllCustomData($tbl, $order_colm, $order_type, $where_colm, $coln_value)
  {
    $this->db->select('*');
    $this->db->from($tbl);
    if ($order_colm != '') {
      $this->db->order_by($order_colm, $order_type);
    }
    if ($where_colm != '') {
      $this->db->where($where_colm, $coln_value);
    }
    $this->db->where("del_status", 'Live');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param string
   */
  public function getAllByCompanyId($company_id, $table_name)
  {
    $this->db->select('*');
    $this->db->from($table_name);
    $this->db->where('del_status', 'Live');
    $this->db->order_by('id', 'DESC');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }


  public function get_customers($company_id)
  {
    return $this->db->select('tc.*')
      ->from('tbl_customers tc')
      ->join('tbl_customer_address as tca', 'tca.id = tc.default_address', 'left')
      // ->where('tc.company_id', $company_id)
      ->where('tc.del_status', 'Live')
      ->order_by('tc.id', 'DESC')
      ->get()
      ->result();
  }


  /**
   * return all custom table data
   * @access public
   * @param int
   * @param int
   * @param string
   */
  public function getAllByGroupId($company_id, $group_id, $table_name)
  {
    $this->db->select('*');
    $this->db->from($table_name);
    $this->db->where('company_id', $company_id);
    $this->db->where('group_id', $group_id);
    $this->db->where('del_status', 'Live');
    $this->db->order_by('id', 'DESC');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param string
   */
  public function getAll($company_id, $table_name)
  {
    $result = $this->db->query("SELECT i.*, sum_tbl.total_purchase,order_tbl.total_order,supplier_payment.total_supplier_due_payment,expense_tbl.total_expense,deposit_tbl.total_deposit,withdraw_tbl.total_withdraw
FROM tbl_payment_methods i
LEFT JOIN (select payment_method_id, SUM(paid) as total_purchase from tbl_purchase where del_status='Live' group by payment_method_id) sum_tbl ON sum_tbl.payment_method_id = i.id
LEFT JOIN (select payment_id, SUM(total_amount) as total_order from tbl_orders where del_status='Live' AND status='Delivered' group by payment_id) order_tbl ON order_tbl.payment_id = i.id
LEFT JOIN (select payment_method_id, SUM(amount) as total_supplier_due_payment from tbl_supplier_payments where del_status='Live' group by payment_method_id) supplier_payment ON supplier_payment.payment_method_id = i.id
LEFT JOIN (select payment_method_id, SUM(amount) as total_expense from tbl_expenses where del_status='Live' group by payment_method_id) expense_tbl ON expense_tbl.payment_method_id = i.id
LEFT JOIN (select payment_method_id, SUM(amount) as total_deposit from tbl_deposit where del_status='Live' AND tbl_deposit.type='Deposit' group by payment_method_id) deposit_tbl ON deposit_tbl.payment_method_id = i.id
LEFT JOIN (select payment_method_id, SUM(amount) as total_withdraw from tbl_deposit where del_status='Live' AND tbl_deposit.type='Withdraw' group by payment_method_id) withdraw_tbl ON withdraw_tbl.payment_method_id = i.id
WHERE i.del_status='Live' AND i.company_id='$company_id' ORDER BY i.id DESC")->result();
    return $result;
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param string
   * @param string
   */
  public function getCustomerByType($company_id, $table_name, $type)
  {
    $this->db->select('*');
    $this->db->from($table_name);
    $this->db->where("company_id", $company_id);
    $this->db->where("customer_type", $type);
    $this->db->where("del_status", 'Live');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param int
   * @param int
   * @param string
   */
  public function getAllItemsByCategorySubcategory($category_id = '', $subcategory_id = '', $supplier_id = '', $table_name)
  {
    $this->db->select('*');
    $this->db->from($table_name);
    if ($category_id != '') {
      $this->db->where("category_id", $category_id);
    }
    if ($subcategory_id != '') {
      $this->db->where("subcategory_id", $subcategory_id);
    }
    if ($supplier_id != '') {
      $this->db->where("supplier_id", $supplier_id);
    }
    $this->db->order_by("id", 'DESC');
    $this->db->where("del_status", 'Live');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param string
   */
  public function getByCompanyId($company_id, $table_name)
  {
    $this->db->select('*');
    $this->db->from($table_name);
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", 'Live');
    $this->db->order_by("id", 'DESC');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }


  public function getCouponCustomers()
  {
    $result = $this->db->select('tbl_customers.*, order.total_amount, coup.code ,coup.amount ,coup.coupon_option ,coup.expired_date, coup.user_id')
      ->from('tbl_coupon_customer')
      ->join('tbl_coupons as coup', 'coup.id = tbl_coupon_customer.coupon_id')
      ->join('tbl_customers', 'tbl_customers.id = tbl_coupon_customer.customer')
      ->join('tbl_orders as order', 'order.id = coup.order_id')
      ->where('tbl_customers.del_status', 'Live')
      ->order_by('tbl_customers.id', 'DESC')
      ->get();
    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param string
   */
  public function getAllByCompanyIdForDropdown($company_id, $table_name)
  {
    $this->db->select('*');
    $this->db->from($table_name);
    $this->db->where('del_status', 'Live');
    $this->db->order_by('id', 'DESC');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return all custom table data for dropdown
   * @access public
   * @param string
   */
  public function getAllForDropdown($table_name)
  {
    $result = $this->db->query("SELECT * 
              FROM $table_name 
              WHERE del_status = 'Live'  
              ORDER BY 2")->result();
    return $result;
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param string
   */
  public function getAllByOutletId($outlet_id, $table_name)
  {
    $this->db->select('*');
    $this->db->from($table_name);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("del_status", 'Live');
    $this->db->order_by("id", 'DESC');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return all custom order list data
   * @access public
   * @param string
   * @param string
   * @param string
   * @param string
   * @param int
   */
  public function getCustomOrderList($date = '', $area = '', $phone = '', $status = '')
  {
    $this->db->select('to.*, tpm.name as paymentName, tc.name as customer_name');
    $this->db->from("tbl_orders to");
    $this->db->join('tbl_customers as tc', 'tc.id = to.customer_id', 'left');
    $this->db->join('tbl_payment_methods as tpm', 'tpm.id = to.payment_id', 'left');
    if ($date != '') {
      $this->db->where("to.delivery_date", $date);
    }
    if ($area) {
      $this->db->where("to.area", $area);
    }
    if ($phone) {
      $this->db->where("to.phone", $phone);
    }
    if ($status) {
      $this->db->where("to.status", $status);
    }

    // $this->db->where("to.del_status", 'Live');
    $this->db->order_by("to.id", 'DESC');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param string
   */
  public function getAllByOutletIdASC($outlet_id, $table_name)
  {
    $this->db->select('*');
    $this->db->from($table_name);
    $this->db->where("outlet_id", $outlet_id);
    $this->db->where("del_status", 'Live');
    $this->db->order_by("id", 'ASC');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * return all custom for dropdown
   * @access public
   * @param int
   */
  public function getAllByOutletIdForDropdown($outlet_id, $table_name)
  {
    $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE outlet_id=$outlet_id AND del_status = 'Live'  
          ORDER BY 2")->result();
    return $result;
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param string
   */
  public function getAllItemsByCategory($category_id, $table_name)
  {
    $this->db->select('*');
    $this->db->from($table_name);
    $this->db->where("category_id", $category_id);
    $this->db->where("del_status", 'Live');
    $this->db->order_by("id", 'DESC');
    $result = $this->db->get();

    if ($result != false) {
      return $result->result();
    } else {
      return false;
    }
  }

  /**
   * delete table row
   * @access public
   * @param int
   * @param string
   */
  public function deleteStatusChange($id, $table_name)
  {
    $this->db->set('del_status', "Deleted");
    $this->db->where('id', $id);
    $this->db->update($table_name);
  }

  public function permanentDelete($id, $table_name)
  {
    $this->db->where('id', $id)->delete($table_name); // permanent delete query
  }

  /**
   * delete custom table row
   * @access public
   * @param int
   * @param string
   * @param string
   */
  public function deleteCustomRow($id, $colm, $tbl)
  {
    $this->db->set('del_status', "Deleted");
    $this->db->where($colm, $id);
    $this->db->update($tbl);
  }

  /**
   * delete custom table row with child
   * @access public
   * @param int
   * @param string
   * @param string
   * @param string
   * @param string
   */
  public function deleteStatusChangeWithChild($id, $id1, $table_name, $table_name2, $filed_name, $filed_name1)
  {
    $this->db->set('del_status', "Deleted");
    $this->db->where($filed_name, $id);
    $this->db->update($table_name);

    $this->db->set('del_status', "Deleted");
    $this->db->where($filed_name1, $id1);
    $this->db->update($table_name2);
  }

  /**
   * cancel order
   * @access public
   * @param int
   * @param string
   * @param string
   * @param string
   * @param string
   * @param string
   */
  public function cancelOrder($id, $id1, $table_name, $table_name2, $filed_name, $filed_name1)
  {
    $this->db->set('status', "Cancel");
    $this->db->where($filed_name, $id);
    $this->db->update($table_name);

    $this->db->set('order_status', "c");
    $this->db->where($filed_name1, $id1);
    $this->db->update($table_name2);
  }

  /**
   * insert data in custom table
   * @access public
   * @param array
   * @param string
   */
  public function insertInformation($data, $table_name)
  {
    $this->db->insert($table_name, $data);
    return $this->db->insert_id();
  }

  /**
   * return all custom table data
   * @access public
   * @param int
   * @param string
   */
  public function getDataById($id, $table_name)
  {
    $this->db->select("*");
    $this->db->from($table_name);
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }


  public function getCategoryProduct($cat_id, $type, $limit, $offset)
  {
    $condition = $type == 1 ? "i.category_id={$cat_id}" : "i.subcategory_id={$cat_id}";
    $limit = $limit > 0 ? $limit : 12;
    $offset = $offset > 0 ? $offset : 0;
    return $this->db->query("SELECT i.*,i.name as product_name, i.order_limit, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.available='Yes' AND {$condition} GROUP BY i.id LIMIT {$limit} OFFSET {$offset}")->result();
  }

  public function SearchProducts($string)
  {
    $condition = "i.name LIKE '%" . $string . "%'";

    return $this->db->query("SELECT i.*,i.name as product_name, i.order_limit, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.available='Yes' AND {$condition} GROUP BY i.id ")->result();
  }


  public function check_for_update($id, $code, $table)
  {
    return $this->db->select("*")
      ->from($table)
      ->where('id !=', $id)
      ->where('code =', $code)
      ->get()
      ->row();
  }


  public function check_for_bulk_upload($name, $table)
  {
    $this->db->select("*");
    $this->db->from($table);
    $this->db->where('name', $name);
    return $this->db->get()->row();
  }

  public function check_for_update_unit($id, $name, $table)
  {
    $this->db->select("*");
    $this->db->from($table);
    $this->db->where('id !=', $id);
    $this->db->where('unit_name', $name);
    return $this->db->get()->row();
  }


  /**
   * update table information
   * @access public
   * @param array
   * @param int
   * @param string
   */
  public function updateInformation($data, $id, $table_name)
  {
    $this->db->where('id', $id);
    $this->db->update($table_name, $data);
  }

  /**
   * update custom table data
   * @access public
   * @param array
   * @param int
   * @param string
   * @param string
   */
  public function updateInformationByCustom($data, $id, $field, $table_name)
  {
    $this->db->where($field, $id);
    $this->db->update($table_name, $data);
  }

  /**
   * update custom table data by company id
   * @access public
   * @param array
   * @param int
   * @param string
   */
  public function updateInformationByCompanyId($data, $company_id, $table_name)
  {
    $this->db->where('company_id', $company_id);
    $this->db->update($table_name, $data);
  }

  /**
   * permanently delete table row
   * @access public
   * @param string
   * @param int
   * @param string
   */
  public function deletingMultipleFormData($field_name, $primary_table_id, $table_name)
  {
    $this->db->delete($table_name, array($field_name => $primary_table_id));
  }

  /**
   * return all customer table data
   * @access public
   */
  public function getAllCustomers()
  {
    return $this->db->get("tbl_customers")->result();
  }

  /**
   * return purchase paid amount
   * @access public
   * @param string
   */
  public function getPurchasePaidAmount($month)
  {
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
  public function getPurchaseAmount($month)
  {
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
  public function getSupplierPaidAmount($month)
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $partypaid = $this->db->query("SELECT IFNULL(SUM(p.amount),0) as partypaid
        FROM tbl_supplier_payments p  
        WHERE p.outlet_id=$outlet_id AND p.del_status = 'Live'
        AND p.date LIKE '$month%' ")->row('partypaid');
    return $partypaid;
  }

  /**
   * return product name
   * @access public
   * @param string
   */
  public function getMenuByMenuName($menu_name)
  {
    $this->db->select("*");
    $this->db->from('tbl_products');
    $this->db->where("tbl_products.name", $menu_name);
    $this->db->order_by('id', 'ASC');
    return $this->db->get()->row();
  }

  /**
   * return product return
   * @access public
   * @param string
   */
  public function getIngredientByIngredientName($menu_name)
  {
    $this->db->select("*");
    $this->db->from('tbl_products');
    $this->db->where("tbl_products.name", $menu_name);
    $this->db->order_by('id', 'ASC');
    return $this->db->get()->row();
  }

  /**
   * return waste data
   * @access public
   * @param string
   */
  public function getWaste($month)
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $totalWaste = $this->db->query("SELECT IFNULL(SUM(w.total_loss),0) as totalWaste
        FROM tbl_damages w  
        WHERE w.outlet_id=$outlet_id AND w.del_status = 'Live'
        AND w.date LIKE '$month%'")->row('totalWaste');
    return $totalWaste;
  }

  /**
   * return expense data
   * @access public
   * @param string
   */
  public function getExpense($month)
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $totalExpense = $this->db->query("SELECT IFNULL(SUM(w.amount),0) as totalExpense
        FROM tbl_expenses w  
        WHERE w.outlet_id=$outlet_id AND w.del_status = 'Live'
        AND w.date LIKE '$month%'")->row('totalExpense');
    return $totalExpense;
  }

  /**
   * return current inventory/stock
   * @access public
   */
  public function currentInventory()
  {
    $company_id = $this->session->userdata('company_id');
    $outlet_id = $this->session->userdata('outlet_id');

    $result = $this->db->query("SELECT i.*,(select SUM(quantity_amount) from tbl_purchase_products where product_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_purchase, 
                (select SUM(consumption) from tbl_sale_consumptions_of_menus where product_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_consumption,
                (select SUM(waste_amount) from tbl_waste_products  where product_id=i.id AND outlet_id=$outlet_id AND tbl_waste_products.del_status='Live') total_waste,
                (select category_name from tbl_product_categories where id=i.category_id  AND del_status='Live') category_name,
                (select unit_name from tbl_units where id=i.unit_id AND del_status='Live') unit_name
                FROM tbl_products i WHERE i.del_status='Live' AND i.company_id= '$company_id' ORDER BY i.name ASC")->result();
    $grandTotal = 0;
    foreach ($result as $value) {
      $totalStock = $value->total_purchase - $value->total_consumption - $value->total_waste;
      if ($totalStock >= 0) {
        $grandTotal = $grandTotal + $totalStock * getLastPurchaseAmount($value->id);
      }
    }
    return $grandTotal;
  }

  /**
   * notification seen/delete status change
   * @access public
   * @param int
   * @param string
   */
  public function change_status_notification($id, $value = '')
  {
    $this->db->set('visible_status', '0');
    if ($value == 3) {
    } else {
      $this->db->where('id', $id);
    }
    $this->db->update('tbl_notifications');

    $notifications_read_count = $this->db->where('del_status', 'Live')->where('visible_status', '1')->get('tbl_notifications')->result();
    $total = sizeof($notifications_read_count);
    $data['total_unread'] = $total;
    echo json_encode($data);
  }

  /**
   * return order details
   * @access public
   * @param int
   */
  public function getOrderDetails($id)
  {
    $this->db->select('tbl_orders.*,tbl_customers.name as customer_name, tbl_customers.phone as phone, tbl_customers.email as email');
    $this->db->from('tbl_orders');
    $this->db->join('tbl_customers', 'tbl_customers.id = tbl_orders.customer_id', 'left');
    $this->db->where('tbl_orders.id', $id);
    $this->db->where('tbl_orders.del_status', 'Live');
    return $this->db->get()->row();
  }

  /**
   * return supplier payable
   * @access public
   */
  public function top_ten_supplier_payable()
  {
    $outlet_id = $this->session->userdata('outlet_id');
    $this->db->select('sum(due) as totalDue,supplier_id,date,name');
    $this->db->from('tbl_purchase');
    $this->db->join('tbl_suppliers', 'tbl_suppliers.id = tbl_purchase.supplier_id', 'left');
    $this->db->order_by('totalDue desc');
    $this->db->where('tbl_purchase.outlet_id', $outlet_id);
    $this->db->where('tbl_purchase.del_status', 'Live');
    $this->db->group_by('tbl_purchase.supplier_id');
    return $this->db->get()->result();
  }

  /**
   * return custom category
   * @access public
   * @param int
   */
  public function getCustomCat($company_id)
  {
    $this->db->select('*');
    $this->db->from('tbl_product_categories');
    $this->db->order_by('order_b');
    $this->db->where('del_status', 'Live');
    $this->db->where('special_category <>', 'Yes');
    $this->db->where('company_id', $company_id);
    return $this->db->get()->result();
  }

  /**
   * return payable amount by supplier id
   * @access public
   * @param int
   */
  public function getPayableAmountBySupplierId($id)
  {
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
   * return comparison order for chart view
   * @access public
   * @param string
   * @param string
   */
  public function comparison_sale_report($start_date, $end_date)
  {
    $query = $this->db->query("select year(delivery_date) as year, month(delivery_date) as month, sum(total_amount) as total_amount from tbl_orders WHERE `delivery_date` BETWEEN '$start_date' AND '$end_date'  group by year(delivery_date), month(delivery_date)");
    if ($query->row()) {
      return $query->row()->total_amount;
    } else {
      return 0;
    }
  }

  /**
   * return item cateogries
   * @access public
   * @params int
   */
  public function getItemCategories($company_id)
  {
    $result = $this->db->query("SELECT * 
          FROM tbl_product_categories 
          WHERE company_id=$company_id AND del_status = 'Live'  
          ORDER BY name")->result();
    return $result;
  }

  /**
   * set time zone
   * @access public
   */
  public function setDefaultTimezone()
  {
    $this->db->select("time_zone");
    $this->db->from('tbl_site_setting');
    $zoneName = $this->db->get()->row();
    if ($zoneName) {
      date_default_timezone_set($zoneName->time_zone);
    }
  }

  /**
   * return custom table row
   * @access public
   * @param string
   * @param string
   * @param string
   * @param string
   */
  public function get_row($table_name, $where_param, $select_param, $group = "", $limit = "")
  {
    if (!empty($select_param)) {
      $this->db->select($select_param);
    }
    if (!empty($where_param)) {
      $this->db->where($where_param);
    }
    $this->db->group_by($group);
    if (!empty($limit)) {
      $this->db->limit($limit);
    }
    $result = $this->db->get($table_name);
    return $result->result();
  }

  /**
   * return custom row array
   * @access public
   * @param string
   * @param string
   * @param string
   * @param string
   * @param string
   * @param string
   * @param string
   */
  public function get_row_array($table_name, $where_param, $select_param, $group = "", $limit = "", $order_by = false, $order_value = false)
  {
    if (!empty($select_param)) {
      $this->db->select($select_param);
    }
    if (!empty($where_param)) {
      $this->db->where($where_param);
    }
    if (!empty($group)) {
      $this->db->group_by($group);
    }
    if (!empty($order_by)) {
      $this->db->order_by($order_by, $order_value);
    }
    if (!empty($limit)) {
      $this->db->limit($limit);
    }
    $result = $this->db->get($table_name);
    return $result->result_array();
  }

  /**
   * return table data by custom sql
   * @access public
   * @param string
   */
  public function customeQuery($sql)
  {
    $result = $this->db->query($sql);
    return $result->result_array();
  }


  public function getCategoryBySlug(string $slug, int $type)
  {
    if ($type == 1) {
      return $this->db->select('*')
        ->from('tbl_product_categories')
        ->where("slug", trim($slug))
        ->where("del_status", 'Live')
        ->get()
        ->row();
    } elseif ($type == 2) {
      return $this->db->select('tpsc.*, tpc.id as parent_id, tpc.name as parent_name, tpc.slug as parent_slug')
        ->from('tbl_product_sub_categories as tpsc')
        ->join('tbl_product_categories as tpc', 'tpsc.cat_id = tpc.id', 'left')
        ->where('tpsc.slug', trim($slug))
        ->where("tpsc.del_status", 'Live')
        ->get()
        ->row();
    }
  }

  public function getCategorySubCategory($cat_id)
  {
    return $this->db->select('*')
      ->from('tbl_product_sub_categories')
      ->where("cat_id", $cat_id)
      ->get()
      ->result();
  }

  public function getSubCategoryParent($cat_id)
  {
    return $this->db->select('*')->from('tbl_product_categories')
      ->where("id", $cat_id)
      ->where("del_status", "Live")
      ->get()->row();
  }

  public function getSinglePage($slug)
  {
    return $this->db->select('*')
      ->from('tbl_pages')
      ->where("slug", $slug)
      ->where("del_status", "Live")
      ->get()
      ->row();
  }


  public function getSubCategoryProducts($cat_id, $type, $limit)
  {
    $condition = $type == 1 ? "i.category_id = {$cat_id}" : "i.subcategory_id = {$cat_id}";
    return $this->db->query("SELECT i.*,i.name as product_name, i.order_limit, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' AND i.available='Yes' AND {$condition} GROUP BY i.id  ORDER BY i.id DESC LIMIT {$limit} ")->result();
  }


  public function updateOrInsertWishlist($product_id, $user_id)
  {
    $query = $this->db->where('product_id', $product_id)
      ->where('user_id', $user_id)
      ->where('is_purchase', null)
      ->get('tbl_wishlists')
      ->row_array();
    if (empty($query)) {
      $this->db->insert('tbl_wishlists', [
        'product_id' => $product_id,
        'user_id' => $user_id,
        'is_purchase' => null
      ]);
    }
    return $this->db->where('user_id', $user_id)
      ->where('is_purchase', null)
      ->get('tbl_wishlists')
      ->result_array();
  }

  public function removeFromWishlist($product_id, $user_id)
  {
    $this->db->where('product_id', $product_id)
      ->where('user_id', $user_id)
      ->delete('tbl_wishlists');
    return $this->db->where('user_id', $user_id)
      ->where('is_purchase', null)
      ->get('tbl_wishlists')
      ->result_array();
  }


  public function get_wishlist($user_id)
  {
    return $this->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
INNER JOIN tbl_wishlists as tw ON tw.product_id = i.id
WHERE i.del_status='Live' AND i.available='Yes' AND tw.user_id={$user_id} AND tw.is_purchase IS NULL  GROUP BY i.id ORDER BY i.id DESC limit 10")->result_array();
  }
}
