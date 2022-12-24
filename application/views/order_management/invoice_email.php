<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo lang('InvoiceNo'); ?> : <?= $order->order_number ?? '' ?></title>
  <style>
    body {
      color: #000;
      font-family: Times New Roman, sans-serif;
    }

    #invoice {
      padding: 30px;
      max-width: 800px;
      margin: 0 auto;
    }

    .h3,
    h3 {
      font-size: 1.75rem;
    }

    .h1,
    .h2,
    .h3,
    .h4,
    .h5,
    .h6,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      margin-bottom: .5rem;
      font-family: inherit;
      font-weight: 500;
      line-height: 1.2;
      color: inherit;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      margin-top: 0;
      margin-bottom: .5rem;
    }


    .btn {
      display: inline-block;
      font-weight: 400;
      text-align: center;
      white-space: nowrap;
      vertical-align: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      border: 1px solid transparent;
      padding: .375rem .75rem;
      font-size: 1rem;
      line-height: 1.5;
      border-radius: .25rem;
      transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .btn-primary {
      color: #fff !important;
      background-color: #007bff;
      border-color: #007bff;
    }

    a {
      color: #007bff;
      text-decoration: none;
      background-color: transparent;
      -webkit-text-decoration-skip: objects;
    }

    .text-center {
      text-align: center !important;
    }

    .mb-5,
    .my-5 {
      margin-bottom: 3rem !important;
    }

    .h1,
    h1 {
      font-size: 2.5rem;
    }

    .h4,
    h4 {
      font-size: 1.5rem;
    }

    hr {
      margin-top: 1rem;
      margin-bottom: 1rem;
      border: 0;
      border-top: 1px solid rgba(0, 0, 0, .1);
    }

    table {
      border-collapse: collapse;
    }

    .table {
      width: 100%;
      max-width: 100%;
      margin-bottom: 1rem;
      background-color: transparent;
    }

    .table-sm td,
    .table-sm th {
      padding: .3rem;
    }

    .table td,
    .table th {
      vertical-align: top;
      border-top: 1px solid #dee2e6;
    }

    .text-right {
      text-align: right !important;
    }

    .text-left {
      text-align: left !important;
    }


    .order_barcodes img {
      float: none !important;
      margin-top: 0.3rem;
    }

    p {
      font-size: 1rem;
      margin: 0 0 0.25rem;
    }

    @media print {
      .no-print {
        display: none;
      }

      #wrapper {
        width: 100%;
        min-width: 250px;
        margin: 0 auto;
      }

      .no-border {
        border: none !important;
      }

      .border-bottom {
        border-bottom: 1px solid #a2a2a2 !important;
      }


      table tfoot {
        display: table-row-group;
      }

      .tbl {
        page-break-inside: auto;
      }

      .tbl tr {
        page-break-inside: avoid;
        page-break-after: auto
      }

      .tbl td {
        border: 1px solid #a2a2a2;
        font-size: 14px;
        padding: 3px 6px 2px !important;
      }


      tr.noBorder td {
        border: 0 !important;
      }

      .tablePage {
        page-break-inside: auto;
      }
    }

    footer {
      width: 100%;
      text-align: center;
    }

    @media print {
      .no_print {
        display: none !important;
      }

      .inv_black {
        -webkit-print-color-adjust: exact;
        background-color: #000 !important;
        color: #fff !important;
        font-weight: bold;
        color: #fff;
        font-size: 25px;
        display: table;
        text-align: center;
        margin: 0 auto;
        padding: 3px 8px;
        margin-top: 10px;
        border-radius: 3px;
      }


      footer {
        position: static;
        /* <-- Key line */
        width: 100%;
        bottom: 0;
        left: 0;
      }

      .content-block,
      p {
        page-break-inside: avoid;
      }
    }

    /* for footer print*/

    .inv_black {
      -webkit-print-color-adjust: exact;
      background-color: #000;
      font-weight: bold;
      color: #fff;
      font-size: 25px;
      display: table;
      text-align: center;
      margin: 0 auto;
      padding: 3px 8px;
      margin-top: 10px;
      border-radius: 3px;
    }

    .bold {
      font-weight: bold;
    }

    .tbl {
      page-break-inside: auto;
    }

    .tbl tr {
      page-break-inside: avoid;
      page-break-after: auto
    }

    .tbl td {
      border: 1px solid #a2a2a2;
      font-size: 14px;
      padding: 3px 6px 2px !important;
    }

    tr.noBorder td {
      border: 0 !important;
    }

    .tablePage {
      page-break-inside: auto;
    }

    .logo_header {
      margin-bottom: 18px;
      overflow: hidden;
      display: inline-block;
      width: 100%;
    }

    .width_100_p {
      width: 100% !important;
    }

    .width_40_p {
      width: 40% !important;
    }

    .width_75_p {
      width: 100% !important;
    }

    .width_250_px {
      width: 250px !important;
    }

    .p_txt_1 {
      text-align: center !important;
      margin: 0px !important;
    }

    .p_txt_2 {
      text-align: center !important;
      margin: 0px auto !important;
      width: 500px !important;
    }

    .p_txt_3 {
      text-align: center !important;
      margin: 0px !important;
      font-size: 18px !important;
    }

    .p_txt_7 {
      background-color: #5c5c5c !important;
      color: white !important;
      border: 1px solid white !important;
      padding: 6px !important;
    }

    .p_txt_8 {
      padding: 6px !important;
      font-weight: bold !important;
      width: 1% !important;
    }

    .p_txt_9 {
      padding: 6px !important;
      font-weight: bold !important;
    }

    .p_txt_10 {
      padding: 6px !important;
      font-weight: bold !important;
      width: 15% !important;
    }

    .p_txt_15_10 {
      padding: 6px !important;
      font-weight: bold !important;
      width: 10% !important;
    }

    .p_txt_11 {
      padding: 6px !important;
      font-weight: bold !important;
      width: 15% !important;
      text-align: right !important;
    }

    .p_txt_12 {
      float: left !important;
      width: 100% !important;
    }

    .p_txt_13 {
      width: 25% !important;
      float: left !important;
    }

    .p_txt_14 {
      font-size: 0.95rem !important;
      font-weight: bold !important;
      border-top: 1px solid black !important;
      text-align: center !important;
    }

    .p_txt_15 {
      width: 25% !important;
      float: right !important;
    }

    .p_txt_16 {
      padding-top: 10px !important;
      text-transform: uppercase !important;
    }

    .p_txt_17 {
      background: #F5F5F5 !important;
      padding: 10px !important;
      color: red !important;
    }

    .p_txt_18 {
      font-weight: bold !important;
      text-transform: none !important;
    }

    .p_txt_19 {
      text-transform: capitalize !important;
    }

    .c_txt_right {
      text-align: right;
    }

    .c_txt_left {
      text-align: left;
    }

    .clear_both {
      clear: both !important;
    }


    @media print {
      .invoice {
        font-size: 0.75rem !important;
        overflow: hidden !important
      }

      .invoice footer {
        position: absolute;
        bottom: 0.70rem;
        page-break-after: always
      }

      .invoice>div:last-child {
        page-break-before: always
      }
    }
  </style>
