<section class="content-header">
    <h3  class="txt-uh-83"><?php echo lang('expense_report'); ?></h3>
    <hr class="txt-uh-83">
    <div class="row">
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/expenseReport') ?>
            <div class="form-group">
                <input tabindex="1" autocomplete="off" type="text" id="" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
            </div>
        </div>
        <div class="col-md-2">

            <div class="form-group">
                <input tabindex="2" autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
            </div>
        </div>
        <div class="col-md-2">

            <div class="form-group">
                <select tabindex="2" class="form-control select2 width_100_p" id="expense_product_id" name="expense_product_id">
                    <option value=""><?php echo lang('expense_product'); ?></option>
                    <?php
                    foreach ($expense_products as $value) {
                        ?>
                        <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('expense_product_id', $value->id); ?>><?php echo escape_output($value->name) ?></option>
                    <?php } ?>
                </select>
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
                    <h3 class="c_center"><?php echo lang('expense_report'); ?></h3>
                    <h4 class="c_center"><?php echo isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?php echo isset($start_date) && $start_date && !$end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?php echo isset($end_date) && $end_date && !$start_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
                    <h4 class="txt-uh-83"><?php
                    if (isset($expense_product_id) && $expense_product_id):
                        echo lang('expense_product').": <span class='txt-uh-84'>" . userName($expense_product_id) . "</span>";
                    else:
                        echo lang('expense_product').": ".lang('all');
                    endif;
                    ?></h4>
                    <br><input type="hidden" class="datatable_name" data-title="<?php echo lang('expense_report'); ?>" data-id_name="datatable">
                    <table id="datatable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="width_1_p"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('amount'); ?></th>
                                <th><?php echo lang('category'); ?></th>
                                <th><?php echo lang('responsible_person'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            $countTotal = 0;
                            if (isset($expenseReport)):
                                foreach ($expenseReport as $key => $value) {
                                    $grandTotal+=$value->amount;
                                    $key++;
                                    ?>
                                    <tr>
                                        <td class="c_center"><?php echo escape_output($key); ?></td>
                                        <td><?php echo date($this->session->userdata('date_format'), strtotime($value->date)) ?></td>
                                        <td><?php echo escape_output($value->amount) ?></td>
                                        <td><?php echo escape_output($value->categoryName) ?></td>
                                        <td><?php echo escape_output($value->EmployeedName); ?></td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="width_2_p c_center">
                                <th class="c_txt_right"><?php echo lang('total'); ?> </th>
                                <th><?php echo number_format($grandTotal, 2) ?></th>
                                <th></th>
                                <th></th>
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