<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?= lang('slideshows'); ?> </h2>
    </div>
    <div class="col-md-offset-4 col-md-2">
      <a href="<?= base_url("slideshow/addEditSlideshow") ?>"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_slideshow'); ?></button></a>
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
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('slideshows'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="width_1_p"><?php echo lang('sn'); ?></th>
                <th class="width_23_px"><?php echo lang('title'); ?></th>
                <th class="width_23_px">Url</th>
                <th class="width_10_p"><?php echo lang('status'); ?></th>
                <th class="width_10_p"><?php echo lang('show'); ?></th>
                <th class="width_2_p c_center not-export-col"><?php echo lang('actions'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($slideshows && !empty($slideshows)) {
                $i = count($slideshows);
              }
              foreach ($slideshows as $usrs) {
              ?>
                <tr>
                  <td class="c_center"><?php echo escape_output($i--); ?></td>
                  <td><?php echo escape_output($usrs->title); ?></td>
                  <td><?php echo escape_output($usrs->btn_url); ?></td>
                  <td><?php echo escape_output($usrs->active_status); ?></td>
                  <td><a href="<?php echo base_url() ?>slide images/<?php echo escape_output($usrs->photo); ?>" class="btn btn-xs btn-primary show_preview" data-toggle="modal" data-target="#logo_preview"><?php echo lang('show'); ?></a></td>
                  <td class="c_center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>

                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li>
                          <a href="<?php echo base_url() ?>slideshow/addEditSlideshow/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>"><i class="fa fa-edit"></i><?php echo lang('edit'); ?></a>
                        </li>
                        <li>
                          <a class="delete" href="<?php echo base_url() ?>slideshow/deleteSlideshow/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>"><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a>
                        </li>

                      </ul>
                    </div>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th class="width_1_p"><?php echo lang('sn'); ?></th>
                <th><?php echo lang('title'); ?></th>
                <th class="width_10_p"><?php echo lang('status'); ?></th>
                <th class="width_10_p"><?php echo lang('show'); ?></th>
                <th class="width_2_p c_center not-export-col"><?php echo lang('actions'); ?></th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="logo_preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <img class="width_100_p" src="" id="show_id">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
      </div>
    </div>

  </div>
</div>

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
<script src="<?php echo base_url(); ?>assets/js/slide_show.js"></script>