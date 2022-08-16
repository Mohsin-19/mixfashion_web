<section class="content">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- form start -->
        <?= form_open('admin/size/add-edit/' . (isset($size) ? $size->id : '')); ?>
        <div class="box-body">
          <h3><?= isset($size) ? lang('edit') : lang('add') . lang('Size'); ?> </h3>

          <div class="form-group">
            <div class="checkbox">
              <label>
                <?php
                $activeDate = date('Y-m-d H:i:s');
                $ActiveChecked = '';
                if (isset($size)) {
                  if ($size->active) {
                    $activeDate = date('Y-m-d H:i:s', strtotime($size->active));
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
            <label for="name">Size name <span class="required_star">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Size Name" value="<?= isset($size) ? $size->name : set_value('name') ?>">
            <?= show_field_error('name'); ?>
          </div>

          <div class="form-group">
            <label for="description">Details</label>
            <textarea name="description" id="description" class="form-control" placeholder="Desciption" rows="4"><?= isset($size) ? $size->description : set_value('description') ?></textarea>
            <?= show_field_error('description'); ?>
          </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" name="submit" value="submit" class="btn btn-primary"><?= lang('submit'); ?></button>
          <a href="<?= site_url('admin/size') ?>" class="btn btn-primary"><?= lang('back'); ?></a>
        </div>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</section>