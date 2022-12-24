<section class="content-header">
  <div class="row">
    <div class="col-md-2">
      <h2 class="top-left-header"><?php echo lang('products'); ?> </h2>
    </div>
    <?php echo form_open(base_url() . 'Item/products') ?>
    <div class="col-md-2">

      <select name="category_id" id="category_id" class="form-control select2 width_100_p">
        <option value=""><?php echo lang('category'); ?></option>
        <?php foreach ($productCategories as $ctry): ?>
          <option value="<?php echo escape_output($ctry->id) ?>" <?php echo set_select('category_id', $ctry->id); ?>>
            <?php echo escape_output(htmlspecialchars_decode($ctry->name)) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-2">
      <select name="subcategory_id" id="subcategory_id" class="form-control select2 width_100_p">
        <option value=""><?php echo lang('Subcategory'); ?></option>
        <?php foreach ($subcategories as $val) { ?>
          <option value="<?php echo escape_output($val->id) ?>"
            <?php echo set_select('subcategory_id', $val->id); ?>><?php echo escape_output(htmlspecialchars_decode($val->name)) ?>
          </option>
        <?php } ?>
      </select>
    </div>
    <div class="col-md-1">
      <select name="supplier_id" id="supplier_id" class="form-control select2 width_100_p">
        <option value=""><?php echo lang('supplier'); ?></option>
        <?php foreach ($suppliers as $val) { ?>
          <option
              value="<?php echo escape_output($val->id) ?>" <?php echo set_select('supplier_id', $val->id); ?>><?php echo escape_output($val->name) ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="hidden-lg">&nbsp;</div>
    <div class="col-md-1">
      <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
    </div>
    <?php echo form_close(); ?>
    <div class="hidden-lg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

    <div class="col-md-4 text-right">
      <ul class="list-inline text-right">
        <?php if (has_permission('add_product')): ?>
          <li>
            <a href="<?= site_url('Item/addEditItem') ?>">
              <button type="button" class="btn btn-primary pull-right"><?php echo lang('add_product'); ?></button>
            </a>
          </li>
        <?php endif; ?>
        <?php if (has_permission('upload_product')): ?>
          <li>
            <a href="<?= site_url("Item/uploadItem") ?>">
              <button type="button" class="btn btn-primary pull-right"><?php echo lang('upload_product'); ?></button>
            </a>
          </li>
        <?php endif; ?>
        <?php if (has_permission('barcode_product')): ?>
          <li>
            <a href="<?= site_url("Item/productBarcodeGenerator") ?>">
              <button type="button" class="btn  btn-primary pull-right"><?php echo lang('product_barcode'); ?></button>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>

  </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- /.box-header -->
        <?php
        $has_permission = has_permission(['show_product', 'edit_product', 'delete_product']);
        $show_product = has_permission('show_product');
        $edit_product = has_permission('edit_product');
        $delete_product = has_permission('delete_product');
        ?>
        <div class="box-body table-responsive">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_13_p"><?php echo lang('name'); ?></th>
              <th style="widt: 16%"><?php echo lang('description'); ?></th>
              <th class="width_8_p"><?php echo lang('sale_price'); ?></th>
              <th class="width_12_p"><?php echo lang('purchase_price'); ?></th>
              <th class="width_5_p"><?php echo lang('available'); ?></th>
              <th class="width_10_p"><?php echo lang('discount_price'); ?></th>
              <th class="width_7_p"><?php echo lang('has_offer'); ?></th>
              <th class="width_10_p"><?php echo lang('manage_stock'); ?></th>
              <th class="width_12_p"><?php echo lang('added_by'); ?></th>
              <?php if ($has_permission): ?>
                <th style="width: 6%;text-align: center" class="not-export-col"><?php echo lang('actions'); ?></th>
              <?php endif; ?>
            </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_13_p"><?php echo lang('name'); ?></th>
              <th style="widt: 16%"><?php echo lang('description'); ?></th>
              <th class="width_8_p"><?php echo lang('sale_price'); ?></th>
              <th class="width_12_p"><?php echo lang('purchase_price'); ?></th>
              <th class="width_5_p"><?php echo lang('available'); ?></th>
              <th class="width_10_p"><?php echo lang('discount_price'); ?></th>
              <th class="width_7_p"><?php echo lang('has_offer'); ?></th>
              <th class="width_10_p"><?php echo lang('manage_stock'); ?></th>
              <th class="width_12_p"><?php echo lang('added_by'); ?></th>
              <?php if ($has_permission): ?>
                <td class="not-export-col" style="width: 6%;text-align: center"><?php echo lang('actions'); ?></td>
              <?php endif; ?>
            </tr>
            </tfoot>
          </table>
        </div>
       
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?php echo base_url(); ?>assets/js/products.js"></script>