<link rel="stylesheet" href="<?php echo base_url('assets/') ?>buttonCSS/checkBotton.css">
<section class="content-header">
    <h1>
        <?php echo lang('edit_employee'); ?>
    </h1>
</section>
<?php
//site setting
$getSiteSetting =  getSiteSetting();
//default base color
$base_color = "#6ab04c";
//dynamic base color from database
if(isset($getSiteSetting->base_color) && $getSiteSetting->base_color){
    $base_color = $getSiteSetting->base_color;
}
?>
<style>
    .container input:checked ~ .checkmark {
        background-color: <?php echo escape_output($base_color)?> !important;
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
               <?php
                $attributes = array('id' => 'add_user');
                echo form_open_multipart(base_url('User/addEditUser/' . $encrypted_id), $attributes); ?>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="full_name" class="form-control" placeholder="<?php echo lang('name'); ?>"
                                       value="<?php echo escape_output($user_details->full_name); ?>">
                            </div>
                            <?php if (form_error('full_name')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('full_name'); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('email_address'); ?>  <span class="required_star">*</span></label>
                                <input tabindex="2" autocomplete="off" type="text" name="email_address" class="form-control" placeholder="<?php echo lang('email_address'); ?>" value="<?php echo escape_output($user_details->email_address); ?>">
                            </div>
                            <?php if (form_error('email_address')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('email_address'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" autocomplete="off" type="text" name="phone" class="form-control integerchk" placeholder="<?php echo lang('phone'); ?>" value="<?php echo escape_output($user_details->phone); ?>">
                            </div>
                            <?php if (form_error('phone')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('designation'); ?><span class="required_star"> *</span></label>
                                <input tabindex="4" autocomplete="off" type="text" name="designation" class="form-control" placeholder="<?php echo lang('designation'); ?>" value="<?php echo escape_output($user_details->designation); ?>">
                                </select>
                            </div>
                            <?php if (form_error('designation')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('designation'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('commission'); ?><span class="required_star"> *</span></label>
                                <input tabindex="5" autocomplete="off" type="text" name="commission" class="form-control" placeholder="<?php echo lang('commission'); ?>" value="<?php echo escape_output($user_details->commission); ?>">
                                </select>
                            </div>
                            <?php if (form_error('commission')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('commission'); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('salary'); ?><span class="required_star"> *</span></label>
                                <input tabindex="6" autocomplete="off" type="text" name="salary" class="form-control" placeholder="<?php echo lang('salary'); ?>" value="<?php echo escape_output($user_details->salary); ?>">
                                </select>
                            </div>
                            <?php if (form_error('salary')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('salary'); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label> <?php echo lang('photo'); ?> </label>
                                <input type="file" name="photo" class="form-control" value="" id="photo" placeholder="<?php echo lang('photo'); ?>">
                            </div>
                            <?php if (form_error('photo')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('photo'); ?></p>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label> &nbsp; </label><br>
                                <button id="view_photo" type="button" class="btn btn-primary" data-toggle="modal" data-target="#view_photo_modal"><?php echo lang('view_photo'); ?></button>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><input type="checkbox" <?php echo escape_output($user_details->role) && $user_details->role=="Delivery Person"?'checked':''?> name="is_delivery_person" value="Delivery Person"><?php echo lang('ThisisDeliveryPerson'); ?></label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group radio_button_problem">
                                <label><?php echo lang('will_login'); ?> <span class="required_star">*</span></label>
                                <div class="radio">
                                    <label>
                                        <input tabindex="5" autocomplete="off" type="radio" name="will_login" id="will_login_yes" value="Yes" <?php if($user_details->will_login=="Yes"){echo "checked";} ?>><?php echo lang('Yes'); ?> </label>
                                    <label>

                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <input tabindex="5" autocomplete="off" type="radio" name="will_login" id="will_login_no" value="No" <?php if($user_details->will_login=="No"){echo "checked";} ?>><?php echo lang('No'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php if (form_error('will_login')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('will_login'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div id="will_login_section" style="display:<?php if($user_details->will_login=="Yes"){echo "block;";}else{echo "none;";}?>">
                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label><?php echo lang('password'); ?> <span class="required_star">*</span></label>
                                    <input tabindex="5" autocomplete="off" type="text" name="password" class="form-control" placeholder="<?php echo lang('password'); ?>" value="">
                                </div>
                                <?php if (form_error('password')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <span class="error_paragraph"><?php echo form_error('password'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label><?php echo lang('confirm_password'); ?> <span class="required_star">*</span></label>
                                    <input tabindex="4" autocomplete="off" type="text" name="confirm_password" class="form-control" placeholder="<?php echo lang('confirm_password'); ?>" value="">
                                </div>
                                <?php if (form_error('confirm_password')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <span class="error_paragraph"><?php echo form_error('confirm_password'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label"><?php echo lang('menu_access'); ?> <span class="required_star">*</span></label>
                            <div class="col-md-3">
                                <label class="container txt-uh-73"><?php echo lang('select_all'); ?>
                                    <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="clearfix"></div>
                            <span class="error_alert_atleast txt-uh-74"role="alert"></span>
                            <?php
                            $ignoreModule = array();
                            foreach($access_modules as $keys=>$value){
                                if (!in_array($value->main_module_id, $ignoreModule)) {
                                    $ignoreModule[] = $value->main_module_id;
                                    ?>
                                    <div class="col-sm-12">
                                        <table  class="txt-uh-75">
                                            <tbody>
                                            <tr>
                                                <td width="30%">
                                                    <hr class="txt-uh-76">
                                                </td>
                                                <td class="width_10_p c_center"><b
                                                            class="txt-uh-31"><?php echo getMainModuleName($value->main_module_id)?></b></td>
                                                <td width="30%">
                                                    <hr class="txt-uh-76">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="col-sm-12">
                                    <label class="container txt-uh-73"><?php echo "<b>".$value->label_name."</b>"?>
                                        <input class="checkbox_user_p  parent_class parent_class_<?php echo str_replace(' ', '_', $value->module_name)?>" data-name="<?php echo str_replace(' ', '_', $value->module_name)?>" type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>

                                    <hr class="txt-uh-77">
                                </div>
                                <?php
                                foreach($value->functions as $keys_f=>$value_f) {
                                    $checked = '';
                                    $access_id_ = $value_f->id;
                                    if (isset($selected_modules_arr)):
                                        foreach ($selected_modules_arr as $uma) {
                                            if (in_array($access_id_, $selected_modules_arr)) {
                                                $checked = 'checked';
                                            } else {
                                                $checked = '';
                                            }
                                        }
                                    endif;
                                    ?>

                                    <div class="col-md-<?php echo escape_output($value_f->label_name) == "Change Password" ? '3' : '2' ?>">
                                        <label class="container txt-uh-77"><?php echo escape_output($value_f->label_name); ?>
                                            <input type="checkbox" <?php echo escape_output($checked)?> class="checkbox_user child_class child_<?php echo str_replace(' ', '_', $value->module_name)?>" data-parent_name="<?php echo str_replace(' ', '_', $value->module_name)?>" value="<?php echo escape_output($value->id); ?>|<?php echo escape_output($value_f->id); ?>" name="access_id[]">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div  class="txt-uh-79"></div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>User/users"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>

<div id="view_photo_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('photo'); ?></h4>
      </div>
      <div class="modal-body">
        <p class="text-center">
            <?php if (!empty($user_details->photo)) { ?>
               <img class="txt-uh-80"  src="<?php echo base_url().'images/'. $user_details->photo ?>">
            <?php
                }else{
                    echo "<h2>Not Available</h2>";
                }
            ?>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/add_user.js"></script>