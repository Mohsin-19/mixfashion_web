<section class="content-header">
  <h3 class="txt-uh-83"><?php echo lang('productSaleReport'); ?></h3>
  <hr class="txt-uh-83">
  <div class="row">
    <div class="col-md-2">
      <?php echo form_open(base_url() . 'Report/saleReport', $arrayName = array('id' => 'orderReport')) ?>
      <div class="form-group">
        <input tabindex="1" autocomplete="off" type="text" id="" name="startDate" class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>" value="<?php echo date('Y-m-d') ?>">
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <input tabindex="2" autocomplete="off" type="text" id="endMonth" name="endDate" class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>" value="<?php echo date('Y-m-d') ?>">
      </div>
    </div>
    <div class="col-md-2">
      <select class="form-control select2 width_100_p" name="area">
        <option value=""><?php echo lang('Area'); ?></option>
        <?php
        foreach ($arees as $value) :
        ?>
          <option <?php echo set_select('area', $value->name); ?> value="<?php echo escape_output($value->name); ?>"><?php echo escape_output($value->name); ?></option>
        <?php
        endforeach;
        ?>
      </select>
    </div>

    <div class="col-md-2">
      <select class="form-control select2 width_100_p" name="status">
        <option value=""><?php echo lang('status'); ?></option>
        <option <?php echo set_select('status', "New"); ?> value="New"><?php echo lang('New'); ?></option>
        <option <?php echo set_select('status', "Cancel"); ?> value="Cancel"><?php echo lang('cancel'); ?></option>
        <option <?php echo set_select('status', "In Progress"); ?> value="In Progress"><?php echo lang('InProgress'); ?></option>
        <option <?php echo set_select('status', "Delivered"); ?> value="Delivered"><?php echo lang('Delivered'); ?></option>
      </select>
    </div>
    <div class="col-md-1">
      <div class="form-group">
        <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
      </div>
    </div>
    <div class="hidden-lg">
      <div class="clearfix"></div>
    </div>
  </div>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <h3 class="c_center"><?php echo lang('productSaleReport'); ?></h3>
          <h4 class="c_center"><?php echo isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('date') . ": " . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?php echo isset($start_date) && $start_date && !$end_date ? lang('date') . ": " . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?php echo isset($end_date) && $end_date && !$start_date ? lang('date') . ": " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
          <?php
          if (isset($area) && $area) : ?>
            <h4 class="c_center"><?php echo lang('Area'); ?>: <?php echo escape_output($area) ?></h4>
          <?php
          endif;
          ?> <?php
              if (isset($status) && $status) : ?>
            <h4 class="c_center"><?php echo lang('status'); ?>: <?php echo escape_output($status) ?></h4>
          <?php
              endif;
          ?>
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('ProductSaleReport'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-striped">
            <thead>
              <tr>
                <th scope="col"><?php echo lang('sn'); ?></th>
                <th scope="col"><?php echo lang('date'); ?></th>
                <th scope="col"><?php echo lang('OrderNumber'); ?></th>
                <th scope="col"><?php echo lang('customer'); ?></th>
                <th scope="col">Product</th>
                <th scope="col">QTY</th>
                <th scope="col">Unit</th>
                <th scope="col">Purchase-Price</th>
                <th scope="col">MRP</th>
                <th scope="col">Item-Value</th>
                <th scope="col">Discount</th>
                <th scope="col">Net Item Value</th>
                <th scope="col">Order Value</th>
                <th scope="col">Coupon Discount</th>
                <th scope="col"><?= lang('DeliveryCharge'); ?></th>
                <th scope="col">Net Order Value</th>
                <th scope="col">Sold-By</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $qty = 0;
              $price = 0;
              $item_value = 0;
              $discount = 0;
              $netItemValue = 0;
              $total_amount = 0;
              $total_tax = 0;
              $deliveryCharge = 0;
              $total_avg_purchase = 0;
              $order_number = 0;
              $orderValue = 0;
              $couponDiscount = 0;
              $order_value = 0;
              $total_Order = 0;
              $end_row = 0;
              if (isset($orderReport)) :
                foreach ($orderReport as $key => $value) :
                  $qty += $value->qty;
                  $price += $value->price;
                  $item_value += $value->price * $value->qty;
                  $discount += $value->discount;
                  $netItemValue += $value->price * $value->qty - $value->discount;
                  $total_amount += $value->total_amount;
                  $total_tax += $value->total_tax;

                  //calculate all over average price
                  $all_avg_total = $value->avg_total + ($value->opening_stock * $value->purchase_price);
                  $all_avg_quantity = $value->avg_quantity + $value->opening_stock;
                  $avg_purchase = $all_avg_total;
                  if ($all_avg_quantity > 0) {
                    $avg_purchase = ($all_avg_total / $all_avg_quantity);
                  }

                  $total_avg_purchase += $avg_purchase;

                  $key++;
                  $order_number = $value->order_number;
                  $total_row = count_order_items($order_number);

                  if ($order_number != $end_row) {
                    $orderValue += $value->order_value;
                    $couponDiscount += $value->coupon_discount;
                    $deliveryCharge += $value->delivery_charge;
                    $order_value = $value->order_value - $value->delivery_charge - $value->coupon_discount;
                    $total_Order += $order_value;
                  }

              ?>
                  <tr>
                    <?php if ($order_number != $end_row) : ?>
                      <th class="txt-uh-41" scope="row"><?php echo escape_output($key) ?></th>
                      <td class="txt-uh-41"><?php echo date("d/m/Y", strtotime($value->delivery_date)) ?></td>
                      <td class="txt-uh-41"><?php echo escape_output($value->order_number); ?> </td>
                      <td class="txt-uh-41"><?php echo escape_output($value->customer_name); ?>
                        (<?php echo escape_output($value->customer_phone); ?>)
                      </td>
                    <?php else : ?>
                      <th class="txt-uh-41" scope="row"><?php echo escape_output($key) ?></th>
                      <td class="txt-uh-41">"</td>
                      <td class="txt-uh-41">"</td>
                      <td class="txt-uh-41">"</td>
                    <?php endif; ?>

                    <td class="txt-uh-41"><?php echo escape_output($value->product_name); ?></td>
                    <td class="txt-uh-41"><?php echo escape_output($value->qty); ?></td>
                    <td class="txt-uh-41"><?php echo escape_output($value->unit); ?></td>
                    <td class="txt-uh-41 text-right"><?= number_format($avg_purchase, 2) ?></td>
                    <td class="txt-uh-41 text-right"><?php echo escape_output($value->price); ?></td>
                    <td class="txt-uh-41 text-right"><?php echo escape_output($value->price * $value->qty); ?></td>
                    <td class="txt-uh-41"><?php echo escape_output($value->discount); ?></td>
                    <td class="txt-uh-41"><?php echo escape_output($value->price * $value->qty - $value->discount); ?></td>

                    <?php if ($order_number != $end_row) : ?>
                      <td class="txt-uh-41"><?= escape_output($value->order_value) ?></td>
                      <td class="txt-uh-41"><?= escape_output($value->coupon_discount) ?></td>
                      <td class="txt-uh-41"> <?= escape_output($value->delivery_charge); ?> </td>
                      <td class="txt-uh-41"> <?= $order_value ?></td>
                      <td class="txt-uh-41">
                        <?php
                        $method = getPaymentName($value->payment_id);
                        if ($method == 'SSLCOMMERZ') {
                          echo 'Paid';
                        } elseif ($method == 'Cash On Delivery') {
                          echo 'COD';
                        } else {
                          echo $method;
                        }
                        ?>
                      </td>
                    <?php else : ?>
                      <td class="txt-uh-41">"</td>
                      <td class="txt-uh-41">"</td>
                      <td class="txt-uh-41">"</td>
                      <td class="txt-uh-41">"</td>
                      <td class="txt-uh-41">"</td>
                    <?php endif; ?>
                  </tr>
              <?php
                  $end_row = $order_number;
                endforeach;
              endif;
              ?>
            </tbody>
            <tr>
              <th class="width_2_p c_center">
              <th></th>
              <th></th>
              <th></th>
              <th class="c_txt_right"><?php echo lang('total'); ?></th>
              <th><?php echo escape_output($qty) ?></th>
              <th>-</th>
              <th><?php echo escape_output(number_format($total_avg_purchase, 2)) ?></th>
              <th><?php echo escape_output($price) ?></th>
              <th><?php echo escape_output($item_value) ?></th>
              <th><?php echo escape_output($discount) ?></th>
              <th><?php echo escape_output($netItemValue) ?></th>
              <th><?php echo escape_output($orderValue) ?></th>
              <th><?php echo escape_output($couponDiscount) ?></th>
              <th><?php echo escape_output($deliveryCharge) ?></th>
              <th><?php echo escape_output($total_Order) ?></th>
              <th></th>
            </tr>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/buttons.print.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatable_custom/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatable_custom/buttons.dataTables.min.css">
<script src="<?php echo base_url(); ?>assets/js/custom_report.js"></script>