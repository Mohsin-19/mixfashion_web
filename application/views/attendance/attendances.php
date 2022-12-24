<?php
if ($value =$this->session->flashdata('exception')) {

    echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo escape_output($this->session->flashdata('exception'));
    echo '</p></div></section>';
}
?> 

<style type="text/css">
    .top-left-header{
        margin-top: 0px !important;
    }
</style>

<section class="content-header">
    <div class="row">
        <div class="col-md-6">
            <h2 class="top-left-header"><?php echo lang('attendances'); ?> </h2>
        </div>
        <div class="col-md-offset-3 col-md-3">
            <a href="<?php echo base_url() ?>Attendance/addEditAttendance"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('add_attendance'); ?></button></a>
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
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('attendances'); ?>" data-id_name="datatable">
                    <table id="datatable_2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="width_1_p"><?php echo lang('sn'); ?></th>
                                <th class="width_11_p"><?php echo lang('ref_no'); ?></th>
                                <th class="width_9_p"><?php echo lang('date'); ?></th>
                                <th class="width_18_p"><?php echo lang('employee'); ?></th>
                                <th class="width_10_p"><?php echo lang('in_time'); ?></th>
                                <th class="width_10_p"><?php echo lang('out_time'); ?></th>
                                <th class="width_15_p"><?php echo lang('update_time'); ?></th>
                                <th class="width_14_p"><?php echo lang('time_count'); ?></th>
                                <th class="width_15_p"><?php echo lang('note'); ?></th>
                                <th class="width_29_p"><?php echo lang('added_by'); ?></th>
                                <th class="width_6_p not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($attendances && !empty($attendances)) {
                                $i = count($attendances); 
                            foreach ($attendances as $value) {
                                ?>                       
                                <tr> 
                                    <td><?php echo escape_output($i--); ?></td>
                                    <td><?php echo escape_output($value->reference_no); ?></td>
                                    <td><?php echo date($this->session->userdata('date_format'), strtotime($value->date)); ?></td>
                                    <td><?php echo employeeName($value->employee_id); ?></td>
                                    <td><?php echo escape_output($value->in_time); ?></td>
                                    <td>
                                        <?php 
                                        if($value->out_time == '00:00:00'){ 
                                            echo 'N/A<br>';  
                                        }else{ 
                                            echo escape_output($value->out_time);
                                        } 
                                        ?> 
                                    </td>
                                    <td>
                                        <?php 
                                            echo '<a class="btn btn-primary" href="'. base_url().'Attendance/addEditAttendance/'. $value->id .'">Update Time</a>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php  
                                        if($value->out_time == '00:00:00'){ 
                                            echo 'N/A'; 
                                        }else{ 
                                            $to_time = strtotime($value->out_time);
                                            $from_time = strtotime($value->in_time);
                                            $minute = round(abs($to_time - $from_time) / 60,2); 
                                            $hour = round(abs($minute) / 60,2);
                                            echo escape_output($hour)." Hour";
                                        }

                                        ?> 
                                    </td>
                                    <td><?php if ($value->note != NULL) echo escape_output($value->note); ?></td>
                                    <td><?php echo userName($value->user_id); ?></td>
                                    <td class="c_center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">  
                                                <li><a class="delete" href="<?php echo base_url() ?>Attendance/deleteAttendance/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" ><i class="fa fa-trash tiny-icon"></i><?php echo lang('delete'); ?></a></li>
                                            </ul> 
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            } }
                            ?> 
                        </tbody>
                        <tfoot>
                            <tr>
                               <th class="width_1_p"><?php echo lang('sn'); ?></th>
                                <th class="width_11_p"><?php echo lang('ref_no'); ?></th>
                                <th class="width_9_p"><?php echo lang('date'); ?></th>
                                <th class="width_18_p"><?php echo lang('employee'); ?></th>
                                <th class="width_10_p"><?php echo lang('in_time'); ?></th>
                                <th class="width_10_p"><?php echo lang('out_time'); ?></th>
                                <th class="width_15_p"><?php echo lang('update_time'); ?></th>
                                <th class="width_14_p"><?php echo lang('time_count'); ?></th>
                                <th class="width_15_p"><?php echo lang('note'); ?></th>
                                <th class="width_29_p"><?php echo lang('added_by'); ?></th>
                                <th class="width_6_p not-export-col"><?php echo lang('actions'); ?></th>
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
<!-- DataTables --><script src="<?php echo base_url(); ?>assets/plugins/datatable_custom/jquery-3.3.1.js"></script>
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