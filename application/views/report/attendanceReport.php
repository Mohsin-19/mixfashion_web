<section class="content-header">
    <h3  class="txt-uh-83"><?php echo lang('attendance_report'); ?></h3>
    <hr class="txt-uh-83">
    <div class="row">
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/attendanceReport') ?>
            <div class="form-group">
                <input tabindex="1" autocomplete="off" type="text" id="" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
            </div>
        </div>
        <div class="col-md-2">

            <div class="form-group">
                <input tabindex="2" autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
            </div>
        </div>
        <div class="col-md-2">

            <div class="form-group">
                <select tabindex="2" class="form-control select2 width_100_p" id="employee_id" name="employee_id">
                    <option value=""><?php echo lang('employee'); ?></option>
                    <?php
                    foreach ($employees as $value) {
                        ?>
                        <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('employee_id', $value->id); ?>><?php echo escape_output($value->full_name) ?></option>
                    <?php } ?>
                </select>
            </div>
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
                    <h3 class="c_center"><?php echo lang('attendance_report'); ?></h3>
                    <h4 class="c_center"><?php echo isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?php echo isset($start_date) && $start_date && !$end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?php echo isset($end_date) && $end_date && !$start_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?></h4>
                    <h4 class="txt-uh-83"><?php
                    if (isset($employee_id) && ($employee_id)){
                        echo lang('employee').": <span class='txt-uh-84'>" . employeeName($employee_id) . "</span>";
                    } 
                    ?></h4>
                    <br><input type="hidden" class="datatable_name" data-title="<?php echo lang('attendance_report'); ?>" data-id_name="datatable">
                    <table id="datatable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="width_1_p"><?php echo lang('sn'); ?></th>
                                <th class="width_11_p"><?php echo lang('ref_no'); ?></th>
                                <th class="width_9_p"><?php echo lang('date'); ?></th>
                                <th class="width_18_p"><?php echo lang('employee'); ?></th>
                                <th class="width_10_p"><?php echo lang('in_time'); ?></th>
                                <th class="width_10_p"><?php echo lang('out_time'); ?></th>
                                <th class="width_14_p"><?php echo lang('time_count'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_hours = 0;
                            if (!empty($attendanceReport)) {
                                $i = count($attendanceReport); 
                            foreach ($attendanceReport as $value) { 

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
                                        if($value->out_time == '00:00:00'){ 
                                            echo 'N/A'; 
                                        }else{ 
                                            $to_time = strtotime($value->out_time);
                                            $from_time = strtotime($value->in_time);
                                            $minute = round(abs($to_time - $from_time) / 60,2); 
                                            $hour = round(abs($minute) / 60,2);
                                            echo escape_output($hour)." ".lang('hour');
                                            $total_hours += $hour;
                                        }

                                        ?> 
                                    </td> 
                                </tr> 
                                <?php
                            } }
                            ?> 
                            <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td> 
                                    <td><b><?php echo lang('total'); ?> <?php echo lang('hours'); ?></b></td>
                                    <td><?php echo escape_output($total_hours) . " ".lang('hours'); ?></td>
                                </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="width_1_p"><?php echo lang('sn'); ?></th>
                                <th class="width_11_p"><?php echo lang('ref_no'); ?></th>
                                <th class="width_9_p"><?php echo lang('date'); ?></th>
                                <th class="width_18_p"><?php echo lang('employee'); ?></th>
                                <th class="width_10_p"><?php echo lang('in_time'); ?></th>
                                <th class="width_10_p"><?php echo lang('out_time'); ?></th>
                                <th class="width_14_p"><?php echo lang('time_count'); ?></th>
                            </tr>
                        </tfoot>
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