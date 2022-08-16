<section class="content-header">
    <div class="row">
        <div class="col-md-3">
            <h2 class="top-left-header"><?php echo lang('ProducttoPurchase'); ?> </h2>
        </div>
        <?php echo form_open(base_url() . 'orderManagement/productPurchase') ?>
        <div class="col-md-2">
            <?php
            $old_date = set_value('date');
            ?>
            <input type="text" name="date" id="" readonly class="form-control customDatepickerCustom" value="<?php echo isset($old_date) && $old_date?$old_date:date("Y-m-d",strtotime('today'))?>">
        </div>
        <div class="col-md-1">
            <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('ProducttoPurchase'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col"><?php echo lang('sn'); ?></th>
                            <th scope="col"><?php echo lang('ItemName'); ?></th>
                            <th scope="col" class="c_center"><?php echo lang('order'); ?> <?php echo lang('amount'); ?></th>
                            <th scope="col" class="c_center"><?php echo lang('Stock'); ?> <?php echo lang('amount'); ?></th>
                            <th scope="col" class="c_center"><?php echo lang('Stock'); ?> - <?php echo lang('order'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($items && !empty($items)) {
                            $i = count($items);
                            foreach ($items as $value):
                                $current_stock = getCurrentStockOnly($value->product_id);
                                ?>
                                <tr>
                                    <th class="txt-uh-41" scope="row"><?php echo escape_output($i--)?></th>
                                    <td class="txt-uh-41"><?php echo escape_output($value->name); ?></td>
                                    <td class="txt-uh-41 c_center"><?php echo escape_output($value->totalQuantity_amount); ?></td>
                                    <td class="txt-uh-41 c_center"><?php echo escape_output($current_stock)?></td>
                                    <td class="txt-uh-41 c_center"><?php echo escape_output($current_stock - $value->totalQuantity_amount)?></td>
                                </tr>
                                <?php
                            endforeach;
                        }

                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
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