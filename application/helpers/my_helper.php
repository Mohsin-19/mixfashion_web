<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * return  characters to HTML entities.
 * @param string
 * @return string
 */
function escape_output($string)
{
  if ($string) {
    return htmlspecialchars_decode($string);
  } else {
    return '';
  }
}

function root_path($path = '')
{
  $path = $path ? "/$path" : '';
  return $_SERVER["DOCUMENT_ROOT"] . $path;
}

/**
 * @param string $key
 * @return string|null
 */
function customer($key = '')
{
  $CI = &get_instance();
  $customer = $CI->session->userdata('customer');
  if ($key) {
    return $customer->$key ?? '';
  }
  return null;
}

/**
 *  generate remember me _token
 */
function remember_me_generate($token = '_token')
{
  $CI = &get_instance();
  $CI->load->helper('cookie');
  $_token = md5('apacon' . microtime());
  set_cookie($token, $_token, 2419200); // four weeks
  return $_token;
}

/**
 * global check customer authentication
 */
function check_remember_login()
{
  $CI = &get_instance();
  $user_id = $CI->session->userdata('c_id');
  if (empty($user_id)) {
    $CI->load->helper('cookie');
    $remember_me = get_cookie('_token');
    if ($remember_me) {
      $remember_me = md5($remember_me);
      $customer = $CI->Landing_model->checkCustomerRememberMeToken(trim($remember_me));
      // dd($customer);
      if ($customer) {
        $return_data['c_id'] = $customer->id;
        $return_data['c_name'] = $customer->name ? $customer->name : 'Customer';
        $return_data['c_phone'] = $customer->phone;
        $return_data['c_address'] = $customer->address;
        $return_data['c_email'] = $customer->email;
        $return_data['is_otp_verified'] = 1;
        $CI->session->set_userdata($return_data);
        $CI->session->set_userdata(['customer' => $customer]);
      }
    }
  }
}


function check_remember_login_for_admin()
{
  $CI = &get_instance();
  $user_id = $CI->session->userdata('user_id');
  if (empty($user_id)) {
    $CI->load->helper('cookie');
    $remember_me = get_cookie('_token2');
    if ($remember_me) {
      $remember_me = md5($remember_me);
      $user_information = $CI->Authentication_model->check_remember_me_user(trim($remember_me));

      if ($user_information) {
        $company_info = $CI->Authentication_model->getCompanyInformation($user_information->company_id);
        $setting_info = getSiteSetting();

        //User Information
        $login_session = [
          'user_id' => $user_information->id,
          'language' => $user_information->language,
          'full_name' => $user_information->full_name,
          'phone' => $user_information->phone,
          'email_address' => $user_information->email_address,
          'role_name' => $user_information->role_name,
          'role_slug' => $user_information->role_slug,
          'photo' => $user_information->photo,
          'company_id' => $user_information->company_id,
          'outlet_id' => $company_info->outlet_id,
          'currency' => $setting_info->currency,
          'time_zone' => $setting_info->time_zone,
          'date_format' => $setting_info->date_format,
        ];
        //Set session
        $CI->session->set_userdata($login_session);
        $outlet_details = $CI->Common_model->getDataById($company_info->outlet_id, 'tbl_outlets');

        $outlet_id = $company_info->outlet_id;
        $outlet_session = array();
        $outlet_session['outlet_id'] = $company_info->outlet_id;
        $outlet_session['tax_is_gst'] = $outlet_details->tax_is_gst;
        $outlet_session['gst_state_code'] = $outlet_details->state_code;
        $outlet_session['outlet_name'] = $outlet_details->outlet_name;
        $outlet_session['address'] = $outlet_details->address;
        $outlet_session['phone'] = $outlet_details->phone;
        $outlet_session['collect_tax'] = $outlet_details->collect_tax;
        $outlet_session['tax_registration_no'] = $outlet_details->tax_registration_no;
        $outlet_session['invoice_print'] = $outlet_details->invoice_print;
        $outlet_session['print_format'] = $outlet_details->print_format;
        $outlet_session['invoice_footer'] = $outlet_details->invoice_footer;
        $outlet_session['pre_or_post_payment'] = $outlet_details->pre_or_post_payment;
        $outlet_session['sms_setting_check'] = $outlet_details->sms_setting_check;
        $outlet_session['qty_setting_check'] = $outlet_details->qty_setting_check;
        $outlet_session['invoice_logo'] = $outlet_details->invoice_logo;
        $outlet_session['product_modal_status'] = $outlet_details->product_modal_status;
        $CI->session->set_userdata($outlet_session);
      }
    }
  }
}


/**
 * @return mixed
 */
function customer_cart()
{
  $CI = &get_instance();
  $cart = $CI->session->userdata('cart');
  return json_decode(json_encode($cart));
}

/**
 * return custom table name column
 * @param string
 * @param int
 * @return string
 */
function getName($table_name, $id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT * FROM $table_name where `id`='$id'")->row();

  if ($information) {
    return escape_output($information->name);
  } else {
    return "N/A";
  }
}

/**
 * return user phone
 * @param int
 * @return string
 */
function getPhoneByUserId($id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT * FROM tbl_users where `id`='$id'")->row();

  if ($information) {
    return $information->phone;
  } else {
    return " ";
  }
}

/**
 * return user email address
 * @param string
 * @param int
 * @return string
 */
function getEmailByUserId($id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT * FROM tbl_users where `id`='$id'")->row();

  if ($information) {
    return escape_output($information->email_address);
  } else {
    return " ";
  }
}

/**
 * set notification sound if
 */
function setAllSoundSleepNotification()
{
  $data['sound_status'] = '1';
  $CI = &get_instance();
  $CI->db->update("tbl_notifications", $data);
}

/**
 * return number to string
 * @param int
 * @return string
 */
