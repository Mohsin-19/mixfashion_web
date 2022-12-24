<link rel="stylesheet" href="<?php echo base_url('assets/') ?>buttonCSS/checkBotton.css">
<section class="content-header">
  <h1>
    <?php echo lang('EditArea'); ?>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">

        <?php
        $attributes = array('id' => 'add_Area');
        echo form_open_multipart(base_url('Area/addEditArea/' . $encrypted_id), $attributes); ?>
        <div class="box-body">
          <div class="row">

            <div class="col-md-4">
              <div class="form-group">
                <label><?php echo lang('AreaName'); ?> <span class="required_star">*</span></label>
                <input tabindex="1" autocomplete="off" type="text" name="name" class="form-control" placeholder="Area Name"
                       value="<?php echo escape_output($area->name); ?>">
              </div>
              <?php if (form_error('name')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                </div>
              <?php } ?>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="charge_type">Charge type <span class="required_star">*</span></label>
                <select name="charge_type" class="form-control" id="charge_type">
                  <option value="flat_charge">Flat Delivery Charge</option>
                  <option value="avg_charge">Average Delivery Charge</option>
                </select>
              </div>
              <?php if (form_error('charge_type')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <span class="error_paragraph"><?php echo form_error('charge_type'); ?></span>
                </div>
              <?php } ?>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label><?= lang('DeliveryCharge'); ?> <span class="required_star">*</span></label>
                <input tabindex="1" autocomplete="off" type="text" name="delivery_charge" class="form-control"
                       placeholder="<?= lang('DeliveryCharge'); ?>" value="<?php echo escape_output($area->delivery_charge); ?>">
              </div>
              <?php if (form_error('delivery_charge')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <span class="error_paragraph"><?php echo form_error('delivery_charge'); ?></span>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
          <a href="<?php echo base_url() ?>Area/area">
            <button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button>
          </a>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</section>