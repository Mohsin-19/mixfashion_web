<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">

<?php
$paymentSetting = paymentSetting();
?>

<span id="single_page_name" class="d-none">payment</span>

<input type="hidden" id="application_mode" class="application_mode" value="<?= APPLICATION_MODE; ?>">


<!--sslcommerz payment form-->
<form method="POST" action="<?= site_url('sslcommerzPayment') ?>" id="sslcommerz_form">
  <input type="hidden" name="store_id" value="<?= isset($paymentSetting) && $paymentSetting->field_4_key_1 && $paymentSetting->field_4_key_1 ? $paymentSetting->field_4_key_1 : '' ?>">
  <input type="hidden" name="store_password" value="<?= isset($paymentSetting) && $paymentSetting->field_4_key_2 && $paymentSetting->field_4_key_2 ? $paymentSetting->field_4_key_2 : '' ?>">
  <input type="hidden" name="hidden_order_id" id="hidden_order_id" value="">
  <input type="hidden" id="success_url_ssl" name="success_url_ssl" value="<?= site_url('paymentStatus?p_type=ssl&msg=payment_success&order_id=') ?>">
  <input type="hidden" name="fail_url" value="<?= site_url('paymentStatus?msg=payment_failed') ?>">
</form>

<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">
    <div class="col-md-12">
      <ol class="breadcrumb justify-content-start">
        <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= site_url('checkout') ?>">Checkout</a></li>
        <li class="breadcrumb-item active">Payment</li>
      </ol>
    </div>
  </div>
</div>


<div class="main_content">
  <div class="custom-container">

    <div class="row justify-content-center">
      <div class="col-sm-12">
        <h1 class="text-center"><?= lang('ChoosePaymentMethod'); ?> </h1>
      </div>
    </div>


    <div class="row justify-content-center my-3 payment_methods">
      <div class="col-lg-3 col-sm-4 col-6">
        <div class="icon_box icon_box_style4 payment_click cashOnDelivery  mb-3 mb-md-0" data-id="1">
          <div class="icon">
            <img src="<?= base_url("assets/landing/img/cash.png") ?>" style="width: 35px;">
          </div>
          <div class="icon_box_content">
            <h6><?= lang('CashOnDelivery'); ?></h6>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-4 col-6">
        <div class="icon_box icon_box_style4 payment_click  mb-3 mb-md-0" data-id="6">
          <div class="icon">
            <img src="<?= base_url("assets/landing/img/sslcommerz.png") ?>" style="height: 35px;">
          </div>
          <div class="icon_box_content">
            <h6><?= lang('SSLCOMMERZ'); ?></h6>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">

      <div class="col-md-5 text-center">



        <input type="hidden" name="hidden_payment_status" id="hidden_payment_status" class="d-none" value="">

        <div class="mt-3">
          <input class="uk-checkbox " name="accept_payment_terms" id="accept_payment_terms" value="1" type="checkbox">
          Accept
          <a href="<?= site_url('terms-condition') ?>" class="text-danger" target="_blank">terms & condition</a>
        </div>

        <button type="button" class="btn btn-block btn-dark paymentAccept">
          <?= lang('Confirm'); ?>
          <span class="buttonLoader"></span>
        </button>

      </div>


    </div> <!-- row -->

  </div> <!-- custom-container -->
</div> <!-- main_content -->





<div class="welcomeMessage display_none_1">
  <h1 class="title txt-23">
    <?= lang('Orderhasbeenplacedsuccessfullyyourordernumberis'); ?>
    <span class="order_no_success"></span>
    <br><span class="txt-29 redirect_page_counter">5</span>
  </h1>
</div>