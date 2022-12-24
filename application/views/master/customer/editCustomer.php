<section class="content-header">
    <h1>
        <?php echo lang('edit_customer'); ?>
    </h1>  
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary"> 
                <?php echo form_open(base_url('Customer/addEditCustomer/' . $encrypted_id)); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('customer_name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="name" class="form-control" placeholder="<?php echo lang('customer_name'); ?>" value="<?php echo escape_output($customer_information->name); ?>">
                            </div>
                            <?php if (form_error('name')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('name'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                                <input tabindex="2" autocomplete="off" type="text" name="phone"  class="form-control integerchk"  placeholder="Phone" value="<?php echo escape_output($customer_information->phone); ?>">
                            </div>
                            <?php if (form_error('phone')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('phone'); ?></p>
                                </div>
                            <?php } ?>  
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('email'); ?> <span class="required_star">*</span></label>
                                <input tabindex="5" autocomplete="off" type="text" name="email" class="form-control" placeholder="<?php echo lang('email'); ?>" value="<?php echo escape_output($customer_information->email); ?>">
                            </div>
                             <?php if (form_error('email')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('email'); ?></p>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('address'); ?> <span class="required_star">*</span></label>
                                <textarea tabindex="9" name="address" class="form-control" placeholder="<?php echo lang('address'); ?>"><?php echo escape_output($customer_information->address); ?></textarea>
                            </div>
                             <?php if (form_error('address')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('address'); ?></p>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                <a href="<?php echo base_url() ?>Customer/customers"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>