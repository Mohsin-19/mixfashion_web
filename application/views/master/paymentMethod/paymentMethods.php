<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('payment_methods'); ?> </h2>
    </div>
    <?php if (has_permission('add_payment_method')): ?>
      <div class="col-md-offset-4 col-md-2">
        <a href="<?php echo base_url() ?>PaymentMethod/addEditPaymentMethod">
          <button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_payment_method'); ?></button>
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
        $has_permission = has_permission(['edit_payment_method', 'delete_payment_method']);
        $edit_payment_method = has_permission('edit_payment_method');
        $delete_payment_method = has_permission('delete_payment_method');
        ?>

        <div class="box-body table-responsive">
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('payment_methods'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_13_p"><?php echo lang('account_name'); ?></th>
              <th class="width_20_p"><?php echo lang('description'); ?></th>
              <th class="width_13_p"><?php echo lang('balance'); ?></th>
              <th class="width_26_p"><?php echo lang('added_by'); ?></th>
              <?php if ($has_permission): ?>
                <th style="width: 6%;text-align: center"><?php echo lang('actions'); ?></th>
              <?php endif ?>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($paymentMethods && !empty($paymentMethods)) {
              $i = count($paymentMethods);
            }
            foreach ($paymentMethods as $value):
              $balance = 0;
              $balance = $value->current_balance - $value->total_purchase - $value->total_supplier_due_payment + $value->total_deposit - $value->total_withdraw - $value->total_expense + $value->total_order;

              ?>
              <tr>
                <td class="c_center"><?php echo escape_output($i--); ?></td>
                <td><?php echo escape_output($value->name); ?></td>
                <td><?php echo escape_output($value->description); ?></td>
                <td><?php echo escape_output($balance) ?></td>
                <td><?php echo userName($value->user_id); ?></td>

                <?php if ($has_permission): ?>
                  <td class="c_center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <?php if ($edit_payment_method): ?>
                          <li>
                            <a href="<?php echo base_url() ?>PaymentMethod/addEditPaymentMethod/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>">
                              <i class="fa fa-edit"></i><?php echo lang('edit'); ?></a>
                          </li>
                        <?php endif; ?>
                        <?php if ($delete_payment_method): ?>
                          <li>
                            <a class="delete"
                               href="<?php echo base_url() ?>PaymentMethod/deletePaymentMethod/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>">
                              <i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?>
                            </a>
                          </li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </td>
                <?php endif ?>
              </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
              <th><?php echo lang('sn'); ?></th>
              <th><?php echo lang('account_name'); ?></th>
              <th><?php echo lang('description'); ?></th>
              <th class="width_34_p"><?php echo lang('balance'); ?></th>
              <th><?php echo lang('added_by'); ?></th>
              <?php if ($has_permission): ?>
                <th class="c_center"><?php echo lang('actions'); ?></th>
              <?php endif ?>
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