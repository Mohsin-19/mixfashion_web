<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');


function access_control()
{
  return [
    'dashboard' => [
      'show_dashboard' => 'Show Dashboard',
    ],
    'setting' => [
      'site_setting' => 'Show Site Setting',
      'edit_setting' => 'Update Site Setting',
    ],
    'announcement' => [
      'add_announcement' => 'Add Announcement',
      'show_announcement' => 'Show Announcement',
      'edit_announcement' => 'Edit Announcement',
      'delete_announcement' => 'Delete Announcement',
    ],
    'unit' => [
      'add_unit' => 'Add Unit',
      'show_unit' => 'Show Unit',
      'edit_unit' => 'Edit Unit',
      'delete_unit' => 'Delete Unit',
    ],
    'category' => [
      'add_category' => 'Add Category',
      'show_category' => 'Show Category',
      'edit_category' => 'Edit Category',
      'sort_category' => 'Sorting Category',
      'delete_category' => 'Delete Category',
    ],
    'sub-Category' => [
      'add_sub_category' => 'Add Sub-Category',
      'show_sub_category' => 'Show Sub-Category',
      'edit_sub_category' => 'Edit Sub-Category',
      'delete_sub_category' => 'Delete Sub-Category',
    ],
    'product' => [
      'add_product' => 'Add Product',
      'show_product' => 'Show Product',
      'edit_product' => 'Edit Product',
      'upload_product' => 'Upload Product',
      'barcode_product' => 'Barcode Product',
      'delete_product' => 'Delete Product',
    ],
    'coupon' => [
      'add_coupon' => 'Add Coupon',
      'show_coupon' => 'Show Coupon',
      'edit_coupon' => 'Edit Coupon',
      'show_coupon_customer' => 'Show Coupon Customer',
      'delete_coupon' => 'Delete Coupon',
    ],
    'customer' => [
      'add_customer' => 'Add Customer',
      'show_customer' => 'Show Customer',
      'edit_customer' => 'Edit Customer',
      'delete_customer' => 'Delete Customer',
    ],
    'order-Manage' => [
      'show_order' => 'Show Order',
      'print_invoice' => 'Print Invoice',
      'print_package_slip' => 'Print Package Slip',
      'process_order' => 'Process Order',
      'dispatch_order' => 'Dispatch Order',
      'complete_order' => 'Complete Order',
      'return_order' => 'Return Order',
      'cancel_order' => 'Cancel Order',
      'new_order' => 'New Order',
      'assign_delivery' => 'Assign Delivery Person',
      'add_note' => 'Add Note',
      'product_purchase' => 'Product Purchase',
    ],
    'Order-View-By-Status' => [
      'show_new' => 'Show New Status',
      'show_process' => 'Show Process Status',
      'show_dispatch' => 'Show Dispatch Status',
      'show_complete' => 'Show Complete Status',
      'show_return' => 'Show Return Status',
      'show_cancel' => 'Show Cancel Status',
    ],
    'Delivery-Person-Cash' => [
      'show_cash' => 'Show Cash',
      'add_delivery_person_cash' => 'Add Delivery Person Cash',
    ],
    'payment-method' => [
      'add_payment_method' => 'Add Payment Method',
      'show_payment_method' => 'Show Payment Method',
      'edit_payment_method' => 'Edit Payment Method',
      'delete_payment_method' => 'Delete Payment Method',
    ],
    'stock' => [
      'show_stock' => 'Show Stock',
      'alert_stock_list' => 'Stock Alert List',
    ],
    'supplier' => [
      'add_supplier' => 'Add Supplier',
      'show_supplier' => 'Show Suppliers',
      'edit_supplier' => 'Edit Supplier',
      'delete_supplier' => 'Delete Supplier',
    ],
    'purchase' => [
      'add_purchase' => 'Add Purchase',
      'show_purchase' => 'Show Purchase',
      'edit_purchase' => 'Edit Purchase',
      'view_details' => 'View Purchase Details',
      'delete_purchase' => 'Delete Purchase',
    ],
    'Bulk-Price-Update' => [
      'show_bulk_price' => 'Show Bulk Price',
      'update_bulk_price' => 'Update Bulk Price',
    ],
    'Expense-Category' => [
      'add_expense_category' => 'Add Expense Category',
      'show_expense_category' => 'Show Expense Category',
      'edit_expense_category' => 'Edit Expense Category',
      'delete_expense_category' => 'Delete Expense Category',
    ],
    'expense' => [
      'add_expense' => 'Add Expense',
      'show_expense' => 'Show Expense',
      'edit_expense' => 'Edit Expense',
      'delete_expense' => 'Delete Expense',
    ],
    'Supplier-Due-Payment' => [
      'add_due_payment' => 'AA Due Payment',
      'show_due_payment' => 'Show Due Payment',
      'delete_due_payment' => 'Delete Due Payment',
    ],
    'attendance' => [
      'add_attendance' => 'Add Attendance',
      'show_attendance' => 'Show Attendance',
      'edit_attendance' => 'Edit Attendance',
      'delete_attendance' => 'Delete Attendance',
    ],

    // #TODO not acceess set on controller properly

    'Invoice-Tax-Setting' => [
      'restaurant_setting' => 'Show Invoice & Tax Setting',
    ],
    'payroll' => [
      'add_payroll' => 'Add Payroll',
      'show_payroll' => 'Show Payroll',
      'edit_payroll' => 'Edit Payroll',
      'delete_payroll' => 'Delete Payroll',
    ],

    'salary' => [
      'add_salary' => 'Add Salary',
      'show_salary' => 'Show Salary',
      'edit_salary' => 'Edit Salary',
      'delete_salary' => 'Delete Salary',
    ],
    'damage' => [
      'add_damage' => 'Add Damage',
      'show_damage' => 'Show Damage',
      'edit_damage' => 'Edit Damage',
      'delete_damage' => 'Delete Damage',
    ],
    'quotation' => [
      'add_quotation' => 'Add Quotation',
      'show_quotation' => 'Show Quotation',
      'edit_quotation' => 'Edit Quotation',
      'delete_quotation' => 'Delete Quotation',
    ],

    'user' => [
      'add_user' => 'Add User',
      'show_user' => 'Show User',
      'edit_user' => 'Edit User',
      'delete_user' => 'Delete User',
    ],
    'role' => [
      'add_role' => 'Add Role',
      'show_role' => 'Show Role',
      'update_role' => 'Update Role',
      'delete_role' => 'Delete Role',
    ],
    'permission' => [
      'show_permission' => 'Show Permission',
      'edit_permission' => 'Edit Permission',
    ],
    'employee' => [
      'add_employee' => 'Add Employee',
      'show_employee' => 'Show Employee',
      'update_employee' => 'Update Employee',
      'delete_employee' => 'Delete Employee',
    ],
    'deposit' => [
      'add_deposit' => 'Add Deposit',
      'show_deposit' => 'Show Deposit',
      'edit_deposit' => 'Edit Deposit',
      'delete_deposit' => 'Delete Deposit',
    ],
    'withdraw' => [
      'add_withdraw' => 'Add Withdraw',
      'show_withdraw' => 'Show Withdraw',
      'edit_withdraw' => 'Update Withdraw',
      'delete_withdraw' => 'Delete Withdraw',
    ],
    'Database-Backup' => [
      'show_backup' => 'Show Backup',
      'take_backup' => 'Take Backup',
    ],
    'Report' => [
      'sale_report' => 'Sale Report',
      'order_report' => 'Order Report',
      'customer_order_report' => 'Customer Order Report',
      'product_order_report' => 'Product Order Report',
      'most_less_order_product_report' => 'Most Less Order Product Report',
      'balance_sheet' => 'Balance Sheet',
      'daily_summary_report' => 'Daily Summary Report',
      'stock_report' => 'Stock Report',
      'low_stock_report' => 'Low Stock Report',
      'supplier_ledger' => 'Supplier Ledger',
      'supplier_due_report' => 'Supplier Due Report',
      'attendance_report' => 'Attendance Report',
      'purchase_report' => 'Purchase Report',
      'product_purchase_report' => 'Product Purchase Report',
      'expense_report' => 'Expense Report',
      'damage_report' => 'Damange Report',
      'tax_report' => 'Tax Report',
    ],
    'My-Profile' => [
      'change_profile' => 'Change Profile',
      'change_password' => 'Change Password',
    ],
  ];
}


