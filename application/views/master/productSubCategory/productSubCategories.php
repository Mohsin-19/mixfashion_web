<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('product_subcategories'); ?> </h2>
    </div>
    <?php if (has_permission('add_sub_category')): ?>
      <div class="col-md-6 text-right">
        <a href="<?= site_url('SubCategory/addEditItemSubCategory') ?>">
          <button type="button" class="btn btn-primary "><?= lang('add_product_subcategory'); ?></button>
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
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('product_subcategories'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_15_p"><?php echo lang('category'); ?></th>
              <th class="width_15_p"><?php echo lang('SubCategory_name'); ?></th>
              <th class="width_7_p"><?php echo lang('Icon'); ?></th>
              <th class="width_30_p"><?php echo lang('description'); ?></th>
              <th class="width_17_p text-center">No. Of Products</th>
              <th class="width_17_p"><?php echo lang('added_by'); ?></th>
              <?php if (has_permission(['edit_sub_category', 'delete_sub_category'])): ?>
                <th class="width_6_p c_center not-export-col"><?php echo lang('actions'); ?></th>
              <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $totalCategory = 0;
            $totalProduct = 0;
            if ($productSubCategory && !empty($productSubCategory)) {
              $i = count($productSubCategory);
            }
            foreach ($productSubCategory as $fmc) {
              $totalCategory += 1;
              $totalProduct += $fmc->totalProducts;
              ?>
              <tr>
                <td class="c_center"><?php echo escape_output($i--); ?></td>
                <td><?php echo getCategoryName($fmc->cat_id); ?></td>
                <td><?php echo escape_output($fmc->name); ?></td>
                <td>
                  <img src="<?php echo base_url('images/' . $fmc->icon) ?>" style="width: 50px" alt="<?php echo $fmc->name ?>">
                </td>
                <td><?php echo escape_output($fmc->description); ?></td>
                <td class=" text-center"><?= $fmc->totalProducts ?></td>
                <td><?php echo userName($fmc->user_id); ?></td>

                <?php if (has_permission(['edit_sub_category', 'delete_sub_category'])): ?>
                  <th class="c_center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <?php if (has_permission('edit_sub_category')): ?>
                          <li>
                            <a
                                href="<?php echo base_url() ?>SubCategory/addEditItemSubCategory/<?php echo escape_output($this->custom->encrypt_decrypt($fmc->id, 'encrypt')); ?>">
                              <i class="fa fa-edit"></i> <?php echo lang('edit'); ?>
                            </a>
                          </li>
                        <?php endif; ?>
                        <?php if (has_permission('delete_sub_category')): ?>
                          <li>
                            <a class="delete"
                               href="<?php echo base_url() ?>SubCategory/deleteItemSubCategory/<?php echo escape_output($this->custom->encrypt_decrypt($fmc->id, 'encrypt')); ?>">
                              <i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?>
                            </a>
                          </li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </td>
                <?php endif; ?>
              </tr>
              <?php
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_15_p"><?php echo lang('category'); ?></th>
              <th class="width_15_p"><?php echo lang('SubCategory_name'); ?></th>

              <th class="width_7_p"><?php echo lang('Icon'); ?></th>
              <th class="width_30_p"><?php echo lang('description'); ?></th>
              <th class="width_30_p">No. Of Products</th>
              <th class="width_17_p"><?php echo lang('added_by'); ?></th>
              <?php if (has_permission(['edit_sub_category', 'delete_sub_category'])): ?>
                <th class="width_6_p c_center not-export-col"><?php echo lang('actions'); ?></th>
              <?php endif; ?>
            </tr>
            </tfoot>
          </table>


          <p>
            Total Sub Category: <b><?= $totalCategory; ?></b>, Total Products: <b><?= $totalProduct; ?></b>
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