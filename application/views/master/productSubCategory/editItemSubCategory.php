<section class="content-header">
  <h1>
    <?php echo lang('edit_product_subcategory'); ?>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">

      <?php if ($this->session->flashdata('flashExists')) : ?>
        <div class="alert alert-danger" role="alert">
          <?= $this->session->flashdata('flashExists') ?>
        </div>
      <?php endif; ?>

      <!-- general form elements -->
      <div class="box box-primary">
        <!-- form start -->
        <?php echo form_open_multipart(base_url('SubCategory/addEditItemSubCategory/' . $encrypted_id)); ?>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3">

              <div class="form-group">
                <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                <input tabindex="1" autocomplete="off" type="text" name="name" class="form-control" placeholder="<?php echo lang('name'); ?>" value="<?php echo escape_output($SubCategory_information->name); ?>">
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
                                  foreach ($categories as $value) :
                                    if ($value->special_category != "Yes") :
                  ?>
                      <option <?php echo isset($SubCategory_information->cat_id) && $SubCategory_information->cat_id && $SubCategory_information->cat_id == $value->id ? 'selected' : '' ?> value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->name); ?></option>
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

            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('description'); ?></label>
                <input tabindex="5" autocomplete="off" type="text" name="description" class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?php echo escape_output($SubCategory_information->description); ?>">
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('Icon'); ?> (Width: 50px, Height:50px, Max Size: 100kb)</label><a data-file_path="<?php echo escape_output($SubCategory_information->icon); ?>" data-id="2" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="file" accept="image/*" name="icon" class="form-control" id="icon" placeholder="<?php echo lang('icon'); ?>">
                <input type="hidden" name="old_icon" value="<?php echo escape_output($SubCategory_information->icon); ?>">
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
          <a href="<?php echo site_url('SubCategory/productSubCategories') ?>">
            <button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button>
          </a>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</section>



<div class="modal fade" id="showPreviewImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header txt-uh-25">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
      </div>
      <div class="modal-body txt-uh-26">
        <div class="row">
          <div class="col-md-12 txt-uh-100">
            <img class="txt-uh-101" src="" id="show_id1">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
      </div>
    </div>

  </div>
</div>


<link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<script src="<?php echo base_url() ?>assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/add_item_cat.js"></script>