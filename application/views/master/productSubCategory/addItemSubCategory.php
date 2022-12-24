<section class="content-header">
  <h1>
    <?php echo lang('add_product_subcategory'); ?>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- form start -->
        <?php echo form_open_multipart('SubCategory/addEditItemSubCategory') ?>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3">

              <div class="form-group">
                <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                <input tabindex="1" autocomplete="off" type="text" name="name" class="form-control" placeholder="<?php echo lang('name'); ?>"
                       value="<?php echo set_value('name'); ?>">
              </div>
              <?php if (form_error('name')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('name'); ?></p>
                </div>
              <?php } ?>
            </div>
            <div class="col-md-3">

              <div class="form-group">
                <label><?php echo lang('category'); ?> <span class="required_star">*</span></label>
                <select tabindex="2" name="cat_id" class="form-control select2 width_100_p">
                  <option value=""><?php echo lang('select'); ?></option>
                  <?php
                  foreach ($categories as $value):
                    if ($value->special_category != "Yes"):
                      ?>
                      <option value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->name); ?></option>
                    <?php
                    endif;
                  endforeach;
                  ?>
                </select>
                <?php if (form_error('cat_id')) { ?>
                  <div class="alert alert-error txt-uh-21">
                    <p><?php echo form_error('cat_id'); ?></p>
                  </div>
                <?php } ?>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label><?php echo lang('description'); ?></label>
                <input tabindex="5" autocomplete="off" type="text" name="description" class="form-control"
                       placeholder="<?php echo lang('description'); ?>" value="<?php echo set_value('description'); ?>">
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('Icon'); ?> (Width: 180px, Height:140px, Max Size: 100kb)</label>
                <input type="file" accept="image/*" name="icon" class="form-control" id="icon"
                       placeholder="<?php echo lang('Icon'); ?>">
              </div>
              <?php if (form_error('icon')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('icon'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="clearfix"></div>

          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
          <a href="<?php echo base_url() ?>SubCategory/productSubCategories">
            <button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button>
          </a>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</section>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<script src="<?php echo base_url() ?>assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/add_item_cat.js"></script>