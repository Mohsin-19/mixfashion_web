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
        <?php echo lang('PaymentSetting'); ?>
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
                <?php echo form_open(base_url() . 'Authentication/paymentSetting/'.(isset($paymentSetting) && $paymentSetting->id?$paymentSetting->id:''), $arrayName = array('id' => 'add_whitelabel','enctype'=>'multipart/form-data')) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?php
                            $s_field_4 = set_value('field_4');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_4) && $s_field_4==1?'checked':''?>  <?php echo isset($paymentSetting->field_4) && $paymentSetting->field_4==1?'checked':''?>  type="checkbox" name="field_4" value="1"> Cash On Delivery?</label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <?php
                            $s_field_1 = set_value('field_1');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_1) && $s_field_1==1?'checked':''?>  <?php echo isset($paymentSetting->field_1) && $paymentSetting->field_1==1?'checked':''?>  type="checkbox" name="field_1" value="1"> Aamarpay?</label>
                                <select name="field_1_v"  class="form-control field_1_v">
                                    <option <?php echo set_select('field_1_v', "false"); ?> <?php echo isset($paymentSetting->field_1_v) && $paymentSetting->field_1_v=="false"?'selected':''?> value="false">Live</option>
                                    <option <?php echo set_select('field_1_v', "true"); ?> <?php echo isset($paymentSetting->field_1_v) && $paymentSetting->field_1_v=="true"?'selected':''?> value="true">Sandbox</option>
                                </select>
                                <?php if (form_error('field_1_v')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_1_v'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <input type="text" onfocus="select();" name="field_1_key_1" class="form-control field_1_key_1" placeholder="Store ID" value="<?php echo isset($paymentSetting->field_1_key_1) && $paymentSetting->field_1_key_1?$paymentSetting->field_1_key_1:set_value('field_1_key_1')?>">
                                <?php if (form_error('field_1_key_1')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_1_key_1'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <input type="text" onfocus="select();" name="field_1_key_2" class="form-control field_1_key_2" placeholder="Signature Key" value="<?php echo isset($paymentSetting->field_1_key_2) && $paymentSetting->field_1_key_2?$paymentSetting->field_1_key_2:set_value('field_1_key_2')?>">
                                <?php if (form_error('field_1_key_2')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_1_key_2'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4 display_none">
                            <?php
                            $s_field_2 = set_value('field_2');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_2) && $s_field_2==1?'checked':''?>  <?php echo isset($paymentSetting->field_2) && $paymentSetting->field_2==1?'checked':''?>  type="checkbox" name="field_2" value="1"> Paypal?</label>
                                <select name="field_2_v"  class="form-control">
                                    <option <?php echo set_select('field_2_v', "live"); ?> <?php echo isset($paymentSetting->field_2_v) && $paymentSetting->field_2_v=="live"?'selected':''?> value="live">Live</option>
                                    <option <?php echo set_select('field_2_v', "sandbox"); ?> <?php echo isset($paymentSetting->field_2_v) && $paymentSetting->field_2_v=="sandbox"?'selected':''?> value="sandbox">Sandbox</option>
                                </select>
                                <?php if (form_error('field_2_v')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_2_v'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-4 display_none">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <input type="text" onfocus="select();" name="field_2_key_1" class="form-control" placeholder="Client ID" value="<?php echo isset($paymentSetting->field_2_key_1) && $paymentSetting->field_2_key_1?$paymentSetting->field_2_key_1:set_value('field_2_key_1')?>">
                                <?php if (form_error('field_2_key_1')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_2_key_1'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-4 display_none">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <input type="text" onfocus="select();" name="field_2_key_2" class="form-control" placeholder="Secret Key" value="<?php echo isset($paymentSetting->field_2_key_2) && $paymentSetting->field_2_key_2?$paymentSetting->field_2_key_2:set_value('field_2_key_2')?>">
                                <?php if (form_error('field_2_key_2')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_2_key_2'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4 display_none">
                            <?php
                            $s_field_3 = set_value('field_3');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_3) && $s_field_3==1?'checked':''?>  <?php echo isset($paymentSetting->field_3) && $paymentSetting->field_3==1?'checked':''?>  type="checkbox" name="field_3" value="1"> Stripe?</label>
                                <select name="field_3_v"  class="form-control">
                                    <option <?php echo set_select('field_3_v', "live"); ?> <?php echo isset($paymentSetting->field_3_v) && $paymentSetting->field_3_v=="live"?'selected':''?> value="live">Live</option>
                                    <option <?php echo set_select('field_3_v', "demo"); ?> <?php echo isset($paymentSetting->field_3_v) && $paymentSetting->field_3_v=="demo"?'selected':''?> value="demo">Sandbox</option>
                                </select>
                                <?php if (form_error('field_3_v')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_3_v'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-4 display_none">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <input type="text" onfocus="select();" name="field_3_key_1" class="form-control" placeholder="Stripe API Key" value="<?php echo isset($paymentSetting->field_3_key_1) && $paymentSetting->field_3_key_1?$paymentSetting->field_3_key_1:set_value('field_3_key_1')?>">
                                <?php if (form_error('field_3_key_1')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_3_key_1'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-4 display_none">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <input type="text" onfocus="select();" name="field_3_key_2" class="form-control" placeholder="Stripe Publishable Key" value="<?php echo isset($paymentSetting->field_3_key_2) && $paymentSetting->field_3_key_2?$paymentSetting->field_3_key_2:set_value('field_3_key_2')?>">
                                <?php if (form_error('field_3_key_2')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_3_key_2'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <?php
                            $s_field_5 = set_value('field_5');
                            ?>
                            <div class="form-group">
                                <label><input <?php echo isset($s_field_5) && $s_field_5==1?'checked':''?>  <?php echo isset($paymentSetting->field_5) && $paymentSetting->field_5==1?'checked':''?>  type="checkbox" name="field_5" value="1"> SSLCOMMERZ?</label>
                                <select name="field_4_v"  class="form-control">
                                    <option <?php echo set_select('field_4_v', "live"); ?> <?php echo isset($paymentSetting->field_4_v) && $paymentSetting->field_4_v=="0"?'selected':''?> value="0">Live</option>
                                    <option <?php echo set_select('field_4_v', "demo"); ?> <?php echo isset($paymentSetting->field_4_v) && $paymentSetting->field_4_v=="1"?'selected':''?> value="1">Sandbox</option>
                                </select>
                                <?php if (form_error('field_4_v')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_4_v'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <input type="text" onfocus="select();" name="field_4_key_1" class="form-control" placeholder="Store Key" value="<?php echo isset($paymentSetting->field_4_key_1) && $paymentSetting->field_4_key_1?$paymentSetting->field_4_key_1:set_value('field_4_key_1')?>">
                                <?php if (form_error('field_4_key_1')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_4_key_1'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <input type="text" onfocus="select();" name="field_4_key_2" class="form-control" placeholder="Store Password" value="<?php echo isset($paymentSetting->field_4_key_2) && $paymentSetting->field_4_key_2?$paymentSetting->field_4_key_2:set_value('field_4_key_2')?>">
                                <?php if (form_error('field_4_key_2')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('field_4_key_2'); ?></p>
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
<script src="<?php echo base_url(); ?>assets/js/payment_setting.js"></script>