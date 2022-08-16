<section class="content">
  <div class="row" style="justify-content: center!important;display: flex;">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= lang('add_role'); ?></h3>
        </div> <!-- /.box-header -->

        <?= form_open(site_url('admin/role'), ['role' => 'form']); ?>
        <div class="box-body">

          <div class="form-group">
            <label for="name"> Role name <span class="required_star">*</span> :</label>
            <?= form_input(['name' => 'name', 'id' => 'name', 'class' => 'form-control', 'placeholder' => 'name']) ?>
            <?php if (form_error('name')): ?>
              <div class="alert alert-error txt-uh-21">
                <p><?= form_error('name'); ?></p>
              </div>
            <?php endif; ?>
          </div> <!-- form-group -->

          <div class="form-group">
            <label for="description"> Description :</label>
            <?= form_textarea(['name' => 'description', 'id' => 'description', 'class' => 'form-control', 'placeholder' => 'description', 'rows' => 3]) ?>
            <?php if (form_error('description')): ?>
              <div class="alert alert-error txt-uh-21">
                <p><?= form_error('description'); ?></p>
              </div>
            <?php endif ?>
          </div>

        </div> <!-- /.box-body -->

        <div class="box-footer">
          <div class="form-group">
              <?= form_submit('submit', lang('submit'), ['class' => 'btn btn-primary']); ?>
              <a href="<?= site_url("admin/role") ?>" class="btn btn-danger">
                <?= lang('back'); ?>
              </a>
          </div>
        </div>
        <?= form_close(); ?>
      </div> <!-- box-primary -->
    </div>
  </div>
</section>
