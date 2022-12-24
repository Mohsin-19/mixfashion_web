<section class="content-header">
  <div class="col-md-12 text-center">
    <h2 class="top-left-header"><?php echo lang('low_inventory'); ?></h2>
  </div>
  <div class="row">
    <div class="col-md-1">
      <a href="<?php echo base_url() . 'Inventory/inventory' ?>"
         class="btn btn-block btn-primary pull-left"><strong><?php echo lang('back'); ?></strong></a>
    </div>
    <strong class="txt-uh-38" id=""><?php echo lang('price'); ?> = <?php echo lang('p_status'); ?></strong>
    <div class="hidden-lg"><span class="txt-uh-39">hidden text</span></div>
  </div>

</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="title width_5_p"><?php echo lang('sn'); ?></th>
              <th class="title width_30_p"><?php echo lang('product'); ?>(<?php echo lang('code'); ?>)</th>
              <th class="title width_15_p"><?php echo lang('category'); ?></th>
              <th class="title width_12_p c_center"><?php echo lang('stock_qty_amount_p'); ?></th>
              <th class="title width_12_p c_center"><?php echo lang('stock_qty_amount_s'); ?></th>
              <th class="title width_12_p c_center"><?php echo lang('price'); ?></th>
              <th class="title width_25_p c_center"><?php echo lang('alert_quantity'); ?></th>
              <th class="title width_10_p c_center"><?php echo lang('total'); ?></th>
            </tr>
            </thead>
            <tbody>

            <?php
            $totalStock = 0;
            $grandTotal = 0;
            $alertCount = 0;
            $totalTK = 0;
            $i = 1;
            $totalStockPurchase = 0;
            if (!empty($inventory) && isset($inventory)):
              foreach ($inventory as $key => $value):

                $total = 0;

                $totalStock = ($value->total_purchase * $value->conversion_rate) - $value->total_damage - $value->total_order + $value->opening_stock;
                $totalTK = $totalStock * getLastPurchaseAmount($value->id);
                if ($totalStock >= 0) {
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
                if ($value->conversion_rate == 0 || $value->conversion_rate == '') {
                  $totalStockPurchase = isset($value->conversion_rate) && (int)$value->conversion_rate ? (int)($totalStock / 1) : '0';
                } else {
                  $totalStockPurchase = isset($value->conversion_rate) && (int)$value->conversion_rate ? (int)($totalStock / $value->conversion_rate) : '0';
                }
                if ($totalStock <= $value->alert_quantity):
                  ?>
                  <tr>
                    <td class="c_center"><?php echo escape_output($i) ?></td>
                    <td><?php echo escape_output($value->name) . "(" . $value->code . ")" ?></td>
                    <td><?php echo escape_output($value->product_category_name) ?></td>
                    <td class="c_center"><?php echo ($totalStock) ? $totalStock : '0.0' ?><?php echo " " . $value->sale_unit_name ?></span></td>
                    <td class="c_center"><?php echo ($totalStockPurchase) && $totalStockPurchase > 0 ? $totalStockPurchase : '0.0' ?><?php echo " " . $value->purchse_unit_name ?></span></td>
                    <!--    <td><?php echo (getLastPurchaseAmount($value->id)) && getLastPurchaseAmount($value->id) > 0 ? (round(getLastPurchaseAmount($value->id) / $value->conversion_rate, 2)) : 'N/A'//getLastPurchaseAmount($value->id)
                    ?></td>-->
                    <?php if ($value->conversion_rate == 0 || $value->conversion_rate == '') { ?>
                      <th class="c_center"><?php echo (getLastPurchaseAmount($value->id)) && getLastPurchaseAmount($value->id) > 0 ? (round(getLastPurchaseAmount($value->id) / 1, 2)) : 'N/A'//getLastPurchaseAmount($value->id) ?></td>
                    <?php } else { ?>
                      <th class="c_center"><?php echo (getLastPurchaseAmount($value->id)) && getLastPurchaseAmount($value->id) > 0 ? (round(getLastPurchaseAmount($value->id) / $value->conversion_rate, 2)) : 'N/A'//getLastPurchaseAmount($value->id) ?></td>
                    <?php } ?>

                    <th class="c_center"><span
                          style="<?php echo ($totalStock <= $value->alert_quantity) ? 'color:red' : '' ?>"><?php echo escape_output($value->alert_quantity) ?><?php echo " " . $value->sale_unit_name ?></span>
                    </td>

                    <th class="c_center">
                    <?php echo ($total) && $total > 0 ? number_format($total) : "N/A" ?></td>
                  </tr>
                  <?php
                  $i++;
                endif;

              endforeach;
            endif;
            ?>
            </tbody>
            <tfoot>
            <tr>
              <th class="title"><?php echo lang('sn'); ?></th>
              <th class="title"><?php echo lang('product'); ?>(<?php echo lang('code'); ?>)</th>
              <th class="title"><?php echo lang('category'); ?></th>
              <th class="title c_center"><?php echo lang('stock_qty_amount_p'); ?></th>
              <th class="title c_center"><?php echo lang('stock_qty_amount_s'); ?></th>
              <th class="title c_center"><?php echo lang('price'); ?></th>
              <th class="title c_center"><?php echo lang('alert_quantity'); ?></th>
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