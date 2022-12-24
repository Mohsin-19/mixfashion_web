<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title><?= lang('InvoiceNo'); ?> : <?= escape_output($order->order_number); ?></title>
  <style>
    * {
      font-family: 'SolaimanLipi', Arial, sans-serif !important;
    }

    body {
      color: #000;
    }


    h4 {
      margin: 5px 0;
    }

    .order_barcodes img {
      float: none !important;
      margin-top: 5px;
    }

    p {
      font-size: 12px;
    }

    footer {
      width: 100%;
      text-align: center;
    }

    .bold {
      font-weight: bold;
    }

    .tbl {
      page-break-inside: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
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


    .p_txt_4 {
      width: 60% !important;
      float: left !important;
    }

    .p_txt_5 {
      vertical-align: top !important;
      width: 20% !important;
    }

    .p_txt_6 {
      vertical-align: top !important;
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


    .c_txt_right {
      text-align: right;
    }


    .clear_both {
      clear: both !important;
    }
    .header{
      margin-top: 0; position: relative
    }
    .invoice-header{
      width: 100%;
      position: absolute;
      left: 0; right: 0;
      text-align: center
    }
    .invoiceText{
      background-color: #0a0a0a;
      color: #fff;
      padding: 10px;
      border-radius: 10px;
      display: inline;
    }

  </style>
</head>

<body>

<header class="header">
  <div style="width: 100px;display: inline-block">
    <?php
    //                $getSiteSetting = getSiteSetting();
    //                 $invoice_logo = $this->session->userdata('invoice_logo');
    //                $invoice_logo = "assets/images/{$getSiteSetting->site_logo}";
    //                $invoice_logo = $_SERVER["DOCUMENT_ROOT"].'/assets/images/footer-ausbdbazaar.png';
    $invoice_logo = root_path("assets/images/ausbdbazaar.png");
    $image = "data:image/png;base64," . base64_encode(file_get_contents($invoice_logo));
    if (isset($invoice_logo) && $invoice_logo) : ?>
      <img style="width: 100%" src="<?= $image ?>" alt="AusbdBazaar">
    <?php else : ?>
      <img style="width: 100%" src="<?= $image ?>" alt="AusbdBazaar">
    <?php endif; ?>
  </div>
  <div class="invoice-header">
    <h1 style="margin: 0"><?= escape_output($this->session->userdata('outlet_name')); ?></h1>
    <h4 style="margin: 0; width: 50%; text-align: center"><?= escape_output($this->session->userdata('address')); ?></h4>
    <h3 style="margin: 0"><?= escape_output($this->session->userdata('phone')); ?></h3>
    <p class="bold invoiceText"><?= lang('invoice'); ?></p>
  </div>
</header>


<main>
  <div id="receiptData">
    <div id="receipt-data">
      <div id="receipt-data">
        <div class="logo_header">
          <div class="width_100_p">
          </div>
        </div>

        <table class="bold p_txt_4">
          <tr>
            <td class="p_txt_5"> <?= lang('invoice'); ?>:
              এন্ট্রি এন্ড এক্সিট টেকনিকস ইউসিং সিম্পল
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
              <?php echo date($this->session->userdata('date_format'), strtotime($order->delivery_date)); ?><?php echo escape_output($order->delivery_time) ?>
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
              <b><?php echo isset($order) && $order->checkout_name ? $order->checkout_name : '---'; ?> ক্রেতার নামঃ DDD</b>
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
            <td class="p_txt_9"><?= lang('product') ?></td>
            <td class="p_txt_15_10 text-center">Details</td>
            <td class="p_txt_15_10 text-center"><?= lang('price') ?></td>
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
                <td><?= escape_output($row->name); ?></td>
                <td class="text-center"><?= escape_output($row->description) ?></td>
                <td class="text-center">
                  <?= escape_output($this->session->userdata('currency') . " ") ?>
                  <?= escape_output($row->original_price); ?>
                </td>
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
                    <? //escape_output($this->session->userdata('currency') . " ") ?>
                    <? // escape_output(number_format($row->price, 2)); ?>
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

          <tbody>
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

          <?php if ($order->delivery_charge) : ?>
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

          </tbody>
        </table>


      </div>
    </div>
    <div class="clear_both"></div>
  </div>
  <?php
  if ($order->paid && $order->paid != "0.00") :

    $paid_seal = root_path('assets/images/paid_seal.png');
    $paid_seal = "data:image/png;base64," . base64_encode(file_get_contents($paid_seal));

    ?>
    <div style="text-align: center">
      <img style="opacity: .5;" src="<?= $paid_seal ?>" alt="AusbdBazaar Paid">
    </div>
  <?php endif; ?>
</main>

</body>
</html>