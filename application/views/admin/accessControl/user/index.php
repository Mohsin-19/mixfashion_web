
<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?= lang('manage_users'); ?> </h2>
    </div>
    <div class="col-md-offset-4 col-md-2">
      <a href="<?= site_url('admin/user/create') ?>" class="btn btn-block btn-primary pull-right">
        <?= lang('add_user'); ?>
      </a>
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
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('employees'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_23_p"><?php echo lang('name'); ?></th>
              <th class="width_10_p"><?php echo lang('phone'); ?></th>
              <th class="width_26_p"><?php echo lang('email'); ?></th>
              <th class="width_10_p"><?php echo lang('role'); ?></th>
              <th class="width_5_p"><?php echo lang('status'); ?></th>
              <th class="width_27_p"><?php echo lang('outlet_name'); ?></th>
              <th class="width_2_p c_center not-export-col"><?php echo lang('actions'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($users && !empty($users)) {
              $i = count($users);
            }
            foreach ($users as $usrs) {
              if ($usrs->id != $this->session->userdata['user_id']):
                ?>
                <tr>
                  <td class="c_center"><?php echo escape_output($i--); ?></td>
                  <td><?php echo escape_output($usrs->full_name); ?></td>
                  <td><?php echo escape_output($usrs->phone); ?></td>
                  <td><?php echo escape_output($usrs->email_address); ?></td>
                  <td><?php echo escape_output($usrs->role_name); ?></td>
                  <td><?php echo escape_output($usrs->active_status); ?></td>
                  <td><?php echo escape_output($usrs->outlet_name); ?></td>

                  <td class="c_center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>

                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <?php if ($usrs->active_status == 'Active'): ?>
                          <li>
                            <a href="<?php echo base_url() ?>User/deactivateUser/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>"><i
                                  class="fa fa-times tiny-icon"></i><?php echo lang('deactivate'); ?></a>
                          </li>
                        <?php else: ?>
                          <li>
                            <a href="<?php echo base_url() ?>User/activateUser/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>"><i
                                  class="fa fa-check tiny-icon"></i><?php echo lang('activate'); ?></a>
                          </li>
                        <?php endif ?>
                        <li>
                          <a href="<?= site_url("admin/user/{$usrs->id}/edit") ?>">
                            <i class="fa fa-edit"></i> <?= lang('edit'); ?>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php
              endif;
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
              <th><?php echo lang('sn'); ?></th>
              <th><?php echo lang('name'); ?></th>
              <th><?php echo lang('phone'); ?></th>
              <th><?php echo lang('email'); ?></th>
              <th><?php echo lang('role'); ?></th>
              <th><?php echo lang('status'); ?></th>
              <th><?php echo lang('outlet_name'); ?></th>
              <th class="not-export-col"><?php echo lang('actions'); ?></th>
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