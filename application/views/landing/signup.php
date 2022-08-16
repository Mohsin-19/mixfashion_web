<!DOCTYPE html>
<html lang="en">
<?php
$getSiteSetting = getSiteSetting();
$getShopSetting = getShopSetting();
//set default currency
$currency = "$";
if (isset($getSiteSetting->currency) && $getSiteSetting->currency) {
  $currency = $getSiteSetting->currency;
}
//set display css
$display = "display:none";
//set default color
$base_color = "#6ab04c";
if (isset($getSiteSetting->base_color) && $getSiteSetting->base_color) {
  $base_color = $getSiteSetting->base_color;
}
$paymentSetting = paymentSetting();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= isset($getSiteSetting->site_title) && $getSiteSetting->site_title ? $getSiteSetting->site_title : '' ?>
  </title>

  <?php if (isset($getSiteSetting->favicon) && $getSiteSetting->favicon) : ?>
    <link rel="icon" href="<?= base_url() ?>assets/images/<?php echo escape_output($getSiteSetting->favicon); ?>">
  <?php else : ?>
    <link rel="icon" href="<?= base_url('assets/landing/img/favicon.png') ?>">
  <?php endif; ?>
  <!--Start Style for Frontend -->
  <!-- Animation CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/animate.css">
  <!-- Latest Bootstrap min CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/bootstrap/css/bootstrap.min.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
  <!-- Icon Font CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/themify-icons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/linearicons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/flaticon.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/simple-line-icons.css">
  <!--- owl carousel CSS-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/owlcarousel/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/owlcarousel/css/owl.theme.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/owlcarousel/css/owl.theme.default.min.css">
  <!-- Magnific Popup CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/magnific-popup.css">
  <!-- Slick CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/slick.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/slick-theme.css">
  <!-- Style CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/responsive.css">
  <!--End Style for Frontend -->
  <link rel="stylesheet" href="<?= mix('assets/landing/css/preApp.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.4.0/css/uikit.min.css" integrity="sha512-PLEvwqBSIBekNbat/mKSClHFq3efQqqWtBgbFtatXBLuZARaT2eX4LBQ16zt50y9wwnbTAQgQbv9vsSunpaZWg==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
  <link rel="stylesheet" href="<?= mix('assets/landing/css/app.css') ?>">

  <!-- <script src="http://code.jquery.com/jquery-1.8.3.min.js" ></script> -->
  <style>
    footer * {
      color: white;
    }

    .uk-modal {
      z-index: 9999;
      padding: 1px 0px !important;
    }

    #modal-container {
      z-index: 10;
    }

    span.ripple {
      background-color:
        <?= escape_output($base_color) ?>;
    }

    /* for button focus color */
    .productDetailsModal .productAllInfo .modalAmount .quantity button:focus,
    #rightSidebarForAddToCart .content .showCartItem .productCartView li .right-item .innerCartBox .cartQuantityBox button:focus {
      box-shadow: 0 0 0 1px <?= escape_output($base_color) ?>;
      border-color:
        <?= escape_output($base_color) ?>;
    }

    /* for button hover color */
    .productDetailsModal .productAllInfo .modalAmount .quantity button:hover,
    #rightSidebarForAddToCart .content .showCartItem .productCartView li .right-item .innerCartBox .cartQuantityBox button:hover {
      background-color:
        <?= escape_output($base_color) ?>;
      border-color:
        <?= escape_output($base_color) ?>;
      box-shadow: 0 0 0 0.1rem <?= escape_output($base_color) ?>;
    }

    /*For Text Color*/
    .txtColor {
      color:
        <?php echo escape_output($base_color) ?>;
    }

    /*For Solid BG Color*/
    .bgColor {
      background-color:
        <?php echo escape_output($base_color) ?>;
    }

    /*For BG Color With Opacity*/
    .bgAlphaColor {
      background-color:
        <?php echo escape_output($base_color) ?>;
      opacity: 0.9;
    }

    .theme-background-color {
      background-color:
        <?php echo escape_output($base_color) ?> !important;
    }

    header.mainHeader ul>li .uk-dropdown-nav li a {
      color:
        <?php echo escape_output($base_color) ?> !important;
    }

    /*======== Sweet Alert ==========*/
    .sa-confirm-button-container .confirm {
      background-color:
        <?php echo escape_output($base_color) ?> !important;
    }

    .sweet-alert fieldset {
      <?php echo escape_output($display) ?>
    }

    .preloader .preloader-container .animated-preloader {
      background-color:
        <?php echo escape_output($base_color) ?> !important;
    }

    .preloader .preloader-container .animated-preloader:before {
      background-color:
        <?php echo escape_output($base_color) ?> !important;
      opacity: 0.6;
    }

    legend.panel-title.uk-legend {
      background-color:
        <?php echo escape_output($base_color) ?> !important;
    }

    @media (max-width: 640px) {
      #mainHomeContent #productPage .productItemContainer .itemWrapper .cartBtnBox .cardBtn {
        background-color:
          <?php echo escape_output($base_color) ?> !important;
      }
    }

    @media (min-width: 320px) and (max-width: 1024px) {
      .searchform {
        width: 300px;
        top: 49px;
        display: none;
        left: -111px;
      }
    }

    @media only screen and (max-width: 380px) {
      .navbar-nav .dropdown-menu.cart_box_search.show {
        right: -191px;
        width: 310px;
      }

      .header_wrap .navbar .navbar-nav.attr-nav {
        margin-left: 0px !important;
      }
    }



    .search_wrap {
      top: -277px;
      max-width: 459px !important;
    }

    .close-search {
      color: #ff0101 !important;
      top: 38% !important;
    }

    .search_wrap .form-control {
      background-color: #008614 !important;
      color: #ffffff !important;
    }

    .search_overlay.open {
      width: 0px !important;
    }

    /* zoom style */
    .zoomWindow {
      top: -9px !important;
      left: 400px !important;
      border: 2px solid rgb(68, 68, 68) !important;
    }

    .small-galary-img {
      width: 100px !important;
      border: 1px solid;
      float: left !important;
    }

    .searchform {
      position: absolute;
      width: 300px;
      top: 49px;
      display: none;
      right: 0px;

    }

    .cardlist {
      position: absolute;
      width: 322px;
      top: 49px;
      right: 0px;
      display: none;

    }

    .d-block {
      display: block !important;
    }

    .wilistmenu,
    .cmenu {
      width: 320px;
      background-color: #fff;
      box-shadow: 0 13px 42px 11px rgb(0 0 0 / 5%);
      opacity: 1;
      visibility: visible;
      margin-top: 0px;
      pointer-events: auto;
      position: absolute;
      padding: .5rem 0;
      display: none;
    }

    .cart_list {
      width: 100%;
      padding: 0 !important;
      max-height: 242px;
      overflow-y: auto;
    }
  </style>


  <?php
  if ($this->session->has_userdata('language')) {
    $font_detect = $this->session->userdata('language');
  } else {
    $getSiteSetting = getSiteSetting();
    if ($getSiteSetting->default_language_frontend) {
      $font_detect = $getSiteSetting->default_language_frontend;
    } else {
      $font_detect = 'english';
    }
  }
  if ($font_detect == "bangla") : ?>
    <link rel="stylesheet" href="<?= base_url('assets/landing/css/bangla.css') ?>">
  <?php endif; ?>


