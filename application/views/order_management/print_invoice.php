<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title><?php echo lang('InvoiceNo'); ?> : <?php echo escape_output($order->order_number); ?></title>
  <script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
  <script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/order_print.css') ?>" type="text/css" />
</head>

<body>
  <div id="wrapper">
    <div id="receiptData">
      <div id="receipt-data">
        <div id="receipt-data">
          <div class="logo_header">
            <table class="width_100_p">
              <tr>
                <td style="width: 20% !important;">
                  <?php
                  //                $getSiteSetting = getSiteSetting();
                  //                $invoice_logo = base_url("assets/images/{$getSiteSetting->site_logo}");
                  $invoice_logo = base_url("assets/images/footer-and-invoice.png");
                  if (isset($invoice_logo) && $invoice_logo) :
                  ?>
                    <img class="width_75_p" src="<?= $invoice_logo ?>">
                  <?php
                  else :
                  ?>
                    <img class="width_75_p" src="<?= base_url('assets/branding/logo.png') ?>">
                  <?php
                  endif;
                  ?>
                </td>
                <td>
                  <h1 class="p_txt_1"><?= escape_output($this->session->userdata('outlet_name')); ?></h1>
                  <h4 class="p_txt_2"><?= escape_output($this->session->userdata('address')); ?></h4>
                  <h3 class="p_txt_3"><?= escape_output($this->session->userdata('phone')); ?></h3>
                  <p class="inv_black"><?= lang('invoice'); ?></p>
                </td>
                <td style="width: 20% !important;"></td>
              </tr>
            </table>
          </div>

          <table class="bold p_txt_4">
            <tr>
              <td class="p_txt_5">
                <?php echo lang('invoice'); ?>:
              </td>
              <td class="p_txt_6">
                <?php echo escape_output($order->order_number); ?>
              </td>
            </tr>
            <tr>
              <td class="p_txt_5">
                <?php echo lang('invoice'); ?> <?php echo lang('date'); ?>:
              </td>
              <td class="p_txt_6">
                <?php
                $date_format = $this->session->userdata('date_format');
                if ($order->delivery_date) {
                  echo date($date_format, strtotime($order->delivery_date));
                } else {
                  echo date($date_format);
                }
                ?>
              </td>
            </tr>
            <tr>
              <td class="p_txt_5">
                <?php echo lang('sales_associate'); ?>:
              </td>
              <td class="p_txt_6">
                <?php
                if ($order->paymentName == 'Cash On Delivery') {
                  echo $order->paymentName;
                } else {
                  echo 'Online Payment';
                }
                ?>
              </td>
            </tr>
          </table>
          <table class="width_40_p">
            <tr>
              <td class="p_txt_5">
                <b><?php echo lang('customer'); ?>:</b>
              </td>
              <?php
              $customer_info = getCustomerData($order->customer_id);
              $fullAddress = json_decode($order->address, true);
              ?>
              <td class="p_txt_6">
                <b><?= is_array($fullAddress) ? $fullAddress['name'] : $order->checkout_name; ?></b>
              </td>
            </tr>
            <tr>
              <td class="p_txt_5">
                <b><?php echo lang('phone'); ?>:</b>
              </td>
              <td class="p_txt_6">
                <?= is_array($fullAddress) ? $fullAddress['phone_one'] : $order->checkout_phone; ?>
              </td>
            </tr>
            <!-- <tr>
              <td class="p_txt_5">
                <b> Phone 2:</b>
              </td>
              <td class="p_txt_6">
                <?php echo isset($customer_info) && $customer_info->phone_two ? $customer_info->phone_two : '---'; ?>
              </td>
            </tr> -->
            <tr>
              <td class="p_txt_5">
                <b><?php echo lang('address'); ?>:</b>
              </td>
              <td class="p_txt_6">
                <?php echo isset($order) && $order->address ? $order->address : '---'; ?>
              </td>
            </tr>
            <tr>
              <td class="p_txt_5">
                <b> Area:</b>
              </td>
              <td class="p_txt_6">
                <?= is_array($fullAddress) ? $fullAddress['area'] : $order->area;; ?>
              </td>
            </tr>
          </table>

          <table class="tbl width_100_p">
            <tr class="p_txt_7">
              <td class="p_txt_8">SL</td>
              <td class="p_txt_8">Picture</td>
              <td class="p_txt_9"><?= lang('product') ?></td>
              <td class="p_txt_15_10 text-center"><?= lang('price') ?></td>
              <td class="p_txt_15_10 text-center"><?= lang('qty') ?></td>
              <td class="p_txt_15_10 text-center">Unit</td>
              <td class="p_txt_15_10 text-center">Item <?= lang('discount') ?></td>
              <!-- <td class="p_txt_15_10 text-center">Discounted Amount</td> -->
              <td class="p_txt_11"><?= lang('subtotal'); ?></td>
            </tr>
            <?php
            $sub_total = 0;
            $product_saving = 0;
            $totalItems = 0;
            $total_Tax = 0;
            $total_discount_item = 0;
            if (isset($items)) {
              $i = 1;
              foreach ($items as $row) {
                $totalItems++;
                $total_discount = "0.00";
                $total_cupon_discount = "0.00";
                $total_amount = $row->price * $row->qty;
                if ($row->discount_amount && $row->discount_amount != "0.00") {
                  $total_discount = ($row->original_price - $row->discount_amount) * $row->qty;
                  $total_discount_item = +$total_discount;
                }
                $sub_total += $total_amount;
                $discount_amount = ($row->original_price - $row->price);
                $product_saving += $discount_amount * $row->qty;
            ?>
                <tr>
                  <td><?= escape_output($i++); ?></td>
                  <td>
                    <img src="<?= base_url('images/product/' . $row->photo) ?>" style="max-width:60px; margin: 0 auto;">
                  </td>
                  <td>
                    <?= escape_output($row->name); ?>
                    <?php
                    if ($row->color) {
                      echo '<p class="small m-0">Color: ' . $row->color . '</p>';
                    }
                    ?>
                    <?php
                    if ($row->size) {
                      echo '<p class="small m-0">Size: ' . $row->size . '</p>';
                    }
                    ?>
                  </td>
                  <td class="text-center">
                    <?= floating($row->original_price) ?>
                  </td>
                  <td class="text-center"><?= escape_output($row->qty); ?></td>
                  <td class="text-center"><?= unitName(getSaleUnitIdByIgId($row->product_id)) ?></td>
                  <td class="text-center">
                    <?= $discount_amount ? floating($discount_amount * $row->qty) : '0.00' ?>
                  </td>
                  <!-- <td class="text-center">
                    <? //escape_output($this->session->userdata('currency') . " ") 
                    ?>
                    <? // escape_output(number_format($row->price, 2)); 
                    ?>
                  </td> -->
                  <td class="c_txt_right">
                    <?= floating($total_amount) ?></td>
                </tr>
            <?php }
            }
            ?>
          </table>
          <br>

          <div class="clear_both"></div>
          <table class="table table-condensed">

            <tfoot>
              <tr>
                <th><?php echo lang('total'); ?> <?php echo lang('product'); ?>
                  : <?php echo escape_output($totalItems) ?></th>
                <th class="c_txt_right"><?= floating($sub_total) ?></th>
              </tr>

              <?php
              #vat
              if ($this->session->userdata('collect_tax') == 'Yes' && ($order->total_tax != NULL && $order->total_tax != "0.00")) : ?>
                <th>Vat:</th>
                <th class="text-right"><?= floating($order->total_tax) ?></th>
              <?php
              endif;
              #vat end
              ?>

              <?php
              $delivery_charge = 0;
              if ($order->delivery_charge) :
              ?>
                <tr>
                  <th><?= lang('DeliveryCharge'); ?>:</th>
                  <th class="text-right">
                    <?php
                    if ($order->delivery_charge == '0.00') {
                      $delivery_charge = $order->coupon_discount;
                    } else {
                      $delivery_charge = $order->delivery_charge;
                    }
                    echo floating($delivery_charge) ?? 0;
                    ?>
                  </th>
                </tr>
              <?php endif; ?>

              <?php if ($order->coupon_discount && $order->coupon_discount != "0.00") : ?>
                <tr>
                  <th><?= lang('coupon_discount'); ?> (<?= getCoupon($order->id) ?>):</th>
                  <th class="text-right"><?= escape_output($this->session->userdata('currency') . " (-) ") . $order->coupon_discount; ?></th>
                <?php endif; ?>
                </tr>

                <?php if ($order->paid && $order->paid != "0.00") : ?>
                  <tr>
                    <th><?= lang('paid'); ?>:</th>
                    <th class="text-right"><?= floating($order->paid) ?></th>
                  </tr>
                <?php endif; ?>

                <tr>
                  <th><?= lang('total_payable'); ?> </th>
                  <th class="text-right">
                    <?php
                    $total_tax = (int)$order->total_tax > 0 ? (int)$order->total_tax : 0;
                    $total_payable = $sub_total + $total_tax  + $delivery_charge - $order->coupon_discount;
                    ?>
                    <?= floating($total_payable) ?>
                  </th>
                </tr>
                <tr>
                  <th> <?php echo lang('in_word'); ?></th>
                  <th class="text-right">
                    <?= numtostr($total_payable) ?>
                  </th>
                </tr>

                <tr>
                  <th>Total Savings:</th>
                  <th class="text-right">
                    <?php
                    $total_savings = $order->coupon_discount + $product_saving;
                    echo floating($total_savings);
                    ?>
                  </th>
                </tr>

            </tfoot>
          </table>


        </div>
      </div>
      <div class="clear_both"></div>
    </div>
    <?php
    if ($order->paid && $order->paid != "0.00") :
    ?>
      <div style="text-align: center">
        <img style="opacity: .5;" src="<?= base_url("assets/images/paid_seal.png") ?>">
      </div>
    <?php
    endif;
    ?>
    <footer>
      <td class="p_txt_12">
        <div class="p_txt_13">
          <p class="p_txt_14">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo lang('customer_signature'); ?></p>
        </div>
        <div class="p_txt_13">
          <p>&nbsp;</p>
        </div>
        <div class="p_txt_13">
          <p>&nbsp;</p>
        </div>
        <p class="p_txt_14"><?php echo lang('authorized_signature'); ?></p>
      </td>
    </footer>
    <div class="p_txt_16 no_print">
      <hr>
      <span class="pull-right col-xs-12">
        <button onclick="window.print();" class="btn btn-block btn-primary"><?php echo lang('print'); ?></button> </span>
      <div class="clear_both"></div>
      <div class="p_txt_17">
        <div class="p_txt_18">
          Please follow these steps before you print for first tiem:
        </div>
        <p class="p_txt_19">
          1. Disable Header and Footer in browser's print setting<br>
          For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Make all
          --blank--<br>
          For Chrome: Menu &gt; Print &gt; Uncheck Header/Footer in More Options
        </p>
        <p class="p_txt_19">
          2. Set margin 0.5<br>
          For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Margins
          (inches) &gt; set all margins
          0.5<br>
          For Chrome: Menu &gt; Print &gt; Set Margins to Default
        </p>
      </div>
      <div class="clear_both"></div>
    </div>
  </div>
  <script src="<?= base_url("assets/dist/js/print/jquery-2.0.3.min.js") ?>"></script>
  <script src="<?= base_url("assets/dist/js/print/custom.js") ?>"></script>
  <script src="<?= base_url("assets/js/onload_print.js") ?>"></script>
</body>

</html>