function redirect_back()
{
  redirect($_SERVER['HTTP_REFERER']);

  $CI = &get_instance();
  $CI->load->library('user_agent');
  if ($CI->agent->is_referral()) {
    echo $CI->agent->referrer();
  }
}

function is_administrator($role)
{
  return $role == 'administrator' ? true : false;
}


function role_has_permission($item, $role)
{
  $CI = &get_instance();
  if (!$CI->session->has_userdata('user_id')) {
    redirect('Authentication/index');
  }
  if (is_administrator($role)) {
    return true;
  };
  $file = "./application/user_access/{$role}.json";
  if (!file_exists($file)) {
    return false;
  }
  $collection = json_decode(file_get_contents($file), true);
  if (!is_array($collection)) {
    return false;
  }
  return in_array($item, $collection) ? true : false;
}


function get_user_role()
{
  $CI = &get_instance();
  if (!$CI->session->has_userdata('user_id')) {
    redirect('Authentication/userProfile');
  }
  if ($CI->session->has_userdata('role_slug')) {
    return $CI->session->userdata('role_slug');
  }
  redirect('Authentication/userProfile');
}


function has_role($role)
{
  $get_role = get_user_role();
  $role = str_slug($role);
  return $get_role == $role ? true : false;
}


/**
 * @param mixed $item
 * @return bool
 */
