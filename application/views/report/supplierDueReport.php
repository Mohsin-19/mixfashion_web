<section class="content-header">
    <h3  class="txt-uh-83"><?php echo lang('supplier_due_report'); ?></h3>
    <hr class="txt-uh-83">
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <h3 class="c_center"><?php echo lang('supplier_due_report'); ?></h3>
                    <br>
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('supplier_due_report'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="width_2_p c_center"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('supplier'); ?></th>
                                <th><?php echo lang('payable_due'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $pGrandTotal = 0;
                            $i = 1;
                            if (isset($supplierDueReport) && $supplierDueReport):
                                foreach ($supplierDueReport as $key => $value) {
                                    if (($value->previous_due + $value->totalDue) > 0):
                                        $pGrandTotal+=$value->previous_due + $value->totalDue - $value->due_paid;
                                        ?>
                                        <tr>
                                            <th class="c_center"><?php echo escape_output($i); ?></td>
                                            <td><?php echo escape_output($value->name) ?></td>
                                            <td><?php echo number_format($value->previous_due + $value->totalDue - $value->due_paid,2) ?></td>
                                        </tr>
                                        <?php
                                    endif;
                                    $i++;
                                }
                            endif;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="width_2_p c_center">
                                <th class="c_txt_right"><?php echo lang('total'); ?></th>
                                <th><?php echo number_format($pGrandTotal, 2) ?></th>
                            </tr>

                        </tfoot>
                    </table>
                    <br>
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