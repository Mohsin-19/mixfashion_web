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
            <h2 class="top-left-header">
                <?php
                $role = $this->session->userdata('role');
                echo ($role =="Admin"?lang('DeliveryPersonCash'):lang('MyCash'));
                ?>
                </h2>
        </div>
        <div class="col-md-offset-4 col-md-2">
            <?php
            $role = $this->session->userdata('role');
            $delivery_person_id = '';
            if($role=="Delivery Person"):
            else:
            ?>
            <a href="<?php echo base_url() ?>deliveryPerson/addDeliveryPersonItems"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('AddDeliveryPersonCash'); ?></button></a>
            <?php
            endif;
            ?>
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
                    <input type="hidden" class="datatable_name" data-title="<?php  echo ($role =="Admin"?lang('DeliveryPersonCash'):lang('MyCash')) ?>" data-id_name="datatable">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="width_1_p"><?php echo lang('sn'); ?></th>
                            <th class="width_1_p"><?php echo lang('Enter'); ?></th>
                            <th class="width_10_p"><?php echo lang('date'); ?></th>
                            <th class="width_10_p"><?php echo lang('OpeningAmount'); ?></th>
                            <th class="width_10_p"><?php echo lang('OpenedBy'); ?></th>
                            <th class="width_10_p"><?php echo lang('OpeningTime'); ?></th>
                            <th class="width_10_p"><?php echo lang('CurrentBalance'); ?></th>
                            <th class="width_10_p"><?php echo lang('ClosingAmount'); ?></th>
                            <th class="width_10_p"><?php echo lang('ClosedBy'); ?></th>
                            <th class="width_10_p"><?php echo lang('ClosingTime'); ?></th>
                            <th class="width_6_p not-export-col"><?php echo lang('actions'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($items && !empty($items)) {
                            $i = count($items);
                        }
                        foreach ($items as $expnss) {
                            ?>
                            <tr>
                                <td class="c_center"><?php echo escape_output($i--); ?></td>
                                <td class="c_center">
                                    <?php
                                    $role = $this->session->userdata('role');
                                    if($role =="Admin" && ($expnss->close_status==1 || $expnss->close_status==2)):
                                    ?>
                                    <a class="btn btn-xs btn-primary txt-uh-31" href="<?php echo base_url() ?>deliveryPerson/addDeliveryPersonItems/<?php echo escape_output($this->custom->encrypt_decrypt($expnss->id, 'encrypt')); ?>" >Enter</a>
                                    <?php
                                    else:
                                    ?>
                                        <a class="btn btn-xs btn-default txt-uh-30" disabled="" href="" >Closed</a>
                                    <?php
                                    endif;
                                    ?>
                                </td>

                                <td><?php echo date($this->session->userdata('date_format'), strtotime($expnss->date)); ?></td>
                                <td> <?php echo escape_output($this->session->userdata('currency')); ?> <?php echo escape_output($expnss->opening_amount); ?></td>
                                <td><?php echo userName($expnss->open_by); ?></td>
                                <td><?php echo escape_output($expnss->opening_time); ?></td>
                                <td> <?php echo escape_output($this->session->userdata('currency')); ?> <?php echo escape_output($expnss->current_balance); ?></td>
                                <td> <?php echo escape_output($this->session->userdata('currency')); ?> <?php echo escape_output($expnss->closing_amount); ?></td>
                                <td><?php echo userName($expnss->close_by); ?></td>
                                <td><?php echo escape_output($expnss->closing_time); ?></td>
                                <td class="c_center">
                                    <?php
                                    $role = $this->session->userdata('role');
                                        if($role=="Admin"):
                                    ?>
                                    <a class="delete txt-uh-31" href="<?php echo base_url() ?>DeliveryPerson/deleteDeliveryItems/<?php echo escape_output($this->custom->encrypt_decrypt($expnss->id, 'encrypt')); ?>" ><?php echo lang('delete'); ?></a>
                                            <?php
                                            else:
                                            ?>
                                                <?php
                                                endif;
                                                ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="width_1_p"><?php echo lang('sn'); ?></th>
                            <th class="width_1_p"><?php echo lang('Enter'); ?></th>
                            <th class="width_10_p"><?php echo lang('date'); ?></th>
                            <th class="width_10_p"><?php echo lang('OpeningAmount'); ?></th>
                            <th class="width_10_p"><?php echo lang('OpenedBy'); ?></th>
                            <th class="width_10_p"><?php echo lang('OpeningTime'); ?></th>
                            <th class="width_10_p"><?php echo lang('CurrentBalance'); ?></th>
                            <th class="width_10_p"><?php echo lang('ClosingAmount'); ?></th>
                            <th class="width_10_p"><?php echo lang('ClosedBy'); ?></th>
                            <th class="width_10_p"><?php echo lang('ClosingTime'); ?></th>
                            <th class=" not-export-col"><?php echo lang('actions'); ?></th>
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
