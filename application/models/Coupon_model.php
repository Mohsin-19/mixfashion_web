<?php
/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
defined('BASEPATH') OR exit('No direct script access allowed');


class Coupon_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }
  /**
   * payment configration
   * @access public
   * @param int
   */
  function paymentConfig($payment_name)
  {
    $paymentSetting = paymentSetting();
    if ($payment_name == "paypal") {
      if (APPLICATION_MODE == 'demo') {
        return ["sandbox", "", ""];
      } else {
        if ($paymentSetting->field_1 && $paymentSetting->field_2 == 1) {
          return [$paymentSetting->field_2_v, $paymentSetting->field_2_key_1, $paymentSetting->field_2_key_2];
        } else {
          return ['', '', ''];
        }
      }
    }
  }
}
