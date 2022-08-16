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
                  //                $invoice_logo = $this->session->userdata('invoice_logo');
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
                  <p class="inv_black"><?php echo lang('Packing Slip'); ?></p>
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
                <?php echo date($this->session->userdata('date_format'), strtotime($order->delivery_date)) . ' ' . escape_output($order->delivery_time) ?>
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
              <?php $customer_info = getCustomerData($order->customer_id); ?>
              <td class="p_txt_6">
                <b><?php echo isset($order) && $order->checkout_name ? $order->checkout_name : '---'; ?></b>
              </td>
            </tr>
            <tr>
              <td class="p_txt_5">
                <b><?php echo lang('phone'); ?>:</b>
              </td>
              <td class="p_txt_6">
                <?php echo isset($order) && $order->checkout_phone ? $order->checkout_phone : '---'; ?>
              </td>
            </tr>

            <tr>
              <td class="p_txt_5">
                <b> Phone 2:</b>
              </td>
              <td class="p_txt_6">
                <?php echo isset($order) && $order->checkout_email ? $order->checkout_email : '---'; ?>
              </td>
            </tr>

            <tr>
              <td class="p_txt_5">
                <b><?php echo lang('address'); ?>:</b>
              </td>
              <td class="p_txt_6">
                <?php echo isset($order) && $order->address ? $order->address : '---'; ?>
              </td>
            </tr>
          </table>

          <table class="tbl width_100_p">
            <tr class="p_txt_7">
              <td class="p_txt_8">SL</td>
              <td class="p_txt_8">Picture</td>
              <td class="p_txt_9"><?= lang('product') ?></td>
              <td class="p_txt_15_10 text-center">Details</td>
              <td class="p_txt_15_10 text-center"><?= lang('qty') ?></td>
              <td class="p_txt_15_10 text-center">Unit</td>
              <td class="p_txt_15_10 text-center">Total <?= lang('discount') ?></td>
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
                  <td><?= escape_output($row->name); ?></td>
                  <td class="text-center"><?= escape_output($row->description) ?></td>
                  <td class="text-center"><?= escape_output($row->qty); ?></td>
                  <td class="text-center"><?= unitName(getSaleUnitIdByIgId($row->product_id)) ?></td>
                  <td class="text-center">
                    <?php
                    if ($discount_amount) {
                      echo escape_output($this->session->userdata('currency') . " ") . $discount_amount * $row->qty;
                    } else {
                      echo '-';
                    }
                    ?>
                  </td>
                  <!-- <td class="text-center">
                  <? //escape_output($this->session->userdata('currency') . " ") 
                  ?>
                    <? // escape_output(number_format($row->price, 2)); 
                    ?>
                  </td> -->
                  <td class="c_txt_right">
                    <?= escape_output($this->session->userdata('currency') . " ") . number_format($total_amount, 2); ?></td>
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
                <th class="c_txt_right"><?= escape_output($this->session->userdata('currency')) . ' ' . number_format($sub_total, 2) ?></th>
              </tr>

              <?php
              #vat
              if ($this->session->userdata('collect_tax') == 'Yes' && ($order->total_tax != NULL && $order->total_tax != "0.00")) : ?>
                <th><?php echo lang('vat'); ?>:</th>
                <th class="text-right"><?php echo escape_output($this->session->userdata('currency') . " ") . number_format($order->total_tax, 2); ?></th>
              <?php
              endif;
              #vat end
              ?>

              <?php
              $delivery_charge = 0;
              if ($order->delivery_charge) :
              ?>
                <tr>
                  <th><?php echo lang('DeliveryCharge'); ?>:</th>
                  <th class="text-right">
                    <?php
                    if ($order->delivery_charge == '0.00') {
                      $delivery_charge = $order->coupon_discount;
                    } else {
                      $delivery_charge = $order->delivery_charge;
                    }
                    echo escape_output($this->session->userdata('currency') . " ") . $delivery_charge;
                    ?>
                  </th>
                </tr>
              <?php endif; ?>

              <?php if ($order->coupon_discount && $order->coupon_discount != "0.00") : ?>
                <tr>
                  <th><?php echo lang('coupon_discount'); ?> (<?= getCoupon($order->id) ?>):</th>
                  <th class="text-right"><?php echo escape_output($this->session->userdata('currency') . " (-) ") . $order->coupon_discount; ?></th>
                <?php endif; ?>
                </tr>

                <?php if ($order->paid && $order->paid != "0.00") : ?>
                  <tr>
                    <th><?php echo lang('paid'); ?>:</th>
                    <th class="text-right"><?php echo $this->session->userdata('currency') . " " . $order->paid; ?></th>
                  </tr>
                <?php endif; ?>

                <tr>
                  <th><?php echo lang('total_payable'); ?> </th>
                  <th class="text-right">
                    <?php $total_payable = $sub_total + $delivery_charge - $order->coupon_discount ?>
                    <?= escape_output($this->session->userdata('currency') . " ") . number_format($total_payable, 2); ?>
                  </th>
                </tr>
                <tr>
                  <th> <?php echo lang('in_word'); ?></th>
                  <th class="text-right">
                    <?php
                    echo numtostr($total_payable);
                    ?>
                  </th>
                </tr>

                <tr>
                  <th>Total Savings:</th>
                  <th class="text-right">
                    <?php
                    $total_savings = $order->coupon_discount + $product_saving;
                    echo escape_output($this->session->userdata('currency')) . number_format($total_savings, 2);
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
        <img style="opacity: .5;" src="<?php echo base_url() ?>assets/images/paid_seal.png">
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
</body>

</html>