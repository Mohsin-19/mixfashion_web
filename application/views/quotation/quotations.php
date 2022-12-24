<?php
if ($this->session->flashdata('exception')) {

    echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    //This variable could not be escaped because need html code here
    echo $this->session->flashdata('exception');
    echo '</p></div></section>';
}
?>
<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <h2 class="top-left-header"><?php echo lang('quotations'); ?> </h2>
        </div>
        <div class="col-md-offset-4 col-md-2">
            <a href="<?php echo base_url() ?>Quotation/addEditQuotation"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_quotation'); ?></button></a>
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
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('quotations'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-responsive table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="width_1_p"><?php echo lang('sn'); ?></th>
                               <th class="width_11_p"><?php echo lang('ref_no'); ?></th>
                               <th class="width_8_p"><?php echo lang('date'); ?></th>
                               <th class="width_18_p"><?php echo lang('customer'); ?></th>
                               <th class="width_9_p"><?php echo lang('g_total'); ?></th>
                               <th class="width_12_p"><?php echo lang('added_by'); ?></th>
                                <th class="width_5_p c_center not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($quotations && !empty($quotations)) {
                                $i = count($quotations);
                            }
                            foreach ($quotations as $prchs) {
                                ?>                       
                                <tr> 
                                    <td><?php echo escape_output($i--); ?></td>
                                    <td><?php echo escape_output($prchs->reference_no); ?></td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($prchs->date)); ?></td> 
                                    <td><?php echo getCustomerName($prchs->customer_id); ?></td>
                                    <td><?php echo escape_output($this->session->userdata('currency') . " ") . $prchs->grand_total ?></td>
                                    <td><?php echo userName($prchs->user_id); ?></td>  
                                    <td class="c_center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li><a href="<?php echo base_url() ?>Quotation/addEditQuotation/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>/copy" ><i class="fa fa-files-o"></i><?php echo lang('copy'); ?></a></li>
                                                <li><a href="<?php echo base_url() ?>Quotation/quotationDetails/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>" ><i class="fa fa-eye tiny-icon"></i><?php echo lang('view_details'); ?></a></li>
                                                <li><a target="_blank" href="<?php echo base_url() ?>Quotation/quotationDetails/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>/print" ><i class="fa fa-print"></i><?php echo lang('print'); ?></a></li>
                                                <li><a href="<?php echo base_url() ?>Quotation/addEditQuotation/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>" ><i class="fa fa-edit"></i><?php echo lang('edit'); ?></a></li>
                                                <li><a class="delete" href="<?php echo base_url() ?>Quotation/deleteQuotation/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>" ><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a></li>
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
                                <th><?php echo lang('ref_no'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('customer'); ?></th>
                                <th><?php echo lang('g_total'); ?></th>  

                                <th><?php echo lang('added_by'); ?></th>  
                                <th class="c_center not-export-col"><?php echo lang('actions'); ?></th>
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