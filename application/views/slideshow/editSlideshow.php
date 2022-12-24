<!--hidden filed use in javascript-->
<input type="hidden" class="file_size_check" value="<?php echo lang('file_size_check'); ?>">
<input type="hidden" class="file_w_h_check" value="<?php echo lang('file_w_h_check'); ?>">

<link rel="stylesheet" href="<?php echo base_url('assets/') ?>buttonCSS/checkBotton.css">
<section class="content-header">
    <h1>
        <?php echo lang('edit_slideshow'); ?>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <?php //echo form_open(base_url('Slideshow/addEditUser/' . $encrypted_id)); ?>

                <?php
                $attributes = array('id' => 'add_slideshow');
                echo form_open_multipart(base_url('Slideshow/addEditSlideshow/' . $encrypted_id), $attributes); ?>
                <div class="box-body">
                    <div class="row">


                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('title'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="title" class="form-control" placeholder="<?php echo lang('title'); ?>" value="<?php echo escape_output($slide->title); ?>">
                            </div>
                            <?php if (form_error('title')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('title'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label>Url <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="btn_url" class="form-control" placeholder="Url" value="<?php echo escape_output($slide->btn_url); ?>">
                            </div>
                            <?php if (form_error('btn_url')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('btn_url'); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('status'); ?></label>
                                <select name="active_status" id="active_status" class="form-control">
                                    <option <?php echo isset($slide->active_status) && $slide->active_status && $slide->active_status=="Inactive"?'selected':''?> value="Inactive">Inactive</option>
                                    <option <?php echo isset($slide->active_status) && $slide->active_status && $slide->active_status=="Active"?'selected':''?> value="Active">Active</option>
                                </select>
                            </div>
                            <?php if (form_error('active_status')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <span class="error_paragraph"><?php echo form_error('active_status'); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label> <?php echo lang('photo'); ?> (Width: 950px, Height:260px, Max Size: 350kb) <span class="required_star">*</span></label><a href="<?php echo base_url()?>slide images/<?php echo escape_output($slide->photo); ?>" class="btn btn-xs btn-primary pull-right show_preview"><?php echo lang('show'); ?></a>
                                <input type="file" name="photo"  class="form-control" value=""  accept="image/*" id="photo" placeholder="<?php echo lang('photo'); ?>">
                                <input type="hidden" name="old_photo" class="form-control" value="<?php echo escape_output($slide->photo); ?>"   id="old_photo">
                            </div>
                            <?php if (form_error('photo')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('photo'); ?></p>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>Slideshow/slideshows"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="logo_preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <img class="width_100_p" src="" id="show_id">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/slide_show.js"></script>

