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
      <h2 class="top-left-header">
        <?php echo lang('coupons-customer'); ?>
      </h2>
    </div>
    <div class="col-md-offset-4 col-md-2">
      <!--      <a href="--><?php //echo base_url() 
                            ?>
      <!--Coupon/addEditCoupon">-->
      <!--        <button type="button" class="btn btn-block btn-primary pull-right">--><?php //echo lang('add_coupon'); 
                                                                                        ?>
      <!--</button>-->
      <!--      </a>-->
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
                <th class="width_20_p"><?php echo lang('used_customer'); ?></th>
                <th class="width_20_p"><?php echo lang('order_total'); ?></th>
                <th class="width_10_p"><?php echo lang('dis_amount'); ?></th>
                <th class="width_20_p"><?php echo lang('code'); ?></th>
                <th class="width_13_p"><?php echo lang('expired_date'); ?></th>
                <th class="width_20_p"><?php echo lang('added_by'); ?></th>
                <th style="width: 6%;text-align: center" class="not-export-col"><?php echo lang('actions'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($coupon_customers && !empty($coupon_customers)) {
                $i = count($coupons);
              }
              foreach ($coupon_customers as $value) {
              ?>
                <tr style="background-color: <?= isset($value->is_complete) && $value->is_complete == 1 ? '#f0dbdb' : '' ?>">
                  <td class="c_center"><?php echo escape_output($i--); ?></td>
                  <td><?php echo escape_output(getCustomerName($value->id)); ?></td>
                  <td><?php echo escape_output($value->total_amount); ?></td>
                  <td><?php echo escape_output($value->amount) ?></td>
                  <td><?php echo escape_output($value->code); ?></td>
                  <td><?php echo escape_output($value->expired_date) ?></td>
                  <td><?php echo userName($value->user_id); ?></td>
                  <td class="c_center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li><a href="<?php echo base_url() ?>Coupon/addEditCoupon/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>"><i class="fa fa-edit"></i><?php echo lang('edit'); ?></a></li>
                        <li><a class="delete" href="<?php echo base_url() ?>Coupon/deleteCoupon/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>"><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a></li>
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
                <th><?php echo lang('used_customer'); ?></th>
                <th><?php echo lang('code'); ?></th>
                <th><?php echo lang('amount'); ?></th>
                <th><?php echo lang('expired_date'); ?></th>
                <th><?php echo lang('added_by'); ?></th>
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