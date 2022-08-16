<script src="<?php echo base_url(); ?>assets/plugins/local/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/jquery.timepicker.min.css">
<!--for check dynamically-->
<script>
    $(function () {
        "use strict";

        $('#in_time').timepicker({
            timeFormat: 'HH:mm:ss',
            interval: 15,
            <?php if($encrypted_id == ''){ echo "defaultTime: 'now',"; } ?>
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        $('#out_time').timepicker({
            timeFormat: 'HH:mm:ss',
            interval: 15,
            <?php if($encrypted_id != ''){ echo "defaultTime: 'now',"; } ?>
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

    })
</script>

<section class="content-header">
    <h1>
        <?php echo lang('add_update_attendance'); ?>
    </h1>  
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open(base_url('Attendance/addEditAttendance/' . $encrypted_id) ); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('ref_no'); ?></label>
                                <input tabindex="1" autocomplete="off" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo escape_output($reference_no) ?>">
                            </div>
                            <?php if (form_error('reference_no')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('reference_no'); ?></p>
                                </div>
                            <?php } ?>
                        </div> 
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" id="date" readonly name="date" class="form-control" placeholder="<?php echo lang('date'); ?>" value="<?php if($encrypted_id == ''){ echo date('Y-m-d'); }else{ echo escape_output($attendance_details->date);}?>">
                            </div>
                            <?php if (form_error('date')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('date'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('employee'); ?> <span class="required_star">*</span></label>
                                <select tabindex="3" class="form-control select2 width_100_p" id="employee_id" name="employee_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($employees as $value) { ?>

                                        <?php if($encrypted_id == ''){ ?>
                                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('value_id', $value->id); ?>><?php echo escape_output($value->full_name) ."-". $value->designation ."-". $value->phone?></option>
                                        <?php }else{ ?>   
                                            <option value="<?php echo escape_output($value->id) ?>"
                                            <?php
                                            if ($attendance_details->employee_id == $value->id) {
                                                echo "selected";
                                            }
                                            ?>>
                                            <?php echo escape_output($value->full_name) ."-". $value->designation ."-". $value->phone?> 
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="alert alert-info"></div>
                            <?php if (form_error('employee_id')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('employee_id'); ?></p>
                                </div>
                            <?php } ?>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-4" id="in_time_container">
                            <div class="form-group"> 
                                <label><?php echo lang('in_time'); ?> <?php if($encrypted_id == ''){ echo '<span class="required_star">*</span>'; } ?></label>
                                <input tabindex="2" autocomplete="off" type="text" name="in_time" id="in_time" autocomplete="off" class="form-control width_100_p" placeholder="<?php echo lang('in_time'); ?>" value="<?php if($encrypted_id == ''){ echo set_value('in_time'); }else{ echo escape_output($attendance_details->in_time);}?>">
                            </div>
                            <?php if (form_error('in_time')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('in_time'); ?></p>
                                </div>
                            <?php } ?> 
                        </div>
                        <div class="col-md-4" id="out_time_container">
                            <div class="form-group"> 
                                <label><?php echo lang('out_time'); ?> <?php if($encrypted_id != ''){ echo '<span class="required_star">*</span>'; } ?></label>
                                <input tabindex="2" autocomplete="off" type="text" name="out_time" id="out_time" autocomplete="off" class="form-control width_100_p" placeholder="<?php echo lang('out_time'); ?>" value="<?php if($encrypted_id == ''){ echo set_value('out_time'); }else{ echo escape_output($attendance_details->out_time);}?>">
                            </div>
                            <?php if (form_error('out_time')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('out_time'); ?></p>
                                </div>
                            <?php } ?> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('note'); ?></label>
                                <textarea tabindex="5" class="form-control" rows="4" name="note" placeholder="<?php echo lang('enter'); ?> ..."><?php echo escape_output($this->input->post('note')); ?></textarea>
                            </div> 
                            <?php if (form_error('note')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('note'); ?></p>
                                </div>
                            <?php } ?>  
                        </div> 

                    </div>
                    <!-- /.box-body -->
                </div>  

                <input type="hidden" name="in_or_out" value="">
                
                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>Attendance/attendances"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>