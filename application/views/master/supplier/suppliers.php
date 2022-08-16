<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('suppliers'); ?> </h2>
    </div>
    <?php if (has_permission('add_supplier')): ?>
      <div class="col-md-offset-4 col-md-2">
        <a href="<?php echo base_url() ?>Supplier/addEditSupplier">
          <button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_supplier'); ?></button>
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
        <?php
        $has_permission = has_permission(['edit_supplier', 'delete_supplier']);
        $edit_supplier = has_permission('edit_supplier');
        $delete_supplier = has_permission('delete_supplier');
        ?>
        <div class="box-body table-responsive">
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('suppliers'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_14_p"><?php echo lang('name'); ?></th>
              <th class="width_14_p"><?php echo lang('contact_person'); ?></th>
              <th class="width_10_p"><?php echo lang('phone'); ?></th>
              <th class="width_10_p"><?php echo lang('email'); ?></th>
              <th class="width_20_p"><?php echo lang('address'); ?></th>
              <th class="width_10_p"><?php echo lang('current_due'); ?></th>
              <th class="width_16_p"><?php echo lang('added_by'); ?></th>
              <?php if ($has_permission): ?>
                <th class="width_6_p c_center not-export-col"><?php echo lang('actions'); ?></th>
              <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($suppliers && !empty($suppliers)) {
              $i = count($suppliers);
            }
            foreach ($suppliers as $si): ?>
              <tr>
                <td class="c_center"><?php echo escape_output($i--); ?></td>
                <td><?php echo escape_output($si->name); ?></td>
                <td><?php echo escape_output($si->contact_person); ?></td>
                <td><?php echo escape_output($si->phone); ?></td>
                <td><?php echo escape_output($si->email); ?></td>
                <td><?php echo escape_output($si->address); ?></td>
                <td><?php echo escape_output($this->session->userdata('currency')) ?><?php echo getSupplierDue($si->id) + $si->previous_due; ?></td>
                <td><?php echo userName($si->user_id); ?></td>
                <?php if ($has_permission): ?>
                  <td class="c_center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <?php if ($edit_supplier): ?>
                          <li>
                            <a href="<?php echo base_url() ?>Supplier/addEditSupplier/<?php echo escape_output($this->custom->encrypt_decrypt($si->id, 'encrypt')); ?>">
                              <i class="fa fa-edit"></i><?php echo lang('edit'); ?>
                            </a>
                          </li>
                        <?php endif; ?>
                        <?php if ($delete_supplier): ?>
                          <li>
                            <a class="delete"
                               href="<?php echo base_url() ?>Supplier/deleteSupplier/<?php echo escape_output($this->custom->encrypt_decrypt($si->id, 'encrypt')); ?>">
                              <i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?>
                            </a>
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
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th><?php echo lang('name'); ?></th>
              <th><?php echo lang('contact_person'); ?></th>
              <th><?php echo lang('phone'); ?></th>
              <th><?php echo lang('email'); ?></th>
              <th><?php echo lang('address'); ?></th>
              <th><?php echo lang('current_due'); ?></th>
              <th><?php echo lang('added_by'); ?></th>
              <?php if ($has_permission): ?>
                <th class="c_center not-export-col"><?php echo lang('actions'); ?></th>
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