function numberToWritten($number)
{
  return "";
  /*  // _dd($number)
            list($integer, $fraction) = explode(".", (string) $number);

            $output = "";

            if ($integer{0} == "-")
            {
                $output = "negative ";
                $integer    = ltrim($integer, "-");
            }
            else if ($integer{0} == "+")
            {
                $output = "positive ";
                $integer    = ltrim($integer, "+");
            }

            if ($integer{0} == "0")
            {
                $output .= "zero";
            }
            else
            {
                $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
                $group   = rtrim(chunk_split($integer, 3, " "), " ");
                $groups  = explode(" ", $group);

                $groups2 = array();
                foreach ($groups as $g)
                {
                    $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});
                }

                for ($z = 0; $z < count($groups2); $z++)
                {
                    if ($groups2[$z] != "")
                    {
                        $output .= $groups2[$z] . convertGroup(11 - $z) . (
                            $z < 11
                            && !array_search('', array_slice($groups2, $z + 1, -1))
                            && $groups2[11] != ''
                            && $groups[11]{0} == '0'
                                ? " and "
                                : ", "
                            );
                    }
                }

                $output = rtrim($output, ", ");
            }

            if ($fraction > 0)
            {
                $output .= " point";
                for ($i = 0; $i < strlen($fraction); $i++)
                {
                    $output .= " " . convertDigit($fraction{$i});
                }
            }

            return ucwords($output);*/
}

/**
 * return convert group
 * @param string
 * @param int
 * @return string
 */
function convertGroup($index)
{
  switch ($index) {
    case 11:
      return " decillion";
    case 10:
      return " nonillion";
    case 9:
      return " octillion";
    case 8:
      return " septillion";
    case 7:
      return " sextillion";
    case 6:
      return " quintrillion";
    case 5:
      return " quadrillion";
    case 4:
      return " trillion";
    case 3:
      return " billion";
    case 2:
      return " million";
    case 1:
      return " thousand";
    case 0:
      return "";
  }
}

/**
 * return string from digit value
 * @param int
 * @param int
 * @param int
 * @return string
 */
function convertThreeDigit($digit1, $digit2, $digit3)
{
  $buffer = "";

  if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0") {
    return "";
  }

  if ($digit1 != "0") {
    $buffer .= convertDigit($digit1) . " hundred";
    if ($digit2 != "0" || $digit3 != "0") {
      $buffer .= " and ";
    }
  }

  if ($digit2 != "0") {
    $buffer .= convertTwoDigit($digit2, $digit3);
  } else if ($digit3 != "0") {
    $buffer .= convertDigit($digit3);
  }

  return $buffer;
}

/**
 * return string from digit value
 * @param int
 * @param int
 * @return string
 */
function convertTwoDigit($digit1, $digit2)
{
  if ($digit2 == "0") {
    switch ($digit1) {
      case "1":
        return "ten";
      case "2":
        return "twenty";
      case "3":
        return "thirty";
      case "4":
        return "forty";
      case "5":
        return "fifty";
      case "6":
        return "sixty";
      case "7":
        return "seventy";
      case "8":
        return "eighty";
      case "9":
        return "ninety";
    }
  } else if ($digit1 == "1") {
    switch ($digit2) {
      case "1":
        return "eleven";
      case "2":
        return "twelve";
      case "3":
        return "thirteen";
      case "4":
        return "fourteen";
      case "5":
        return "fifteen";
      case "6":
        return "sixteen";
      case "7":
        return "seventeen";
      case "8":
        return "eighteen";
      case "9":
        return "nineteen";
    }
  } else {
    $temp = convertDigit($digit2);
    switch ($digit1) {
      case "2":
        return "twenty $temp";
      case "3":
        return "thirty $temp";
      case "4":
        return "forty $temp";
      case "5":
        return "fifty $temp";
      case "6":
        return "sixty $temp";
      case "7":
        return "seventy $temp";
      case "8":
        return "eighty $temp";
      case "9":
        return "ninety $temp";
    }
  }
}

/**
 * return string from digit value
 * @param int
 * @return string
 */
function convertDigit($digit)
{
  switch ($digit) {
    case "0":
      return "zero";
    case "1":
      return "one";
    case "2":
      return "two";
    case "3":
      return "three";
    case "4":
      return "four";
    case "5":
      return "five";
    case "6":
      return "six";
    case "7":
      return "seven";
    case "8":
      return "eight";
    case "9":
      return "nine";
  }
}

/**
 * return string from number
 * @param int
 * @return string
 */
function numtostr($number)
{
  /**
   * can handel up to 999999999
   */
  $decimal = round($number - ($no = floor($number)), 2) * 100;
  $hundred = null;
  $digits_length = strlen($no);
  $i = 0;
  $str = array();
  $words = array(
    0 => '', 1 => 'one', 2 => 'two',
    3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
    7 => 'seven', 8 => 'eight', 9 => 'nine',
    10 => 'ten', 11 => 'eleven', 12 => 'twelve',
    13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
    16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
    19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
    40 => 'forty', 50 => 'fifty', 60 => 'sixty',
    70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
  );
  $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
  while ($i < $digits_length) {
    $divider = ($i == 2) ? 10 : 100;
    $number = floor($no % $divider);
    $no = floor($no / $divider);
    $i += $divider == 10 ? 1 : 2;
    if ($number) {
      $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
      $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
      @$str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
    } else $str[] = null;
  }
  $taka = implode('', array_reverse($str));
  $paise = ($decimal > 0) ? "point " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . '' : '';
  return ucwords($taka ? $taka . '' : '') . ucwords($paise);
}

/**
 * return custom row
 * @param string
 * @param int
 * @return string
 */
function getDetails($table_name, $id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT * FROM $table_name where `id`='$id'")->row();

  if ($information) {
    return $information;
  } else {
    return "";
  }
}

/**
 * return total row
 * @param int
 * @return int
 */
function totalUsers($company_id)
{
  $CI = &get_instance();
  $total_users = $CI->db->query("SELECT * FROM tbl_users where `company_id`='$company_id'")->num_rows();
  return $total_users;
}

/**
 * return user name
 * @param int
 * @return string
 */
function userName($user_id)
{
  $CI = &get_instance();
  $user_information = $CI->db->query("SELECT * FROM tbl_users where `id`='$user_id'")->row();
  if ($user_information) {
    return escape_output($user_information->full_name);
  } else {
    return "";
  }
}

/**
 * return custom row
 * @param string
 * @param int
 * @return string
 */
function getCustomerName($customer_id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT * FROM tbl_customers where `id`='$customer_id'")->row();

  if ($information) {
    return escape_output($information->name);
  } else {
    return "";
  }
}

/**
 * return customer information
 * @param int
 * @return mixed
 */
function getCustomerData($customer_id)
{
  $CI = &get_instance();
  return $CI->db->query("SELECT * FROM tbl_customers where id='{$customer_id}'")->row();
  // return $CI->db->query("SELECT * FROM tbl_customer_address where customer_id ='{$customer_id}'")->row();
}

