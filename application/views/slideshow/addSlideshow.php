<!--hidden filed use in javascript-->
<input type="hidden" class="file_size_check" value="<?php echo lang('file_size_check'); ?>">
<input type="hidden" class="file_w_h_check" value="<?php echo lang('file_w_h_check'); ?>">


<link rel="stylesheet" href="<?php echo base_url('assets/css/custom_check_box.css') ?>">
<section class="content-header">
  <h1>
    <?php echo lang('add_slideshow'); ?>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- form start -->
        <?php
        $attributes = array('id' => 'add_slideshow');
        echo form_open_multipart(base_url('slideshow/addEditSlideshow/'), $attributes); ?>
        <div class="box-body">
          <div class="row">

            <div class="col-md-4">

              <div class="form-group">
                <label><?php echo lang('title'); ?> <span class="required_star">*</span></label>
                <input tabindex="1" autocomplete="off" type="text" name="title" class="form-control" placeholder="<?php echo lang('title'); ?>" value="<?php echo set_value('title'); ?>">
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
                <input tabindex="1" autocomplete="off" type="text" name="btn_url" class="form-control" placeholder="Link url" value="<?php echo set_value('btn_url'); ?>">
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
                  <option value="Inactive"><?php echo lang('Inactive'); ?></option>
                  <option value="Active"><?php echo lang('Active'); ?></option>
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
                <label> <?php echo lang('photo'); ?> (Width: 950px, Height:260px, Max Size: 350kb) <span class="required_star">*</span></label>
                <input type="file" name="photo" class="form-control" value="" accept="image/*" id="photo" placeholder="<?php echo lang('photo'); ?>">
              </div>
              <?php if (form_error('photo')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('photo'); ?></p>
                </div>
              <?php } ?>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
            <a href="<?php echo base_url() ?>slideshow/slideshows"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
</section>

<script src="<?php echo base_url(); ?>assets/js/slide_show.js"></script>