</head>

<body>

  <div id="invoice">
    <div class="invoice overflow-auto">
      <div>
        <header>
          <h3>
            <?= isset($txt) ? $txt : '' ?>
          </h3>

          <p class="text-center my-5">
            <a href="<?= site_url('/') ?>" class="btn btn-primary">Track Your Order</a>
          </p>

          <hr>

          <table class="width_100_p">
            <tr>
              <td style="width: 30% !important;">
                <?php
                // $getSiteSetting = getSiteSetting();
                // $invoice_logo = $this->session->userdata('invoice_logo');
                // $invoice_logo =  base_url("assets/images/{$getSiteSetting->site_logo}");
                $invoice_logo = base_url("assets/images/email-invoice.png");
                $currency = "Tk. ";
                $order_date = $order->order_date_time ? strtotime($order->order_date_time) : null;

                if (isset($invoice_logo) && $invoice_logo) :
                ?>
                  <img class="width_75_p" src="<?= $invoice_logo ?>">
                <?php
                else :
                ?>
                  <img class="width_75_p" src="<?= base_url('assets/images/email-invoice.png') ?>">
                <?php
                endif;
                ?>
              </td>
              <td class="text-center">
                <h1 class="p_txt_1"><?= $this->session->userdata('outlet_name'); ?></h1>
                <h4 class="p_txt_2">1st Floor, 56 Gareeb-e-Nawaz Avenue, Sector-13, Uttara, Dhaka-1230</h4>
                <h3 class="p_txt_3">+880 1717-466896</h3>
                <p class="inv_black"><?= lang('invoice'); ?></p>
              </td>
              <td style="width: 30% !important;"></td>
            </tr>
          </table>
          <table class="width_100_p">
            <tr>
              <td style="width: 35%">
                <p style="margin: 0">
                  <?= lang('invoice'); ?>: <b><?= $order->order_number ?></b>
                </p>
                <p style="margin: 0">
                  <?= lang('Order') . " " . lang('date'); ?>
                  :
                  <b><?= $order_date ? date($this->session->userdata('date_format'), $order_date) : 'Not Set'; ?></b>
                </p>
                <p style="margin: 0">
                  <b>
                    <?php echo lang('sales_associate'); ?>: <?php
                                                            if ($order->paymentName == 'Cash On Delivery') {
                                                              echo $order->paymentName;
                                                            } else {
                                                              echo 'Online Payment';
                                                            }
                                                            ?>
                  </b>
                </p>
              </td>
              <td></td>
              <td style="width: 35%">
                <p style="margin: 0">
                  <?php echo lang('customer'); ?>:
                  <b><?php echo isset($order) && $order->checkout_name ? $order->checkout_name : '---'; ?></b>
                </p>
                <p style="margin: 0">
                  <b><?php echo lang('phone'); ?>:</b>
                  <?php echo isset($order) && $order->checkout_phone ? $order->checkout_phone : '---'; ?>
                </p>
                <p style="margin: 0">
                  <b> Phone 2:</b>
                  <?php echo isset($order) && $order->checkout_email ? $order->checkout_email : '---'; ?>
                </p>
                <p style="margin: 0">
                  <b><?php echo lang('address'); ?>:</b>
                  <?php echo isset($order) && $order->address ? $order->address : '---'; ?>
                </p>
              </td>
            </tr>
          </table>
        </header>

        <main>
          <table class="tbl">
            <tr class="p_txt_7">
              <td class="p_txt_8">SL</td>
              <td class="p_txt_9"><?= lang('product') ?></td>
              <td class="p_txt_15_10 text-center">MRP</td>
              <td class="p_txt_15_10 text-center">Price</td>
              <td class="p_txt_15_10 text-center"><?= lang('qty') ?></td>
              <td class="p_txt_15_10 text-center">Unit</td>
              <td class="p_txt_15_10 text-center">Total <?= lang('discount') ?></td>
              <!-- <td class="p_txt_15_10 text-center">Discounted Amount</td> -->
              <td class="p_txt_11">
                <?= lang('subtotal'); ?> <br>
                After Discount
              </td>
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
                  <td><?= $i++ ?></td>
                  <td><?= $row->name ?></td>
                  <td class="text-center">
                    <?= $currency . $row->original_price ?>
                  </td>
                  <td class="text-center"><?= $currency . $row->price ?></td>
                  <td class="text-center"><?= $row->qty ?></td>
                  <td class="text-center"><?= unitName(getSaleUnitIdByIgId($row->product_id)) ?></td>
                  <td class="text-center">
                    <?php
                    if ($discount_amount) {
                      echo $currency . ($discount_amount * $row->qty);
                    } else {
                      echo '-';
                    }
                    ?>
                  </td>
                  <td class="c_txt_right">
                    <?= $currency . number_format($total_amount, 2); ?></td>
                </tr>
            <?php }
            }
            ?>
          </table>
          <br>
          <table class="table table-sm">
            <tfoot>
              <tr>
                <th class="text-left"><?php echo lang('total'); ?> <?php echo lang('product'); ?>
                  : <?= $totalItems ?></th>
                <th class="c_txt_right"><?= $currency . number_format($sub_total, 2) ?></th>
              </tr>
              <?php
              #vat
              if ($this->session->userdata('collect_tax') == 'Yes' && ($order->total_tax != NULL && $order->total_tax != "0.00")) : ?>
                <th class="text-left"><?php echo lang('vat'); ?>:</th>
                <th class="text-right"><?php echo $currency . number_format($order->total_tax, 2); ?></th>
              <?php
              endif;
              #vat end
              ?>

              <?php if ($order->delivery_charge) : ?>
                <tr>
                  <th class="text-left"><?php echo lang('DeliveryCharge'); ?>:</th>
                  <th class="text-right">
                    <?php
                    if ($order->delivery_charge == '0.00') {
                      $delivery_charge = $order->coupon_discount;
                    } else {
                      $delivery_charge = $order->delivery_charge;
                    }
                    echo $currency . $delivery_charge;
                    ?>
                  </th>
                </tr>
              <?php endif; ?>

              <?php if ($order->coupon_discount && $order->coupon_discount != "0.00") : ?>
                <tr>
                  <th class="text-left"><?php echo lang('coupon_discount'); ?> (<?= getCoupon($order->id) ?>):</th>
                  <th class="text-right">(-)<?= $currency . $order->coupon_discount; ?></th>
                <?php endif; ?>
                </tr>

                <?php if ($order->paid && $order->paid != "0.00") : ?>
                  <tr>
                    <th class="text-left"><?php echo lang('paid'); ?>:</th>
                    <th class="text-right"><?= $currency . $order->paid; ?></th>
                  </tr>
                <?php endif; ?>

                <tr>
                  <th class="text-left"><?php echo lang('total_payable'); ?> </th>
                  <th class="text-right">
                    <?php $total_payable = $sub_total + $delivery_charge - $order->coupon_discount ?>
                    <?= $currency . number_format($total_payable, 2); ?>
                  </th>
                </tr>
                <tr>
                  <th class="text-left"> <?php echo lang('in_word'); ?></th>
                  <th class="text-right">
                    <?php
                    echo numtostr($total_payable);
                    ?>
                  </th>
                </tr>

                <tr>
                  <th class="text-left">Total Savings:</th>
                  <th class="text-right">
                    <?php
                    $total_savings = $order->coupon_discount + $product_saving;
                    echo $currency . number_format($total_savings, 2);
                    ?>
                  </th>
                </tr>

            </tfoot>
          </table>
        </main>

        <footer>
          &copy; All rights are reserved by <a href="http://mixfashionhouse.com/">mixfashionhouse.com</a>
        </footer>
      </div>
      <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
      <div></div>
    </div>
  </div>


</body>

</html>