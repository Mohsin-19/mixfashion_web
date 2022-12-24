<section class="content-header">
  <div class="row">
    <div class="col-md-6">
      <h2 class="top-left-header"><?php echo lang('customers'); ?> </h2>
    </div>
    <div class="col-md-offset-2 col-md-4">
      <ul class="list-inline text-right">
        <?php if (has_permission('add_customer')) : ?>
          <li>
            <a href="<?php echo base_url() ?>Customer/addEditCustomer">
              <button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_customer'); ?></button>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- /.box-header -->
        <?php
        $has_permission = has_permission(['edit_customer', 'delete_customer']);
        $edit_customer = has_permission('edit_customer');
        $delete_customer = has_permission('delete_customer');
        ?>

        <div class="box-body table-responsive">
          <input type="hidden" class="datatable_name" data-title="<?php echo lang('customers'); ?>" data-id_name="datatable">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="width_1_p"><?= lang('sn'); ?></th>
                <th class="width_18_p"><?= lang('customer_name'); ?></th>
                <th class=""><?= lang('phone'); ?></th>
                <th class=""><?= lang('email'); ?></th>
                <th class="width_16_p"><?= lang('address'); ?></th>
                <th class=""><?= lang('total') . ' ' . lang('order'); ?></th>
                <th class=""><?= lang('cancel') . ' ' . lang('order'); ?></th>
                <th class=""><?= lang('total') . ' ' . lang('order') . ' ' . lang('amount'); ?></th>
                <th class=""><?= lang('Last') . ' ' . lang('order') . ' ' . lang('date'); ?></th>
                <th class=""><?= lang('added_by'); ?></th>
                <?php if ($has_permission) : ?>
                  <th class="width_1_p c_center not-export-col"><?= lang('actions'); ?></th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($customers && !empty($customers)) {
                $i = count($customers);
              }
              foreach ($customers as $cust) :
                $getTotalValue = getTotalValue($cust->id);
              ?>
                <tr>
                  <td class="c_center"><?php echo escape_output($i--); ?></td>
                  <td><?= escape_output($cust->name); ?></td>
                  <td><?= escape_output($cust->phone); ?></td>
                  <td><?= escape_output($cust->email); ?></td>

                  <td><?= escape_output($cust->address); ?></td>

                  <td><?= escape_output($getTotalValue[0]); ?></td>
                  <td><?= escape_output($getTotalValue[1]); ?></td>
                  <td><?= escape_output($getTotalValue[2]); ?></td>
                  <td><?= escape_output($getTotalValue[3]); ?></td>
                  <td><?= userName($cust->user_id); ?></td>
                  <?php if ($has_permission) : ?>
                    <td class="c_center">
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                          <?php if ($edit_customer) : ?>
                            <li>
                              <a href="<?php echo base_url() ?>Customer/addEditCustomer/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>">
                                <i class="fa fa-edit"></i><?php echo lang('edit'); ?>
                              </a>
                            </li>
                          <?php endif ?>
                          <?php if ($delete_customer) : ?>
                            <li>
                              <a class="delete" href="<?php echo base_url() ?>Customer/deleteCustomer/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>">
                                <i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?>
                              </a>
                            </li>
                          <?php endif ?>

                        </ul>
                      </div>
                    </td>
                  <?php endif ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th><?= lang('sn'); ?></th>
                <th><?= lang('customer_name'); ?></th>
                <th><?= lang('phone'); ?></th>
                <th><?= lang('email'); ?></th>
                <th><?= lang('address'); ?></th>

                <th><?= lang('total') . ' ' . lang('order'); ?></th>
                <th><?= lang('cancel') . ' ' . lang('order'); ?></th>
                <th><?= lang('total') . ' ' . lang('order') . ' ' . lang('amount'); ?></th>
                <th><?= lang('Last') . ' ' . lang('order') . ' ' . lang('date'); ?></th>
                <th><?= lang('added_by'); ?></th>
                <?php if ($has_permission) : ?>
                  <th class="not-export-col"><?= lang('actions'); ?></th>
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