<?php
$getSiteSetting = getSiteSetting();
$special_categories = special_categories();
$all_categories = all_categories();
// $all_categories = sidebar_categories();


$currency = $getSiteSetting->currency;
$site_logo = $getSiteSetting->site_logo;
//set display css
$display = "display:none";
//set default color
$base_color = "#6ab04c";
if (isset($getSiteSetting->base_color) && $getSiteSetting->base_color) {
  $base_color = $getSiteSetting->base_color;
}
$paymentSetting = paymentSetting();

?>

<!-- START HEADER -->
<header class="header_wrap fixed-top header_with_topbar">
  <div class="top-header d-none d-md-block">
    <div class="custom-container">
      <div class="row align-items-center">
        <div class="col-md-6">

        </div>
        <div class="col-md-6">

        </div>
      </div>
    </div>
  </div>
  <div class="bottom_header padUpDn dark_skin main_menu_uppercase">
    <div class="custom-container">
      <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="<?= site_url('/') ?>">
          <?php
          $logo_light = isset($logo_light) ? 'assets/images/' . $logo_light : 'assets/images/shatkahon.png';
          $site_logo = $site_logo ? 'assets/images/' . $site_logo : 'assets/images/shatkahon.png';
          ?>
          <img class="logo_light d-inline d-md-none" src="<?= base_url($site_logo) ?>" alt="logo" />
          <img class="logo_dark d-none d-md-inline" src="<?= base_url($site_logo) ?>" alt="logo" />
        </a>

        <button class="d-inline d-md-none navbar-toggler sidebar_collapse" type="button" data-toggle="collapse" aria-expanded="false">
          <span class="icon-menu"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">

          <div class="product_search_form">
            <form method="GET" class="header_search_form" action="<?= site_url('search') ?>">
              <input class="form-control search_landing" placeholder="Search for your desired products" autocomplete="off" required="required" type="text">
              <button type="submit" class="search_btn2"><i class="icon-search"></i></button>
            </form>
          </div>

          <div class="hotline">
            <?php if (isset($getSiteSetting->phone) && $getSiteSetting->phone) : ?>
              <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                <ul class="contact_detail text-center pl-4 text-lg-left">
                  <a href="tel:<?= $getSiteSetting->phone ?>"><i class="icon-phone" style="color:#000;"></i></a>
                  <!-- <li><a href="tel:<?= $getSiteSetting->phone ?>"><span><?= $getSiteSetting->phone ?></span></a></li> -->
                </ul>
              </div>
            <?php endif ?>
          </div>

          <div class="text-center text-md-right">
            <ul class="header_list pl-3">

              <?php
              $c_id = $this->session->userdata("c_id");
              $c_name = $this->session->userdata("c_name");
              $c_photo = $this->session->userdata("c_photo");
              $c_phone = $this->session->userdata("c_phone");
              ?>

              <?php if ($c_id) : ?>
                <li class="dropdown">
                  <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown" aria-expanded="false"><?= $c_name ?></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item " href="#change_profile" data-toggle="modal"><?= lang('ChangeProfile'); ?></a>
                    <a class="dropdown-item " href="<?= site_url('my-orders') ?>"><?= lang('MyOrders'); ?></a>
                    <!-- <a class="dropdown-item " href="#changePass">Change password</a> -->
                    <a class="dropdown-item " href="<?= site_url('logout') ?>"><?= lang('Logout'); ?></a>
                  </div>
                </li>
              <?php else : ?>
                <li><a href="<?= site_url('login') ?>" class="nav-link"><i class="icon-user-female"></i><span>Login</span></a></li>
              <?php endif; ?>

            </ul>
          </div>

        </div>
        <ul class="navbar-nav attr-nav align-items-center">
          <li class="d-inline d-md-none"><a href="javascript:void(0);" class="nav-link search_trigger"><i class="linearicons-magnifier"></i></a>
          </li>
          <li>
            <a href="<?= site_url('wishlist') ?>" class="nav-link">
              <i class="icon-heart-empty"></i><span class="wishlist_count">0</span></a>
          </li>
          <li class="dropdown cart_dropdown"><a class="nav-link cart_trigger" href="#" data-toggle="dropdown">
              <i class="icon-shopping-bag"></i><span class="cart_count">2</span></a>
            <div class="cart_box dropdown-menu dropdown-menu-right">
              <ul class="cart_list addToCartBox">
                <!-- card data will append here -->
              </ul>
              <div class="cart_footer">
                <p class="cart_total"><strong>Subtotal:</strong> <span class="cart_price"></span> <span class="totalVal"><?= $currency ?> 0.00</span>
                </p>
                <p class="cart_buttons">
                  <a href="<?= site_url('/checkout') ?>" class="btn btn-block btn-fill-out btn-radius checkout">Checkout</a>
                </p>
              </div>
            </div>
          </li>
        </ul>
      </nav>
    </div>
  </div>

  <div class="bottom_header dark_skin main_menu_uppercase border-top d-none d-md-block" style="background-color: red;">
    <div class="container">
      <div class="row align-items-center align-content-center">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
          <nav class="navbar navbar-expand-lg">
            <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
              <ul class="navbar-nav mx-auto">
                <li class="">
                  <a class="nav-link nav_item" href="<?= base_url('/') ?>">Home</a>
                </li>
                <li class="dropdown">
                  <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">All Categoorys</a>
                  <div class="dropdown-menu">
                    <ul class="pl-0">
                      <?php foreach ($all_categories as $key => $value) : ?>
                        <li>
                          <a class="dropdown-item nav-link nav_item" href="<?= site_url($value->slug) ?>">
                            <?= (ucfirst($value->name)) ?>
                          </a>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </li>
                <!-- <?php foreach ($all_categories as $key => $value) : ?>
                  <?php
                        if (isset($value->subcategories) && $value->subcategories) :
                  ?>
                    <li class="dropdown">
                      <a class="dropdown-toggle nav-link" href="<?= base_url($value->slug) ?>" data-toggle="dropdown"><?php echo (ucfirst($value->name)) ?></a>
                      <div class="dropdown-menu">
                        <ul class="pl-0">
                          <?php foreach ($value->subcategories as $key1 => $value1) : ?>
                            <li><a class="dropdown-item nav-link nav_item" href="<?= base_url($value1->slug) ?>"><?php echo (escape_output($value1->name)); ?></a></li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    </li>
                  <?php
                        else :
                  ?>
                    <li><a class="nav-link nav_item" href="<?= base_url($value->slug) ?>"><?= (ucfirst($value->name)) ?></a></li>
                  <?php
                        endif;
                  ?>
                <?php endforeach; ?> -->

                <li><a class="nav-link nav_item" href="contact-us">Contact Us</a></li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </div>


  <div class="product_search_form2 d-none">
    <form method="GET" class="header_search_form" action="<?= site_url('search') ?>">
      <button type="button" class="btn search_close"><i class="fa fa-times"></i></button>
      <input class="form-control mobile_search_landing" placeholder="Search for products, brands and shops" autocomplete="off" required="required" type="text">
      <button type="submit" class="search_btn2"><i class="fa fa-search"></i></button>
    </form>
  </div>

</header>
<!-- END HEADER -->