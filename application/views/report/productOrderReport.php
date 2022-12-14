<section class="content-header">
    <h3  class="txt-uh-83"><?php echo lang('ProductOrderReport'); ?></h3>
    <hr class="txt-uh-83">
    <div class="row">
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/productOrderReport', $arrayName = array('id' => 'productOrderReport')) ?>
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
            <select class="form-control select2 width_100_p" name="status">
                <option value=""><?php echo lang('status'); ?></option>
                <option <?php echo set_select('status', "New"); ?> value="New"><?php echo lang('New'); ?></option>
                <option  <?php echo set_select('status', "Cancel"); ?>  value="Cancel"><?php echo lang('cancel'); ?></option>
                <option  <?php echo set_select('status', "In Progress"); ?>  value="In Progress"><?php echo lang('InProgress'); ?></option>
                <option  <?php echo set_select('status', "Delivered"); ?>  value="Delivered"><?php echo lang('Delivered'); ?></option>
            </select>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <select tabindex="2" class="form-control select2 width_100_p" id="deliver_person_id" name="deliver_person_id">
                    <option value=""><?php echo lang('DeliveryPerson'); ?></option>
                    <?php
                    foreach ($delivery_persons as $value) {
                        ?>
                        <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('deliver_person_id', $value->id); ?>><?php echo escape_output($value->full_name); ?>(<?php echo escape_output($value->phone); ?>)</option>
                    <?php } ?>
                </select>
            </div>
            <div class="alert alert-error error-msg customer_id_err_msg_contnr txt-uh-21">
                <p id="customer_id_err_msg"></p>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
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
                    <h3 class="c_center"><?php echo lang('ProductOrderReport'); ?></h3>
                    <h4 class="txt-uh-83"><?php
                        if (isset($product_id) && $product_id):
                            echo lang('product').": " . (substr(ucwords(strtolower(getItemNameById($product_id))), 0, 50)) ." (". getItemCodeById($product_id) . ")</span>";
                        endif;
                        ?></h4>
                    <h4 class="c_center"><?php echo isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?php echo isset($start_date) && $start_date && !$end_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?php echo isset($end_date) && $end_date && !$start_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>

                    <?php
                    if (isset($deliver_person_id) && $deliver_person_id):?>
                        <h4 class="c_center"><?php echo lang('DeliveryPerson'); ?>: <?php echo userName($deliver_person_id)?></h4>
                        <?php
                    endif;
                    ?>
                    <?php
                    if (isset($status) && $status):?>
                        <h4 class="c_center"><?php echo lang('status'); ?>: <?php echo escape_output($status)?></h4>
                        <?php
                    endif;
                    ?>

                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('ProductOrderReport'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="width_2_p c_center"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('product'); ?></th>
                            <th><?php echo lang('quantity_amount'); ?></th>
                            <th><?php echo lang('OrderNumber'); ?></th>
                            <th><?php echo lang('date'); ?></th>
                            <th><?php echo lang('customer'); ?></th>
                            <th><?php echo lang('DeliveryPerson'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $pGrandTotal = 0;
                        if (isset($productOrderReport)):
                            foreach ($productOrderReport as $key => $value) {
                                $pGrandTotal+=$value->totalQuantity_amount;
                                $key++;
                                ?>
                                <tr>
                                    <td class="c_center"><?php echo escape_output($key); ?></td>
                                    <td><?php echo escape_output($value->name . "(" . $value->code . ")") ?></td>
                                    <td><?php echo escape_output($value->totalQuantity_amount) ?></td>
                                    <td><?php echo escape_output($value->order_number) ?></td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($value->delivery_date)) ?></td>
                                    <td><?php echo escape_output($value->customer_name) ?>(<?php echo escape_output($value->customer_phone) ?>)</td>
                                    <td><?php echo escape_output($value->delivery_person_name) ?></td>
                                </tr>
                                <?php
                            }
                        endif;
                        ?>
                        </tbody>
                        <tr>
                            <th class="width_2_p c_center">
                            <th class="c_txt_right"><?php echo lang('total'); ?></th>
                            <th><?php echo escape_output($pGrandTotal) ?></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
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