function getOrderItems($order_id)
{
  $CI = &get_instance();
  return $CI->Common_model->getOrderItems($order_id);
}

/**
 * return access module main name
 * @param int
 * @return string
 */
if (!function_exists('getMainModuleName')) {
  function getMainModuleName($id)
  {
    $CI = &get_instance();
    $CI->db->select("*");
    $CI->db->from("tbl_main_modules");
    $CI->db->where("id", $id);
    $result = $CI->db->get()->row();
    if ($result) {
      return escape_output($result->name);
    } else {
      return '';
    }
  }
}

/**
 * return supplier name
 * @param int
 * @return string
 */
function getSupplierName($supplier_id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT * FROM tbl_suppliers where `id`='$supplier_id'")->row();

  if ($information) {
    return escape_output($information->name);
  } else {
    return "";
  }
}

/**
 * return category name
 * @param int
 * @return string
 */
function getCategoryName($cat_id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT * FROM tbl_product_categories where `id`='$cat_id'")->row();

  if ($information) {
    return escape_output($information->name);
  } else {
    return "";
  }
}

/**
 * return sub category name
 * @param int
 * @return string
 */
function getSubCategoryName($cat_id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT * FROM tbl_product_sub_categories where `id`='$cat_id'")->row();

  if ($information) {
    return escape_output($information->name);
  } else {
    return "";
  }
}

/**
 * return product name
 * @param int
 * @param int
 * @param int
 * @return string
 */
function getSubCatRow($product_id, $category_id, $sub_cat_id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT * FROM tbl_products where `id`='$product_id' AND `category_id`='$category_id' AND `subcategory_id`='$sub_cat_id' AND `del_status`='Live'")->row();

  if ($information) {
    return escape_output($information->name);
  } else {
    return "";
  }
}

/**
 * check access module
 * @param int
 * @return boolean
 */
if (!function_exists('checkAccess')) {
  function checkAccess($controller, $function)
  {
    $CI = &get_instance();
    $role = $CI->session->userdata('role');
    if ($role == "Admin") {
      return true;
    } else {
      $controllerFunction = $function . "-" . $controller;
      $arr = $CI->session->userdata("function_access");
      if (isset($arr) && $arr) {
        if (!in_array($controllerFunction, $CI->session->userdata("function_access"))) {
          return false;
        } else {
          return true;
        }
      } else {
        return false;
      }
    }
  }
}
/**
 * return purchase reference no
 * @param int
 * @return string
 */
function getPurchaseInvoiceNo($purchase_id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT reference_no FROM tbl_purchase where `id`='$purchase_id'")->row();

  if ($information) {
    return $information->reference_no;
  } else {
    return "";
  }
}

/**
 * return Yes, if code available otherwise No
 * @param string
 * @return string
 */
function checkItemUnique($code)
{
  $CI = &get_instance();
  // $information = $CI->db->query("SELECT id FROM tbl_products where `code`='$code' and del_status='Live'")->row();
  $information = $CI->db->query("SELECT id FROM tbl_products where `code`='$code'")->row();
  return $information ? 'Yes' : 'No';
}

/**
 * return customer due amount
 * @param int
 * @return string
 */
function getCustomerDue($customer_id)
{
  $CI = &get_instance();
  $due_tmp = 0;
  $due_tmp1 = 0;
  $remaining_due = $due_tmp - $due_tmp1;
  return $remaining_due;
}

/**
 * return supplier due amount
 * @param int
 * @return string
 */
function getSupplierDue($supplier_id)
{
  $CI = &get_instance();
  $outlet_id = $CI->session->userdata('outlet_id');
  $supplier_due = $CI->db->query("SELECT SUM(due) as due FROM tbl_purchase WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live'")->row();
  $supplier_payment = $CI->db->query("SELECT SUM(amount) as amount FROM tbl_supplier_payments WHERE supplier_id=$supplier_id and outlet_id=$outlet_id and del_status='Live'")->row();
  $remaining_due = $supplier_due->due - $supplier_payment->amount;
  return $remaining_due;
}

/**
 * return customer information
 * @param int
 * @return string
 */
function getCustomer($customer_id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT * FROM tbl_customers where `id`='$customer_id'")->row();

  if ($information) {
    return $information;
  } else {
    return "";
  }
}

/**
 * return expense item name
 * @param int
 * @return string
 */
function expenseItemName($id)
{
  $CI = &get_instance();
  $expense_product_information = $CI->db->query("SELECT * FROM tbl_expense_products where `id`='$id'")->row();

  if ($expense_product_information) {
    return escape_output($expense_product_information->name);
  } else {
    return "";
  }
}

/**
 * return user name
 * @param int
 * @return string
 */
function employeeName($id)
{
  $CI = &get_instance();
  $employee_information = $CI->db->query("SELECT * FROM tbl_users where `id`='$id'")->row();

  if (!empty($employee_information)) {
    return escape_output($employee_information->full_name);
  } else {
    return "N/A";
  }
}

/**
 * return total order amount
 * @param int
 * @return string
 */
function getTotalValue($id)
{
  $CI = &get_instance();
  $total_order = $CI->db->query("SELECT count(id) as total_order FROM tbl_orders where `customer_id`='$id' AND del_status = 'Live'")->row();
  $v1 = 0;
  if ($total_order) {
    $v1 = $total_order->total_order;
  }

  $cancel_order = $CI->db->query("SELECT count(id) as total_cancel FROM tbl_orders where `customer_id`='$id' AND status = 'Cancel' AND del_status = 'Live'")->row();
  $v2 = 0;
  if ($total_order) {
    $v2 = $cancel_order->total_cancel;
  }

  $order_amount = $CI->db->query("SELECT sum(total_amount) as total_amount FROM tbl_orders where `customer_id`='$id' AND del_status = 'Live'")->row();
  $v3 = 0;
  if ($total_order) {
    $v3 = $order_amount->total_amount;
  }

  $last_order = $CI->db->query("SELECT * FROM tbl_orders where `customer_id`='$id' AND del_status = 'Live' ORDER BY id DESC")->row();
  $v4 = '';
  if ($last_order) {
    $v4 = date($CI->session->userdata('date_format'), strtotime($last_order->delivery_date));
  }
  return [$v1, $v2, $v3, $v4];
}

/**
 * return cateogry name
 * @param int
 * @return string
 */
function categoryName($category_id)
{
  $CI = &get_instance();
  $category_information = $CI->db->query("SELECT * FROM tbl_product_categories where `id`='$category_id'")->row();
  if ($category_information) {
    return escape_output($category_information->name);
  } else {
    return "";
  }
}

