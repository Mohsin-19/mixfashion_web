<section class="content-header">
  <h1>
    <?php echo isset($Units) ? lang('edit') : lang('add') ?><?php echo lang('unit'); ?>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <!-- form start -->
        <?php echo form_open(site_url('Unit/addEditUnit/' . (isset($Units) ? $this->custom->encrypt_decrypt($Units->id, 'encrypt') : ''))); ?>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Color Name <span class="required_star">*</span></label>
                <input tabindex="1" autocomplete="off" type="text" name="unit_name" class="form-control"
                       placeholder="Color Name"
                       value="<?php echo isset($Units) && $Units ? $Units->unit_name : set_value('unit_name') ?>">
              </div>
              <?php if (form_error('unit_name')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('unit_name'); ?></p>
                </div>
              <?php } ?>

            </div>
            <div class="col-md-6">

              <div class="form-group">
                <label><?php echo lang('description'); ?></label>
                <input tabindex="2" autocomplete="off" name="description" class="form-control"
                       value="<?php echo isset($Units) && $Units ? $Units->description : set_value('description') ?>"
                       placeholder="<?php echo lang('description'); ?>"/>
              </div>
              <?php if (form_error('description')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('description'); ?></p>
                </div>
              <?php } ?>

            </div>

          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
          <a href="<?php echo base_url() ?>Unit/Units">
            <button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button>
          </a>
        </div>
        <?php echo form_close(); ?>
      </div>

    </div>
  </div>
</section>