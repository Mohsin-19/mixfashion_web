<section class="content">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- form start -->
        <?= form_open_multipart('admin/color/add-edit/' . (isset($color) ? $color->id : '')); ?>
        <div class="box-body">
          <h3><?= isset($color) ? lang('edit') : lang('add') . lang('Color'); ?> </h3>

          <div class="form-group">
            <div class="checkbox">
              <label>
                <?php
                $activeDate = date('Y-m-d H:i:s');
                $ActiveChecked = '';
                if (isset($color)) {
                  if ($color->active) {
                    $activeDate = date('Y-m-d H:i:s', strtotime($color->active));
                    $ActiveChecked = 'checked';
                  }
                }
                ?>
                <input type="checkbox" name="active" value="<?= $activeDate ?>" checked="<?= $ActiveChecked ?>"> Active
              </label>
            </div>
            <?= show_field_error('name'); ?>
          </div>

          <div class="form-group">
            <label for="name">Color name <span class="required_star">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Color Name" value="<?= isset($color) ? $color->name : set_value('name') ?>">
            <?= show_field_error('name'); ?>
          </div>

          <div class="form-group">
            <label for="color_code">Color code</label>
            <input type="color" name="color_code" id="color_code" class="form-control" placeholder="Color code" value="<?= isset($color) ? $color->color_code : set_value('color_code') ?>">
            <?= show_field_error('color_code'); ?>
          </div>

          <div class="form-group">
            <label for="color_image">Color Image</label>
            <input type="hidden" name="old_color_image" value="<?= isset($color) ? $color->color_image : '' ?>">
            <input type="file" name="color_image" id="color_image" class="form-control">
            <?= show_field_error('color_image'); ?>
          </div>

          <div class="form-group">
            <?php
            $checkColor = 'checked="checked"';
            $checkImage = '';
            if (isset($color)) {
              if ($color->color_option == 'image') {
                $checkColor = '';
                $checkImage = 'checked="checked"';
              }
            }
            ?>
            <div class="radio">
              <label>
                <input type="radio" name="color_option" id="code" value="color" <?= $checkColor ?>>
                Show color
              </label>
              <label style="margin-left: 15px;">
                <input type="radio" name="color_option" id="image" value="image" <?= $checkImage ?>>
                Show color image
              </label>
            </div>
            <?= show_field_error('color_option'); ?>
          </div>

          <div class="form-group">
            <label for="description">Details</label>
            <textarea name="description" id="description" class="form-control" placeholder="Desciption" rows="4"><?= isset($color) ? $color->description : set_value('description') ?></textarea>
            <?= show_field_error('description'); ?>
          </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" name="submit" value="submit" class="btn btn-primary"><?= lang('submit'); ?></button>
          <a href="<?= site_url('admin/color') ?>" class="btn btn-primary"><?= lang('back'); ?></a>
        </div>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</section>