/**
 * return category name
 * @param int
 * @return string
 */
function productCategoryName($category_id)
{
  $CI = &get_instance();
  $category_information = $CI->db->query("SELECT * FROM tbl_product_categories where `id`='$category_id'")->row();
  if ($category_information) {
    return escape_output($category_information->name);
  } else {
    return "N/A";
  }
}

/**
 * return order number
 * @param int
 * @return string
 */
function getRowByOrderNo($order_id)
{
  $CI = &get_instance();
  $category_information = $CI->db->query("SELECT * FROM tbl_orders where `order_number`='$order_id'")->row();
  if ($category_information) {
    return $category_information->id;
  } else {
    return "";
  }
}

function getCoupon($order_id)
{
  $CI = &get_instance();
  $category_information = $CI->db->query("SELECT * FROM tbl_coupons inner join tbl_coupon_customer on tbl_coupon_customer.coupon_id = tbl_coupons.id  where  tbl_coupon_customer.order_id={$order_id}")->row();
  if ($category_information) {
    return $category_information->code;
  } else {
    return "";
  }
}

function getRowDetailsByOrderNo($order_id)
{
  $CI = &get_instance();
  $category_information = $CI->db->query("SELECT * FROM tbl_orders where order_number='{$order_id}'")->row();
  if ($category_information) {
    return $category_information;
  } else {
    return "";
  }
}

/**
 * @param $data
 */
function dd($data)
{
  echo '<pre>';
  print_r($data);
  echo '</pre>';
  die();
}


function request($input, $default = '')
{
  $CI = &get_instance();
  $data = $CI->input->post($input);
  return $data ? $data : $default;
}

function request_get($input, $default = '')
{
  $CI = &get_instance();
  $data = $CI->input->get($input);
  return $data ? $data : $default;
}

function setCouponUsed($code, $order_id)
{
  $CI = &get_instance();
  $code = $CI->db->query("SELECT * FROM tbl_coupons where code='{$code}'")->row();
  $amount = 0;
  if ($code) {
    $selected_date = $code->expired_date;
    $current_date = date("Y-m-d");
    $amount = $code->amount;
    $coupon_id = $code->id;
    $customer_id = customer('id');
    $data = [
      'order_id' => $order_id,
      'coupon_id' => $coupon_id,
      'customer' => $customer_id,
      'del_status' => 'Live',
    ];
    // $userCoupon = $CI->Common_model->checkCouponUse($coupon_id, $customer_id);
    // if (is_null($userCoupon)) {
    //   statement will go
    // }
    $CI->db->insert("tbl_coupon_customer", $data);
    return $CI->db->insert_id();
  }
  return $amount;
}

function setUnused($order_id)
{
  $CI = &get_instance();
  $data = array();
  $data['is_complete'] = "0";
  $data['customer'] = "";
  $data['coupon_id'] = "";
  // $CI->db->where('order_id', $order_id);
  // $CI->db->update("tbl_coupon_customer", $data);
}

function updateOrder($order_id)
{
  $CI = &get_instance();
  $data = array();
  $data['del_status'] = "Live";
  $CI->db->where('id', $order_id);
  $CI->db->update("tbl_orders", $data);
}

/**
 * return order number
 * @param int
 * @return int
 */
function getRowByOrderID($id)
{
  $CI = &get_instance();
  $category_information = $CI->db->query("SELECT * FROM tbl_orders where `id`='$id'")->row();
  if ($category_information) {
    return $category_information->order_number;
  } else {
    return "";
  }
}

/**
 * return product name
 * @param int
 * @return string
 */
function foodMenuName($id)
{
  $CI = &get_instance();
  $food_information = $CI->db->query("SELECT * FROM tbl_products where `id`='$id'")->row();

  if ($food_information) {
    return escape_output($food_information->name);
  } else {
    return "";
  }
}

/**
 * return product code
 * @param int
 * @return string
 */
function foodMenuNameCode($id)
{
  $CI = &get_instance();
  $food_information = $CI->db->query("SELECT * FROM tbl_products where `id`='$id'")->row();

  if (!empty($food_information)) {
    return "(" . $food_information->code . ")";
  } else {
    return '';
  }
}

/**
 * return unit name
 * @param int
 * @return string
 */
function unitName($unit_id)
{
  $CI = &get_instance();
  $unit_information = $CI->db->query("SELECT * FROM tbl_units where `id`='$unit_id'")->row();

  if (!empty($unit_information)) {
    return escape_output($unit_information->unit_name);
  } else {
    return '';
  }
}

/**
 * return payment name
 * @param int
 * @return string
 */
function getPaymentName($id)
{
  $CI = &get_instance();
  $getPaymentName = $CI->db->query("SELECT * FROM tbl_payment_methods where `id`='$id'")->row();
  if ($getPaymentName) {
    return escape_output($getPaymentName->name);
  } else {
    return '';
  }
}

/**
 * return total alert product
 * @return int
 */
function getAlertCount()
{
  $CI = &get_instance();
  $result = $CI->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live' ORDER BY i.name ASC")->result();
  $alertCount = 0;
  foreach ($result as $value) {
    $totalStock = ($value->total_purchase * $value->conversion_rate) - $value->total_damage - $value->total_order + $value->opening_stock;
    if ($totalStock <= $value->alert_quantity) {
      $alertCount++;
    }
  }
  return $alertCount;
}

/**
 * return current stock
 * @param int
 * @return string
 */
function getCurrentStock($product_id)
{
  $CI = &get_instance();
  $where = '';
  if ($product_id != '') {
    $where .= "  AND i.id = '$product_id'";
  }
  $result = $CI->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live'  $where ORDER BY i.name ASC")->row();

  if ($result) {
    $totalStock = $result->opening_stock + ($result->total_purchase * $result->conversion_rate) - $result->total_sale - $result->total_damage;
    if ($totalStock && $totalStock > 0) {
      return ($totalStock . " " . $result->sale_unit_name);
    } else {
      return "0";
    }
  } else {
    return "0";
  }
}

/**
 * return current stock only
 * @param int
 * @return string
 */
