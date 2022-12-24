<!--hidden filed use in javascript-->
<input type="hidden" class="product" value="<?php echo lang('product'); ?>">
<input type="hidden" class="stock_value" value="<?php echo lang('stock_value'); ?>">
<input type="hidden" class="inventory_tooltip" value="<?php echo lang('inventory_tooltip'); ?>">


<section class="content-header">
  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="top-left-header"><?php echo lang('inventory'); ?> </h2>
    </div>
  </div>
  <hr class="txt-uh-42">
  <div class="row">
    <?php echo form_open(base_url() . 'Inventory/inventory') ?>
    <input type="hidden" name="<?php echo escape_output($this->security->get_csrf_token_name()); ?>" value="<?php echo escape_output($this->security->get_csrf_hash()); ?>">
    <input type="hidden" name="hiddentIngredientID" id="hiddentIngredientID" value="<?php echo isset($product_id) ? $product_id : '' ?>">
    <div class="col-md-2">
      <div class="form-group">
        <select class="form-control select2 category_id width_100_p" name="category_id" id="category_id">
          <option value=""><?php echo lang('category'); ?></option>
          <?php foreach ($product_categories as $value) { ?>
            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('category_id', $value->id); ?>><?php echo escape_output($value->name) ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <div class="col-md-2">
      <div class="form-group">
        <select class="form-control select2 width_100_p" name="product_id" id="product_id">
          <option value=""><?php echo lang('product'); ?></option>
          <?php foreach ($products as $value) { ?>
            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('product_id', $value->id); ?>><?php echo escape_output($value->name) . "(" . $value->code . ")" ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-md-1">
      <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
    </div>
    <div class="hidden-lg"><span class="txt-uh-40">space</span></div>
    <div class="hidden-lg"><br><br></div>
    <?php if (has_permission('alert_stock_list')) : ?>
      <div class="col-md-2">
        <a href="<?= site_url('Inventory/getInventoryAlertList') ?>" class="btn btn-block btn-primary pull-left">
          <span class="txt-uh-24"><?php echo getAlertCount() ?></span> <?= lang('products_alert'); ?>
        </a>
      </div>
    <?php endif; ?>
    <div class="col-md-5">
      <table class="width_100_p">
        <tr>
          <td class="width_37_p txt-uh-41"><strong id="stockValue"></strong></td>
          <td class="txt-uh-41"><strong id=""><?php echo lang('price'); ?> = <?php echo lang('p_status'); ?></strong></td>
        </tr>
      </table>

    </div>
  </div>
  <?php echo form_close(); ?>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- /.box-header -->

        <div class="box-body table-responsive">
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('inventory'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="title width_5_p"><?php echo lang('sn'); ?></th>
                <th class="title width_15_p"><?php echo lang('product'); ?></th>
                <th class="title c_center width_15_p"><?php echo lang('product_sku'); ?></th>
                <th class="title width_15_p"><?php echo lang('category'); ?></th>
                <th class="title width_20_p c_center"><?php echo lang('pur_stock'); ?></th>
                <th class="title width_20_p c_center"><?php echo lang('pur_unit'); ?></th>

                <th class="title width_20_p c_center"><?php echo lang('sale_stock'); ?></th>
                <th class="title width_20_p c_center"><?php echo lang('sale_unit'); ?></th>

                <th class="title width_15_p c_center"><?php echo lang('price'); ?></th>
                <th class="title width_20_p"><?php echo lang('total'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $totalStock = 0;
              $grandTotal = 0;
              $alertCount = 0;
              $totalTK = 0;
              $totalStockPurchase = 0;
              if (!empty($inventory) && isset($inventory)) :
                foreach ($inventory as $key => $value) :
                  $totalStock = ($value->total_purchase * $value->conversion_rate) - $value->total_damage - $value->total_order + $value->opening_stock;
                  $totalTK = $totalStock * getLastPurchaseAmount($value->id);
                  if ($totalStock >= 0) {
                    // $grandTotal = $grandTotal + $totalStock * getLastPurchaseAmount($value->id);
                    if ($value->conversion_rate == 0 || $value->conversion_rate == '') {
                      $grandTotal = $grandTotal + $totalStock * (getLastPurchaseAmount($value->id) / 1);
                    } else {
                      $grandTotal = $grandTotal + $totalStock * (round(getLastPurchaseAmount($value->id) / $value->conversion_rate, 2));
                    }
                  }
                  if ($value->conversion_rate == 0 || $value->conversion_rate == '') {
                    $total = $totalStock * (getLastPurchaseAmount($value->id) / 1); //added by alauddin
                  } else {
                    $total = $totalStock * (round(getLastPurchaseAmount($value->id) / $value->conversion_rate, 2)); //added by alauddin
                  }

                  $key++;
                  if ($value->conversion_rate == 0 || $value->conversion_rate == '') {
                    $totalStockPurchase = isset($value->conversion_rate) && (int)$value->conversion_rate ? (int)($totalStock / 1) : '0';
                  } else {
                    $totalStockPurchase = isset($value->conversion_rate) && (int)$value->conversion_rate ? (int)($totalStock / $value->conversion_rate) : '0';
                  }
              ?>
                  <tr>
                    <td class="c_center"><?php echo escape_output($key) ?></td>
                    <td><?php echo escape_output($value->name) ?></td>
                    <td><?php echo escape_output($value->code) ?></td>
                    <td><?php echo escape_output($value->product_category_name) ?></td>
                    <td class="c_center"><?php echo ($totalStockPurchase) && $totalStockPurchase > 0 ? number_format($totalStockPurchase, 2) : '0.0' ?></span></td>
                    <td class="c_center"><?php echo " " . $value->purchse_unit_name ?></span></td>
                    <td class="c_center"><?php echo ($totalStock) && $totalStock > 0 ? number_format($totalStock, 2) : '0.0' ?></span></td>
                    <td class="c_center"><?php echo " " . $value->sale_unit_name ?></span></td>

                    <?php if ($value->conversion_rate == 0 || $value->conversion_rate == '') : ?>
                      <td class="c_center"><?php echo (getLastPurchaseAmount($value->id)) && getLastPurchaseAmount($value->id) > 0 ? (round(getLastPurchaseAmount($value->id) / 1, 2)) : 'N/A' //getLastPurchaseAmount($value->id) 
                                            ?></td>
                    <?php else : ?>
                      <td class="c_center"><?php echo (getLastPurchaseAmount($value->id)) && getLastPurchaseAmount($value->id) > 0 ? (round(getLastPurchaseAmount($value->id) / $value->conversion_rate, 2)) : 'N/A' //getLastPurchaseAmount($value->id) 
                                            ?></td>
                    <?php endif; ?>
                    <td class="c_center"><?php echo ($total) && $total > 0 ? number_format($total) : "N/A" ?></td>
                  </tr>
              <?php
                endforeach;
              endif;
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th class="title"><?php echo lang('sn'); ?></th>
                <th class="title"><?php echo lang('product'); ?></th>
                <th class="title c_center"><?php echo lang('product_sku'); ?></th>
                <th class="title"><?php echo lang('category'); ?></th>
                <th class="title  c_center"><?php echo lang('pur_stock'); ?></th>
                <th class="title c_center"><?php echo lang('pur_unit'); ?></th>
                <th class="title c_center"><?php echo lang('sale_stock'); ?></th>
                <th class="title c_center"><?php echo lang('sale_unit'); ?></th>
                <th class="title c_center"><?php echo lang('price'); ?></th>
                <th class="title c_center"><?php echo lang('total'); ?></th>
              </tr>
            </tfoot>
          </table>
          <input type="hidden" value="<?php echo number_format($grandTotal, 2) ?>" id="grandTotal" name="grandTotal">
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
<script src="<?php echo base_url(); ?>assets/js/inventory.js"></script>