<section class="content-header">
  <h1>
    <?php echo lang('EditPage'); ?>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <?php
        $attributes = array('id' => 'add_Page');
        echo form_open_multipart(base_url('Page/addEditPage/' . $encrypted_id), $attributes); ?>
        <div class="box-body">
          <div class="form-group">
            <label><?= lang('MenuName'); ?><span class="required_star">*</span></label>
            <input tabindex="1" autocomplete="off" type="text" name="menu_name" class="form-control" placeholder="<?php echo lang('MenuName'); ?>" value="<?= escape_output($page->menu_name); ?>">
            <?php if (form_error('menu_name')) : ?>
              <div class="alert alert-error txt-uh-21">
                <span class="error_paragraph"><?= form_error('menu_name'); ?></span>
              </div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label> <?php echo lang('MenuContent'); ?> <span class="required_star">*</span></label>
            <textarea tabindex="3" class="editor" name="menu_content"><?= escape_output($page->menu_content); ?></textarea>
            <?php if (form_error('menu_content')) : ?>
              <div class="alert alert-error txt-uh-21">
                <span class="error_paragraph"><?= form_error('menu_content'); ?></span>
              </div>
            <?php endif; ?>
          </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
          <a href="<?php echo base_url() ?>Page/pages"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
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


<script src="<?= base_url('assets/plugins/tinymce/jquery.tinymce.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/tinymce/editor-helper.js'); ?>"></script>

<script>
  $(function() {
    simple_editor('.editor', 450);
  });
</script>