function getCurrentStockOnly($product_id)
{
  $CI = &get_instance();
  $where = '';
  if ($product_id != '') {
    $where .= "  AND i.id = '$product_id'";
  }
  $result = $CI->db->query("SELECT i.*,i.name as product_name, i.purchase_price as last_purchase_price, sum_tbl.total_purchase,damage_tbl.total_damage,order_tbl.total_order,cat_tbl.name as product_category_name,unit_p_tbl.unit_name as purchse_unit_name,unit_s_tbl.unit_name as sale_unit_name
FROM tbl_products i
LEFT JOIN (select product_id, SUM(quantity_amount) as total_purchase from tbl_purchase_details where del_status='Live' group by product_id) sum_tbl ON sum_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(damage_amount) as total_damage from tbl_damage_details where del_status='Live' group by product_id) damage_tbl ON damage_tbl.product_id = i.id
LEFT JOIN (select product_id, SUM(qty) as total_order from tbl_order_items where del_status='Live' AND tbl_order_items.order_status!='c' group by product_id) order_tbl ON order_tbl.product_id = i.id
LEFT JOIN (select id,name from tbl_product_categories where del_status='Live') cat_tbl ON cat_tbl.id = i.category_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_s_tbl ON unit_s_tbl.id = i.sale_unit_id
LEFT JOIN (select id,unit_name from tbl_units where del_status='Live') unit_p_tbl ON unit_p_tbl.id = i.purchase_unit_id
WHERE i.del_status='Live'  $where ORDER BY i.name ASC")->row();

  if ($result) {
    $totalStock = ($result->total_purchase * $result->conversion_rate) - $result->total_damage - $result->total_order + $result->opening_stock;
    if ($totalStock && $totalStock > 0) {
      return $totalStock;
    } else {
      return 0;
    }
  } else {
    return 0;
  }
}

/**
 * return collect GST
 * @return string
 */
function collectGST()
{
  $CI = &get_instance();
  $company_id = $CI->session->userdata('company_id');
  $outlet_id = $CI->session->userdata('outlet_id');
  if ($outlet_id) {
    $outlet_info = $CI->db->query("SELECT * FROM tbl_outlets where `id`='$outlet_id'")->row();
    return $outlet_info->tax_is_gst;
  } else {
    return "No";
  }
}

/**
 * check existing salary
 * @param int
 * @param int
 * @return boolean
 */
function checkExistingSalary($month, $year)
{
  $CI = &get_instance();
  $info = $CI->db->query("SELECT * FROM tbl_salaries where `month`='$month' AND `year`='$year' AND `del_status`='Live'")->row();
  if ($info) {
    return true;
  } else {
    return false;
  }
}

//SELECT * from sma_sales  desc limit 1
function getSiteSetting()
{
  $CI = &get_instance();
  $CI->db->select("*");
  $CI->db->from("tbl_site_setting");
  $CI->db->order_by("id", "DESC");
  $CI->db->limit(1);
  return $CI->db->get()->row();
}

//SELECT * from sma_sales  desc limit 1
function getShopSetting()
{
  $CI = &get_instance();
  $CI->db->select("*");
  $CI->db->from("tbl_outlets");
  $CI->db->order_by("id", "DESC");
  $CI->db->limit(1);
  return $CI->db->get()->row();
}

//SELECT * from sma_sales  desc limit 1
function getSMTPSetting()
{
  $CI = &get_instance();
  $CI->db->select("*");
  $CI->db->from("tbl_smtp_setting");
  $CI->db->order_by("id", "DESC");
  $CI->db->limit(1);
  return $CI->db->get()->row();
}

//SELECT * from sma_sales  desc limit 1
function paymentSetting()
{
  $CI = &get_instance();
  $CI->db->select("*");
  $CI->db->from("tbl_payment_setting");
  $CI->db->order_by("id", "DESC");
  $CI->db->limit(1);
  return $CI->db->get()->row();
}

//SELECT * from sma_sales  desc limit 1
function getSMSSetting()
{
  $CI = &get_instance();
  $CI->db->select("*");
  $CI->db->from("tbl_sms_setting");
  $CI->db->order_by("id", "DESC");
  $CI->db->limit(1);
  return $CI->db->get()->row();
}

/**
 * return product name
 * @param int
 * @return string
 */
function getItemNameById($id)
{
  $CI = &get_instance();
  $ig_information = $CI->db->query("SELECT * FROM tbl_products where `id`='$id'")->row();
  if (!empty($ig_information)) {
    return escape_output($ig_information->name);
  } else {
    return '';
  }
}

/**
 * return product item code
 * @param int
 * @return string
 */
function getItemCodeById($id)
{
  $CI = &get_instance();
  $ig_information = $CI->db->query("SELECT * FROM tbl_products where `id`='$id'")->row();

  if ($ig_information) {
    return $ig_information->code;
  } else {
    return "";
  }
}

/**
 * close the delivery person item
 * @param int
 * @return int
 */
function getClosingAmount($id)
{
  $CI = &get_instance();
  $data = $CI->db->query("SELECT * FROM tbl_delivery_person_items where del_status = 'Live' AND `del_p_id`='$id'")->result();
  $return_amount = 0;
  foreach ($data as $value) {
    if ($value->item_name == "Opening Cash") {
      $return_amount += $value->amount;
    } else if ($value->item_name == "Expense") {
      $return_amount -= $value->amount;
    } else if ($value->item_name == "Purchase") {
      $return_amount -= $value->amount;
    } else if ($value->item_name == "Delivery") {
      $return_amount += $value->amount;
    }
  }
  return $return_amount;
}

/**
 * check delivery person data
 * @param int
 * @param int
 * @return boolean
 */
function checkDelData($id, $delivery_person_id)
{
  $CI = &get_instance();
  $data = $CI->db->query("SELECT * FROM tbl_delivery_persons where del_status = 'Live' AND `delivery_person_id`='$delivery_person_id' AND `id`='$id'")->row();
  if ($data) {
    return true;
  } else {
    return false;
  }
}

/**
 * generate order number and return
 * @return string
 */
