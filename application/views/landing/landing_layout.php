<?php
$getSiteSetting = getSiteSetting();
$getShopSetting = getShopSetting();
$search_page = search_page();
$all_special_categories = all_special_categories();
$social_login_msg = social_login_msg();
//set default currency
$currency = "$";
if (isset($getSiteSetting->currency) && $getSiteSetting->currency) {
  $currency = $getSiteSetting->currency;
}
//set default color
$base_color = "#6ab04c";
if (isset($getSiteSetting->base_color) && $getSiteSetting->base_color) {
  $base_color = $getSiteSetting->base_color;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <meta name="author" content="Avanteca Limited">
  <meta name="Developer" content="Sumon Ahmed">
  <meta name="resource-type" content="document">
  <meta name="contact" content="sumon4skf@gmail.com">
  <meta name="copyright" content="Copyright (c) <?= date("Y"); ?>. All Rights &reg;Reserved by shatkahonbd.com">

  <meta name="robots" content="index, follow">
  <meta name="googlebot" content="index, follow">
  <meta name="googlebot-news" content="index, follow">
  <meta name="msnbot" content="index, follow">
  <?php
  $appTitle =  isset($getSiteSetting->site_title) && $getSiteSetting->site_title ? $getSiteSetting->site_title : '';
  ?>
  <meta property="fb:app_id" content="517977738399933">
  <meta property="og:site_name" content="shatkahonbd">
  <meta property="og:title" content="<?= $appTitle; ?>">
  <meta property="og:description" content="<?= $appTitle ?>">
  <meta property="og:url" content="<?= site_url('/'); ?>">
  <meta property="og:type" content="article">
  <meta property="og:image" content="<?= base_url("assets/images/meta-banner.png") ?>">
  <meta property="og:locale" content="en_US">

  <title> <?= $appTitle ?> </title>

  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url("assets/frontend/images/favicon/apple-touch-icon.png") ?>">
  <?php if (isset($getSiteSetting->favicon) && $getSiteSetting->favicon) : ?>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url("assets/images/" . $getSiteSetting->favicon) ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("assets/images/" . $getSiteSetting->favicon) ?>">
  <?php else : ?>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/landing/img/favicon.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/landing/img/favicon.png') ?>">
  <?php endif; ?>
  <link rel="manifest" href="<?= base_url("assets/frontend/images/favicon/site.webmanifest") ?>">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">

  <!-- preloaded css -->
  <link rel="stylesheet" href="<?= mix('assets/landing/css/preApp.css') ?>">

  <!-- Icon Font CSS -->
  <link rel="stylesheet" href="<?= base_url("assets/plugins/fontello/css/fontello.css"); ?>">

  <!--- owl carousel CSS-->
  <link rel="stylesheet" href="<?= base_url("assets/frontend/owlcarousel/css/owl.carousel.min.css"); ?>">
  <link rel="stylesheet" href="<?= base_url("assets/frontend/owlcarousel/css/owl.theme.css"); ?>">
  <link rel="stylesheet" href="<?= base_url("assets/frontend/owlcarousel/css/owl.theme.default.min.css"); ?>">
  <!-- Magnific Popup CSS -->
  <link rel="stylesheet" href="<?= base_url("assets/frontend/css/magnific-popup.css"); ?>">
  <!-- Slick CSS -->
  <link rel="stylesheet" href="<?= base_url("assets/frontend/css/slick.css"); ?>">
  <link rel="stylesheet" href="<?= base_url("assets/frontend/css/slick-theme.css"); ?>">

  <link rel="stylesheet" href="<?= mix('assets/landing/css/app.css') ?>">


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
  ?>

  <?php if ($font_detect == "bangla") : ?>
    <link rel="stylesheet" href="<?= base_url('assets/landing/css/bangla.css') ?>">
  <?php endif; ?>

  <?php
  $this->load->view('landing/includes/header-style.php', ['base_color' => $base_color]);
  ?>



  <!-- Facebook Pixel Code -->
  <script>
    ! function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
      'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '863669651021262');
    fbq('track', 'PageView');

    function fb_pixel_ViewContent(contents, content_name, content_category, price, num_items = 1) {
      fbq('track', 'ViewContent', {
        contents: contents,
        content_type: 'product',
        value: price,
        currency: 'BDT',
        content_name: content_name,
        content_category: content_category,
        num_items: num_items,
      });
    }

    function fb_pixel_AddToCart(contents, price, num_items = 1) {
      fbq('track', 'AddToCart', {
        contents: contents,
        content_type: 'product',
        value: price,
        currency: 'BDT',
        num_items: num_items
      });
    }

    function fb_pixel_Purchase(contents, price, num_items = 1) {
      fbq('track', 'Purchase', {
        contents: contents,
        content_type: 'product',
        value: price,
        currency: 'BDT',
        num_items: num_items
      });
    };
  </script>
  <noscript>
    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=863669651021262&ev=PageView&noscript=1" />
  </noscript>
  <!-- End Facebook Pixel Code -->

</head>

<body class="" style="<?= $font_detect == "bangla" ? 'font-family:bangla_font' : '' ?>">


  <!-- LOADER -->
  <div class="preloader">
    <div class="lds-ellipsis">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <!-- END LOADER -->

  <?php
  $this->load->view('landing/includes/fb-chat.php');
  ?>


  <?php if (isset($announcement) && !isset($refresh)) : ?>
    <div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content rounded">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
            </button>
            <div class="row no-gutters p-3" style="min-height: 300px;">
              <div class="col-12">
                <?php
                $content = $announcement->upload_content;
                if ($announcement->upload_type == 'img') {
                  $upload_content = '<img src="' . base_url('images/' . $content) . '" style="width:100%" alt="' . $announcement->title . '">';
                } elseif ($announcement->upload_type == 'yt') {
                  $upload_content = '<iframe src="https://www.youtube-nocookie.com/embed/' . youTube_id($content) . '?autoplay=1&amp;showinfo=0&amp;rel=0&amp;modestbranding=1&amp;playsinline=1" width="1280" height="720" frameborder="0" allowfullscreen uk-responsive uk-video="autoplay: inview"></iframe>';
                } else {
                  $upload_content =  $announcement->description;
                }
                echo $upload_content;
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php
  $this->load->view('landing/includes/header.php');

  if (isset($all_special_categories)) {
    $this->load->view('landing/includes/sidebar.php');
  }


  $search = isset($search) ? $search : '';
  $search_products = isset($search_products) ? $search_products : [];


  ?>

  <div id="searching_page" style="display:<?= $search ? '' : 'none' ?>">
    <?php
    $this->load->view('landing/searchProducts.php', ['products' => $search_products]);
    ?>
  </div>


  <div id="normal_page">

    <?php
    if (isset($all_slides)) {
      $this->load->view('landing/includes/banner.php', ['all_slides' => $all_slides]);
    }
    ?>

    <?= isset($main_content) && $main_content ? $main_content : '' ?>

  </div>


  <div class="modal fade" id="change_profile" tabindex="-1" role="dialog" aria-labelledby="change_profileLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content ">
        <div class="modal-header">
          <h5 class="modal-title" id="change_profileLabel">Update profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" id="form_change_profile" enctype="multipart/form-data">

            <div class="form-group">
              <label for="sc_name"><?= lang('name'); ?> <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="sc_name" id="sc_name" placeholder="Name" value="<?= $this->session->userdata('c_name') ?>">
              <?= show_field_error('sc_name'); ?>
            </div>

            <div class="form-group">
              <label for="sc_phone"><?= lang('phone'); ?> <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="sc_phone" id="sc_phone" placeholder="Phone" value="<?= $this->session->userdata('c_phone') ?>">
              <?= show_field_error('sc_phone'); ?>
            </div>

            <div class="form-group">
              <label for="sc_email"><?= lang('email'); ?> <span class="text-danger">*</span></label>
              <input type="email" class="form-control" name="sc_email" id="sc_email" placeholder="email" value="<?= $this->session->userdata('c_email') ?>">
              <?= show_field_error('sc_email'); ?>
            </div>

            <div class="form-group">
              <label for="sc_photo"><?= lang('Photo'); ?> </label>
              <input type="file" class="form-control-file" name="sc_photo" id="sc_photo">
              <?= show_field_error('sc_photo'); ?>
            </div>

            <div class="form-group">
              <label for="address"><?= lang('address'); ?> </label>
              <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?= $this->session->userdata('c_address') ?>">
              <?= show_field_error('address'); ?>
            </div>

            <div class="form-group">
              <button class="btn btn-block btn-success save_change_profile_data " type="button"><?= lang('submit'); ?></button>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <?php
  $this->load->view('landing/includes/footer.php');
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

  <script>
    window.delivery_charge = [<?= $javascript_obects_delivery_charge ?>];
    window.base_url = "<?= base_url() ?>";
    window.currency = "<?= $currency ?>";
    window.hidden_ok = "<?= lang('ok') ?>";
    window.hidden_alert = "<?= lang('alert') ?>";
    window.hidden_cancel = "<?= lang('cancel') ?>";
  </script>



  <script src="<?= mix('assets/landing/js/app.js') ?>"></script>

  <!-- owl-carousel min js  -->
  <script src="<?php echo base_url(); ?>assets/frontend/owlcarousel/js/owl.carousel.min.js"></script>
  <!-- magnific-popup min js  -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/magnific-popup.min.js"></script>
  <!-- parallax js  -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/parallax.js"></script>
  <!-- imagesloaded js -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/imagesloaded.pkgd.min.js"></script>
  <!-- jquery.dd.min js -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/jquery.dd.min.js"></script>
  <!-- slick js -->
  <script src="<?php echo base_url(); ?>assets/frontend/js/slick.min.js"></script>

  <!-- elevatezoom js -->
  <script src="<?= base_url("assets/frontend/js/jquery.elevatezoom.js") ?>"></script>
  <!-- scripts js -->
  <script src="<?= base_url("assets/frontend/js/scripts.js"); ?>"></script>
  <!-- End Script for Frontend -->

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


    //delivery object
    var social_login_msg = "<?= $social_login_msg ?>";
    if (social_login_msg) {
      swal_alert_happy(hidden_alert, social_login_msg);
    }
  </script>


  <script>
    $(document).ready(function() {
      $('.fa-times').click(function() {
        $(".searchBox").addClass("d-none");
      });
      $('.searchicon').click(function() {
        $(".searchBox").removeClass("d-none");
      });
    });
  </script>



</body>

</html>