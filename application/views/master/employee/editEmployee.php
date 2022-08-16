<section class="content-header">
    <h1>
       <?php echo lang('edit_employee'); ?>
    </h1>  
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary"> 
                <!-- form start -->
                <?php echo form_open(base_url('Master/addEditEmployee/' . $encrypted_id)); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="name" class="form-control" placeholder="<?php echo lang('name'); ?>" value="<?php echo escape_output($employee_information->name); ?>">
                            </div>
                            <?php if (form_error('name')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('name'); ?></p>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label><?php echo lang('designation'); ?> <span class="required_star">*</span></label><small>(<?php echo lang('enter_waiter'); ?>)</small>
                                <input tabindex="2" autocomplete="off" type="text" name="designation" class="form-control" placeholder="<?php echo lang('designation'); ?>" value="<?php echo escape_output($employee_information->designation); ?>">
                            </div>
                            <?php if (form_error('designation')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('designation'); ?></p>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" autocomplete="off" type="text" name="phone" class="form-control integerchk"  placeholder="<?php echo lang('phone'); ?>" value="<?php echo escape_output($employee_information->phone); ?>">
                            </div>
                            <?php if (form_error('phone')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('phone'); ?></p>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('description'); ?></label>
                                <textarea tabindex="4" class="form-control" rows="7" name="description" placeholder="<?php echo lang('enter'); ?> ..."><?php echo escape_output($employee_information->description); ?></textarea>
                            </div> 
                            <?php if (form_error('description')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('description'); ?></p>
                                </div>
                            <?php } ?>  
                        </div> 

                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>Master/suppliers"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>