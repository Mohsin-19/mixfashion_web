<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('coupons'); ?> </h2>
    </div>
    <?php if (has_permission('add_coupon')): ?>
      <div class="col-md-offset-4 col-md-2">
        <a href="<?= site_url('Coupon/addEditCoupon') ?>">
          <button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_coupon'); ?></button>
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
        $has_permission = has_permission(['edit_coupon', 'delete_coupon']);
        $edit_coupon = has_permission('edit_coupon');
        $delete_coupon = has_permission('delete_coupon');
        ?>
        <div class="box-body table-responsive">
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('coupons'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_20_p"><?php echo lang('code'); ?></th>
              <th class="width_20_p"><?php echo lang('coupon_option'); ?></th>
              <th class="width_10_p"><?php echo lang('amount'); ?></th>
              <th class="width_13_p"><?php echo lang('expired_date'); ?></th>
              <th class="width_20_p"><?php echo lang('added_by'); ?></th>
              <?php if ($has_permission): ?>
                <th style="width: 6%;text-align: center" class="not-export-col"><?php echo lang('actions'); ?></th>
              <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $today = strtotime(date('Y-m-d'));
            if ($coupons && !empty($coupons)) {
              $i = count($coupons);
            }
            foreach ($coupons as $value) {
              ?>
              <tr style="background-color: <?= strtotime($value->expired_date) >= $today ?: '#f0dbdb' ?>">
                <td class="c_center"><?php echo escape_output($i--); ?></td>
                <td><?php echo escape_output($value->code); ?></td>
                <td>
                  <?php
                  if ($value->coupon_option == '2000') {
                    echo 'For 1,999+ Total';
                  } elseif ($value->coupon_option == 'emp_special_300') {
                    echo 'Employee Special 300+ Order ';
                  } elseif ($value->coupon_option == '499_1999') {
                    echo 'For 499-1,999 Total';
                  } elseif ($value->coupon_option == 'repeat_coupon') {
                    echo 'For Repeat Coupon';
                  } elseif ($value->coupon_option == 'new_user') {
                    echo 'New User Coupon';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  if ($value->amount == 'free_deliver') {
                    echo 'Free Delivery';
                  } else {
                    echo $value->amount . '% Flat Discount';
                  }
                  ?>
                </td>
                <td><?php echo escape_output($value->expired_date) ?></td>
                <td><?php echo userName($value->user_id); ?></td>

                <?php if ($has_permission): ?>
                  <td class="c_center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <?php if ($edit_coupon): ?>
                          <li>
                            <a href="<?php echo base_url() ?>Coupon/addEditCoupon/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>"><i
                                  class="fa fa-edit"></i><?php echo lang('edit'); ?></a>
                          </li>
                        <?php endif; ?>
                        <?php if ($delete_coupon): ?>
                          <li>
                            <a class="delete"
                               href="<?php echo base_url() ?>Coupon/deleteCoupon/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>"><i
                                  class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a>
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
              <th><?php echo lang('code'); ?></th>
              <th><?php echo lang('coupon_option'); ?></th>
              <th><?php echo lang('amount'); ?></th>
              <th><?php echo lang('expired_date'); ?></th>
              <th><?php echo lang('added_by'); ?></th>
              <?php if ($has_permission): ?>
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