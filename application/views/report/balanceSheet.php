<?php
$getSiteSetting =  getSiteSetting();
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <h3 class="c_center"><?php echo lang('BalanceSheet'); ?></h3>
                    <h4 class="c_center"><?php echo isset($getSiteSetting->site_title) && $getSiteSetting->site_title?$getSiteSetting->site_title:''?></h4>
                    <h4 class="c_center"><?php echo lang('GeneratedOn'); ?>: <?php echo date($this->session->userdata('date_format'), strtotime('today'))?></h4>

                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('BalanceSheet'); ?>" data-id_name="datatable">
                    <table id="datatable"  class="table table-bordered table-striped">
                        <thead>
                        <tr class="no-print display_none">
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="txt-uh-32">
                            <td class="txt-uh-85"><h3 class="txt-uh-87"><?php echo lang('Accounts'); ?></h3></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th class="txt-uh-86"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('account_name'); ?></th>
                            <th><?php echo lang('balance'); ?></th>
                        </tr>
                        <?php
                        $balance_total = 0;
                        if ($accounts && !empty($accounts)) {
                            foreach ($accounts as $key => $value) {
                                $balance=0;
                                $balance =$value->current_balance-$value->total_purchase-$value->total_supplier_due_payment+$value->total_deposit-$value->total_withdraw-$value->total_expense;
                                $key++;
                                $balance_total+=$balance;

                                ?>
                                <tr>
                                    <th class="txt-uh-88"><?php echo escape_output($key) ?></th>
                                    <th><?php echo escape_output($value->name) ?></th>
                                    <th><?php echo escape_output($balance) ?></th>
                                </tr>
                            <?php  }  } ?>
                        <tr>
                            <th class="c_center"></th>
                            <th class="c_txt_right"><?php echo lang('total'); ?> </th>
                            <th><?php echo number_format($balance_total, 2) ?></th>
                        </tr>

                        <tr>
                            <td class="txt-uh-85"><h3 class="txt-uh-87"><?php echo lang('SupplierPayables'); ?></h3></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th class="txt-uh-86"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('supplier'); ?></th>
                            <th><?php echo lang('amount'); ?></th>
                        </tr>
                        <?php
                        $balance_total = 0;
                        if ($supplier_payable && !empty($supplier_payable)) {
                            foreach ($supplier_payable as $key => $value) {
                                $key++;
                                if($value->due != '0.00' && $value->due != ''){
                                    ?>
                                    <tr>
                                        <th class="txt-uh-88"><?php echo escape_output($key) ?></th>
                                        <th><?php echo escape_output($value->name) ?> (<?php echo escape_output($value->phone); ?>)</th>
                                        <th><?php $current_due = $value->due - getSupplierDuePayment($value->supplier_id);
                                            $balance_total+=$current_due;
                                        ?>
                                            <span><?php echo escape_output($current_due) ?></span>
                                        </th>
                                    </tr>

                                <?php } }  } ?>
                        <tr>
                            <th class="c_center"></th>
                            <th class="c_txt_right"><?php echo lang('total'); ?> </th>
                            <th><?php echo number_format($balance_total, 2) ?></th>
                        </tr>
                        </tbody>
                        <tfoot>

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