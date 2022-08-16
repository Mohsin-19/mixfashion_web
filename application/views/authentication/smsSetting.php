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
        <?php echo lang('SMSSetting'); ?>
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
                <?php echo form_open(base_url() . 'Authentication/smsSetting/'.(isset($smsSetting) && $smsSetting->id?$smsSetting->id:''), $arrayName = array('id' => 'add_whitelabel','enctype'=>'multipart/form-data')) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('SMSType'); ?></label>
                                <select class="form-control select2 width_100_p" name="enable_status" id="enable_status">
                                    <option <?php echo isset($smsSetting) && $smsSetting->enable_status=="0"?'selected':''?> <?php echo set_select('enable_status', "0"); ?>  value="0">None</option>
                                    <option  <?=isset($smsSetting) && $smsSetting->enable_status=="1"?'selected':''?>   <?php echo set_select('enable_status', "1"); ?>   value="1">MIM SMS</option>
                                </select>
                            </div>
                            <?php if (form_error('enable_status')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('enable_status'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <h3>MIM SMS</h3>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>API Key</label>
                                <input type="text" name="user_name" value="<?php echo isset($smsSetting) && $smsSetting->user_name?$smsSetting->user_name:set_value('user_name')?>" placeholder="API Key" id="user_name" class="form-control">
                            </div>
                            <?php if (form_error('user_name')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('user_name'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-3" style="display: none">
                            <div class="form-group">
                                <label><?php echo lang('Password'); ?></label>
                                <input type="text" name="password" value="<?php echo isset($smsSetting) && $smsSetting->password?$smsSetting->password:set_value('password')?>" placeholder="<?php echo lang('Password'); ?>" id="password" class="form-control">
                            </div>
                            <?php if (form_error('password')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('password'); ?></p>
                                </div>
                            <?php } ?>
                        </div> <div class="clearfix"></div>
                        <div class="col-md-12" style="display: none">
                            <h3><?php echo lang('ForTextLocal'); ?></h3>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-3 display_none">
                            <div class="form-group">
                                <label><?php echo lang('SMSUsername'); ?></label>
                                <input type="text" name="user_name1" value="<?php echo isset($smsSetting) && $smsSetting->user_name1?$smsSetting->user_name1:set_value('user_name1')?>" placeholder="<?php echo lang('SMSUsername'); ?>" id="user_name1" class="form-control">
                            </div>
                            <?php if (form_error('user_name1')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('user_name1'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-3 display_none">
                            <div class="form-group">
                                <label><?php echo lang('Password'); ?></label>
                                <input type="text" name="password1" value="<?php echo isset($smsSetting) && $smsSetting->password1?$smsSetting->password1:set_value('password1')?>" placeholder="<?php echo lang('Password'); ?>" id="password1" class="form-control">
                            </div>
                            <?php if (form_error('password1')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('password1'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-3 display_none">
                            <div class="form-group">
                                <label><?php echo lang('APIKey'); ?></label>
                                <input type="text" name="apikey" value="<?php echo isset($smsSetting) && $smsSetting->apikey?$smsSetting->apikey:set_value('apikey')?>" placeholder="<?php echo lang('APIKey'); ?>" id="apikey" class="form-control">
                            </div>
                            <?php if (form_error('apikey')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('apikey'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <?php
                            $s_field_1 = set_value('field_1');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_1) && $s_field_1==1?'checked':''?>  <?php echo isset($smsSetting->field_1) && $smsSetting->field_1==1?'checked':''?>  type="checkbox" name="field_1" value="1"> <?php echo lang('WhowillgetSMSnotificationwhenanorderisplaced'); ?></label>
                                <select name="field_1_v"  class="form-control">
                                    <option value=""><?php echo lang('select')?></option>
                                    <?php
                                    foreach ($users as $value):
                                        if($value->id!=1):
                                            ?>
                                            <option <?php echo set_select('field_1_v', $value->id); ?> <?php echo isset($smsSetting->field_1_v) && $smsSetting->field_1_v==$value->id?'selected':''?> value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->full_name); ?></option>
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
                                <label><input <?php echo isset($s_field_2) && $s_field_2==1?'checked':''?>  <?php echo isset($smsSetting->field_2) && $smsSetting->field_2==1?'checked':''?>  type="checkbox" name="field_2" value="1"> <?php echo lang('WhowillgetSMSnotificationwhenanorderiscancelled'); ?></label>
                                <select name="field_2_v"  class="form-control">
                                    <option value=""><?php echo lang('select')?></option>
                                    <?php
                                    foreach ($users as $value):
                                        if($value->id!=1):
                                            ?>
                                            <option <?php echo set_select('field_2_v', $value->id); ?> <?php echo isset($smsSetting->field_2_v) && $smsSetting->field_2_v==$value->id?'selected':''?> value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->full_name); ?></option>
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
                                <label><input <?php echo isset($s_field_3) && $s_field_3==1?'checked':''?>  <?php echo isset($smsSetting->field_3) && $smsSetting->field_3==1?'checked':''?>  type="checkbox" name="field_3" value="1"> <?php echo lang('CustomerwillgetSMSnotificationwhenanorderisinplaced'); ?></label>
                                <select name="field_3_v"  class="form-control">
                                    <option <?php echo set_select('field_3_v', "No"); ?> <?php echo isset($smsSetting->field_3_v) && $smsSetting->field_3_v=="No"?'selected':''?> value="No"><?php echo lang('No'); ?></option>
                                    <option <?php echo set_select('field_3_v', "Yes"); ?> <?php echo isset($smsSetting->field_3_v) && $smsSetting->field_3_v=="Yes"?'selected':''?> value="Yes"><?php echo lang('Yes'); ?></option>
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
                                <label><input <?php echo isset($s_field_4) && $s_field_4==1?'checked':''?>  <?php echo isset($smsSetting->field_4) && $smsSetting->field_4==1?'checked':''?>  type="checkbox" name="field_4" value="1"> <?php echo lang('CustomerwillgetSMSnotificationwhenanorderisinprogress'); ?></label>
                                <select name="field_4_v"  class="form-control">
                                    <option <?php echo set_select('field_4_v', "No"); ?> <?php echo isset($smsSetting->field_4_v) && $smsSetting->field_4_v=="No"?'selected':''?> value="No"><?php echo lang('No'); ?></option>
                                    <option <?php echo set_select('field_4_v', "Yes"); ?> <?php echo isset($smsSetting->field_4_v) && $smsSetting->field_4_v=="Yes"?'selected':''?> value="Yes"><?php echo lang('Yes'); ?></option>

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
                                <label><input <?php echo isset($s_field_5) && $s_field_5==1?'checked':''?>  <?php echo isset($smsSetting->field_5) && $smsSetting->field_5==1?'checked':''?>  type="checkbox" name="field_5" value="1"> <?php echo lang('CustomerwillgetSMSnotificationwhenanorderisindelivered'); ?></label>
                                <select name="field_5_v"  class="form-control">
                                    <option <?php echo set_select('field_5_v', "No"); ?> <?php echo isset($smsSetting->field_5_v) && $smsSetting->field_5_v=="No"?'selected':''?> value="No"><?php echo lang('No'); ?></option>
                                    <option <?php echo set_select('field_5_v', "Yes"); ?> <?php echo isset($smsSetting->field_5_v) && $smsSetting->field_5_v=="Yes"?'selected':''?> value="Yes"><?php echo lang('Yes'); ?></option>
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
                                <label><input <?php echo isset($s_field_6) && $s_field_6==1?'checked':''?>  <?php echo isset($smsSetting->field_6) && $smsSetting->field_6==1?'checked':''?>  type="checkbox" name="field_6" value="1"> <?php echo lang('CustomerwillgetSMSnotificationwhenanorderisincancelled'); ?></label>
                                <select name="field_6_v"  class="form-control">
                                    <option <?php echo set_select('field_6_v', "No"); ?> <?php echo isset($smsSetting->field_6_v) && $smsSetting->field_6_v=="No"?'selected':''?> value="No"><?php echo lang('No'); ?></option>
                                    <option <?php echo set_select('field_6_v', "Yes"); ?> <?php echo isset($smsSetting->field_6_v) && $smsSetting->field_6_v=="Yes"?'selected':''?> value="Yes"><?php echo lang('Yes'); ?></option>
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