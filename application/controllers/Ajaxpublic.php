<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Ajaxpublic extends Cl_Controller
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
    $this->load->model('Landing_model');
    $this->load->library('form_validation');
    $this->Common_model->setDefaultTimezone();
  }

  public function responseJson(array $array)
  {
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($array));
  }


  public function findCatProduct()
  {
    $cat_id = $this->input->post('p_id');
    $type = $this->input->post('type');
    // $offset = $this->input->post('offset');
    //        $limit = $this->input->post('limit');

    if ($cat_id) {
      $all_products = $this->Common_model->getCategoryProduct($cat_id, $type, 500, 0);

      $javascript_obects = "";
      $total_products = count($all_products);
      $i = 1;
      $getShopSetting = getShopSetting();

      foreach ($all_products as $key => $value) :

        $img_size = "images/" . $value->photo;
        if (file_exists($img_size) && $value->photo != "") {
          $image_path = base_url() . 'images/' . $value->photo;
        } else {
          $image_path = base_url() . 'assets/images/no_image_thumb.png';
        }

        $img_size_1 = "images/" . $value->details_modal_image;
        if (file_exists($img_size_1) && $value->details_modal_image != "") {
          $image_path1 = base_url() . 'images/' . $value->details_modal_image;
        } else {
          $image_path1 = $image_path;
        }

        $img_size = "images/" . $value->photo;
        if (file_exists($img_size) && $value->photo != "") {
          $image_path = base_url() . 'images/' . $value->photo;
        } else {
          $image_path = $image_path1;
        }

        $tax_info = json_decode($value->tax_information);
        $total_p = 0;
        $collect_tax = $getShopSetting->collect_tax;

        if (isset($collect_tax) && $collect_tax == "Yes") {
          foreach ($tax_info as $tax) {
            $total_p += $tax->tax_field_percentage;
          }
        }
        if ((int)$value->discount_price) :
          $card_price = $value->discount_price;
        else :
          $card_price = $value->sale_price;
        endif;

        //        $totalStock1 = ($value->total_purchase * $value->conversion_rate) - $value->total_damage - $value->total_order + $value->opening_stock;
        //        if ($totalStock1 && $totalStock1 > 0) {
        //          $current_stock = $totalStock1;
        //        } else {
        //          $current_stock = 0;
        //        }

        $current_stock = 2000; // make default current stock

        $percengtage = 0;
        $tmp_total = 0;
        if ((int)$value->discount_price) :
          $sale_price = $value->sale_price;
          $discount_price = $value->discount_price;
          $tmp_total = $sale_price - $discount_price;
          $percengtage = ($tmp_total / $value->sale_price) * 100;

        endif;

        $all_products[$key]->name = str_replace("'", "", ucfirst($value->name));
        $all_products[$key]->description = str_replace("'", "", $value->description);
        $all_products[$key]->offer = str_replace("'", "", $value->offer);
        $all_products[$key]->code = str_replace("'", "", $value->code);
        $all_products[$key]->name_for_your = str_replace("'", "", $value->name_for_your);
        $all_products[$key]->name_for_people = str_replace("'", "", $value->name_for_people);
        $all_products[$key]->category = str_replace("'", "", ($value->product_category_name));
        $all_products[$key]->subcategory = str_replace("'", "", (getSubCategoryName($value->subcategory_id)));
        $all_products[$key]->photo = $image_path;
        $all_products[$key]->current_stock = $current_stock;
        $all_products[$key]->order_limit = $value->order_limit;
        $all_products[$key]->manage_stock = str_replace("'", "", $value->manage_stock);
        $all_products[$key]->discount_price = $value->discount_price;
        $all_products[$key]->tax_p = $total_p;
        $all_products[$key]->percengtage = number_format($percengtage, 0);
        $all_products[$key]->details_modal_image = $image_path1;

        $i++;
      endforeach;

      return $this->responseJson($all_products);
    }
  }


  public function findSearchProducts()
  {
    $searched_string = $this->input->post('searched_string');

    if ($searched_string) {
      $all_products = $this->Common_model->SearchProducts($searched_string);

      $javascript_obects = "";
      $total_products = count($all_products);
      $i = 1;
      $getShopSetting = getShopSetting();

      foreach ($all_products as $key => $value) :

        $img_size = "images/" . $value->photo;
        if (file_exists($img_size) && $value->photo != "") {
          $image_path = base_url() . 'images/' . $value->photo;
        } else {
          $image_path = base_url() . 'assets/images/no_image_thumb.png';
        }

        $img_size_1 = "images/" . $value->details_modal_image;
        if (file_exists($img_size_1) && $value->details_modal_image != "") {
          $image_path1 = base_url() . 'images/' . $value->details_modal_image;
        } else {
          $image_path1 = $image_path;
        }

        $img_size = "images/" . $value->photo;
        if (file_exists($img_size) && $value->photo != "") {
          $image_path = base_url() . 'images/' . $value->photo;
        } else {
          $image_path = $image_path1;
        }

        $tax_info = json_decode($value->tax_information);
        $total_p = 0;
        $collect_tax = $getShopSetting->collect_tax;

        if (isset($collect_tax) && $collect_tax == "Yes") {
          foreach ($tax_info as $tax) {
            $total_p += $tax->tax_field_percentage;
          }
        }
        if ((int)$value->discount_price) :
          $card_price = $value->discount_price;
        else :
          $card_price = $value->sale_price;
        endif;


        $current_stock = 2000; // make default current stock

        $percengtage = 0;
        $tmp_total = 0;
        if ((int)$value->discount_price) :
          $sale_price = $value->sale_price;
          $discount_price = $value->discount_price;
          $tmp_total = $sale_price - $discount_price;
          $percengtage = ($tmp_total / $value->sale_price) * 100;

        endif;

        $all_products[$key]->name = str_replace("'", "", ucfirst($value->name));
        $all_products[$key]->description = str_replace("'", "", $value->description);
        $all_products[$key]->offer = str_replace("'", "", $value->offer);
        $all_products[$key]->code = str_replace("'", "", $value->code);
        $all_products[$key]->name_for_your = str_replace("'", "", $value->name_for_your);
        $all_products[$key]->name_for_people = str_replace("'", "", $value->name_for_people);
        $all_products[$key]->category = str_replace("'", "", ($value->product_category_name));
        $all_products[$key]->subcategory = str_replace("'", "", (getSubCategoryName($value->subcategory_id)));
        $all_products[$key]->photo = $image_path;
        $all_products[$key]->current_stock = $current_stock;
        $all_products[$key]->order_limit = $value->order_limit;
        $all_products[$key]->manage_stock = str_replace("'", "", $value->manage_stock);
        $all_products[$key]->discount_price = $value->discount_price;
        $all_products[$key]->tax_p = $total_p;
        $all_products[$key]->percengtage = number_format($percengtage, 0);
        $all_products[$key]->details_modal_image = $image_path1;

        $i++;
      endforeach;

      return $this->responseJson($all_products);
    }
  }


  /**
   * store signup data by ajax
   * @access public
   * @return json
   */
  public function storeSignup()
  {
    $data = array();
    $data['name'] = htmlspecialchars($this->input->post('s_name'));
    $data['password'] = md5($this->input->post($this->security->xss_clean('password')));
    $data['phone'] = htmlspecialchars($this->input->post('phone'));
    $data['address'] = htmlspecialchars($this->input->post('address'));
    $data['email'] = htmlspecialchars($this->input->post('s_email'));

    $checkExistingAccount = $this->Common_model->checkExistingAccount($this->input->post($this->security->xss_clean('phone')), '');
    $return_data = array();
    $return_data['c_status'] = false;
    if ($checkExistingAccount) {
      $return_data['msg'] = lang('Alreadyexistanaccountforthisphonenumber');
    } else {
      $id = $this->Common_model->insertInformation($data, "tbl_customers");

      $data_address = array();
      $data_address['address'] = htmlspecialchars($this->input->post('address'));
      $data_address['customer_id'] = $id;
      $this->Common_model->insertInformation($data_address, "tbl_customer_address");

      $return_data['msg'] = lang('Somethingiswrong');
      if ($id) {
        $return_data['c_status'] = true;
        $return_data['msg'] = lang('Successfullysingupyouraccount');
      }
    }

    echo json_encode($return_data);
  }

  /**
   * order confirm for cash on delivery
   * @access public
   * @return CI_Output
   */
  public function orderConfirm()
  {
    $return_data['status'] = false;

    $order_number = $this->customer_order_store();

    if ($order_number) {
      $return_data['status'] = true;
      $return_data['order_number'] = $order_number;
    }

    return $this->responseJson($return_data);
  }


  public function customer_order_store($p_method = null)
  {
    $order_number = getOrderId();
    $customer_id = customer('id');

    $cart = $this->session->userdata('cart');
    $address = $this->session->userdata('address');
    $customer = getCustomerData($customer_id);

    if (!$customer && empty($address)) {
      return false;
    }

    $name = $address['name'] ?? 'N/A';
    $phone = $address['phone'] ?? 'N/A';
    $email = isset($customer->email) ? $customer->email : $phone . '@customer.com';
    $city_name = $address['city_name'] ?? 'N/A';
    $address = $address['address'] ?? 'N/A';

    $cart = customer_cart();
    $delivery_charge = $cart->d_charge ? (int)$cart->d_charge : 0;
    $discount = $cart->discount ? (int)$cart->discount : 0;

    // dd($cart->cart_total);

    $payment_id = $this->input->post('payment_id');
    $cart_total = $cart->cart_total;
    $total_tax =  (int) $cart_total * 0.075;
    $total_amount = $cart_total + $total_tax + $delivery_charge - $discount;

    $data = [
      'customer_id' => $customer_id,
      'order_number' => $order_number,
      'checkout_name' => $name,
      'checkout_phone' => $phone,
      'checkout_email' => $email,
      'area' => $city_name,
      'address' => $address,
      'order_date_time' => date('Y-m-d H:i:s'),
      'delivery_date' => $cart->select_date ?? null,
      'delivery_time' => $cart->select_time ?? null,
      'payment_id' => $payment_id,
      'delivery_charge' => $delivery_charge,
      'paid' => $p_method ? $total_amount : null,
      'coupon_discount' => $cart->discount,
      'total_tax' => $total_tax ?? 0,
      'total_items' => $cart->total_items,
      'total_amount' => $total_amount,
      'del_status' => $p_method ? 'Deleted' : 'Live',
    ];

    $id = $this->Common_model->insertInformation($data, "tbl_orders");
    $cart_list = json_decode($cart->cart_list);
    $data = array();
    foreach ($cart_list as $value) {
      $data = [
        'order_id' => $id,
        'product_id' => $value->id,
        'name' => $value->name,
        'qty' => $value->quantity,
        'price' => $value->price,
        'original_price' => $value->sale_price,
        'discount_amount' => $value->discount_price,
        'delivery_charge' => $value->actual_del_charge ?? null,
        'color_id' => $value->color_id ?? null,
        'color' => $value->color_name ?? null,
        'size_id' => $value->size_id ?? null,
        'size' => $value->size_name ?? null,
      ];
      $this->Common_model->insertInformation($data, "tbl_order_items");
    }

    if ($id) {
      if (is_null($p_method)) {
        $data = array();
        $order = $this->Common_model->getOrderData($id);
        //store notification when happened an order
        $txt = "Hello Sir/ Madam. Thank you for placing your order at http://mixfashionhouse.com/ Your order " . $order_number . " & order amount BDT " . $order->total_amount . ".";
        $data['notifications_details'] = $txt;
        $data['order_id'] = $id;
        $data['date'] = date("Y-m-d", strtotime('today'));
        $this->Common_model->insertInformation($data, "tbl_notifications");

        if ($phone) {
          $status = sendSSL_WareSMS($txt, $phone);
        }

        if ($email) {
          $data['txt'] = $txt;
          $data['order'] = $this->Common_model->getOrderData($id);
          $data['items'] = $this->Common_model->getOrderItems($id);
          $data['outlet_information'] = $this->Common_model->getDataById(customer('outlet_id'), "tbl_outlets");
          $html = $this->load->view('order_management/invoice_email.php', $data, true);
          $email =  sendEmail($html, $email, "", 1);
        }
      }

      setCouponUsed($cart->coupon_code, $id);
      $this->session->unset_userdata('cart');
      $this->session->unset_userdata('address');

      return $order_number;
    }

    return false;
  }


  /**
   * order confirm1 for payment method such as aamarpay,stripe,paypal
   * @access public
   */
  public function orderConfirm1()
  {
    $order_number = getOrderId(); // TODO must make as more helpfull

    $customer_id = $this->session->userdata('c_id');
    $return_data['status'] = false;

    // $customer = getCustomerData($customer_id);
    // if (!$customer->email) {
    //   $return_data['msg'] = 'You can\'t online payment without complete profile with email!';
    //   return $this->responseJson($return_data);
    // }

    $order_number = $this->customer_order_store('online');

    if ($order_number) {
      $return_data['status'] = true;
      $return_data['order_number'] = $order_number;
    }

    return $this->responseJson($return_data);
  }


  /**
   * get order list by customer id
   * @access public
   * @return json
   */
  public function getOrderItemsByCustomerId()
  {
    $getSiteSetting = getSiteSetting();
    $currency = "$";
    if (isset($getSiteSetting->currency) && $getSiteSetting->currency) {
      $currency = $getSiteSetting->currency;
    }
    $order_id = isset($_POST['order_id']) && $_POST['order_id'] ? $_POST['order_id'] : '';
    $items = $this->Common_model->getDataCustomName("tbl_order_items", "order_id", $order_id);
    $html = '';
    $status = false;
    if ($items && !empty($items)) {
      $i = count($items);
    }
    foreach ($items as $value) {
      $html .= '<tr>
                    <td class="text-center" scope="row">' . ($i--) . '</td>
                    <td class="txt-18">' . $value->name . '</td>
                    <td class="text-center" style="width: 125px;">' . floating($value->price) . '</td>
                    <td class="text-center">' . $value->qty . '</td>
                </tr>';
      $status = true;
    }

    return responseJson(['status' => $status, 'html' => $html]);
  }

  /**
   * ajax sign in check
   * @access public
   * @return json
   */
  public function checkSignInData()
  {
    $l_phone = $this->input->post('l_phone');


    //        $l_password = $this->input->post('l_password');
    //        $checkExistingAccount = $this->Common_model->checkExistingAccount($l_phone, $l_password);
    //        $return_data = array();
    //        $return_data['c_status'] = false;
    //        if ($checkExistingAccount) {
    //            if ($checkExistingAccount->is_otp_verified == 1) {
    //                $return_data['c_id'] = $checkExistingAccount->id;
    //                $return_data['c_name'] = $checkExistingAccount->name;
    //                $return_data['c_phone'] = $checkExistingAccount->phone;
    //                $return_data['c_address'] = $checkExistingAccount->address;
    //                $return_data['c_email'] = $checkExistingAccount->email;
    //                $return_data['is_otp_verified'] = 1;
    //                $this->session->set_userdata($return_data);
    //                $return_data['c_status'] = true;
    //                $return_data['msg'] = lang('Successfullylogin');
    //            } else {
    //                $return_data['msg'] = lang('otp_verified');
    //            }
    //        } else {
    //            $return_data['msg'] = lang('PhoneorPasswordwrong');
    //        }

    echo json_encode($l_phone);
  }

  public function checkOTPValidation()
  {
    $return_data['c_status'] = true;
    echo json_encode($return_data);
  }


  public function checkCoupon()
  {
    $customer_id = $this->session->userdata('c_id');
    if (!$customer_id) {
      $return_data['msg'] = lang("Please login first");
      return $this->responseJson($return_data);
    }

    $enter_code = $this->input->post('enter_code');
    // $deliveryCharge = $this->input->post('delivery');
    $deliveryCharge = 0;
    $total = $this->input->post('total');
    $cost = $total - $deliveryCharge;
    $current_date = date("Y-m-d");
    $coupon = $this->Common_model->checkCoupon($enter_code, $current_date);

    $validMessage = $this->responseJson(['msg' => lang("Please enter valid coupon code")]);

    if ($coupon) {
      $newUser = $this->Common_model->checkCouponNewCustomer($customer_id);
      $coupon_data = [
        'status' => true,
        'amount' => $coupon->amount,
        'coupon_txt' => $coupon->amount . "% Flat Discount",
      ];

      if ($coupon->coupon_option == 'repeat_coupon') {
        if ($coupon->amount == 'free_deliver') {
          return $this->responseJson(['delivery_charge' => 'free-delivery']);
        } elseif ($cost >= 300) {
          return $this->responseJson($coupon_data);
        }
      }

      if (is_null($newUser) && $coupon->coupon_option == 'new_user') {
        if ($coupon->amount == 'free_deliver') {
          return $this->responseJson(['delivery_charge' => 'free-delivery']);
        } else {
          return $this->responseJson($coupon_data);
        }
      }


      if ($coupon->coupon_option == 'emp_special_300') {
        if ($coupon->amount == 'free_deliver') {
          return $this->responseJson(['delivery_charge' => 'free-delivery']);
        } elseif ($cost >= 300) {
          return $this->responseJson($coupon_data);
        }
      }


      if ($coupon->coupon_option == '499_1999') {
        if ($cost >= 499 && $cost <= 1999) {
          if ($coupon->amount == 'free_deliver') {
            return $this->responseJson(['delivery_charge' => 'free-delivery']);
          } else {
            return $this->responseJson($coupon_data);
          }
        } else {
          return $validMessage;
        }
      }

      if ($coupon->coupon_option == '2000') {
        if ($cost >= 2000) {
          if ($coupon->amount == 'free_deliver') {
            return $this->responseJson(['delivery_charge' => 'free-delivery']);
          } else {
            return $this->responseJson($coupon_data);
          }
        } else {
          return $validMessage;
        }
      }
    }

    return $validMessage;
  }


  public function check_cut_off_time()
  {
    $date = $this->input->post('selectDate');
    $option = cut_out_time($date);
    return $this->responseJson(['option' => $option]);
  }


  public function checkPhoneNumberForOTP()
  {
    $phone_number = $this->input->post('l_phone');
    $accept_terms = $this->input->post('accept_terms');
    $remember_me = $this->input->post('remember_me');
    $return_data['status'] = false;
    $return_data['l_phone'] = $phone_number;
    $return_data['term'] = $accept_terms;
    if ($accept_terms) {
      $exists = $this->Common_model->checkPhoneNumberForOTP($phone_number);
      $otp = mt_rand(1000, 9999);
      $data['otp_code'] = $otp;
      if ($remember_me) {
        $this->session->set_userdata(['remember_token' => $remember_me]);
      }
      if ($exists) {
        $this->Common_model->updateInformation($data, $exists->id, "tbl_customers");
      } else {
        $data['phone'] = $phone_number;
        $this->Common_model->insertInformation($data, "tbl_customers");
      }
      $siteUrl = site_url('/');
      $txt = "{$otp} is your one time pin (OTP) for mixfashionhouse.com validity for OTP is 3 minutes.
      {$siteUrl}";
      //send sms
      $smsSetting = getSMSSetting();
      if ($smsSetting->enable_status == 1) {
        $status = 1;
        $status = sendSSL_WareSMS($txt, $phone_number);
        // dd($status);

        $return_data['status'] = true;
        $return_data['msg'] = 'OTP send your phone';
      } else {
        $return_data['msg'] = 'OTP Something wrong';
      }
    } else {
      $return_data['msg'] = 'Please accept terms and condition';
    }
    return $this->responseJson($return_data);
  }


  public function checkOTP()
  {
    $phone_number = $this->input->post('userPhone');
    $otp_code = $this->input->post('f_otpCode');

    $checkExistingAccount = $this->Common_model->checkPhoneNumberForOTP($phone_number);

    $is_send_otp = '';
    if (!$checkExistingAccount) {
      $c_email = $this->session->userdata('c_email');
      if ($c_email) {
        $checkExistingAccount = $this->Common_model->checkExistingAccountByEmail($c_email);
      }
    }

    $return_data = array();
    $return_data['status'] = false;
    if ($checkExistingAccount && $checkExistingAccount->otp_code == $otp_code) {
      $remember_me = $this->session->userdata('remember_token');
      if (!empty($remember_me)) {
        $data['remember_token'] = md5(remember_me_generate());
      }

      $data = array();
      $data['is_otp_verified'] = 1;
      $data['phone'] = $phone_number;
      $this->Common_model->updateInformation($data, $checkExistingAccount->id, "tbl_customers");

      $return_data['c_id'] = $checkExistingAccount->id;
      $return_data['c_name'] = $checkExistingAccount->name ? $checkExistingAccount->name : 'Customer';
      $return_data['c_phone'] = $phone_number;
      $return_data['c_address'] = $checkExistingAccount->address;
      $return_data['c_email'] = $checkExistingAccount->email;
      $return_data['is_otp_verified'] = 1;
      $this->session->set_userdata($return_data);

      $this->session->set_userdata(['customer' => $checkExistingAccount]);

      $return_data['status'] = true;
      $return_data['msg'] = lang('success_verified');
    } else {
      $return_data['msg'] = lang('not_valid_otp');
    }

    return $this->responseJson($return_data);
  }

  /**
   * change frontend language
   * @access public
   * @return json
   */
  public function changeFrontEndLanguage()
  {
    $language = $this->input->post('ln');
    if ($language == "") {
      $language = "english";
    }
    $this->session->set_userdata('language', $language);
    echo json_encode("Success");
  }

  /**
   * change password
   * @access public
   * @return json
   */
  public function changePassword()
  {
    $old_password = $this->input->post('old_password');
    $new_password = $this->input->post('new_password');
    $checkExistingAccount = $this->Common_model->checkExistingAccount($this->session->userdata('c_phone'), $old_password);
    $return_data = array();
    $return_data['c_status'] = false;
    if ($checkExistingAccount) {
      $data = array();
      $data['password'] = md5($new_password);
      $this->Common_model->updateInformation($data, $checkExistingAccount->id, "tbl_customers");

      //send email
      $emailSetting = getSMTPSetting();
      $getSiteSetting = getSiteSetting();
      $txt = "Your new password is : " . $new_password;
      if ($emailSetting->enable_status == 1) {
        sendEmailOnly($emailSetting->user_name, $emailSetting->password, $txt, $this->session->userdata('c_email'), $attached = '', $getSiteSetting->email, "Changed Password");
      }
      //send sms
      $smsSetting = getSMSSetting();
      if ($smsSetting->enable_status == 1) {
        sendOnnoSMS($smsSetting->user_name, $smsSetting->password, $txt, $this->session->userdata('c_phone'));
      } elseif ($smsSetting->enable_status == 2) {
        sendLocalSMS($smsSetting->user_name1, $smsSetting->password1, $txt, $this->session->userdata('c_phone'), '', $smsSetting->apikey);
      }
      //unset customer session data
      $this->session->unset_userdata('c_id');
      $this->session->unset_userdata('c_name');
      $this->session->unset_userdata('c_phone');
      $this->session->unset_userdata('c_address');
      $this->session->unset_userdata('c_email');

      $return_data['c_status'] = true;
      $return_data['msg'] = lang('Passwordsuccessfullychanged');
    } else {
      $return_data['msg'] = lang('OldPasswordiswrong');
    }
    echo json_encode($return_data);
  }

  /**
   * forgot password
   * @access public
   * @return json
   */
  public function forgotPassword()
  {
    $f_email = $this->input->post('f_email');
    $checkExistingAccount = $this->Common_model->checkExistingAccountByEmail($f_email);
    $return_data = array();
    $return_data['c_status'] = false;
    if ($checkExistingAccount) {
      $data = array();
      $auto_generated_password = mt_rand(100000, 999999);
      $data['password'] = md5($auto_generated_password);
      $this->Common_model->updateInformation($data, $checkExistingAccount->id, "tbl_customers");

      $emailSetting = getSMTPSetting();
      $getSiteSetting = getSiteSetting();
      sendEmailOnly($emailSetting->user_name, $emailSetting->password, "Your new password is : " . $auto_generated_password, $f_email, '', $getSiteSetting->email, 'Changed Password');

      $return_data['c_status'] = true;
      $return_data['msg'] = lang('PasswordsuccessfullychangedPleasecheckyouremailinboxorspam');
    } else {
      $return_data['msg'] = lang('Emailnotexist');
    }
    echo json_encode($return_data);
  }

  /**
   * change profile
   * @access public
   * @return json
   */
  public function changeProfile()
  {
    $name = htmlspecialchars($this->input->post('sc_name'));
    $photo = htmlspecialchars($this->input->post('sc_photo'));
    $address = htmlspecialchars($this->input->post('address'));
    $email = htmlspecialchars($this->input->post('sc_email'));
    $phone = htmlspecialchars($this->input->post('sc_phone'));
    $checkExistingAccount = $this->Common_model->checkExistingAccount($this->session->userdata('c_phone'), '');
    $return_data = array();
    $return_data['c_status'] = false;
    if ($checkExistingAccount) {
      $data = array();

      if ($_FILES['sc_photo']['name'] != "") {
        $config['upload_path'] = './images/customer';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['max_size'] = '1000';
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("sc_photo")) {

          $upload_info = $this->upload->data();

          $file_name = $upload_info['file_name'];
          $config['image_library'] = 'gd2';
          $config['source_image'] = './images/customer/' . $file_name;
          $config['maintain_ratio'] = TRUE;
          //$config['width'] = 200;
          //$config['height'] = 350;
          $this->load->library('image_lib', $config);
          $this->image_lib->resize();
          $this->session->set_userdata('photo', $file_name);
        }

        $data['photo'] = $file_name;
        $return_data['c_photo'] = $file_name;
      } else {
        $data['name'] = $name;
        $data['address'] = $address;
        $data['email'] = $email;
        $data['phone'] = $phone;
      }


      $this->Common_model->updateInformation($data, $checkExistingAccount->id, "tbl_customers");

      $return_data['c_name'] = $name;
      $return_data['c_address'] = $address;
      $return_data['c_email'] = $email;
      $return_data['c_phone'] = $phone;
      $this->session->set_userdata($return_data);

      $return_data['c_status'] = true;
      $return_data['msg'] = lang('Profilesuccessfullychanged');
    } else {
      $return_data['msg'] = lang('Pleaseloginandtryagain');
    }
    echo json_encode($return_data);
  }
  /**
   * check image validation and upload image file
   * @access public
   * @param int
   * @return void
   */


  /**
   * cancel order form customer order list
   * @access public
   * @return json
   */
  public function cancelOrder()
  {
    $id = $this->input->post('id');

    $getRow = $this->Common_model->getDataById($id, "tbl_orders");
    $return_data = array();
    $return_data['c_status'] = false;
    if ($getRow && $getRow->status == "In Progress" || $getRow->status == "Delivered") {
      $return_data['c_status'] = false;
      $return_data['msg'] = lang('Youcannotdeletethisorder');
    } elseif ($getRow) {
      $return_data['c_status'] = true;
      $this->Common_model->cancelOrder($id, $id, "tbl_orders", "tbl_order_items", 'id', 'order_id');
      $return_data['msg'] = lang('Orderhasbeencanceledsuccessfully');
      $txt = "Order has been canceled, Order Number is: " . $getRow->order_number . " Customer Name: " . $this->session->userdata('c_name') . " Customer Phone No: " . $this->session->userdata('c_phone');
      //send sms
      smsSend($txt, $this->session->userdata('c_phone'), 2);
      //send email
      sendEmail($txt, $this->session->userdata('c_email'), '', 2);
    } else {
      $return_data['msg'] = lang('Somethingiswrong');
    }
    echo json_encode($return_data);
  }

  /**
   * delivery time available check before conform the order
   * @access public
   * @return CI_Output
   */
  public function checkout_cart_save_to_session()
  {
    $cart_list = $this->input->post('cart');
    $cart_total = $this->input->post('cart_total');
    $total_items = $this->input->post('total_items');
    $vat_charge = $this->input->post('vat_charge');
    $total_payable = $this->input->post('total_payable');
    $d_charge = $this->input->post('city');


    $total_tax = $vat_charge;

    $coupon_code = $this->input->post('hidden_coupon_code');
    $discount = $this->input->post('hidden_coupon_amount');

    $name = $this->input->post('name');
    $phone = $this->input->post('phone');
    $email = $this->input->post('email');
    $city_name = $this->input->post('city_name');
    $address = $this->input->post('address');

    $data_r['status'] = false;
    $data = [];

    if ((int)$cart_total) {
      $data['cart'] = [
        'cart_list' => $cart_list,
        'cart_total' => $cart_total,
        'total_items' => $total_items,
        'd_charge' => $d_charge,
        'coupon_code' => $coupon_code,
        'total_tax' => $total_tax,
        'vat_charge' => $vat_charge,
        'discount' => $discount,
        'total_payable' => $total_payable
      ];

      $data['address'] = [
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'city_name' => $city_name,
        'address' => $address,
      ];

      $this->session->set_userdata($data);
      $data_r['status'] = true;
    }

    return responseJson($data_r);
  }


  public function add_delivery_address()
  {
    $data['areas'] = $this->Common_model->getAllByTable("tbl_areas");
    return $this->load->view('landing/ajax/address/add_edit_address', $data);
  }

  public function SaveShippingAddress()
  {
    $this->form_validation->set_rules('p_c_name', lang('name'), 'required|max_length[155]|callback_validate_address');
    $this->form_validation->set_rules('p_c_phone', lang('phone'), 'required|max_length[55]');
    $this->form_validation->set_rules('p_c_phone2', lang('phone'), 'max_length[55]');
    $this->form_validation->set_rules('p_area', 'Area', 'required|max_length[55]');
    $this->form_validation->set_rules('p_address', lang('address'), "required|max_length[600]");

    $this->form_validation->set_rules('address_id', 'Address Id', "numeric");
    $this->form_validation->set_rules('shipping_customer_id', 'Address Customer ID', "numeric");

    $response['status'] = false;
    if ($this->form_validation->run() == false) {
      $response['msg'] = 'Address required not empty and save before';
      return $this->responseJson($response);
    }

    $c_id = customer('id');

    if ($c_id) {
      $address = [
        'customer_id' => htmlspecialchars($c_id),
        'name' => htmlspecialchars($this->input->post('p_c_name')),
        'phone_one' => htmlspecialchars($this->input->post('p_c_phone')),
        'phone_two' => htmlspecialchars($this->input->post('p_c_phone2')),
        'area' => htmlspecialchars($this->input->post('p_area')),
        'address' => htmlspecialchars($this->input->post('p_address')),
      ];
      $address_id = $this->input->post('address_id');

      if ($address_id) {
        $this->Ajax_model->updateAddressInformation($address, $address_id);
      } else {
        $address_id = $this->Common_model->insertInformation($address, "tbl_customer_address");
      }

      $data['default_address'] = $address_id;
      $this->Common_model->updateInformation($data, $c_id, "tbl_customers");

      $response['status'] = true;
      $response['msg'] = 'Address Save Successfully';
    }
    return $this->responseJson($response);
  }

  public function validate_address()
  {
    $customer_id = customer('id');
    $name = htmlspecialchars($this->input->post('p_c_name'));
    $phone_one = htmlspecialchars($this->input->post('p_c_phone'));
    $area = htmlspecialchars($this->input->post('p_area'));
    $address = htmlspecialchars($this->input->post('p_address'));
    $address_id = htmlspecialchars($this->input->post('address_id'));
    if ($address_id) {
      return true;
    }
    $checkAddress = $this->Ajax_model->checkCustomerValidAddress($customer_id, $name, $phone_one, $area, $address);

    if ($checkAddress) {
      return false;
    }
    return true;
  }

  public function editShippingAddress()
  {
    $id = $this->input->post('id');
    $customer_id = customer('id');

    $data['address'] = $this->Ajax_model->findCustomerValidAddress($id, $customer_id);
    $data['areas'] = $this->Common_model->getAllByTable("tbl_areas");

    return $this->load->view('landing/ajax/address/add_edit_address', $data);
  }

  public function deleteShippingAddress()
  {
    $id = $this->input->post('id');
    $customer_id = customer('id');
    $address = $this->Ajax_model->deleteCustomerValidAddress($id, $customer_id);
    if ($address) {
      $customer = $this->Common_model->getDataById($customer_id, "tbl_customers");
      if ($customer->default_address == $id) {
        $data['default_address'] = null;
        $this->Common_model->updateInformation($data, $customer_id, "tbl_customers");
      }

      return $this->responseJson(['status' => true]);
    }
    return $this->responseJson(['status' => false]);
  }


  public function getCustomerAddress()
  {
    $c_id = customer('id');
    $customer = getCustomerData($c_id);
    $data['default_address'] = $customer ? $customer->default_address : array();
    $data['address'] = $this->Ajax_model->get_customer_address($c_id);
    return $this->load->view('landing/ajax/address/list_address', $data);
  }

  public function setCustomerDefaultAddress()
  {
    $default_id = $this->input->post('default_id');
    $c_id = customer('id');
    if ($default_id) {
      $data['default_address'] = $default_id;
      $this->Common_model->updateInformation($data, $c_id, "tbl_customers");
    } else {
      $customer = $this->Common_model->getDataById($c_id, "tbl_customers");
      if (!$customer->default_address) {
        $address = $this->Ajax_model->get_customer_first_address($c_id);
        $data['default_address'] = $address ? $address->id : null;
        $this->Common_model->updateInformation($data, $c_id, "tbl_customers");
        $default_id = $address ? $address->id : null;
      } else {
        $default_id = $customer->default_address;
      }
    }
    $data['address'] = $this->Ajax_model->get_customer_default_address($c_id, $default_id);
    return $this->responseJson($data);
  }
}
