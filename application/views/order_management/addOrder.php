<section class="content-header">
  <h1> Add New Order </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <input type="hidden" name="deliveryCharges" id="deliveryCharges" value="<?= 'ads' ?>">
        <!-- form start -->
        <div class="box-body">
          <div class="row">
            <div class="col-sm-9">
              <div class="row">
                <div class="col-md-6 searchProductBox">
                  <div class="form-group">
                    <label for="search_product">Search Product</label>
                    <input type="text" id="search_product" name="search_product" class="form-control" autofocus="autofocus" autocomplete="off" placeholder="Search by English (eg: Potato), Your Language (eg:আলু), Banglish (eg:alu)">
                  </div>
                  <?= error_message('checkout_name') ?>
                  <div class="suggestion-box"></div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="purchase_price">Purchase Price</label>
                    <input type="text" id="purchase_price" name="purchase_price" class="form-control" placeholder="Purchase Price" readonly="readonly">
                  </div>
                  <?= error_message('purchase_price') ?>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="sale_unit">Sale Unit</label>
                    <input type="text" id="sale_unit" name="sale_unit" class="form-control" placeholder="Sale Unit" readonly="readonly">
                  </div>
                  <?= error_message('sale_unit') ?>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="sale_quantity">Sale Quantity</label>
                    <input type="text" id="sale_quantity" name="sale_quantity" class="form-control" placeholder="Sale Quantity">
                  </div>
                  <?= error_message('sale_quantity') ?>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="sale_price">Sale Price</label>
                    <input type="text" id="sale_price" name="sale_price" class="form-control" placeholder="Sale Price">
                  </div>
                  <?= error_message('sale_price') ?>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="invisible">Add</label>
                    <input type="submit" class="btn btn-primary form-control" id="addToCartButton" value="Add to cart">
                  </div>
                  <?= error_message('sale_price') ?>
                </div>
              </div> <!-- row -->
            </div> <!-- col-sm-8 -->
            <div class="col-sm-3">
              <div class="form-group">
                <img src="<?= base_url('assets/images/no_image_thumb.png') ?>" id="product_image" style="max-width: 150px">
              </div>
            </div> <!-- col-sm-4 -->
          </div> <!-- row -->

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Name</th>
                      <th class="text-center">Quantity</th>
                      <th class="text-center">Unit</th>
                      <th class="text-right">Price</th>
                      <th class="text-right">Total</th>
                      <th style="width: 135px; text-align:center">Action</th>
                    </tr>
                  </thead>
                  <tbody id="productTableBody">
                    <!-- add to cart item added there -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>

        <div class="box-footer">
          <button type="submit" id="proceedBtn" class="btn btn-primary">Proceed</button>
          <a href="<?= site_url('orderManagement/orders') ?>" class="btn btn-primary"><?= lang('back'); ?></a>
        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="orderAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square-o txt-uh-48"></i> <?php echo lang('add_supplier'); ?></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="checkout_name">Checkout Name</label>
                <input type="text" id="checkout_name" name="checkout_name" class="form-control" placeholder="Checkout Name">
              </div>
              <?= error_message('checkout_name') ?>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="checkout_phone">Checkout Phone</label>
                <input type="text" id="checkout_phone" name="checkout_phone" class="form-control" placeholder="Checkout Phone">
              </div>
              <?= error_message('checkout_phone') ?>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="checkout_email">Another Phone</label>
                <input type="text" id="checkout_email" name="checkout_email" class="form-control" placeholder="Another Phone">
              </div>
              <?= error_message('checkout_email') ?>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="area">Area</label>
                <input type="text" id="area" name="area" class="form-control" placeholder="Area">
              </div>
              <?= error_message('area') ?>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" class="form-control" placeholder="Address">
              </div>
              <?= error_message('address') ?>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="order_date_time">Order Date Time</label>
                <input type="text" id="order_date_time" name="order_date_time" class="form-control customDatepicker" placeholder="Order Date" value="<?= date('Y-m-d') ?>">
              </div>
              <?= error_message('order_date_time') ?>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="delivery_date">Delivery Date</label>
                <input type="text" id="delivery_date" name="delivery_date" class="form-control customDatepicker" placeholder="Delivery Date" value="<?= date('Y-m-d') ?>">
              </div>
              <?= error_message('delivery_date') ?>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="delivery_time">Delivery Time</label>
                <input type="text" id="delivery_time" name="delivery_time" class="form-control customDatepicker_time" placeholder="Delivery Time" value="<?= date('H:i a') ?>">
              </div>
              <?= error_message('delivery_time') ?>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="status">Status</label>
                <input type="text" id="status" name="status" class="form-control customDatepicker_time" placeholder="Status">
              </div>
              <?= error_message('status') ?>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="addSupplier">
            <i class="fa fa-save"></i> <?php echo lang('submit'); ?></button>
        </div>
      </div>
    </div>
  </div>

</section>


<?php
//delivery object prepare
$javascript_objects_delivery_charge = "";
$obj_charge = json_decode(getSiteSetting()->deliveryChargeSetup);
$total_products = sizeof($obj_charge);
$i = 1;
foreach ($obj_charge as $value) {
  if ($total_products == $i) {
    $javascript_objects_delivery_charge .= "{s_amount:'" . $value->s_amount . "',e_amount:'" . $value->e_amount . "',c_amount:'" . $value->c_amount . "'}";
  } else {
    $javascript_objects_delivery_charge .= "{s_amount:'" . $value->s_amount . "',e_amount:'" . $value->e_amount . "',c_amount:'" . $value->c_amount . "'},";
  }
  $i++;
}

?>

<style>
  .applyCouponButton {
    border-top-right-radius: 4px !important;
    border-bottom-right-radius: 4px !important;
    cursor: pointer;
  }
</style>

<script>
  window.delivery_charge = [<?= $javascript_objects_delivery_charge ?>];
</script>


<script src="<?= base_url('assets/js/add_edit_order.js'); ?>"></script>