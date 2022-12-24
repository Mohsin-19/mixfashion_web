<?php
if ($this->session->flashdata('exception')) {

    echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo escape_output($this->session->flashdata('exception'));
    echo '</p></div></section>';
}
$getSiteSetting =  getSiteSetting();
$currency = "$";
if(isset($getSiteSetting->currency) && $getSiteSetting->currency){
    $currency = $getSiteSetting->currency;
}
?>
<section class="content-header">
    <div class="row">
        <div class="col-md-1">
            <h2 class="top-left-header"><?php echo lang('orders'); ?> </h2>
        </div>
        <?php echo form_open(base_url() . 'orderManagement/printAll') ?>
        <div class="col-md-2">
            <?php
            $old_date = set_value('date');
            ?>
            <input type="text" name="date" id="" class="form-control customDatepicker" value="<?php echo isset($old_date) && $old_date?$old_date:date("Y-m-d",strtotime('today'))?>">
        </div>
        <div class="col-md-2">
            <?php
            $old_date = set_value('date');
            ?>
            <input type="text" name="phone" id="" placeholder="Customer Phone" class="form-control" value="<?php echo set_value('phone')?>">
        </div>
        <div class="col-md-2">
            <select class="form-control select2 width_100_p" name="area">
                <option value=""><?php echo lang('Area'); ?></option>
                <?php
                foreach ($arees as $value):
                    ?>
                    <option <?php echo set_select('area', $value->name); ?> value="<?php echo escape_output($value->name); ?>"><?php echo escape_output($value->name); ?></option>
                    <?php
                endforeach;
                ?>
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-control select2 width_100_p" name="status">
                <option value="">Status</option>
                <option <?php echo set_select('status', "New"); ?> value="New"><?php echo lang('New'); ?></option>
                <option  <?php echo set_select('status', "Cancel"); ?>  value="Cancel"><?php echo lang('cancel'); ?></option>
                <option  <?php echo set_select('status', "In Progress"); ?>  value="In Progress"><?php echo lang('InProgress'); ?></option>
                <option  <?php echo set_select('status', "Delivered"); ?>  value="Delivered"><?php echo lang('Delivered'); ?></option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
        </div>
        <?php echo form_close(); ?>

        <div class="col-md-2">
            <a href="<?php echo base_url()?>orderManagement/productPurchase" class="btn btn-block btn-primary pull-left"><?php echo lang('ProducttoPurchase'); ?></a>
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
                    <a href="<?php echo base_url() ?>orderManagement/orders"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                    <p class="txt-uh-60">&nbsp;</p>
                    <div class="clearfix"></div>
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('orders'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col"><?php echo lang('sn'); ?></th>
                            <th scope="col"><?php echo lang('OrderNumber'); ?></th>
                            <th scope="col"><?php echo lang('OrderArea'); ?></th>
                            <th scope="col"><?php echo lang('OrderDate'); ?></th>
                            <th scope="col"><?php echo lang('DeliveryDate'); ?></th>
                            <th scope="col"><?php echo lang('DeliveryTime'); ?></th>
                            <th scope="col"><?php echo lang('customer_name'); ?></th>
                            <th scope="col"><?php echo lang('phone'); ?></th>
                            <th scope="col"  class="width_1_p"><?php echo lang('payment_method'); ?></th>
                            <th scope="col"  class="width_1_p"><?php echo lang('status'); ?></th>
                            <th scope="col"><?php echo lang('note'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($orders && !empty($orders)) {
                            $i = count($orders);
                        }
                        foreach ($orders as $value):
                            $getCustomerInfo = getCustomer($value->customer_id);
                            ?>
                            <tr>
                                <td class="txt-uh-41" scope="row"><?php echo escape_output($i--)?></td>
                                <td class="txt-uh-41"><?php echo escape_output($value->order_number); ?></td>
                                <td class="txt-uh-41"><?php echo escape_output($value->area); ?></td>
                                <td class="txt-uh-41"><?php echo date("d/m/Y",strtotime($value->order_date_time))?></td>
                                <td class="txt-uh-41"><?php echo date("d/m/Y",strtotime($value->delivery_date))?></td>
                                <td class="txt-uh-41"><?php echo escape_output($value->delivery_time); ?></td>
                                <td class="txt-uh-41"><?php echo isset($getCustomerInfo->name) && $getCustomerInfo->name?$getCustomerInfo->name:''?></td>
                                <td class="txt-uh-41"><?php echo isset($getCustomerInfo->phone) && $getCustomerInfo->phone?$getCustomerInfo->phone:''?></td>
                                <td class="txt-uh-41" class=""><?php echo getPaymentName($value->payment_id)?></td>
                                <td class="txt-uh-41" class="set_text_status<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->status); ?></td>
                                <td class="txt-uh-41" class="set_text_note<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->note); ?></td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th scope="col"><?php echo lang('sn'); ?></th>
                            <th scope="col"><?php echo lang('OrderNumber'); ?></th>
                            <th scope="col"><?php echo lang('OrderArea'); ?></th>
                            <th scope="col"><?php echo lang('OrderDate'); ?></th>
                            <th scope="col"><?php echo lang('DeliveryDate'); ?></th>
                            <th scope="col"><?php echo lang('DeliveryTime'); ?></th>
                            <th scope="col"><?php echo lang('customer_name'); ?></th>
                            <th scope="col"><?php echo lang('phone'); ?></th>
                            <th scope="col"><?php echo lang('payment_method'); ?></th>
                            <th scope="col"><?php echo lang('status'); ?></th>
                            <th scope="col"><?php echo lang('note'); ?></th>
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