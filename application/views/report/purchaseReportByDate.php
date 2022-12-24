<section class="content-header">
    <h3 class="c_center"><?php echo lang('purchase_report'); ?></h3>
    <hr class="txt-uh-83">
    <div class="row"> 
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/purchaseReportByDate') ?>
            <div class="form-group"> 
                <input tabindex="1" autocomplete="off" type="text" id="" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
            </div> 
        </div>
        <div class="col-md-2">

            <div class="form-group">
                <input tabindex="2" autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
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
                    <h3 class="c_center"><?php echo lang('purchase_report'); ?></h3>
                    <h4 class="c_center"><?php echo isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?php echo isset($start_date) && $start_date && !$end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?php echo isset($end_date) && $end_date && !$start_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
                    <br><input type="hidden" class="datatable_name" data-title="<?php echo lang('supplier_ledger'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="width_2_p c_center"><?php echo lang('sn'); ?></th>
                                <th class="width_10_p"><?php echo lang('ref_no'); ?></th>
                                <th class="width_5_p"><?php echo lang('date'); ?></th>
                                <th class="width_10_p"><?php echo lang('supplier'); ?></th>
                                <th class="width_12_p"><?php echo lang('grand_total'); ?></th>
                                <th class="width_7_p"><?php echo lang('paid'); ?></th>
                                <th class="width_7_p"><?php echo lang('due'); ?></th>
                                <th class="width_32_p"><?php echo lang('products'); ?></th>
                                <th class="width_15_p"><?php echo lang('purchased_by'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sum_of_grand_total = 0;
                            $sum_of_paid = 0;
                            $sum_of_due = 0;

                            if (isset($purchaseReportByDate)):
                                foreach ($purchaseReportByDate as $key => $value) { 
                                    $sum_of_grand_total += $value->grand_total;
                                    $sum_of_paid += $value->paid;
                                    $sum_of_due += $value->due;
                                    $key++;
                                    ?>
                                    <tr>
                                        <td class="c_center"><?php echo escape_output($key); ?></td>
                                        <td><?php echo escape_output($value->reference_no); ?></td>
                                        <td><?php echo date($this->session->userdata('date_format'), strtotime($value->date)) ?></td>
                                        <td><?php echo getSupplierNameById($value->supplier_id); ?></td> 
                                        <td><?php echo escape_output($value->grand_total) ?></td>
                                        <td><?php echo escape_output($value->paid) ?></td>
                                        <td><?php echo escape_output($value->due) ?></td>
                                        <td><?php print_r(getPurchaseIngredients($value->id)) ?></td>  
                                        <td><?php echo userName($value->user_id) ?></td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>
                          <tr> 
                                <td>&nbsp;</td> 
                                <td>&nbsp;</td> 
                                <td>&nbsp;</td>  
                                <td  class="c_txt_right"><?php echo lang('total'); ?> </td>
                                <td><?php echo number_format($sum_of_grand_total, 2) ?></td>
                                <td><?php echo number_format($sum_of_paid, 2) ?></td>
                                <td><?php echo number_format($sum_of_due, 2) ?></td>
                                <td>&nbsp;</td>  
                                <td>&nbsp;</td>  
                            </tr> 
                        </tbody>
                        <tfoot> 
                            <tr>
                                <th class="width_2_p c_center"><?php echo lang('sn'); ?></th>
                                <th class="width_10_p"><?php echo lang('ref_no'); ?></th>
                                <th class="width_5_p"><?php echo lang('date'); ?></th>
                                <th class="width_10_p"><?php echo lang('supplier'); ?></th>
                                <th class="width_12_p"><?php echo lang('grand_total'); ?></th>
                                <th class="width_7_p"><?php echo lang('paid'); ?></th>
                                <th class="width_7_p"><?php echo lang('due'); ?></th>
                                <th class="width_32_p"><?php echo lang('products'); ?></th>
                                <th class="width_15_p"><?php echo lang('purchased_by'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div> 
        </div> 
    </div> 
</section>   <!-- DataTables -->
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