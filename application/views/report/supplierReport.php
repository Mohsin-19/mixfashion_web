<section class="content-header">
    <h3  class="txt-uh-83"><?php echo lang('supplier_ledger'); ?></h3>
    <hr class="txt-uh-83">
    <div class="row">
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/supplierReport', $arrayName = array('id' => 'supplierReport')) ?>
            <div class="form-group">
                <input tabindex="1" autocomplete="off" type="text" id="" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
            </div>
        </div>
        <div class="col-md-2">

            <div class="form-group">
                <input tabindex="2" autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
            </div>
        </div>
        <div class="col-md-3">

            <div class="form-group">
                <select tabindex="2" class="form-control select2 width_100_p"  id="supplier_id" name="supplier_id">
                    <option value=""><?php echo lang('suppliers'); ?></option>
                    <?php
                    foreach ($suppliers as $value) {
                        ?>
                        <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('supplier_id', $value->id); ?>><?php echo escape_output($value->name) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="alert alert-error error-msg supplier_id_err_msg_contnr txt-uh-21">
                <p id="supplier_id_err_msg"></p>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
            </div>
        </div>
        <div class="hidden-lg">
            <div class="clearfix"></div>
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
                    <h3 class="c_center"><?php echo lang('supplier_ledger'); ?></h3>
                    <h4 class="txt-uh-83"><?php
                    if (isset($supplier_id) && $supplier_id):
                        echo "<span>" . getSupplierNameById($supplier_id) . "</span>";
                    endif;
                    ?></h4>
                    <h4 class="c_center"><?php echo isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?php echo isset($start_date) && $start_date && !$end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?php echo isset($end_date) && $end_date && !$start_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
                    <br>

                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('supplier_ledger'); ?>" data-id_name="datatable">

                    <table id="datatable"  class="table table-bordered table-striped">
                        <thead>
                        <tr class="no-print display_none">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="txt-uh-32">
                            <td class="txt-uh-85 width_100_p"><h3 class="txt-uh-87"><?php echo lang('purchase'); ?></h3></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th class="width_2_p c_center"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('date'); ?></th>
                            <th><?php echo lang('reference'); ?></th>
                            <th><?php echo lang('g_total'); ?></th>
                            <th><?php echo lang('paid'); ?></th>
                            <th><?php echo lang('due'); ?></th>
                        </tr>
                            <?php
                            $pGrandTotal = 0;
                            $pPaid = 0;
                            $pDue = 0;
                            if (isset($supplierReport)):
                                foreach ($supplierReport as $key => $value) {
                                    $pGrandTotal+=$value->grand_total;
                                    $pPaid+=$value->paid;
                                    $pDue+=$value->due;
                                    $key++;
                                    ?>
                                    <tr>
                                        <td class="c_center"><?php echo escape_output($key); ?></td>
                                        <td><?php echo date($this->session->userdata('date_format'), strtotime($value->date)) ?></td>
                                        <td><?php echo escape_output($value->reference_no) ?></td>
                                        <td><?php echo escape_output($value->grand_total) ?></td>
                                        <td><?php echo escape_output($value->paid) ?></td>
                                        <td><?php echo escape_output($value->due) ?></td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>

                        <tr>
                            <th class="width_2_p c_center">
                            <th></th>
                            <th class="c_txt_right"><?php echo lang('total'); ?></th>
                            <th><?php echo number_format($pGrandTotal, 2) ?></th>
                            <th><?php echo number_format($pPaid, 2) ?></th>
                            <th><?php echo number_format($pDue, 2) ?></th>
                        </tr>


                        <tr>
                            <td class="txt-uh-85 width_100_p"><h3 class="txt-uh-87"><?php echo lang('due_payment'); ?></h3></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th class="width_2_p c_center"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('date'); ?></th>
                            <th><?php echo lang('payment_amount'); ?></th>
                            <th class="width_45_p"><?php echo lang('note'); ?></th>
                            <td></td>
                            <td></td>
                        </tr>

                        <?php
                        $totalAmount = 0;

                        if (isset($supplierDuePaymentReport)):
                            foreach ($supplierDuePaymentReport as $key => $value) {
                                $totalAmount+=$value->amount;
                                $key++;
                                ?>
                                <tr>
                                    <td class="c_center"><?php echo escape_output($key); ?></td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($value->date)) ?></td>
                                    <td><?php echo escape_output($value->amount) ?></td>
                                    <td><?php echo escape_output($value->note) ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                        endif;
                        ?>

                        <tr>
                            <th class="width_2_p c_center">
                            <th class="c_txt_right"><?php echo lang('total'); ?></th>
                            <th><?php echo number_format($totalAmount, 2) ?></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tbody>
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