<div class="main_content " style="margin: 100px 0">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="text-center order_complete">
          <i class="fas fa-check-circle"></i>
          <div class="heading_s1">
            <h3>Your order is completed!</h3>
          </div>
          <h2 class="text-success"><?= lang('Orderhasbeenplacedsuccessfullyyourordernumberis'); ?></h2>
          <p class="txt-29 my-4 text-success redirect_page_counter">5</p>
          <a href="<?= site_url('/') ?>" class="btn btn-fill-out">Continue Shopping</a>
        </div>
      </div>
    </div>
  </div> <!-- container -->
</div> <!-- main_content -->



<script src="<?= base_url('assets/landing/js/payment_success.js') ?>"></script>