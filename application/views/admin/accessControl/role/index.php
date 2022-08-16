<?php
if ($this->session->flashdata('exception')) {

  echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
  echo escape_output($this->session->flashdata('exception'));
  echo '</p></div></section>';
}
?>
<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('manage_role'); ?> </h2>
    </div>
    <div class="col-md-offset-4 col-md-2">
      <a href="<?= site_url('admin/role/create') ?>" class="btn btn-block btn-primary pull-right">
        <?= lang('add_role'); ?>
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
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('coupons'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_20_p">Role</th>
              <th class="width_13_p">Description</th>
              <th class="width_20_p"><?= lang('added_by'); ?></th>
              <th class="width_13_p">Add Date</th>
              <th style="width: 6%;text-align: center" class="not-export-col"><?= lang('actions'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($roles as $key => $role): ?>
              <tr>
                <td class="c_center"><?= ++$key ?></td>
                <td><?= escape_output($role->name); ?></td>
                <td><?= escape_output($role->description) ?></td>
                <td><?= escape_output($role->full_name); ?></td>
                <td><?= date('d-m-Y', strtotime($role->created_at)) ?></td>
                <td class="c_center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                      <li>
                        <a href="<?= site_url("admin/role/{$role->id}/edit") ?>">
                          <i class="fa fa-edit"></i> <?= lang('edit'); ?></a>
                      </li>
                      <li>
                        <a class="delete" href="<?= site_url("admin/role/{$role->id}/delete") ?>">
                          <i class="fa fa-trash tiny-icon"></i> <?= lang('delete'); ?>
                        </a>
                      </li>
                    </ul>
                  </div> <!-- btn-group -->
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
              <th><?php echo lang('sn'); ?></th>
              <th class="width_20_p">Role</th>
              <th class="width_20_p">Description</th>
              <th><?php echo lang('added_by'); ?></th>
              <th>Add Date</th>
              <th><?php echo lang('actions'); ?></th>
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