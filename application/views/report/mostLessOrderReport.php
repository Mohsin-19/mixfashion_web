<section class="content-header">
  <h3 class="txt-uh-83"><?php echo lang('MostLessOrderProductsReport'); ?></h3>
  <hr class="txt-uh-83">
  <div class="row">
    <div class="col-md-2">
      <?php echo form_open(base_url() . 'Report/mostLessOrderReport', $arrayName = array('id' => 'mostLessOrderReport')) ?>
      <div class="form-group">
        <input tabindex="1" autocomplete="off" type="text" id="" name="startDate" readonly class="form-control customDatepicker"
               placeholder="<?php echo lang('StartDate'); ?>" value="<?php echo set_value('startDate'); ?>">
      </div>
    </div>
    <div class="col-md-2">

      <div class="form-group">
        <input tabindex="2" autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker"
               placeholder="<?php echo lang('EndDate'); ?>" value="<?php echo set_value('endDate'); ?>">
      </div>
    </div>
    <div class="col-md-2">
      <select class="form-control select2 width_100_p" name="status">
        <option value=""><?php echo lang('status'); ?></option>
        <option selected <?php echo set_select('status', "Most"); ?> value="Most"><?php echo lang('Most'); ?></option>
        <option <?php echo set_select('status', "Less"); ?> value="Less"><?php echo lang('Less'); ?></option>
      </select>
    </div>

    <div class="col-md-2">
      <?php
      $num = set_value('number_of_products');
      ?>
      <input type="number" placeholder="<?php echo lang('NumberofProduct'); ?>" class="form-control" name="number_of_products"
             value="<?php echo isset($num) && $num ? $num : 10 ?>">
    </div>

    <div class="col-md-1">
      <div class="form-group">
        <button type="submit" name="submit" value="submit"
                class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
      </div>
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
          <h3 class="c_center"><?php echo lang('MostLessOrderProductsReport'); ?></h3>
          <h4 class="txt-uh-83"><?php
            if (isset($product_id) && $product_id):
              echo lang('product') . ": " . (substr(ucwords(strtolower(getItemNameById($product_id))), 0, 50)) . " (" . getItemCodeById($product_id) . ")</span>";
            endif;
            ?></h4>
          <h4 class="c_center"><?php echo isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('date') . ": " . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?php echo isset($start_date) && $start_date && !$end_date ? lang('date') . ": " . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?php echo isset($end_date) && $end_date && !$start_date ? lang('date') . ": " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>

          <?php
          if (isset($number_of_products) && $number_of_products):?>
            <h4 class="c_center"><?php echo lang('NumberofProduct'); ?>: <?php echo escape_output($number_of_products) ?></h4>
          <?php
          endif;
          ?>
          <?php
          if (isset($status) && $status):?>
            <h4 class="c_center"><?php echo lang('status') ?>: <?php echo escape_output($status) ?></h4>
          <?php
          endif;
          ?>

          <input type="hidden" class="datatable_name" data-title="<?php echo lang('MostLessOrderProductsReport'); ?>"
                 data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_2_p c_center"><?php echo lang('sn'); ?></th>
              <th><?php echo lang('product'); ?></th>
              <th><?php echo lang('total'); ?><?php echo lang('order'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($mostLessOrderReport)):
              foreach ($mostLessOrderReport as $key => $value) {
                $key++;
                ?>
                <tr>
                  <td class="c_center"><?php echo escape_output($key); ?></td>
                  <td><?php echo escape_output($value->name) . "(" . $value->code . ")" ?></td>
                  <td><?php echo escape_output($value->totalQuantity_amount) ?></td>
                </tr>
                <?php
              }
            endif;
            ?>
            </tbody>
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