function getOrderId()
{
  $CI = &get_instance();
  $count = $CI->db->query("SELECT count(id) as count
               FROM tbl_orders")->row('count');
  $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
  return $code;
}

function getItemConversionRateById($id)
{
  $CI = &get_instance();
  $ig_information = $CI->db->query("SELECT * FROM tbl_products where `id`='$id'")->row();

  if ($ig_information) {
    return $ig_information->conversion_rate;
  } else {
    return "";
  }
}

/**
 * return supplier name
 * @param int
 * @return string
 */
function getSupplierNameById($supplier_id)
{
  $CI = &get_instance();
  $supplier_information = $CI->db->query("SELECT * FROM tbl_suppliers where `id`='$supplier_id'")->row();

  if ($supplier_information) {
    return escape_output($supplier_information->name);
  } else {
    return "";
  }
}

/**
 * check sms config yes or not
 * @return string
 */
function getSMSEmailConfig()
{
  $CI = &get_instance();
  $sms_config = $CI->db->query("SELECT * FROM tbl_sms_settings where `id`='1'")->row();
  $return_output = array();
  if ($sms_config) {
    return $return_output['sms_config'] = 'yes';
  } else {
    return $return_output['sms_config'] = 'no';
  }
}

/**
 * return purchase unit id
 * @param int
 * @return int
 */
function getUnitIdByIgId($id)
{
  $CI = &get_instance();
  $ig_information = $CI->db->query("SELECT * FROM tbl_products where `id`='$id'")->row();
  if (!empty($ig_information)) {
    return $ig_information->purchase_unit_id;
  } else {
    return '';
  }
}

/**
 * return sale unit id
 * @param int
 * @return int
 */
function getSaleUnitIdByIgId($id)
{
  $CI = &get_instance();
  $ig_information = $CI->db->query("SELECT sale_unit_id FROM tbl_products where `id`='$id'")->row();
  if (!empty($ig_information)) {
    return $ig_information->sale_unit_id;
  } else {
    return '';
  }
}

function count_order_items($order_id)
{
  $CI = &get_instance();
  $ig_information = $CI->db->query("SELECT count(*) as total FROM tbl_order_items where `order_id`='$order_id'")->row();
  return $ig_information ? $ig_information->total : 0;
}

/**
 * return last purchase price
 * @param int
 * @return int
 */
function getLastPurchaseAmount($id)
{
  $CI = &get_instance();
  $purchase_products = $CI->db->query("SELECT * FROM tbl_purchase_details where `product_id`='$id' and del_status='Live' ORDER BY id DESC")->row();
  if (!empty($purchase_products)) {
    $returnPrice = $purchase_products->unit_price;
  } else {
    $product_information = $CI->db->query("SELECT * FROM tbl_products where `id`='$id'")->row();
    if (!empty($product_information)) {
      $returnPrice = $product_information->purchase_price;
    } else {
      $returnPrice = 0.0;
    }
  }
  return $returnPrice;
}

/**
 * check purchase items
 * @param int
 * @return string
 */
function getPurchaseIngredients($id)
{
  $CI = &get_instance();
  $purchase_products = $CI->db->query("SELECT * FROM tbl_purchase_details where `purchase_id`='$id'")->result();

  if (!empty($purchase_products)) {

    $pur_ingr_all = "";
    $key = 1;

    $pur_ingr_all .= "<b>SN-Item-Qty/Amount-Unit Price-Total</b><br>";
    foreach ($purchase_products as $value) {
      $pur_ingr_all .= $key . "-" . getItemNameById($value->product_id) . "-" . $value->quantity_amount . "-" . $value->unit_price . "-" . $value->total . "<br>";
      $key++;
    }
    return $pur_ingr_all;
  } else {
    return "Not found!";
  }
}

/**
 * return last purchase price
 * @param int
 * @return int
 */
function getLastPurchasePrice($product_id)
{
  $CI = &get_instance();
  $purchase_info = $CI->db->query("SELECT *
    FROM tbl_purchase_details
    WHERE product_id = $product_id
    ORDER BY id DESC
    LIMIT 1")->row();

  if (!empty($purchase_info)) {
    return $purchase_info->unit_price;
  } else {
    $ig_information = $CI->db->query("SELECT * FROM tbl_products where `id`='$product_id'")->row();

    return $ig_information->purchase_price;
  }
}

/**
 * return product count
 * @param int
 * @return int
 */
function productCount($id)
{
  $CI = &get_instance();
  $product_count = $CI->db->query("SELECT COUNT(*) AS product_count
    FROM tbl_damage_details
    WHERE damage_id = $id")->row();

  return $product_count->product_count;
}

/**
 *  inventory adjustment count and return
 * @param int
 * @return int
 */
function productCountInvAdj($id)
{
  $CI = &get_instance();
  $product_count = $CI->db->query("SELECT COUNT(*) AS product_count
    FROM tbl_inventory_adjustment_details
    WHERE inventory_adjustment_id = $id")->row();

  return $product_count->product_count;
}

/**
 *  return company details
 * @param int
 * @return string
 */
function companyInformation($company_id)
{
  $CI = &get_instance();
  $company_info = $CI->db->query("SELECT * FROM tbl_companies where `id`='$company_id'")->row();

  return $company_info;
}


/**
 * get different date format
 */
function findDate($date)
{
  //$query1=mysql_query("SELECT date_format FROM company_info where id='1'");
  //$row=mysql_fetch_array($query1);
  $format = null;
  if ($date == '') {
    return '';
  } else {
    $format = 'd/m/Y';
  }
  return date($format, strtotime($date));
}

/////////////////// alterDateFormat////////////////
function alterDateFormat($date)
{
  $query1 = mysql_query("SELECT date_format FROM company_info where id='1'");
  $row = mysql_fetch_array($query1);
  $format = null;
  if ($date != "") {
    $dateSlug = explode('/', $date);
    //return $dateSlug[2].'-'.$dateSlug[1].'-'.$dateSlug[0];
    switch ($row['date_format']) {
      case 'dd/mm/yyyy':
        $format = $dateSlug[2] . '-' . $dateSlug[1] . '-' . $dateSlug[0];
        break;
      case 'mm/dd/yyyy':
        $format = $dateSlug[2] . '-' . $dateSlug[0] . '-' . $dateSlug[1];
        break;
      case 'yyyy/mm/dd':
        $format = $dateSlug[0] . '-' . $dateSlug[1] . '-' . $dateSlug[2];
        break;
      default:
        $format = $dateSlug[2] . '-' . $dateSlug[1] . '-' . $dateSlug[0];
        break;
    }
    return $format;
  } else {
    return "0000-00-00 00:00:00";
  }
}

/**
 * return supplier due payment
 * @param int
 * @return int
 */
function getSupplierDuePayment($supplier_id)
{
  $CI = &get_instance();
  $information = $CI->db->query("SELECT sum(amount) as amount FROM tbl_supplier_payments where `supplier_id`='$supplier_id' and del_status='Live'")->row();
  return $information->amount;
}

/**
 *  search ' and replace blank
 * @param string
 * @return string
 */
function escapeQuot($str)
{
  return str_replace("'", "", $str);
}

/**
 *  send sms for onnorokom sms configuration
 * @param int
 */
function sendOnnoSMS($username, $password, $txt, $phone)
{

  // 
}

function mim_sms($txt, $phone)
{
  try {
      $url = "https://bulk.mimsms.com/smsapi";
       $data = [
        "api_key" => "C200197462fca510b9fc13.27097162",
        "type" => "text",
        "contacts" => $phone,
        "senderid" => "8809612444006",
        "msg" => $txt,
      ];
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $response = curl_exec($ch);
      curl_close($ch);
      return $response;
    } catch (\Throwable $th) {
      throw $th;
    }

  // $url = "https://esms.mimsms.com/smsapi";
  // $data = [
  //   "api_key" => "C20068525f3fdb9a66e121.16607539",
  //   "type" => "text",
  //   "contacts" => "$phone",
  //   "senderid" => "8809612446205",
  //   "msg" => "$txt",
  // ];
  // $ch = curl_init();
  // curl_setopt($ch, CURLOPT_URL, $url);
  // curl_setopt($ch, CURLOPT_POST, 1);
  // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  // $response = curl_exec($ch);
  // curl_close($ch);
  // return $response;
  /*
          try{
              $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
              $paramArray = array(
                  'userName' => $username,
                  'userPassword' => $password,
                  'messageText' => $txt,
                  'numberList' => $phone,
                  'smsType' => "TEXT",
                  'maskName' => '',
                  'campaignName' => '',
              );
              $soapClient->__call("OneToMany", array($paramArray));
          } catch (Exception $e) {
          }*/
}


function sendSSL_WareSMS($txt, $phone)
{
  return ssl_isms($txt, $phone);
  // return mim_sms($txt, $phone);
}

function ssl_isms($txt, $phone)
{
  $msisdn = $phone;
  $messageBody = $txt;
  $csmsId = uniqid(); // csms id must be unique

  $status = singleSms($msisdn, $messageBody, $csmsId);
  // dd($status);
  $decode = json_decode($status, true);
  // dd($decode);
  if (is_array($decode)) {
    if (key_exists('status', $decode)) {
      if ($decode['status'] != 'FAILED') {
        return true;
      }
    }
  }
  return false;
}


/**
 *  get dynamically domain name and return
 * @param string
 * @return string
 */
function getDomain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : '';
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    $tmp = explode('.', $regs['domain']);
    return ucfirst($tmp[0]);
  }
  return FALSE;
}

/**
 * send text local sms
 * @param string
 * @param string
 * @param string
 * @param string
 * @param string
 * @param string
 */
function sendLocalSMS($username, $password, $txt, $phone, $sender, $apikey)
{
  $CI = &get_instance();
  $CI->load->library('setupfile');
  $CI->setupfile->send($phone, $txt, $sender, $username, $password, $apikey);
}

if (!function_exists('sendEmailOnly')) {

  /**
   *  send email for smtp configuration
   * @param string
   * @param string
   * @param string
   * @param string
   * @param string
   * @param string
   * @param string
   * @return boolean
   */
  function sendEmailOnly($username, $password, $txt, $to_email, $attached = '', $sender_email, $subject)
  {
    try {
      $domain_name = getDomain(base_url());
      $form_url = 'info@shatkahonbd.com';
      $emailSetting = getSMTPSetting();
      $CI = &get_instance();

      $CI->load->library('email');
      $config = array(
        'protocol' => 'smtp',
        'smtp_host' => $emailSetting->host_name,
        'smtp_port' => $emailSetting->port_address,
        'smtp_user' => $username,
        'smtp_pass' => $password,
        'mailtype' => 'html',
        'charset' => 'iso-8859-1'
      );

      $CI->email->initialize($config);
      $CI->email->set_newline("\r\n");

      $CI->email->from($form_url, $domain_name);
      $CI->email->to($to_email, $sender_email);
      $CI->email->subject($subject);
      $CI->email->message($txt);
      //send mail
      if ($attached != '') {
        $CI->email->attach($attached);
      }

      if ($CI->email->send()) {
        return TRUE;
      } else {
        return FALSE;
      }
    } catch (Exception $e) {
      log_message('error', 'Email sending failed');
    }
    return FALSE;
  }
}

/**
 *  prepare the sms setting
 * @param string
 * @param string
 * @param string
 */
function smsSend($txt, $phone = '', $status)
{
  $smsSetting = getSMSSetting();
  if ($smsSetting->enable_status == 1) {
    /*1. status 1 is placeorder
                    2. status 2 is cancel order
                    3. status 3 is progress order
                    4. status 4 is deliverd order*/
    if ($status == 1) {
      if ($smsSetting->field_1 == 1) {
        if ($smsSetting->field_1_v) {
          $phone1 = getPhoneByUserId($smsSetting->field_1_v);
          sendOnnoSMS($smsSetting->user_name, $smsSetting->password, $txt, $phone1);
        }
      }
      if ($smsSetting->field_3 == 1) {
        if ($smsSetting->field_3_v == "Yes") {
          $status = sendSSL_WareSMS($txt, $phone);
        }
      }
    } elseif ($status == 2) {
      if ($smsSetting->field_2 == 1) {
        if ($smsSetting->field_2_v) {
          $phone1 = getPhoneByUserId($smsSetting->field_2_v);
          $status = sendSSL_WareSMS($txt, $phone);
        }
      }

      if ($smsSetting->field_6 == 1) {
        if ($smsSetting->field_6_v == "Yes") {
          $status = sendSSL_WareSMS($txt, $phone);
        }
      }
    } elseif ($status == 3) {
      if ($smsSetting->field_4 == 1) {
        if ($smsSetting->field_4_v == "Yes") {
          $status = sendSSL_WareSMS($txt, $phone);
        }
      }
    } elseif ($status == 4) {
      if ($smsSetting->field_5 == 1) {
        if ($smsSetting->field_5_v == "Yes") {
          $status = sendSSL_WareSMS($txt, $phone);
        }
      }
    }
  } elseif ($smsSetting->enable_status == 2) {
    if ($status == 1) {
      if ($smsSetting->field_1 == 1) {
        if ($smsSetting->field_1_v) {
          $phone1 = getPhoneByUserId($smsSetting->field_1_v);
          $status = sendSSL_WareSMS($txt, $phone1);
        }
      }
      if ($smsSetting->field_3 == 1) {
        if ($smsSetting->field_3_v == "Yes") {
          $status = sendSSL_WareSMS($txt, $phone);
        }
      }
    } elseif ($status == 2) {
      if ($smsSetting->field_2 == 1) {
        if ($smsSetting->field_2_v) {
          $phone1 = getPhoneByUserId($smsSetting->field_2_v);
          $status = sendSSL_WareSMS($txt, $phone);
        }
      }
      if ($smsSetting->field_6 == 1) {
        if ($smsSetting->field_6_v == "Yes") {
          $status = sendSSL_WareSMS($txt, $phone);
        }
      }
    } elseif ($status == 3) {
      if ($smsSetting->field_4 == 1) {
        if ($smsSetting->field_4_v == "Yes") {
          $status = sendSSL_WareSMS($txt, $phone);
        }
      }
    } elseif ($status == 4) {
      if ($smsSetting->field_5 == 1) {
        if ($smsSetting->field_5_v == "Yes") {
          $status = sendSSL_WareSMS($txt, $phone);
        }
      }
    }
  }
}

/**
 *  prepare the email setting
 * @param string
 * @param string
 * @param string
 */
function sendEmail($txt, $email, $attach = '', $status)
{
  $emailSetting = getSMTPSetting();
  $getSiteSetting = getSiteSetting();
  if ($emailSetting->enable_status == 1) {
    if ($status == 1) {
      if ($emailSetting->field_1 == 1) {
        if ($emailSetting->field_1_v) {
          $email1 = getEmailByUserId($emailSetting->field_1_v);
          sendEmailOnly($emailSetting->user_name, $emailSetting->password, $txt, $email1, $attach, $getSiteSetting->email, 'Order Placed');
        }
      }
      if ($emailSetting->field_3 == 1) {
        if ($emailSetting->field_3_v == "Yes") {
          sendEmailOnly($emailSetting->user_name, $emailSetting->password, $txt, $email, $attach, $getSiteSetting->email, 'Order Placed');
        }
      }
    } elseif ($status == 2) {
      if ($emailSetting->field_2 == 1) {
        if ($emailSetting->field_2_v) {
          $email1 = getEmailByUserId($emailSetting->field_2_v);
          sendEmailOnly($emailSetting->user_name, $emailSetting->password, $txt, $email1, $attach, $getSiteSetting->email, 'Order Canceled');
        }
      }
      if ($emailSetting->field_6 == 1) {
        if ($emailSetting->field_6_v == "Yes") {
          sendEmailOnly($emailSetting->user_name, $emailSetting->password, $txt, $email, $attach, $getSiteSetting->email, 'Order Canceled');
        }
      }
    } elseif ($status == 3) {
      if ($emailSetting->field_4 == 1) {
        if ($emailSetting->field_4_v == "Yes") {
          sendEmailOnly($emailSetting->user_name, $emailSetting->password, $txt, $email, $attach, $getSiteSetting->email, 'Order In Progress');
        }
      }
    } elseif ($status == 4) {
      if ($emailSetting->field_5 == 1) {
        if ($emailSetting->field_5_v == "Yes") {
          sendEmailOnly($emailSetting->user_name, $emailSetting->password, $txt, $email, $attach, $getSiteSetting->email, 'Order Delivered');
        }
      }
    }
  }
}

/**
 *  prepare the email setting
 * @param string
 * @param string
 * @param string
 */
function sendEmailWithPhoneNumber($txt, $email, $attach = '', $status)
{
  $emailSetting = getSMTPSetting();
  $getSiteSetting = getSiteSetting();
  if ($emailSetting->enable_status == 1) {

    if ($status == 1) {
      if ($emailSetting->field_1 == 1) {
        if ($emailSetting->field_1_v) {
          $email1 = getEmailByUserId($emailSetting->field_1_v);
          sendEmailOnly($emailSetting->user_name, $emailSetting->password, $txt, $email1, $attach, $getSiteSetting->email, 'For Any Query');
        }
      }
      if ($emailSetting->field_3 == 1) {
        if ($emailSetting->field_3_v == "Yes") {
          sendEmailOnly($emailSetting->user_name, $emailSetting->password, $txt, $email, $attach, $getSiteSetting->email, 'For Any Query');
        }
      }
    }
  }
}

function str_slug($text)
{
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  $text = strtolower($text);
  if (empty($text)) {
    return '#';
  }
  return $text;
}


function week_days_with_name()
{
  $currentTime = date('Y-m-d h:i a');
  $time = date('Y-m-d h:i a', strtotime('8:00am'));
  $endTime = date('Y-m-d h:i a', strtotime('4:00pm'));

  $today = false;
  $option = '';
  if (strtotime($currentTime) <= strtotime($endTime)) {
    $today = true;
    $option .= '<option value="' . $currentTime . '">' . date('d M', strtotime($currentTime)) . ', Today</option>';
  }

  foreach (range(1, 6) as $key => $day) {
    $date = date('Y-m-d h:i a', strtotime("+{$day} day"));
    $dayName = $day == 1 ? date('d M', strtotime($date)) . ", Tomorrow" : date('d M, l', strtotime($date));

    $option .= '<option value="' . $date . '">' . $dayName . '</option>';
  }
  return $option;
}

function cut_out_time($current = false)
{

  $currentTime = $current ? date('Y-m-d h:i a', strtotime($current)) : date('Y-m-d h:i a');

  $time = date('Y-m-d h:i a', strtotime('10:00am'));
  $endTime = date('Y-m-d h:i a', strtotime('4:00pm'));
  $option = '';

  $today = false;

  if (strtotime($currentTime) <= strtotime($endTime)) {
    $today = true;
  }


  $single = '<option value="5:00">5:00am - 7:00pm</option>';
  $double = '<option value="11:00">11:00am - 1:00pm</option><option value="5:00pm">5:00pm - 7:00pm</option>';

  //  $newTime = date('Y-m-d h:i a', strtotime($time) + 60 * 60 * 3);
  if ($today) {
    if (strtotime($time) < strtotime($currentTime)) {
      $option .= $single;
    } else {
      $option .= $double;
    }
  } else {
    $option .= $double;
  }

  return $option;
}


if (!function_exists('get_product_attributes')) {
  function get_product_attributes($product_id)
  {
    $CI = &get_instance();
    return $CI->AttributeModel->product_attributes($product_id);
  }
}
