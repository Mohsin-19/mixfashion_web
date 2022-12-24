<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('product_categories'); ?> </h2>
    </div>

    <?php if (has_permission('add_category')): ?>
    <div class="col-md-6 text-right">
      <a href="<?php echo base_url() ?>Category/addEditItemCategory">
        <button type="button" class="btn btn-primary "><?php echo lang('add_product_category'); ?></button>
      </a>
      <?php endif; ?>
      <?php if (has_permission('sort_category')): ?>
      <a href="<?= site_url('Category/orderCategory') ?>">
        <button type="button" class="btn btn-primary"><?= lang('OrderCategory'); ?></button>
      </a>
    </div>
  <?php endif; ?>

  </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('product_categories'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_28_p"><?php echo lang('category_name'); ?></th>
              <th class="width_7_p"><?php echo lang('Icon'); ?></th>
              <th class="width_15_p"><?php echo lang('SpecialCategory'); ?></th>
              <th class="width_25_p"><?php echo lang('description'); ?></th>
              <th class="width_17_p text-center">No. Of Products</th>
              <th class="width_17_p text-center"><?php echo lang('added_by'); ?></th>
              <?php if (has_permission(['edit_category', 'delete_category'])): ?>
                <th class="width_6_p c_center not-export-col"><?php echo lang('actions'); ?></th>
              <?php endif; ?>
            </tr>
            </thead>
            <tbody id="">
            <?php
            $totalCategory = 0;
            $totalProduct = 0;
            if ($productCategories && !empty($productCategories)) {
              $i = count($productCategories);
            }
            foreach ($productCategories as $fmc):
              $totalCategory += 1;
              $totalProduct += $fmc->totalProducts;
              ?>
              <tr>
                <td class="c_center"><?php echo escape_output($i--); ?></td>
                <td><?php echo escape_output($fmc->name); ?></td>
                <td>
                  <img src="<?php echo base_url('images/' . $fmc->icon) ?>" style="width: 50px" class="img-responsive"
                       alt="<?php echo $fmc->name ?>">
                </td>
                <td><?php echo escape_output($fmc->special_category); ?></td>
                <td><?php echo escape_output($fmc->description); ?></td>
                <td class=" text-center"><?php echo escape_output($fmc->totalProducts); ?></td>
                <td class=" text-center"><?php echo userName($fmc->user_id); ?></td>

                <?php if (has_permission(['edit_category', 'delete_category'])): ?>
                  <td class="c_center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <?php if (has_permission('edit_category')): ?>
                          <li>
                            <a href="<?php echo base_url() ?>Category/addEditItemCategory/<?php echo escape_output($this->custom->encrypt_decrypt($fmc->id, 'encrypt')); ?>">
                              <i class="fa fa-edit"></i><?= lang('edit'); ?>
                            </a>
                          </li>
                        <?php endif; ?>

                        <?php if (has_permission('delete_category')): ?>
                          <li>
                            <a class="delete"
                               href="<?php echo base_url() ?>Category/deleteItemCategory/<?php echo escape_output($this->custom->encrypt_decrypt($fmc->id, 'encrypt')); ?>">
                              <i class="fa fa-trash tiny-icon"></i> <?= lang('delete'); ?></a>
                          </li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
              <th><?php echo lang('sn'); ?></th>
              <th><?php echo lang('category_name'); ?></th>
              <th><?php echo lang('Icon'); ?></th>
              <th><?php echo lang('SpecialCategory'); ?></th>
              <th><?php echo lang('description'); ?></th>
              <th class="width_17_p text-center">No. Of Products</th>
              <th><?php echo lang('added_by'); ?></th>
              <?php if (has_permission(['edit_category', 'delete_category'])): ?>
                <th class="c_center not-export-col"><?php echo lang('actions'); ?></th>
              <?php endif; ?>
            </tr>
            </tfoot>
          </table>

          <p>
            Total Category: <b><?= $totalCategory; ?></b>, Total Products: <b><?= $totalProduct; ?></b>
          </p>

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