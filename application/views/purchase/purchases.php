<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('purchases'); ?> </h2>
    </div>
    <?php if (has_permission('add_purchase')): ?>
      <div class="col-md-offset-4 col-md-2">
        <a href="<?php echo base_url() ?>Purchase/addEditPurchase">
          <button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_purchase'); ?></button>
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
        <?php
        $has_permission = has_permission(['view_details', 'edit_purchase', 'delete_purchase']);
        $view_details = has_permission('view_details');
        $edit_purchase = has_permission('edit_purchase');
        $delete_purchase = has_permission('delete_purchase');
        ?>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('purchases'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-responsive table-bordered table-striped">
            <thead>
            <tr>
              <th class="width_1_p"><?php echo lang('sn'); ?></th>
              <th class="width_11_p"><?php echo lang('ref_no'); ?></th>
              <th class="width_11_p"><?php echo lang('invoice_no'); ?></th>
              <th class="width_8_p"><?php echo lang('date'); ?></th>
              <th class="width_18_p"><?php echo lang('supplier'); ?></th>
              <th class="width_9_p"><?php echo lang('g_total'); ?></th>
              <th class="width_9_p"><?php echo lang('due'); ?></th>
              <th class="width_15_p"><?php echo lang('payment_methods'); ?></th>
              <th class="width_12_p"><?php echo lang('added_by'); ?></th>
              <?php if ($has_permission): ?>
                <th class="width_5_p c_center not-export-col"><?php echo lang('actions'); ?></th>
              <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($purchases && !empty($purchases)) {
              $i = count($purchases);
            }
            foreach ($purchases as $prchs):
              ?>
              <tr>
                <td><?php echo escape_output($i--); ?></td>
                <td><?php echo escape_output($prchs->reference_no); ?></td>
                <td><?php echo escape_output($prchs->invoice_no); ?></td>
                <td><?php echo date($this->session->userdata('date_format'), strtotime($prchs->date)); ?></td>
                <td><?php echo getSupplierNameById($prchs->supplier_id); ?></td>
                <td><?php echo escape_output($this->session->userdata('currency') . " ") . $prchs->grand_total ?></td>
                <td><?php echo escape_output($this->session->userdata('currency') . " ") . (isset($prchs->due) && $prchs->due ? $prchs->due : '0.00') ?></td>
                <td><?php echo getPaymentName($prchs->payment_method_id); ?></td>
                <td><?php echo userName($prchs->user_id); ?></td>
                <?php if ($has_permission): ?>
                  <td class="c_center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <?php if ($view_details): ?>
                          <li>
                            <a href="<?php echo base_url() ?>Purchase/purchaseDetails/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>">
                              <i class="fa fa-eye tiny-icon"></i><?php echo lang('view_details'); ?>
                            </a>
                          </li>
                        <?php endif; ?>
                        <?php if ($edit_purchase): ?>
                          <li>
                            <a href="<?php echo base_url() ?>Purchase/addEditPurchase/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>">
                              <i class="fa fa-edit"></i><?php echo lang('edit'); ?>
                            </a>
                          </li>
                        <?php endif; ?>
                        <?php if ($delete_purchase): ?>
                          <li>
                            <a class="delete"
                               href="<?php echo base_url() ?>Purchase/deletePurchase/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>">
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
              <th><?php echo lang('sn'); ?></th>
              <th><?php echo lang('ref_no'); ?></th>
              <th class="width_11_p"><?php echo lang('invoice_no'); ?></th>
              <th><?php echo lang('date'); ?></th>
              <th><?php echo lang('supplier'); ?></th>
              <th><?php echo lang('g_total'); ?></th>
              <th><?php echo lang('due'); ?></th>
              <th><?php echo lang('payment_methods'); ?></th>
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