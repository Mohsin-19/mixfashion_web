<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('announcements'); ?> </h2>
    </div>

    <?php if (has_permission('add_announcement')): ?>
      <div class="col-md-offset-4 col-md-2">
        <a href="<?php echo base_url('announcement/addEditAnnouncement') ?>">
          <button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_announcement'); ?></button>
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
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('coupons'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_20_p">Title</th>
              <th class="width_20_p">Type</th>
              <th class="width_10_p">Content</th>
              <th class="width_13_p"><?php echo lang('expired_date'); ?></th>
              <th class="width_20_p"><?php echo lang('added_by'); ?></th>
              <?php if (has_permission(['edit_announcement', 'delete_announcement'])): ?>
                <th style="width: 6%;text-align: center" class="not-export-col"><?php echo lang('actions'); ?></th>
              <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $today = strtotime(date('Y-m-d H:i:s'));
            if ($announcements && !empty($announcements)) {
              $i = count($announcements);
            }
            foreach ($announcements as $value) {
              ?>
              <tr style="background-color: <?= strtotime($value->end_date) < $today ? '#f0dbdb' : '' ?>">
                <td class="c_center"><?php echo escape_output($i--); ?></td>
                <td><?php echo escape_output($value->title); ?></td>
                <td><?php echo escape_output($value->upload_type); ?></td>
                <td><?php echo escape_output($value->upload_content) ?></td>
                <td><?php echo escape_output($value->end_date) ?></td>
                <td><?php echo userName($value->user_id); ?></td>

                <?php if (has_permission(['edit_announcement', 'delete_announcement'])): ?>
                  <td class="c_center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <?php if (has_permission('edit_announcement')): ?>
                          <li>
                            <a href="<?= site_url('Announcement/addEditAnnouncement') ?>/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>">
                              <i class="fa fa-edit"></i><?= lang('edit'); ?>
                            </a>
                          </li>
                        <?php endif; ?>
                        <?php if (has_permission('delete_announcement')): ?>
                          <li>
                            <a class="delete"
                               href="<?= site_url('Announcement/deleteAnnouncement') ?>/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>">
                              <i class="fa fa-trash tiny-icon"></i> <?= lang('delete'); ?>
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
              <th><?php echo lang('sn'); ?></th>
              <th class="width_20_p">Title</th>
              <th class="width_20_p">Type</th>
              <th class="width_10_p">Content</th>
              <th><?php echo lang('expired_date'); ?></th>
              <th><?php echo lang('added_by'); ?></th>
              <?php if (has_permission(['edit_announcement', 'delete_announcement'])): ?>
                <th><?php echo lang('actions'); ?></th>
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