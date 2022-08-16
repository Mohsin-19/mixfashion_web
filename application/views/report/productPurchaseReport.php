<section class="content-header">
    <h3  class="txt-uh-83"><?php echo lang('productPurchaseReport'); ?></h3>
    <hr class="txt-uh-83">
    <div class="row">
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/productPurchaseReport', $arrayName = array('id' => 'productPurchaseReport')) ?>
            <div class="form-group">
                <input tabindex="1" autocomplete="off" type="text" id="" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('StartDate'); ?>" value="<?php echo set_value('startDate'); ?>">
            </div>
        </div>
        <div class="col-md-2">

            <div class="form-group">
                <input tabindex="2" autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('EndDate'); ?>" value="<?php echo set_value('endDate'); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <select tabindex="2" class="form-control select2 width_100_p" id="products_id" name="products_id">
                    <option value=""><?php echo lang('product'); ?></option>
                    <?php
                    foreach ($products as $value) {
                        ?>
                        <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('products_id', $value->id); ?>><?php echo substr(ucwords(strtolower($value->name)), 0, 50) . " <span>(" . $value->code . ")</span>"; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="alert alert-error error-msg products_id_err_msg_contnr txt-uh-21">
                <p id="products_id_err_msg"></p>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <select tabindex="2" class="form-control select2 width_100_p" id="supplier_id" name="supplier_id">
                    <option value=""><?php echo lang('supplier'); ?></option>
                    <?php
                    foreach ($suppliers as $value) {
                        ?>
                        <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('supplier_id', $value->id); ?>><?php echo substr(ucwords(strtolower($value->name)), 0, 50); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="alert alert-error error-msg supplier_id_err_msg_contnr txt-uh-21">
                <p id="supplier_id_err_msg"></p>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left">Submit</button>
            </div>
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
                    <h3 class="c_center"><?php echo lang('productPurchaseReport'); ?></h3>
                    <h4 class="txt-uh-83"><?php
                    if (isset($products_id) && $products_id):
                        echo lang('product').": " . (substr(ucwords(strtolower(getItemNameById($products_id))), 0, 50)) . getItemCodeById($products_id) . "</span>";
                    endif;
                    ?></h4>
                    <h4 class="c_center"><?php echo isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?php echo isset($start_date) && $start_date && !$end_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?php echo isset($end_date) && $end_date && !$start_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
                    <br><input type="hidden" class="datatable_name" data-title="<?php echo lang('supplier_ledger'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="width_2_p c_center"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('supplier'); ?></th>
                                <th><?php echo lang('product'); ?></th>
                                <th><?php echo lang('quantity_amount'); ?></th>
                                <th><?php echo lang('unit_price'); ?></th>
                                <th><?php echo lang('total'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pGrandTotal = 0;
                            if (isset($productPurchaseReport)):
                                foreach ($productPurchaseReport as $key => $value) {
                                    $key++;
                                    ?>
                                    <tr>
                                        <td class="c_center"><?php echo escape_output($key); ?></td>
                                        <td><?php echo date($this->session->userdata('date_format'), strtotime($value->date)) ?></td>
                                        <td><?php echo getName('tbl_suppliers',$value->supplier_id) ?></td>
                                        <td><?php echo escape_output($value->name) . "(" . $value->code . ")" ?></td>
                                        <td><?php echo escape_output($value->totalQuantity_amount) ?></td>
                                        <td><?php echo escape_output($value->unit_price) ?></td>
                                        <td><?php echo escape_output($value->unit_price)*$value->totalQuantity_amount ?></td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section><!-- DataTables -->
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