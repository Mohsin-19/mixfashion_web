
<section class="content-header">
    <h1>
       <?php echo lang('edit_account'); ?>
    </h1>  
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary"> 
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open(base_url('PaymentMethod/addEditPaymentMethod/' . $encrypted_id)); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('account_name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="name" class="form-control" placeholder="<?php echo lang('account_name'); ?>" value="<?php echo escape_output($payment_method_information->name); ?>">
                            </div>
                            <?php if (form_error('name')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('name'); ?></p>
                                </div>
                            <?php } ?>

                        </div>
						
						
						
                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('description'); ?></label>
                                <input tabindex="2" autocomplete="off" type="text" name="description" class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?php echo escape_output($payment_method_information->description); ?>">
                            </div>
                            <?php if (form_error('description')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('description'); ?></p>
                                </div>
                            <?php } ?> 

                        </div> 
						
						
						<div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('current_balance'); ?></label>
                                <input tabindex="1" autocomplete="off" type="text" name="current_balance" class="form-control integerchk" placeholder="<?php echo lang('current_balance'); ?>" value="<?php echo escape_output($payment_method_information->current_balance); ?>">
                            </div>
                            <?php if (form_error('current_balance')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('current_balance'); ?></p>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                    <!-- /.box-body --> 
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>PaymentMethod/paymentMethods"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?> 
            </div>
        </div>
    </div>
</section>