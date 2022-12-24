<?php

/**
 * @product: Grocery Web apps
 * @author : Avanteca Web, Software & Apps Solution
 * @email: sumon4skf@gmail.com
 * @copyright Reserved by Avanteca Web, Software & Apps Solution
 * @website http://avanteca.com.bd/
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/paypal-php-sdk/paypal/rest-api-sdk-php/sample/bootstrap.php'); // require paypal files


use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Amount;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;

class PaymentController extends CI_Controller
{
  public $_api_context;

  function __construct()
  {
    parent::__construct();
    $this->load->model('Payment_model');
    $this->load->model('Common_model');
    $this->load->model('Landing_model');
    // paypal credentials
    $this->config->load('paypal');
    // Load Stripe library
    $this->load->library('stripe_lib');
  }

  /**
   * paypal,stripe payment function call
   * @access public
   * @param int
   * @return void
   */
  public function payment()
  {
    dd('asdf');
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      redirect('/');
    }

    $check_stripe = isset($_POST['check_stripe']) && $_POST['check_stripe'] ? $_POST['check_stripe'] : '';
    if ($check_stripe == "yes") {
      $order_id_str = $_POST['order_id_str'];
      $data = array();
      $data['total_payable_str'] = $_POST['total_payable_str'];
      $data['description'] = $_POST['item_description_str'];
      $data['order_id_str'] = $order_id_str;

      $data['offer_products'] = $this->Landing_model->getOfferProductsWithStock();
      $data['all_products'] = $this->Landing_model->getProductsWithStock();
      $data['all_slides'] = $this->Landing_model->getActiveSlides();
      $data['all_categories'] = $this->Landing_model->getCategories();
      $data['all_special_categories'] = $this->Landing_model->getSpecialCategories();
      $data['subcats'] = $this->Common_model->getAllByTable("tbl_product_sub_categories");
      $data['arees'] = $this->Common_model->getAllByTable("tbl_areas");
      $data['orders'] = $this->Landing_model->getOrders();
      $data['pages'] = $this->Landing_model->pages();
      foreach ($data['orders'] as $ke => $val) {
        $data['orders'][$ke]->items = $this->Common_model->getDataCustomName("tbl_order_items", "order_id", $val->id);
      }
      $data['search_page'] = 1;
      foreach ($data['all_categories'] as $key => $value) {
        $data['all_categories'][$key]->subcategories = $this->Common_model->getDataCustomName("tbl_product_sub_categories", "cat_id", $value->id);
      }
      $data['products'] = $this->Landing_model->getProductsWithStock();
      $data['main_content'] = $this->load->view('landing/stripe', $data, TRUE);
      $this->load->view('landing/landing_layout', $data);
    } else {
      // setup PayPal api context
      //get configuration from db
      $config_for_paypal = $this->Payment_model->paymentConfig('paypal');
      $this->_api_context = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
          $config_for_paypal[1],
          $config_for_paypal[2]
        )
      );
      $data_config_array = $this->config->item('settings');
      $data_config_array['mode'] = $config_for_paypal[0];
      $this->_api_context->setConfig($data_config_array);


      // ### Payer
      // A resource representing a Payer that funds a payment
      // For direct credit card payments, set payment method
      // to 'credit_card' and add an array of funding instruments.

      $payer['payment_method'] = 'paypal';

      // ### Itemized information
      // (Optional) Lets you specify item wise
      // information
      //for check last order complete before payment
      $order_id_p = $this->input->post('order_id_p');
      $this->session->set_userdata('order_id_p', $order_id_p);


      $item1["name"] = "" . $this->input->post('item_name') . "";
      $item1["sku"] = isset($item_number) && $item_number ? $item_number : 1;  // Similar to `item_number` in Classic API
      $item1["description"] = $this->input->post('item_description');
      $item1["currency"] = "USD";
      $item1["quantity"] = 1;
      $item1["price"] = $this->input->post('item_price');
      $itemList = new ItemList();
      $itemList->setItems(array($item1));

      // ### Additional payment details
      // Use this optional field to set additional
      // payment information such as tax, shipping
      // charges etc.
      $details['tax'] = 0;
      $details['subtotal'] = $this->input->post('item_price');
      // ### Amount
      // Lets you specify a payment amount.
      // You can also specify additional details
      // such as shipping, tax.
      $amount['currency'] = "USD";
      $amount['total'] = $this->input->post('item_price');
      $amount['details'] = $details;
      // ### Transaction
      // A transaction defines the contract of a
      // payment - what is the payment for and who
      // is fulfilling it.
      $transaction['description'] = 'Payment description';
      $transaction['amount'] = $amount;
      $transaction['invoice_number'] = uniqid();
      $transaction['item_list'] = $itemList;


      // ### Redirect urls
      // Set the urls that the buyer must be redirected to after
      // payment approval/ cancellation.
      $baseUrl = base_url();
      $redirectUrls = new RedirectUrls();
      $redirectUrls->setReturnUrl($baseUrl . "paymentStatus")
        ->setCancelUrl($baseUrl . "paymentStatus");

      // ### Payment
      // A Payment Resource; create one using
      // the above types and intent set to sale 'sale'
      $payment = new Payment();
      $payment->setIntent("sale")
        ->setPayer($payer)
        ->setRedirectUrls($redirectUrls)
        ->setTransactions(array($transaction));

      try {
        $payment->create($this->_api_context);
      } catch (Exception $ex) {
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        echo "Payment Configuration Error";
        exit;
        redirect('paymentConfigurationError');
      }
      foreach ($payment->getLinks() as $link) {
        if ($link->getRel() == 'approval_url') {
          $redirect_url = $link->getHref();
          break;
        }
      }

      if (isset($redirect_url)) {
        /** redirect to paypal **/
        redirect($redirect_url);
      }

      $this->session->set_flashdata('success_msg', 'Unknown error occurred');
      redirect('/');
    }
  }

  /**
   * payment stripe function
   * @access public
   * @return void
   */
  public function stripePayment()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      redirect('/');
    }
    // If payment form is submitted with token
    if ($this->input->post('stripeToken')) {
      $order_id_str = $_POST['order_id_str'];
      $this->session->set_userdata('order_id_str', $order_id_str);

      // Retrieve stripe token and user info from the posted form data
      $postData = $this->input->post();
      // Make payment
      $paymentID = $this->paymentStripeData($postData);
      // If payment successful
      if ($paymentID) {
        redirect('paymentStatus?msg=payment_success&&order_id=' . getRowByOrderID($order_id_str));
      } else {
        $order_row_id = getRowByOrderNo($order_id_str);
        setUnused($order_row_id);
        redirect('paymentStatus?msg=payment_failed');
      }
    }
  }

  /**
   * payment stripe data
   * @access public
   * @return void
   */
  public function paymentStripeData($postData)
  {

    // If post data is not empty
    if (!empty($postData)) {
      // Retrieve stripe token and user info from the submitted form data
      $token = $postData['stripeToken'];
      $email = $postData['email'];
      $price = $postData['payable_amount'];
      $description = $postData['description'];

      // Add customer to stripe
      $customer = $this->stripe_lib->addCustomer($email, $token);

      if ($customer) {
        // Charge a credit or a debit card
        $charge = $this->stripe_lib->createCharge($customer->id, $description, $price);
        if ($charge) {
          // Check whether the charge is successful
          if ($charge['amount_refunded'] == 0 && empty($charge['failure_code']) && $charge['paid'] == 1 && $charge['captured'] == 1) {
            // Transaction details
            $brand = $charge['payment_method_details']['card']['brand'];
            $type = $charge['payment_method_details']['type'];

            $transactionID = $charge['balance_transaction'];
            $paidAmount = $charge['amount'];
            $paidAmount = ($paidAmount / 100);
            $payment_status = $charge['status'];
            // If the order is successful
            if ($payment_status == 'succeeded') {
              // Insert tansaction data into the database
              $data_payment = array(
                'customer_id' => $this->session->userdata('c_id'),
                'order_id' => $this->session->userdata('order_id_str'),
                'payment_type' => "Stripe",
                'card_type' => $brand . "-" . $type,
                'amount' => $paidAmount,
                'payment_date' => date("Y-m-d"),
                'details' => $description,
                'txn_id' => $transactionID
              );

              $id = $this->Common_model->insertInformation($data_payment, "tbl_payment_history");

              //update success order row
              $data = array();
              $data['del_status'] = "Live";
              $this->Common_model->updateInformation($data, $this->session->userdata('order_id_str'), "tbl_orders");

              //store notification when happened an order
              $order_number = getRowByOrderID($this->session->userdata('order_id_str'));
              $txt = "a new order has been placed, Order Number is: " . $order_number . " Customer Name: " . $this->session->userdata('c_name') . " Customer Phone No: " . $this->session->userdata('c_phone');
              $data['notifications_details'] = $txt;
              $data['order_id'] = $this->session->userdata('order_id_str');
              $data['outlet_id'] = 1;
              $data['date'] = date("Y-m-d", strtotime('today'));
              $this->Common_model->insertInformation($data, "tbl_notifications");
              //send sms
              mim_sms($txt, $this->session->userdata('c_phone'), 1);
              //send email
              sendEmail($txt, $this->session->userdata('c_email'), '', 1);
              $this->session->unset_userdata('order_id_str');
              return $id;
            }
          }
        }
      }
    } else {
    }
    return false;
  }

  /**
   * payment status check after payment action done
   * @access public
   * @return void
   */
  public function paymentStatus()
  {
    $msg = isset($_GET['msg']) && $_GET['msg'] ? $_GET['msg'] : '';
    $payment_mode = isset($_GET['payment_mode']) && $_GET['payment_mode'] ? $_GET['payment_mode'] : '';
    $order_id = isset($_GET['order_id']) && $_GET['order_id'] ? $_GET['order_id'] : '';
    //aamarpay
    $pay_status = isset($_POST['pay_status']) && $_POST['pay_status'] ? $_POST['pay_status'] : '';
    $p_type = isset($_GET['p_type']) && $_GET['p_type'] ? $_GET['p_type'] : '';

    if ($p_type == "ssl" && $msg == "payment_success") {
      $order = getRowDetailsByOrderNo($order_id);
      $tran_id = "ssl" . $order->order_number;
      $currency = "BDT";
      $currency_amount = $_POST['currency_amount'];

      if (($tran_id == $_POST['tran_id']) && $order->total_amount == $currency_amount) {
        if ($this->sslcommerz->ValidateResponse($_POST['currency_amount'], $currency, $_POST)) {
          //update success order row
          $data = array();
          $data['del_status'] = "Live";
          $this->Common_model->updateInformation($data, $order_id, "tbl_orders");
          $order_number = $order->order_number;

          $txt = "Hello Sir/ Madam. Thank you for placing your order at http://mixfashionhouse.com/. Your order " . $order_number . " & order amount BDT " . $order->total_amount . ".";

          $data['notifications_details'] = $txt;
          $data['order_id'] = $order_id;
          $data['date'] = date("Y-m-d", strtotime('today'));
          $this->Common_model->insertInformation($data, "tbl_notifications");
          //send email
          mim_sms($txt, $this->session->userdata('c_phone'));

          $c_email = $this->session->userdata('c_email');
          if ($c_email) {
            $id = $order_id;
            $data['text'] = $txt;
            $data['order'] = $this->Common_model->getOrderData($id);
            $data['items'] = $this->Common_model->getOrderItems($id);
            $data['outlet_information'] = $this->Common_model->getDataById($this->session->userdata('outlet_id'), "tbl_outlets");
            $html = $this->load->view('order_management/invoice_email.php', $data, true);
            sendEmail($html, $c_email, "", 1);
          }


          $data['order_id'] = $order_id;
          $data['main_content'] = $this->load->view('landing/payment_success', $data, TRUE);

          $this->load->view('landing/landing_layout', $data);
        } else {
          $order_row_id = getRowByOrderNo($order_id);
          setUnused($order_row_id);
          redirect('paymentStatus?msg=payment_failed');
        }
      } else {
        $order_row_id = getRowByOrderNo($order_id);
        setUnused($order_row_id);
        redirect('paymentStatus?msg=payment_failed');
      }
    } else {
      if ($pay_status && $pay_status == "Successful") {

        $bank_txn = isset($_POST['bank_txn']) && $_POST['bank_txn'] ? $_POST['bank_txn'] : '';
        $amount = isset($_POST['amount']) && $_POST['amount'] ? $_POST['amount'] : '';
        $card_type = isset($_POST['card_type']) && $_POST['card_type'] ? $_POST['card_type'] : '';
        $payment_date = isset($_POST['pay_time']) && $_POST['pay_time'] ? date("Y-d-m", strtotime($_POST['pay_time'])) : '';
        $order_row_id = getRowByOrderNo($order_id);
        $data = array();
        $data['txn_id'] = $bank_txn;
        $data['customer_id'] = $this->session->userdata('c_id');
        $data['payment_type'] = "Aamarpay";
        $data['amount'] = $amount;
        $data['card_type'] = $card_type;
        $data['payment_date'] = $payment_date;
        $data['order_id'] = $order_row_id;
        $this->Common_model->insertInformation($data, "tbl_payment_history");


        //update success order row
        $data = array();
        $data['del_status'] = "Live";
        $this->Common_model->updateInformation($data, $order_row_id, "tbl_orders");

        //store notification when happened an order
        $order_number = getRowByOrderID($order_row_id);
        $txt = "a new order has been placed, Order Number is: " . $order_number . " Customer Name: " . $this->session->userdata('c_name') . " Customer Phone No: " . $this->session->userdata('c_phone');
        $data['notifications_details'] = $txt;
        $data['order_id'] = $order_row_id;
        $data['date'] = date("Y-m-d", strtotime('today'));
        $this->Common_model->insertInformation($data, "tbl_notifications");
        //send email
        mim_sms($txt, $this->session->userdata('c_phone'));
        //send sms
        sendEmail($txt, $this->session->userdata('c_email'), '', 1);

        $data['order_id'] = $order_id;
        $data['main_content'] = $this->load->view('landing/payment_success', $data, TRUE);
        $this->load->view('landing/landing_layout', $data);
      } else {
        if ($msg == "payment_failed") {
          $data['order_id'] = $order_id;
          $data['main_content'] = $this->load->view('landing/payment_fail', $data, TRUE);
          $this->load->view('landing/landing_layout', $data);
        } else if ($msg == "payment_success") {
          if ($payment_mode && $payment_mode == 'demo') {
            $order_row_id = getRowByOrderNo($order_id);
            //update success order row
            $data = array();
            $data['del_status'] = "Live";
            $this->Common_model->updateInformation($data, $order_row_id, "tbl_orders");
            //store notification when happened an order
            $data = array();
            $txt = "a new order has been placed, Order Number is: " . $order_id . " Customer Name: " . $this->session->userdata('c_name') . " Customer Phone No: " . $this->session->userdata('c_phone');
            $data['notifications_details'] = $txt;
            $data['order_id'] = $order_row_id;
            $data['date'] = date("Y-m-d", strtotime('today'));
            $this->Common_model->insertInformation($data, "tbl_notifications");
          }
          $data['order_id'] = $order_id;
          $data['main_content'] = $this->load->view('landing/payment_success', $data, TRUE);
          $this->load->view('landing/landing_layout', $data);
        } else {
          // paypal credentials
          /** Get the payment ID before session clear **/
          $payment_id = $this->input->get("paymentId");
          $PayerID = $this->input->get("PayerID");
          $token = $this->input->get("token");
          /** clear the session payment ID **/

          if (empty($PayerID) || empty($token)) {
            redirect('paymentStatus?msg=payment_failed');
          }
          $payment = Payment::get($payment_id, $this->_api_context);
          /** PaymentExecution object includes information necessary **/
          /** to execute a PayPal account payment. **/
          /** The payer_id is added to the request query parameters **/
          /** when the user is redirected from paypal back to your site **/
          $execution = new PaymentExecution();
          $execution->setPayerId($this->input->get('PayerID'));

          /**Execute the payment **/
          $result = $payment->execute($execution, $this->_api_context);


          //  DEBUG RESULT, remove it later **/
          if ($result->getState() == 'approved') {
            $trans = $result->getTransactions();
            // item info
            /*   $Subtotal = $trans[0]->getAmount()->getDetails()->getSubtotal();
                           $Tax = $trans[0]->getAmount()->getDetails()->getTax();*/

            /*     $payer = $result->getPayer();*/
            // payer info //
            /*   $PaymentMethod =$payer->getPaymentMethod();
                           $PayerStatus =$payer->getStatus();
                           $PayerMail =$payer->getPayerInfo()->getEmail();*/

            $relatedResources = $trans[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();
            // sale info //
            $saleId = $sale->getId();
            $CreateTime = $sale->getCreateTime();
            $separete_date = explode('T', $CreateTime);
            $return_arr = array();
            ///
            $Total = $sale->getAmount()->getTotal();

            $data_payment = array();
            $data_payment['txn_id'] = $saleId;
            $data_payment['customer_id'] = $this->session->userdata('c_id');
            $data_payment['payment_type'] = "Paypal";
            $data_payment['amount'] = $Total;
            $data['order_id'] = $this->session->userdata('order_id_p');
            $data_payment['details'] = $trans[0]->item_list->items[0]->name;
            $data_payment['payment_date'] = $CreateTime;
            $this->Common_model->insertInformation($data_payment, "tbl_payment_history");

            //update success order row
            $data = array();
            $data['del_status'] = "Live";
            $this->Common_model->updateInformation($data, $this->session->userdata('order_id_p'), "tbl_orders");
            $order_id_p = $this->session->userdata('order_id_p');
            $this->session->unset_userdata('order_id_p');

            //store notification when happened an order
            $data = array();
            $txt = "a new order has been placed, Order Number is: " . $order_id . " Customer Name: " . $this->session->userdata('c_name') . " Customer Phone No: " . $this->session->userdata('c_phone');
            $data['notifications_details'] = $txt;
            $data['order_id'] = $order_id_p;
            $data['date'] = date("Y-m-d", strtotime('today'));
            $this->Common_model->insertInformation($data, "tbl_notifications");
            //send email
            //                        smsSend($txt, $this->session->userdata('c_phone'), 1);
            mim_sms($txt, $this->session->userdata('c_phone'));
            //send sms
            sendEmail($txt, $this->session->userdata('c_email'), '', 1);

            //end
            /** it's all right **/
            /** Here Write your database logic like that insert record or value in database if you want **/
            redirect('paymentStatus?msg=payment_success&&order_id=' . $order_id);
          }

          $order_row_id = getRowByOrderNo($order_id);
          setUnused($order_row_id);
          redirect('paymentStatus?msg=payment_failed');
        }
      }
    }
  }

  public function sslcommerzPayment()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      redirect('/');
    }

    $hidden_order_id = $this->input->post('hidden_order_id');
    $success_url_ssl = $this->input->post('success_url_ssl');
    $fail_url = $this->input->post('fail_url');
    $ipn_url = site_url('ipn');

    if ($hidden_order_id) {
      $order = getRowDetailsByOrderNo($hidden_order_id);
      if (!$order) {
        redirect('paymentStatus?msg=Order%20details%20not%20found');
      }
      $customer = getCustomerData($order->customer_id);
      if (!$customer) {
        redirect('paymentStatus?msg=Customer%20Information%20Not%20Found');
      }
      $orderItems = getOrderItems($order->id);
      if (!count($orderItems)) {
        redirect('paymentStatus?msg=Order%20Items%20Not%20Found');
      }

      $tran_id = "ssl" . $order->order_number;
      $itemName = [];
      $cat_id = '';
      foreach ($orderItems as $item) {
        $itemName[] = $item->name;
        $cat_id = $item->category_id;
      }
      $CatName = categoryName($cat_id);
      $phone = $customer->phone ? $customer->phone : $order->checkout_phone;
      $email = $customer->email ? $customer->email : ($phone ? "{$phone}@email.com" : 'customer@email.com');

      $post_data = array();
      $post_data['total_amount'] = $order->total_amount;
      $post_data['currency'] = "BDT";
      $post_data['tran_id'] = $tran_id;
      $post_data['success_url'] = $success_url_ssl;
      $post_data['fail_url'] = $fail_url;
      $post_data['cancel_url'] = $fail_url;
      $post_data['ipn_url'] = $ipn_url;
      # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

      # EMI INFO
      // $post_data['emi_option'] = "1";
      // $post_data['emi_max_inst_option'] = "9";
      // $post_data['emi_selected_inst'] = "9";

      # CUSTOMER INFORMATION
      $post_data['cus_name'] = $customer->name ? $customer->name : $order->checkout_name;
      $post_data['cus_email'] = $email;
      $post_data['cus_add1'] = $customer->address ? $customer->address : $order->address;
      $post_data['cus_city'] = $order->area;
      $post_data['cus_state'] = "Dhaka";
      $post_data['cus_postcode'] = "post_code";
      $post_data['cus_country'] = "Bangladesh";
      $post_data['cus_phone'] = $phone;

      # SHIPMENT INFORMATION
      $post_data['ship_name'] = $order->checkout_name;
      $post_data['ship_add1'] = $order->address;
      $post_data['ship_city'] = $order->area;
      $post_data['ship_state'] = $order->area;
      $post_data['ship_postcode'] = "post_code";
      $post_data['ship_country'] = "Bangladesh";

      $post_data['product_profile'] = "physical-goods";
      $post_data['shipping_method'] = "YES";
      $post_data['num_of_item'] = $order->total_items;
      $post_data['product_name'] = implode(',', $itemName);
      $post_data['product_category'] = $CatName;

      //            $this->session->set_userdata('tarndata', $session);
      //            $this->session->set_userdata('custom_data_ssl', $session);
      if ($this->sslcommerz->RequestToSSLC($post_data, '', '', $order->id)) {

        $id = $this->Common_model->updateInformation(['note' => 'pending'], $hidden_order_id, "tbl_orders");
      }
    }
  }

  /**
   * success view after payment
   * @access public
   * @return void
   */
  public function success()
  {
    redirect('purchase/success');
  }

  /**
   * if payment status cancel then show this view
   * @access public
   * @return void
   */
  public function cancel()
  {
    redirect('purchase/fail');
  }

  /**
   * load refund form view
   * @access public
   * @return void
   */
  public function load_refund_form()
  {
    $this->load->view('content/Refund_payment_form');
  }

  /**
   * refund_payment
   * @access public
   * @return float
   */
  public function refund_payment()
  {
    $refund_amount = $this->input->post('refund_amount');
    $saleId = $this->input->post('sale_id');
    $paymentValue = (string)round($refund_amount, 2);;

    // ### Refund amount
    // Includes both the refunded amount (to Payer)
    // and refunded fee (to Payee). Use the $amt->details
    // field to mention fees refund details.
    $amt = new Amount();
    $amt->setCurrency('USD')
      ->setTotal($paymentValue);

    // ### Refund object
    $refundRequest = new RefundRequest();
    $refundRequest->setAmount($amt);

    // ###Sale
    // A sale transaction.
    // Create a Sale object with the
    // given sale transaction id.
    $sale = new Sale();
    $sale->setId($saleId);
    try {
      // Refund the sale
      // (See bootstrap.php for more on `ApiContext`)
      $refundedSale = $sale->refundSale($refundRequest, $this->_api_context);
    } catch (Exception $ex) {
      // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
      ResultPrinter::printError("Refund Sale", "Sale", null, $refundRequest, $ex);
      exit(1);
    }

    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    ResultPrinter::printResult("Refund Sale", "Sale", $refundedSale->getId(), $refundRequest, $refundedSale);

    return $refundedSale;
  }
}