</head>

<body class="" style="font-family: <?= isset($font_detect) && $font_detect == "bangla" ? 'bangla_font' : '' ?>">


  <!-- Messenger Chat Plugin Code -->
  <div id="fb-root"></div>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        xfbml: true,
        version: 'v10.0'
      });
    };

    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>

  <!-- Your Chat Plugin code -->
  <div class="fb-customerchat" attribution="page_inbox" page_id="517977738399933">
  </div>


  <!--hidden input filed for javascript file uses-->
  <input type="hidden" name="base_url_ajax" id="base_url_ajax" class="base_url_ajax" value="<?= base_url() ?>">
  <input type="hidden" name="hidden_currency" id="hidden_currency" class="hidden_currency" value="<?php echo escape_output($currency) ?>">
  <input type="hidden" name="hidden_alert" id="hidden_alert" class="hidden_alert" value="<?php echo lang('alert'); ?>!">
  <input type="hidden" name="hidden_ok" id="hidden_ok" class="hidden_ok" value="<?php echo lang('ok'); ?>">
  <input type="hidden" name="hidden_cancel" id="hidden_cancel" class="hidden_cancel" value="<?php echo lang('cancel'); ?>">
  <input type="hidden" name="hidden_address" id="hidden_address" class="hidden_address" value="<?php echo escape_output($this->session->userdata('c_address')) ?>">
  <input type="hidden" name="hidden_c_id" id="hidden_c_id" class="hidden_c_id" value="<?php echo escape_output($this->session->userdata('c_id')) ?>">
  <input type="hidden" name="item_txt" id="item_txt" class="item_txt" value="">
  <input type="hidden" name="item_txt1" id="item_txt1" class="item_txt1" value="">
  <input type="hidden" name="total_txt" id="total_txt" class="total_txt" value="<?php echo lang('total'); ?>">
  <input type="hidden" name="add_to_cart_txt" id="add_to_cart_txt" class="add_to_cart_txt" value="<?php echo lang('add_to_cart'); ?>">
  <input type="hidden" name="in_bag" id="in_bag" class="in_bag" value="<?php echo lang('in_bag'); ?>">
  <input type="hidden" name="add_to_shopping_bag" id="add_to_shopping_bag" class="add_to_shopping_bag" value="<?php echo lang('add_to_shopping_bag'); ?>">
  <input type="hidden" name="details_txt" id="details_txt" class="details_txt" value="<?php echo lang('Details_land'); ?>">
  <input type="hidden" name="product_hover_effect" id="product_hover_effect" class="product_hover_effect" value="<?php echo escape_output($getSiteSetting->product_hover_effect) ?>">
  <input type="hidden" id="alert_txt_1" class="alert_txt_1" value="<?= lang('Pleaseloginfirstthenplaceorder'); ?>">
  <input type="hidden" id="alert_txt_2" class="alert_txt_2" value="<?= lang('Additemincartbeforeplaceorder'); ?>">
  <input type="hidden" id="alert_txt_3" class="alert_txt_3" value="<?= lang('Pleaseselectapaymentmethod'); ?>.">
  <input type="hidden" id="alert_txt_4" class="alert_txt_4" value="<?= lang('Areyousure'); ?>">
  <input type="hidden" id="alert_txt_5" class="alert_txt_5" value="<?= lang('Stocknotavailable'); ?>">
  <input type="hidden" id="alert_txt_otp_1" class="alert_txt_otp_1" value="<?php echo lang('alert_txt_otp_1'); ?>">
  <input type="hidden" id="alert_txt_otp_2" class="alert_txt_otp_2" value="<?php echo lang('alert_txt_otp_2'); ?>">
  <input type="hidden" id="alert_txt_otp_3" class="alert_txt_otp_3" value="<?php echo lang('Resend Code'); ?>">
  <input type="hidden" id="alert_txt_otp_4" class="alert_txt_otp_4" value="<?php echo lang('Resend Code in'); ?>">
  <input type="hidden" id="alert_txt_otp_5" class="alert_txt_otp_5" value="<?php echo $base_color; ?>">
  <input type="hidden" id="loading_lng" class="loading_lng" value="<?php echo lang('Loading'); ?>">
  <input type="hidden" id="load_more" class="load_more" value="<?php echo lang('Load More'); ?>">
  <input type="hidden" id="thischaracterisnotallowed" class="thischaracterisnotallowed" value="<?php echo lang('This character is not allowed'); ?>">
  <input type="hidden" id="application_mode" class="application_mode" value="<?php echo APPLICATION_MODE; ?>">
  <input type="hidden" id="search_page" class="search_page" value="<?php echo escape_output($search_page) ?>">
  <input type="hidden" id="temp_cat_id" class="temp_cat_id" value="">
  <?php
  $this->load->view('landing/inc/header.php');
  ?>


  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-sm-10 offset-sm-1 mt-5">
          <div class="card my-2">
            <div class="card-header">
            <h2 class="mb-0" style="font-size: 22px;font-weight: 600;">User Account<small class="pull-right" style="font-size: 65%;">Already member? <a class="text-info" href="login">Login</a> here.</small></h2>
            </div>
            <div class="card-body">
              <!-- Sign up form -->
              <form action="#" id="customer_signup">

                <div class="row">
                  <div class="col-md-6">
                    <div class="uk-margin">
                      <p class="uk-margin-remove"><?php echo lang('name'); ?> <span class="uk-text-danger">*</span></p>
                      <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: info"></span>
                        <input class="uk-input" name="s_name" id="s_name" type="text">
                      </div>
                      <div class="error_s_name error_msg"><?php echo lang('TheNamefiledisrequired'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="uk-margin">
                      <p class="uk-margin-remove"><?php echo lang('PhoneNo'); ?> <span class="uk-text-danger">*</span></p>
                      <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: receiver"></span>
                        <input class="uk-input" name="phone" id="s_phone" type="text">
                      </div>
                      <div class="error_phone error_msg"><?php echo lang('ThePhoneNofiledisrequired'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="uk-margin">
                      <p class="uk-margin-remove"><?php echo lang('email'); ?>
                      </p>
                      <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: lock"></span>
                        <input class="uk-input uk-child-width-expand" autocomplete="off" aria-autocomplete="off" onautocompleteerror="off" id="s_email" name="s_email" type="text">
                      </div>
                      <!--<div class="error_s_email error_msg">The Email filed is required.</div>-->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="uk-margin">
                      <p class="uk-margin-remove"><?php echo lang('Password'); ?> <span class="uk-text-danger">*</span>
                      </p>
                      <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: lock"></span>
                        <input class="uk-input uk-child-width-expand" id="s_password" name="password" type="password">
                      </div>
                      <div class="error_password error_msg"><?php echo lang('ThePasswordfiledisrequired'); ?>
                      </div>
                      <div class="error_password1 error_msg"><?php echo lang('ThePasswordfiledmustbeatleast6digit'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="uk-margin">
                      <p class="uk-margin-remove"><?php echo lang('address'); ?>
                      </p>
                      <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: home"></span>
                        <input class="uk-input uk-child-width-expand" id="s_address" type="text" name="address">
                      </div>
                      <div class="error_address error_msg"><?php echo lang('TheAddressfiledisrequired'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <span class="signup_status"></span>
                    <button class="c-btn save_signup_data txt-13" type="button" style="color: #fff; background-color:#cb150f"><?php echo lang('SignUp'); ?></button>
                    <br>
                    <?php echo lang('Or Sign Up With'); ?>-
                    <p style="margin: 0px;margin-bottom: 14px;font-size: 22px;"><a class="custom_icon" title="Google" href="<?= $google_auth_url ?>"><i class="fa fa-google"></i> </a> <a class="custom_icon" title="Facebook" href="<?= $facebook_auth_url ?>"><i class="fa fa-facebook-official"></i> </a></p>
                  </div>

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--Footer Content-->
  <?php
  $this->load->view('landing/inc/footer.php');
  ?>



<?php
  //delivery object prepare
  $javascript_obects_delivery_charge = "";
  $obj_charge = json_decode($getSiteSetting->deliveryChargeSetup);
  $total_products = sizeof($obj_charge);
  $i = 1;
  foreach ($obj_charge as $value) :
    if ($total_products == $i) {
      $javascript_obects_delivery_charge .= "{s_amount:'" . $value->s_amount . "',e_amount:'" . $value->e_amount . "',c_amount:'" . $value->c_amount . "'}";
    } else {
      $javascript_obects_delivery_charge .= "{s_amount:'" . $value->s_amount . "',e_amount:'" . $value->e_amount . "',c_amount:'" . $value->c_amount . "'},";
    }
    $i++;
  endforeach;

  ?>
  <!-- Start Script for Frontend -->
  <!-- Latest jQuery -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/jquery-1.12.4.min.js"></script>
  <!-- elevatezoom js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/2.2.3/jquery.elevatezoom.min.js"></script>
  <!-- popper min js -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/popper.min.js"></script>
  <!-- Latest compiled and minified Bootstrap -->
  <script src="<?php echo base_url(); ?>assets/frontend/bootstrap/js/bootstrap.min.js"></script>
  <!-- owl-carousel min js  -->
  <script src="<?php echo base_url(); ?>assets/frontend/owlcarousel/js/owl.carousel.min.js"></script>
  <!-- magnific-popup min js  -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/magnific-popup.min.js"></script>
  <!-- waypoints min js  -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/waypoints.min.js"></script>
  <!-- parallax js  -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/parallax.js"></script>
  <!-- countdown js  -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/jquery.countdown.min.js"></script>
  <!-- imagesloaded js -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/imagesloaded.pkgd.min.js"></script>
  <!-- isotope min js -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/isotope.min.js"></script>
  <!-- jquery.dd.min js -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/jquery.dd.min.js"></script>
  <!-- slick js -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/slick.min.js"></script>
  <!-- scripts js -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/scripts.js"></script>
  <!-- End Script for Frontend -->

  <script>
    window.delivery_charge = [<?= $javascript_obects_delivery_charge ?>];
    window.base_url = "<?= base_url() ?>";
    window.hidden_ok = "<?= lang('ok') ?>";
    window.hidden_alert = "<?= lang('alert') ?>";
    window.hidden_cancel = "<?= lang('cancel') ?>";
  </script>




  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.4.0/js/uikit.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.4.0/js/uikit-icons.min.js"></script>

  <script src="<?= mix('assets/landing/js/app.js') ?>"></script>

  <script>
    var sidebar = $('#rightSidebarForAddToCart');
    var sidebarHeight = $('#rightSidebarForAddToCart').height();
    var addProductMeter = sidebar.find('.addProductMeter').height();
    var btn2Box = sidebar.find('.btn2Box').height();
    var newHeight = Number(sidebarHeight) - Number(btn2Box) - Number(addProductMeter) - 20;
    sidebar.find('.showCartItem').css({
      height: newHeight + 'px'
    });

    //console.log(btn2Box);

    //#rightSidebarForAddToCart .content .showCartItem


    $(document).on('click', '.announcementClose', function() {
      iframe = $(this).closest('#announcement').find('iframe');
      url = iframe.attr('src');
      iframe.attr('src', '');
      setTimeout(function() {
        iframe.attr('src', url);
      }, 200)
    });

    <?php if (isset($page) && $page == 'search') : ?>
    <?php endif ?>

    <?php if (isset($refresh)) : ?>
      $(".main_div_product").hide();
      $(".show_cat_sub_products ").show();

      <?php if ($refresh == 'subcategory') : ?>
        $(".show_cat_sub_products").hide();
      <?php else : ?>
        $(".show_cat_sub_products").hide();
      <?php endif ?>

      <?php if ($refresh == 'search') : ?>
        $('#search_landing').val('<?= $string ?>').trigger('keyup');
      <?php endif ?>

      $(".search_hide_div").hide();
    <?php endif ?>

    //delivery object
    var social_login_msg = "<?= $social_login_msg ?>";
    if (social_login_msg) {
      swal_alert_happy(hidden_alert, social_login_msg);
    }
  </script>

  <!-- zoom -->
  <script>
    $("#product_img").elevateZoom();
  </script>
  <!-- zoom -->

</body>

</html>