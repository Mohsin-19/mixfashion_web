<section class="content-header">
    <h1>
        <?php echo lang('edit_supplier'); ?>
    </h1>  
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary"> 
                <!-- form start -->
                <?php echo form_open(base_url('Supplier/addEditSupplier/' . $encrypted_id)); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="name" class="form-control" placeholder="<?php echo lang('name'); ?>" value="<?php echo escape_output($supplier_information->name); ?>">
                            </div>
                            <?php if (form_error('name')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('name'); ?></p>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label><?php echo lang('contact_person'); ?> <span class="required_star">*</span></label>
                                <input tabindex="2" autocomplete="off" type="text" name="contact_person" class="form-control" placeholder="<?php echo lang('contact_person'); ?>" value="<?php echo escape_output($supplier_information->contact_person); ?>">
                            </div>
                            <?php if (form_error('contact_person')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('contact_person'); ?></p>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" autocomplete="off" type="text" name="phone" class="form-control integerchk" placeholder="<?php echo lang('phone'); ?>" value="<?php echo escape_output($supplier_information->phone); ?>">
                            </div>
                            <?php if (form_error('phone')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('phone'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label><?php echo lang('email'); ?></label>
                                <input tabindex="4" autocomplete="off" type="text" name="email" class="form-control" placeholder="<?php echo lang('email'); ?>" value="<?php echo escape_output($supplier_information->email); ?>">
                            </div>
                            <?php if (form_error('email')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('email'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('previous_due'); ?></label>
                                <input tabindex="5" autocomplete="off" type="text" id="previous_due" name="previous_due" class="form-control " placeholder="<?php echo lang('previous_due'); ?>" value="<?php echo escape_output($supplier_information->previous_due); ?>">
                            </div>
                            <div class="form-group">
                                <label><?php echo lang('address'); ?></label>
                                <textarea tabindex="6" class="form-control" rows="3" name="address" placeholder="<?php echo lang('address'); ?>"><?php echo escape_output($supplier_information->address); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label><?php echo lang('description'); ?></label>
                                <textarea tabindex="7" class="form-control" rows="3" name="description" placeholder="<?php echo lang('enter'); ?> ..."><?php echo escape_output($supplier_information->description); ?></textarea>
                            </div>
                        </div> 

                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>Supplier/suppliers"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>