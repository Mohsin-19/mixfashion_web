<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('units'); ?> </h2>
    </div>
    <?php if (has_permission('add_unit')): ?>
      <div class="col-md-offset-4 col-md-2">
        <a href="<?php echo base_url() ?>Unit/addEditUnit">
          <button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_unit'); ?></button>
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
              <th class="width_25_p"><?php echo lang('unit_name'); ?></th>
              <th class="width_16_p"><?php echo lang('description'); ?></th>
              <?php if (has_permission(['edit_unit', 'delete_unit'])): ?>
                <th class="width_16_p c_center not-export-col"><?php echo lang('actions'); ?></th>
              <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($Units && !empty($Units)) {
              $i = count($Units);
            }
            foreach ($Units as $unit) {
              ?>
              <tr>
                <td class="c_center"><?php echo escape_output($i--); ?></td>
                <td><?php echo escape_output($unit->unit_name); ?></td>
                <td><?php echo escape_output($unit->description); ?></td>

                <?php if (has_permission(['edit_unit', 'delete_unit'])): ?>
                  <td class="c_center">
                    <?php if ($unit->unit_name != 'Pcs') { ?>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">

                          <?php if (has_permission('edit_unit')): ?>
                            <li>
                              <a href="<?php echo base_url() ?>Unit/addEditUnit/<?php echo escape_output($this->custom->encrypt_decrypt($unit->id, 'encrypt')); ?>"><i
                                    class="fa fa-edit"></i><?php echo lang('edit'); ?></a>
                            </li>
                          <?php endif; ?>

                          <?php if (has_permission('delete_unit')): ?>
                            <li>
                              <a class="delete"
                                 href="<?php echo base_url() ?>Unit/deleteUnit/<?php echo escape_output($this->custom->encrypt_decrypt($unit->id, 'encrypt')); ?>"><i
                                    class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a>
                            </li>
                          <?php endif; ?>
                        </ul>
                      </div>
                    <?php } ?>
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
              <th class="width_25_p"><?php echo lang('unit_name'); ?></th>
              <th class="width_16_p"><?php echo lang('description'); ?></th>
              <?php if (has_permission(['edit_unit', 'delete_unit'])): ?>
                <th class="width_6_p c_center not-export-col"><?php echo lang('actions'); ?></th>
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