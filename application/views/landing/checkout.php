<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">

<?php
$getSiteSetting = getSiteSetting();
$currency = $getSiteSetting->currency;
?>

<span id="single_page_name" class="d-none">checkout</span>
<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">
    <div class="col-md-12">
      <ol class="breadcrumb justify-content-start">
        <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
        <li class="breadcrumb-item active">Checkout</li>
      </ol>
    </div>
  </div>
</div>

<div class="main_content">
  <div class="custom-container">
    <div class="row">
      <div class="col-md-8 px-1">
        <div class="card">
          <div class="card-body">
            <table class="table " id="checkout_cart">
              <thead>
                <tr>
                  <th class="text-center">Sl</th>
                  <th>Product</th>
                  <th class="text-center">Quantity</th>
                  <th class="text-right">Total</th>
                </tr>
              </thead>
              <tbody id="checkoutItemBody">
                <!-- checkout item load here -->
              </tbody>
            </table> <!-- checkout_cart -->
          </div>
        </div>
      </div> <!-- col-md-4 -->
      <div class="col-md-4 px-1">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title"> Shipping address </h4>
            <?php
            $c_name = $this->session->userdata("c_name");
            $c_phone = $this->session->userdata("c_phone");
            $c_email = $this->session->userdata("c_email");
            ?>
            <div class="shipping-address">
              <span class="d-none" id="delivery_districts"><?= json_encode($districts) ?></span>
              
              <form action="<?= site_url('ajax/checkout/cart-save-session') ?>" method="POST" id="shipping-form">
                <input type="hidden" name="hidden_coupon_code" id="hidden_coupon_code">
                <input type="hidden" name="hidden_coupon_amount" id="hidden_coupon_amount">
                <input type="hidden" name="city_name" id="city_name">
                <input type="hidden" name="city" id="city">
                <div class="form-group">
                  <label for="name" class="m-0">Name <span class="text-danger">*</span></label>
                  <input type="text" name="name" id="name" class="form-control" placeholder="Name" autofocus="autofocus" value="<?= $c_name ?>" autocomplete="name" required="required">
                </div>
                <div class="form-group">
                  <label for="phone" class="m-0">Phone <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">+88</span>
                    </div>
                    <input type="text" name="phone" id="phone" placeholder="Phone" value="<?= $c_phone ?>" class="form-control address_phone" autocomplete="phone" aria-describedby="phone" required="required">
                  </div>
                  <small id="phoneHelp" class="form-text text-muted">Example: 01734905649</small>
                </div>
                <div class="form-group">
                  <label for="email" class="m-0">Email</label>
                  <input type="email" name="email" id="email" value="<?= $c_email ?>" class="form-control" placeholder="Email" autocomplete="email">
                </div>
                <div class="form-group">
                  <label for="district_name" class="m-0">City <span class="text-danger">*</span></label>
                  <select name="district_name" id="district_name" class="form-control" required="required">
                    <option value="">- Select Area -</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="address" class="m-0">Address <span class="text-danger">*</span></label>
                  <textarea name="address" id="address" rows="3" class="form-control" placeholder="Address" autocomplete="address" required="required"></textarea>
                </div>
                <input type="submit" value="submit" id="shipping-submit" name="submit" class="d-none">
              </form>
            </div>
          </div> <!-- card-body -->

          <div class="card-body pt-0 pb-4">
            <h4 class="card-title"> Have a Coupon ?</h4>
            <div class="apply-coupon">
              <form action="<?= site_url('ajax/check-coupon') ?>" method="POST" id="check_coupon">
                <div class="input-group">
                  <input type="text" name="coupon" id="coupon" class="form-control" placeholder="Coupon code" required="required">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-success">Apply</button>
                  </div>
                </div>
                <div class="coupon_alert d-none">
                  <p class="m-0">
                    <span class="coupon_text"></span>
                    <a href="/remove-coupon" class="text-danger close_coupon">Remove</a>
                  </p>
                </div>
              </form>
            </div>
          </div> <!-- card-body -->

          <div class="card-body pt-0">
            <h4 class="card-title"> Checkout summary</h4>
            <table class="table table-small" id="checkout_Summary">
              <tr>
                <td class="text-left">Subtotal</td>
                <td class="text-right"><span class="checkout_subtotal">0.00</span></td>
              </tr>
              <tr>
                <td class="text-left">Vat <?= $getSiteSetting->vat ?>%</td>
                <td class="text-right "><span class="vat_charge">0.00</span></td>
              </tr>
              <tr>
                <td class="text-left">Delivery charge</td>
                <td class="text-right "><span class="del_charge">0.00</span></td>
              </tr>
              <tr>
                <td class="text-left">Discount</td>
                <td class="text-right"><span class="checkout_discount"><?= $currency ?> 0.00</span></td>
              </tr>
              <tr>
                <td class="text-left">Total payable</td>
                <td class="text-right "><span class="checkout_total">0.00</span></td>
              </tr>
            </table> <!-- checkout_cart -->
            <button type="button" class="process_order btn btn-block btn-dark">Make Payment</button>
          </div> <!-- card-body -->
        </div>
      </div> <!-- col-md-4 -->

    </div> <!-- row -->

  </div> <!-- custom-container -->
</div> <!-- main_content -->
<input id="vat" type="hidden" value="<?= $getSiteSetting->vat ?>">