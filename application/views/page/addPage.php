<script src="<?php echo base_url() ?>assets/plugins/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>css/custom_check_box.css">
<section class="content-header">
  <h1>
    <?php echo lang('AddPage'); ?>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- form start -->
        <?php
        $attributes = array('id' => 'add_Page');
        echo form_open_multipart(base_url('page/addEditPage/'), $attributes); ?>
        <div class="box-body">
          <div class="row">

            <div class="col-md-12">

              <div class="form-group">
                <label><?= lang('MenuName'); ?><span class="required_star">*</span></label>
                <input tabindex="1" autocomplete="off" type="text" name="menu_name" class="form-control" placeholder="<?php echo lang('MenuName'); ?>" value="<?php echo set_value('menu_name'); ?>">
              </div>
              <?php if (form_error('menu_name')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <span class="error_paragraph"><?= form_error('menu_name'); ?></span>
                </div>
              <?php } ?>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
              <div class="form-group">
                <label> <?php echo lang('MenuContent'); ?><span class="required_star">*</span></label>
                <textarea tabindex="3" class="editor" name="menu_content"><?php echo set_value('menu_content'); ?></textarea>
              </div>
              <?php if (form_error('menu_content')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('menu_content'); ?></p>
                </div>
              <?php } ?>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
            <a href="<?php echo base_url() ?>page/pages"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
</section>


<script src="<?= base_url('assets/plugins/tinymce/jquery.tinymce.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/tinymce/editor-helper.js'); ?>"></script>

<script>
  $(function() {
    simple_editor('.editor', 450);
  });
</script>