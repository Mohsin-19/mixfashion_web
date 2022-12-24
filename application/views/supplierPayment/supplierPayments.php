<?php
if ($this->session->flashdata('exception')) {

    echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo escape_output($this->session->flashdata('exception'));
    echo '</p></div></section>';
}
?>

<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <h2 class="top-left-header"><?php echo lang('supplier_due_payments'); ?> </h2>
        </div>
        <div class="col-md-offset-3 col-md-3">
            <a href="<?php echo base_url() ?>SupplierPayment/addSupplierPayment"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_supplier_due_payment'); ?></button></a>
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
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('supplier_due_payments'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="width_1_p"><?php echo lang('sn'); ?></th>
                                <th class="width_9_p"><?php echo lang('date'); ?></th>
                                <th class="width_18_p"><?php echo lang('supplier'); ?></th>
                                <th class="width_14_p"><?php echo lang('amount'); ?></th>
                                <th class="width_14_p"><?php echo lang('payment_methods'); ?></th>
                                <th class="width_28_p"><?php echo lang('note'); ?></th>
                                <th class="width_19_p"><?php echo lang('added_by'); ?></th>
                                <th class="width_6_p not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($supplierPayments && !empty($supplierPayments)) {
                                $i = count($supplierPayments);
                            }
                            foreach ($supplierPayments as $spns) {
                                ?>
                                <tr>
                                    <td><?php echo escape_output($i--); ?></td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($spns->date)); ?></td>
                                    <td><?php echo getSupplierNameById($spns->supplier_id); ?></td>
                                    <td> <?php echo escape_output($this->session->userdata('currency')); ?> <?php echo escape_output($spns->amount); ?></td>
                                     <td><?php echo getPaymentName($spns->payment_method_id); ?></td>
                                    <td><?php if ($spns->note != NULL) echo escape_output($spns->note); ?></td>
                                    <td><?php echo userName($spns->user_id); ?></td>
                                    <td class="c_center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                <li><a class="delete" href="<?php echo base_url() ?>SupplierPayment/deleteSupplierPayment/<?php echo escape_output($this->custom->encrypt_decrypt($spns->id, 'encrypt')); ?>" ><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('supplier'); ?></th>
                                <th><?php echo lang('amount'); ?></th>
                                <th ><?php echo lang('payment_methods'); ?></th>
                                <th><?php echo lang('note'); ?></th>
                                <th><?php echo lang('added_by'); ?></th>
                                <th class="not-export-col"><?php echo lang('actions'); ?></th>
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
