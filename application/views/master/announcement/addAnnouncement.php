<section class="content-header">
  <h1>
    <?php echo lang('add_announcement'); ?>
  </h1>
</section>

<section class="content">
  <div class="row" style="justify-content: center!important;display: flex;">
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- form start -->
        <?php echo form_open_multipart(base_url('Announcement/addEditAnnouncement'), ['class' => 'form-horizontal']); ?>
        <div class="box-body">

          <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
              <div class="checkbox">
                <label>
                  <?php echo form_checkbox(['name' => 'active', 'value' => date('Y-m-d H:i:s'), 'checked' => 'on']) ?> Active
                </label>
              </div>
              <?php if (form_error('active')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('active'); ?></p>
                </div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label for="title" class="col-sm-4 control-label"> Title <span class="required_star">*</span> :</label>
            <div class="col-sm-8">
              <?php echo form_input(['name' => 'title', 'id' => 'title', 'class' => 'form-control', 'placeholder' => 'title']) ?>
            </div>
            <?php if (form_error('title')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('title'); ?></p>
              </div>
            <?php } ?>
          </div>

          <div class="form-group">
            <label for="description" class="col-sm-4 control-label"> Description :</label>
            <div class="col-sm-8">
              <?php echo form_textarea(['name' => 'description', 'id' => 'description', 'class' => 'form-control editor', 'placeholder' => 'description', 'rows' => 3]) ?>
            </div>
            <?php if (form_error('description')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('description'); ?></p>
              </div>
            <?php } ?>
          </div>

          <div class="form-group">
            <label for="upload_type" class="col-sm-4 control-label"> Announcement Type: </label>
            <div class="col-sm-8">
              <label class="radio-inline">
                <input type="radio" name="upload_type" id="text" value="text" class="upload_type" checked> Normal Text
              </label>
              <label class="radio-inline">
                <input type="radio" name="upload_type" id="img" value="img" class="upload_type"> Image
              </label>
              <label class="radio-inline">
                <input type="radio" name="upload_type" id="yt" value="yt" class="upload_type"> YouTube Video
              </label>
            </div>
            <?php if (form_error('upload_type')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('upload_type'); ?></p>
              </div>
            <?php } ?>
          </div>

          <div class="form-group">
            <label for="image" class="col-sm-4 control-label"> Upload/Video Link <span class="required_star">*</span> : </label>
            <div class="col-sm-8">
              <?php echo form_upload(['name' => 'image', 'id' => 'image', 'class' => 'form-control-static']) ?>
              <?php echo form_input([
                'name' => 'upload_content',
                'id' => 'upload_content',
                'class' => 'form-control',
                'placeholder' => 'video link',
                'value' => set_value('upload_content'),
                'style' => 'display:none',
              ]) ?>

            </div>
            <?php if (form_error('image')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('image'); ?></p>
              </div>
            <?php } ?>
          </div>

          <div class="form-group">
            <label for="end_date" class="col-sm-4 control-label"> Announcement End <span class="required_star">*</span> :</label>
            <div class="col-sm-8">
              <?php echo form_input([
                'name' => 'end_date',
                'id' => 'end_date',
                'class' => 'form-control customDatepickerCustom1',
                'placeholder' => lang('expired_date'),
                'autocomplete' => 'off',
                'tabindex' => '1',
                'value' => set_value('expired_date'),
              ]) ?>
            </div>
            <?php if (form_error('end_date')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('end_date'); ?></p>
              </div>
            <?php } ?>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
              <?php echo form_submit('submit', lang('submit'), ['class' => 'btn btn-primary']); ?>
              <a href="<?php echo site_url("Announcement/index") ?>" class="btn btn-primary"><?php echo lang('back'); ?></a>
            </div>
          </div>

        </div> <!-- /.box-body -->
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
    small_editor('.editor', 300);
  });
</script>

<script>
  $(document).on('change', '.upload_type', function(e) {
    if ($(this).val() === 'img') {
      $('#image').show();
      $('#upload_content').hide();
    } else {
      $('#upload_content').show();
      $('#image').hide();
    }
  });
</script>