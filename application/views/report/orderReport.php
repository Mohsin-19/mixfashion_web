<section class="content-header">
  <h3 class="txt-uh-83"><?php echo lang('OrderReport'); ?></h3>
  <hr class="txt-uh-83">
  <div class="row">
    <div class="col-md-2">
      <?php echo form_open(base_url() . 'Report/orderReport', $arrayName = array('id' => 'orderReport')) ?>
      <div class="form-group">
        <input tabindex="1" autocomplete="off" type="text" id="" name="startDate" readonly class="form-control customDatepicker"
               placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <input tabindex="2" autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker"
               placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
      </div>
    </div>
    <div class="col-md-2">
      <select class="form-control select2 width_100_p" name="area">
        <option value=""><?php echo lang('Area'); ?></option>
        <?php foreach ($arees as $value): ?>
          <option <?php echo set_select('area', $value->name); ?>
              value="<?php echo escape_output($value->name); ?>"><?php echo escape_output($value->name); ?></option>
        <?php endforeach; ?>
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
        <button type="submit" name="submit" value="submit"
                class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
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
          <h3 class="c_center"><?php echo lang('OrderReport'); ?></h3>
          <h4 class="c_center"><?php echo isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('date') . ": " . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?php echo isset($start_date) && $start_date && !$end_date ? lang('date') . ": " . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?php echo isset($end_date) && $end_date && !$start_date ? lang('date') . ": " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
          <?php
          if (isset($area) && $area):?>
            <h4 class="c_center"><?php echo lang('Area'); ?>: <?php echo escape_output($area) ?></h4>
          <?php
          endif;
          ?>  <?php
          if (isset($status) && $status):?>
            <h4 class="c_center"><?php echo lang('status'); ?>: <?php echo escape_output($status) ?></h4>
          <?php
          endif;
          ?>
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('OrderReport'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th scope="col"><?php echo lang('sn'); ?></th>
              <th scope="col"><?php echo lang('OrderNumber'); ?></th>
              <th scope="col"><?php echo lang('date'); ?></th>
              <th scope="col"><?php echo lang('Area'); ?></th>
              <th scope="col"><?php echo lang('customer'); ?></th>
              <th scope="col"><?php echo lang('TotalItem'); ?></th>
              <th scope="col"><?php echo lang('total'); ?></th>
              <th scope="col"><?php echo lang('Tax'); ?></th>
              <th scope="col"><?php echo lang('DeliveryCharge'); ?></th>
              <th scope="col">Coupon Discount</th>
              <th scope="col"><?php echo lang('status'); ?></th>
              <th scope="col">Sold-By</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total_item = 0;
            $total_amount = 0;
            $total_tax = 0;
            $total_dl_charge = 0;
            $total_coupon_discount = 0;
            if (isset($orderReport)):
              foreach ($orderReport as $key => $value) {
                $total_item += $value->total_items;
                $total_amount += $value->total_amount;
                $total_tax += $value->total_tax;
                $total_dl_charge += $value->delivery_charge;
                $total_coupon_discount += $value->coupon_discount;
                $key++;
                ?>
                <tr>
                  <th class="txt-uh-41" scope="row"><?php echo escape_output($key) ?></th>
                  <td class="txt-uh-41"><?php echo escape_output($value->order_number); ?></td>
                  <td class="txt-uh-41"><?php echo date("d/m/Y", strtotime($value->delivery_date)) ?></td>
                  <td class="txt-uh-41"><?php echo escape_output($value->area); ?></td>
                  <td class="txt-uh-41"><?php echo escape_output($value->customer_name); ?>
                    (<?php echo escape_output($value->customer_phone); ?>)
                  </td>
                  <td class="txt-uh-41"><?php echo escape_output($value->total_items); ?></td>
                  <td class="txt-uh-41"><?php echo escape_output($value->total_amount); ?></td>
                  <td class="txt-uh-41"><?php echo escape_output($value->total_tax); ?></td>
                  <td class="txt-uh-41"><?php echo escape_output($value->delivery_charge); ?></td>
                  <td class="txt-uh-41"><?= escape_output($value->coupon_discount); ?></td>
                  <td class="txt-uh-41 set_text_status<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->status); ?></td>
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
                </tr>
                <?php
              }
            endif;
            ?>
            </tbody>
            <tr>
              <th class="width_2_p c_center">
              <th></th>
              <th></th>
              <th></th>
              <th class="c_txt_right"><?php echo lang('total'); ?></th>
              <th><?php echo escape_output($total_item) ?></th>
              <th><?php echo number_format($total_amount, 2); ?></th>
              <th><?php echo number_format($total_tax, 2); ?></th>
              <th><?php echo number_format($total_dl_charge, 2); ?></th>
              <th><?php echo number_format($total_coupon_discount, 2); ?></th>
              <th></th>
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