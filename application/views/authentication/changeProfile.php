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
        <?php echo lang('change_profile'); ?>
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
                <?php 
                $attributes = array('id' => 'change_profile');
                echo form_open_multipart(base_url('Authentication/changeProfile/' . (isset($encrypted_id) && $encrypted_id?$encrypted_id:'')), $attributes); ?>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="full_name" class="form-control" placeholder="<?php echo lang('name'); ?>" value="<?php echo isset($profile_info) && $profile_info->full_name ? $profile_info->full_name : set_value('full_name') ?>">
                            </div>
                            <?php if (form_error('full_name')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('full_name'); ?></span>
                                </div>
                            <?php } ?>
                        </div>


                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('email_address'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" autocomplete="off" type="text" name="email_address" class="form-control" placeholder="<?php echo lang('email_address'); ?>" value="<?php echo isset($profile_info) && $profile_info->email_address ? $profile_info->email_address : set_value('email_address') ?>">
                            </div>
                            <?php if (form_error('email_address')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('email_address'); ?></span>
                                </div>
                            <?php } ?>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('phone'); ?> </label>
                                <input tabindex="2" autocomplete="off" type="text" name="phone" class="form-control integerchk" placeholder="<?php echo lang('phone'); ?>" value="<?php echo isset($profile_info) && $profile_info->phone ? $profile_info->phone : set_value('phone') ?>">
                            </div>
                            <?php if (form_error('phone')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                                </div>
                            <?php } ?>
                        </div> 
                    </div>

                    <div class="row">
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
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
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
            <?php if (!empty($profile_info->photo)) { ?>
               <img class="txt-uh-22"  src="<?php echo base_url().'images/'. $profile_info->photo ?>">
            <?php 
                }else{ 
                    echo "<h2>".lang('NotAvailable')."</h2>";
                } 
            ?>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('Close'); ?></button>
      </div>
    </div>

  </div>
</div> 