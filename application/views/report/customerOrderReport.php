<section class="content-header">
    <h3  class="txt-uh-83"><?php echo lang('CustomerOrderReport'); ?></h3>
    <hr class="txt-uh-83">
    <div class="row">
        <?php echo form_open(base_url() . 'Report/customerOrderReport', $arrayName = array('id' => 'customerOrderReport')) ?>
        <div class="col-md-2">
            <select class="form-control select2 width_100_p" name="customer_id">
                <option value="">Customer</option>
                <?php
                foreach ($customers as $value):
                    ?>
                    <option <?php echo set_select('customer_id', $value->id); ?> value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->name); ?>(<?php echo escape_output($value->phone); ?>)</option>
                    <?php
                endforeach;
                ?>
            </select>
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
                    <h3 class="c_center"><?php echo lang('CustomerOrderReport'); ?></h3>
                    <?php
                    if (isset($customer_id) && $customer_id):?>
                        <h4 class="c_center"><?php echo lang('customer'); ?>: <?php echo getCustomerName($customer_id)?></h4>
                        <?php
                    endif;
                    ?>
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('CustomerOrderReport'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col"><?php echo lang('sn'); ?></th>
                            <th scope="col"><?php echo lang('OrderNumber'); ?></th>
                            <th scope="col"><?php echo lang('date'); ?></th>
                            <th scope="col"><?php echo lang('Area'); ?></th>
                            <th scope="col"><?php echo lang('customer'); ?></th>
                            <th scope="col"><?php echo lang('TotalItem'); ?></th>
                            <th scope="col"><?php echo lang('total'); ?></th>
                            <th scope="col"><?php echo lang('Tax'); ?></th>
                            <th scope="col"><?php echo lang('DeliveryCharge'); ?></th>
                            <th scope="col"><?php echo lang('status'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_item=0;
                        $total_amount=0;
                        $total_tax=0;
                        $total_dl_charge=0;
                        if (isset($orderReport)):
                            foreach ($orderReport as $key => $value) {
                                $total_item+=$value->total_items;
                                $total_amount+=$value->total_amount;
                                $total_tax+=$value->total_tax;
                                $total_dl_charge+=$value->delivery_charge;
                                $key++;
                                ?>
                                <tr>
                                    <th class="txt-uh-41" scope="row"><?php echo escape_output($key)?></th>
                                    <td class="txt-uh-41"><?php echo escape_output($value->order_number); ?></td>
                                    <td class="txt-uh-41"><?php echo date("d/m/Y",strtotime($value->delivery_date))?></td>
                                    <td class="txt-uh-41"><?php echo escape_output($value->area); ?></td>
                                    <td class="txt-uh-41"><?php echo escape_output($value->customer_name); ?>(<?php echo escape_output($value->customer_phone); ?>)</td>
                                    <td class="txt-uh-41"><?php echo escape_output($value->total_items); ?></td>
                                    <td class="txt-uh-41"><?php echo escape_output($value->total_amount); ?></td>
                                    <td class="txt-uh-41"><?php echo escape_output($value->total_tax); ?></td>
                                    <td class="txt-uh-41"><?php echo escape_output($value->delivery_charge); ?></td>
                                    <td class="txt-uh-41 set_text_status<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->status); ?></td>
                                </tr>
                                <?php
                            }
                        endif;
                        ?>
                        </tbody>
                        <tr>
                            <th class="width_2_p c_center">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="c_txt_right"><?php echo lang('total'); ?></th>
                            <th><?php echo escape_output($total_item) ?></th>
                            <th><?php echo number_format($total_amount,2); ?></th>
                            <th><?php echo number_format($total_tax,2); ?></th>
                            <th><?php echo number_format($total_dl_charge,2); ?></th>
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