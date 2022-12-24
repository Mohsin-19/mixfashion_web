<section class="content-header">
    <h3 class="c_center"><?php echo lang('vat'); ?> <?php echo lang('report'); ?></h3>
    <hr class="txt-uh-83">
    <div class="row"> 
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/taxReport') ?>
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
                    <h3 class="c_center"><?php echo lang('vat'); ?> <?php echo lang('report'); ?></h3>
                    <h4 class="c_center"><?php echo isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?php echo isset($start_date) && $start_date && !$end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?php echo isset($end_date) && $end_date && !$start_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
                    <br>
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('supplier_ledger'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="width_2_p c_center"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('OrderNumber'); ?></th>
                                <th><?php echo lang('sale'); ?> <?php echo lang('amount'); ?></th>
                                <th><?php echo lang('vat'); ?> <?php echo lang('amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $vatTotal = 0;
                            $i= 1;
                            if (isset($taxReport)):
                                foreach ($taxReport as $key => $value) {
                                    $vatTotal+=$value->total_vat;
                                    ?>
                                    <tr>
                                        <th class="c_center"><?php echo escape_output($i); ?></td>
                                        <td><?php echo date($this->session->userdata('date_format'), strtotime($value->sale_date)) ?></td>
                                        <td><?php echo escape_output($value->order_number) ?></td>
                                        <td><?php echo escape_output($value->total_payable) ?></td>
                                        <td><?php echo number_format($value->total_vat,2) ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            endif;
                            ?>
                            <tr>
                                <th class="width_2_p c_center">
                                <th></th>
                                <th></th>
                                <th class="c_txt_right"><?php echo lang('total'); ?></th>
                                <th><?php echo number_format($vatTotal, 2) ?></th>
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