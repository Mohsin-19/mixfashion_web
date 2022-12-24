<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header">Manage Size </h2>
    </div>
    <?php if (has_permission('add_size')) : ?>
      <div class="col-md-offset-4 col-md-2">
        <a href="<?= site_url('admin/size/add-edit') ?>">
          <button type="button" class="btn btn-block btn-primary pull-right">Add Size</button>
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
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('units'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
              <tr>	
                <th class="width_1_p"><?php echo lang('sn'); ?></th>
                <th class="width_25_p">Name</th>
                <th class="width_16_p">Description</th>
                <th class="width_16_p">Status</th>
                <th class="width_16_p">AddedBy</th>
                <?php if (has_permission(['edit_size', 'delete_size'])) : ?>
                  <th class="width_16_p c_center not-export-col"><?php echo lang('actions'); ?></th>
                <?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($sizes && !empty($sizes)) {
                $i = count($sizes);
              }
              foreach ($sizes as $size) {
              ?>
                <tr>
                  <td class="c_center"><?php echo escape_output($i--); ?></td>
                  <td><?= $size->name ?></td>
                  <td><?= $size->description ?></td>
                  <td><?= $size->active ? 'Active' : 'Inactive' ?></td>
                  <td><?= $size->full_name ?></td>

                  <?php if (has_permission(['edit_size', 'delete_size'])) : ?>
                    <td class="c_center">
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">

                          <?php if (has_permission('edit_size')) : ?>
                            <li>
                              <a href="<?= site_url('admin/size/add-edit/' . $size->id) ?>"><i class="fa fa-edit"></i><?php echo lang('edit'); ?></a>
                            </li>
                          <?php endif; ?>

                          <?php if (has_permission('delete_size')) : ?>
                            <li>
                              <a class="delete" href="<?= site_url('admin/size/delete/' . $size->id) ?>"><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a>
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
                <th class="width_25_p">Name</th>
                <th class="width_16_p">Description</th>
                <th class="width_16_p">Status</th>
                <th class="width_16_p">AddedBy</th>
                <?php if (has_permission(['edit_size', 'delete_size'])) : ?>
                  <th class="width_16_p c_center not-export-col"><?php echo lang('actions'); ?></th>
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