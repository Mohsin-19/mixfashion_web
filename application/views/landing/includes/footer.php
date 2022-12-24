<?php

$pages = get_pages();

?>


<div class="fottersecound overlay_bg_30" style="background:#000;">
  <div class="footer_top small_pt pb-0">
    <div class="custom-container">
      <div class="row">

        <div class="col-sm">
          <!-- <div class="widget">
                <h6 class="widget_title">CUSTOMER SERVICE</h6>
                <ul class="widget_links pl-0">
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">Discount</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="#">Orders History</a></li>
                    <li><a href="#">Order Tracking</a></li>
                </ul>
            </div> -->
        </div>
        <div class="col-sm">
          <div class="widget">
            <h6 class="widget_title">About Mix Fashion House</h6>
            <ul class="widget_links pl-0">
              <?php
              foreach ($pages as $value) :
                if ($value->id != 10) :
              ?>
                  <li>
                    <a href="<?= site_url($value->slug) ?>">
                      <?= escape_output($value->menu_name); ?>
                    </a>
                  </li>
              <?php
                endif;
              endforeach;
              ?>
            </ul>
          </div>
        </div>

        <div class="col-sm">
          <div class="widget">
            <h6 class="widget_title">Customer care</h6>

            <ul class="widget_links pl-0">
              <li><a href="#">Help Center</a></li>
              <li><a href="#">How to buy</a></li>
              <li><a href="#">Returns & Refound</a></li>
            </ul>
          </div>
        </div>

        <div class="col-sm">
          <div class="widget">
            <h6 class="widget_title">Follow us</h6>
            <ul class="widget_links pl-0 social_design">
              <li><a href="#" target="_blank"><i class="icon-facebook-rect"></i> Facebook</a></li>
              <li><a href="#" target="_blank"><i class="icon-instagram-1"></i> Instagram</a></li>
              <li><a href="#" target="_blank"><i class="icon-twitter"></i> Twitter</a></li>
              <li><a href="#" target="_blank"><i class="icon-youtube-play"></i> Youtube</a></li>
            </ul>
          </div>
        </div>

        <div class="col-sm">
          <!-- <div class="widget">
                <h6 class="widget_title">My Account</h6>
                <ul class="widget_links pl-0">
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">Discount</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="#">Orders History</a></li>
                    <li><a href="#">Order Tracking</a></li>
                </ul>
            </div> -->
        </div>
      </div>

      <hr style="border-color: #000;">

      <!-- Start SECTION Payment -->
      <!-- <div class="position-relative">
        <img src="<?= site_url("assets/frontend/images/ssl.png") ?>" class="img-fluid" alt="logo" />
      </div> -->
      <!-- END SECTION Payment -->

      <hr style="border-color: #000;">

    </div>
  </div>
  <div class="bottom_footer border-top-tran" style="background:#cb150f;">
    <div class="custom-container">
      <div class="row align-items-right">
        <div class="col-lg-12">
          <p class="mb-lg-0 text-center text-white">Copyright &copy; <?= date('Y') ?> Mix Fashion. All Rights Reserved by Mix Fashion. Developed By <a href="https://avanteca.com.bd">Avanteca Limited</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- START FOOTER -->
<footer class="bg_gray">


</footer>
<!-- END FOOTER -->
<!--<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up text-white"></i></a>-->