function has_permission($item)
{
  $role = get_user_role();
  if (is_administrator($role)) {
    return true;
  };
  $file = "./application/user_access/{$role}.json";
  if (!file_exists($file)) {
    return false;
  }
  $collection = json_decode(file_get_contents($file), true);
  if (!is_array($collection)) {
    return false;
  }

  if (is_array($item)) {
    if (!empty(array_intersect($collection, $item))) {
      return true;
    } else {
      return false;
    }
  }

  return in_array($item, $collection) ? true : false;
}


function has_all_permission(array $item)
{
  $role = get_user_role();
  if (is_administrator($role)) {
    return true;
  };
  $file = "./application/user_access/{$role}.json";
  if (!file_exists($file)) {
    return false;
  }
  $collection = json_decode(file_get_contents($file), true);
  if (!is_array($collection)) {
    return false;
  }
  if (is_array($item)) {
    $result = array_intersect($collection, $item);
    if (count($item) == count($result)) {
      return true;
    }
  }
  return false;
}


function check_permission($item)
{
  $CI = &get_instance();
  $role = get_user_role();
  if (is_administrator($role)) {
    return true;
  };
  $file = "./application/user_access/{$role}.json";
  if (!file_exists($file)) {
    $CI->session->set_flashdata('error', lang("401 Unauthorized. You Don't have permission to operation this"));
    redirect('Authentication/userProfile');
  }
  $collection = json_decode(file_get_contents($file), true);
  if (!is_array($collection)) {
    return false;
  }

  if (is_array($item)) {
    if (!empty(array_intersect($collection, $item))) {
      return true;
    }
  } elseif (in_array($item, $collection)) {
    return true;
  }
  $CI->session->set_flashdata('error', lang("401 Unauthorized. You Don't have permission to operation this"));
  redirect('Authentication/userProfile');
}
