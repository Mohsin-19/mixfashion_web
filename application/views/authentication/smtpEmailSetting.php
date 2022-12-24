<?php
if ($this->session->flashdata('exception')) {

    echo '<section class="content-header"><div class="alert alert-success alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo escape_output($this->session->flashdata('exception'));
    echo '</p></div></section>';
}
?>
<?php
if ($this->session->flashdata('exception_1')) {

    echo '<section class="content-header"><div class="alert alert-danger alert-dismissible"> 
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p><i class="icon fa fa-check"></i>';
    echo escape_output($this->session->flashdata('exception_1'));
    echo '</p></div></section>';
}
?>
<section class="content-header">
    <h1>
        <?php echo lang('SMTPEmailSetting'); ?>
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
                <?php echo form_open(base_url() . 'Authentication/smtpEmailSetting/'.(isset($smtEmail) && $smtEmail->id?$smtEmail->id:''), $arrayName = array('id' => 'add_whitelabel','enctype'=>'multipart/form-data')) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('EmailType'); ?></label>
                                <select class="form-control select2 width_100_p" name="enable_status" id="enable_status">
                                    <option <?php echo isset($smtEmail) && $smtEmail->enable_status=="0"?'selected':''?> <?php echo set_select('enable_status', "0"); ?>  value="0"><?php echo lang('None'); ?></option>
                                    <option  <?php echo isset($smtEmail) && $smtEmail->enable_status=="1"?'selected':''?>   <?php echo set_select('enable_status', "1"); ?>   value="1"><?php echo lang('SMTP'); ?></option>
                                </select>
                            </div>
                            <?php if (form_error('enable_status')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('enable_status'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('SMTPHost'); ?> <span  class="display_none required_star">*</span></label>
                                <input type="text" name="host_name" placeholder="SMTP Host"  value="<?php echo isset($smtEmail) && $smtEmail->host_name?$smtEmail->host_name:set_value('host_name')?>" id="host_name" class="form-control">
                            </div>
                            <?php if (form_error('host_name')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('host_name'); ?></p>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('PortAddress'); ?> <span class="display_none  required_star">*</span></label>
                                <input type="text" name="port_address" value="<?php echo isset($smtEmail) && $smtEmail->port_address?$smtEmail->port_address:set_value('port_address')?>"  placeholder="Port Address" id="port_address" class="form-control">
                            </div>
                            <?php if (form_error('port_address')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('port_address'); ?></p>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('Username'); ?> <span class=" display_none required_star">*</span></label>
                                <input type="text" name="user_name" value="<?php echo isset($smtEmail) && $smtEmail->user_name?$smtEmail->user_name:set_value('user_name')?>" placeholder="User Name" id="user_name" class="form-control">
                            </div>
                            <?php if (form_error('user_name')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('user_name'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('Password'); ?> <span class=" display_none required_star">*</span></label>
                                <input type="text" name="password" value="<?php echo isset($smtEmail) && $smtEmail->password?$smtEmail->password:set_value('password')?>" placeholder="Password" id="password" class="form-control">
                            </div>
                            <?php if (form_error('password')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('password'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <?php
                                $s_field_1 = set_value('field_1');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_1) && $s_field_1==1?'checked':''?>  <?php echo isset($smtEmail->field_1) && $smtEmail->field_1==1?'checked':''?>  type="checkbox" name="field_1" value="1"> <?php echo lang('Whowillgetemailnotificationwhenanorderisplaced'); ?></label>
                                <select name="field_1_v"  class="form-control">
                                    <option value=""><?php echo lang('select')?></option>
                                    <?php
                                        foreach ($users as $value):
                                            if($value->id!=1):
                                            ?>
                                            <option <?php echo set_select('field_1_v', $value->id); ?> <?php echo isset($smtEmail->field_1_v) && $smtEmail->field_1_v==$value->id?'selected':''?> value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->full_name); ?></option>
                                    <?php
                                    endif;
                                    endforeach;
                                    ?>

                                </select>
                                <?php if (form_error('field_1_v')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_1_v'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <?php
                                $s_field_2 = set_value('field_2');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_2) && $s_field_2==1?'checked':''?>  <?php echo isset($smtEmail->field_2) && $smtEmail->field_2==1?'checked':''?>  type="checkbox" name="field_2" value="1"> <?php echo lang('Whowillgetemailnotificationwhenanorderiscancelled'); ?></label>
                                <select name="field_2_v"  class="form-control">
                                    <option value=""><?php echo lang('select')?></option>
                                    <?php
                                        foreach ($users as $value):
                                            if($value->id!=1):
                                            ?>
                                            <option <?php echo set_select('field_2_v', $value->id); ?> <?php echo isset($smtEmail->field_2_v) && $smtEmail->field_2_v==$value->id?'selected':''?> value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->full_name); ?></option>
                                    <?php
                                    endif;
                                    endforeach;
                                    ?>

                                </select>
                                <?php if (form_error('field_2_v')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_2_v'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <?php
                                $s_field_3 = set_value('field_3');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_3) && $s_field_3==1?'checked':''?>  <?php echo isset($smtEmail->field_3) && $smtEmail->field_3==1?'checked':''?>  type="checkbox" name="field_3" value="1"> <?php echo lang('Customerwillgetemailnotificationwhenanorderisinplaced'); ?></label>
                                <select name="field_3_v"  class="form-control">
                                    <option <?php echo set_select('field_3_v', "No"); ?> <?php echo isset($smtEmail->field_3_v) && $smtEmail->field_3_v=="No"?'selected':''?> value="No"><?php echo lang('No'); ?></option>
                                    <option <?php echo set_select('field_3_v', "Yes"); ?> <?php echo isset($smtEmail->field_3_v) && $smtEmail->field_3_v=="Yes"?'selected':''?> value="Yes"><?php echo lang('Yes'); ?></option>
                                </select>
                                <?php if (form_error('field_3_v')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_3_v'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <?php
                                $s_field_4 = set_value('field_4');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_4) && $s_field_4==1?'checked':''?>  <?php echo isset($smtEmail->field_4) && $smtEmail->field_4==1?'checked':''?>  type="checkbox" name="field_4" value="1"> <?php echo lang('Customerwillgetemailnotificationwhenanorderisinprogress'); ?></label>
                                <select name="field_4_v"  class="form-control">
                                    <option <?php echo set_select('field_4_v', "No"); ?> <?php echo isset($smtEmail->field_4_v) && $smtEmail->field_4_v=="No"?'selected':''?> value="No"><?php echo lang('No'); ?></option>
                                    <option <?php echo set_select('field_4_v', "Yes"); ?> <?php echo isset($smtEmail->field_4_v) && $smtEmail->field_4_v=="Yes"?'selected':''?> value="Yes"><?php echo lang('Yes'); ?></option>

                                </select>
                                <?php if (form_error('field_4_v')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_4_v'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <?php
                                $s_field_5 = set_value('field_5');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_5) && $s_field_5==1?'checked':''?>  <?php echo isset($smtEmail->field_5) && $smtEmail->field_5==1?'checked':''?>  type="checkbox" name="field_5" value="1"> <?php echo lang('Customerwillgetemailnotificationwhenanorderisindelivered'); ?></label>
                                <select name="field_5_v"  class="form-control">
                                    <option <?php echo set_select('field_5_v', "No"); ?> <?php echo isset($smtEmail->field_5_v) && $smtEmail->field_5_v=="No"?'selected':''?> value="No"><?php echo lang('No'); ?></option>
                                    <option <?php echo set_select('field_5_v', "Yes"); ?> <?php echo isset($smtEmail->field_5_v) && $smtEmail->field_5_v=="Yes"?'selected':''?> value="Yes"><?php echo lang('Yes'); ?></option>
                                </select>
                                <?php if (form_error('field_5_v')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_5_v'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <?php
                                $s_field_6 = set_value('field_6');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_6) && $s_field_6==1?'checked':''?>  <?php echo isset($smtEmail->field_6) && $smtEmail->field_6==1?'checked':''?>  type="checkbox" name="field_6" value="1"> <?php echo lang('Customerwillgetemailnotificationwhenanorderisincancelled'); ?></label>
                                <select name="field_6_v"  class="form-control">
                                    <option <?php echo set_select('field_6_v', "No"); ?> <?php echo isset($smtEmail->field_6_v) && $smtEmail->field_6_v=="No"?'selected':''?> value="No"><?php echo lang('No'); ?></option>
                                    <option <?php echo set_select('field_6_v', "Yes"); ?> <?php echo isset($smtEmail->field_6_v) && $smtEmail->field_6_v=="Yes"?'selected':''?> value="Yes"><?php echo lang('Yes'); ?></option>
                                </select>
                                <?php if (form_error('field_6_v')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_6_v'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>


                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>authentication/siteSetting"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>assets/js/sms_setting.js"></script>