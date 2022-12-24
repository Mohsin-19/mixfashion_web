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
    <h1>
        <?php echo lang('sms_settings'); ?> <small>(<?php echo lang('provide_your_text_local'); ?>)</small>
    </h1>

</section>

<!-- Main content -->
<section class="content">
    <div class="row">

        <!-- left column -->
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open(base_url('Authentication/SMSSetting/' . (isset($sms_information) && $sms_information ? $sms_information->id : ''))); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label><?php echo lang('sms_username'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="sms_username" class="form-control" placeholder="<?php echo lang('sms_username'); ?>" value="<?php echo escape_output($sms_information->sms_username); ?>">
                            </div>
                            <?php if (form_error('sms_username')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('sms_username'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label><?php echo lang('password'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="password" class="form-control" placeholder="<?php echo lang('password'); ?>" value="<?php echo escape_output($sms_information->password); ?>">
                            </div>
                            <?php if (form_error('password')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('password'); ?></p>
                                </div>
                            <?php } ?>
                        </div> 
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                 
                    <a class="btn btn-primary" href="<?php echo base_url();?>Short_message_service/smsService"><?php echo lang('go_to_send_sms_page'); ?></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>