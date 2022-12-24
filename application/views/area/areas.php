<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('Area'); ?></h2>
    </div>
    <div class="col-md-offset-4 col-md-2">
      <a href="<?php echo base_url() ?>area/addEditArea">
        <button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('AddArea'); ?></button>
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
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('Area'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_23_p"><?php echo lang('AreaName'); ?></th>
              <th class="width_23_p">ChargeType</th>
              <th class="width_23_p">DeliveryCharge</th>
              <th class="width_2_p c_center not-export-col"><?php echo lang('actions'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($area && !empty($area)) {
              $i = count($area);
            }
            foreach ($area as $usrs) {
              ?>
              <tr>
                <td class="c_center"><?php echo escape_output($i--); ?></td>
                <td><?php echo escape_output($usrs->name); ?></td>
                <td><?php echo escape_output($usrs->charge_type); ?></td>
                <td><?= $usrs->delivery_charge . " " . ($usrs->charge_type == "avg_charge" ? "% Increase" : ""); ?></td>
                <td class="c_center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                      <li>
                        <a href="<?php echo base_url() ?>area/addEditArea/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>"><i
                              class="fa fa-edit"></i><?php echo lang('edit'); ?></a>
                      </li>
                      <li>
                        <a class="delete"
                           href="<?php echo base_url() ?>area/deleteArea/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>"><i
                              class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a>
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
              <th><?php echo lang('sn'); ?></th>
              <th><?php echo lang('AreaName'); ?></th>
              <th class="width_23_p">ChargeType</th>
              <th class="width_23_p">DeliveryCharge</th>
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