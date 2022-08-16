<!--hidden filed use in javascript-->
<input type="hidden" class="top_banner_image_msg_size" value="<?php echo lang('top_banner_image_msg_size'); ?>">
<input type="hidden" class="top_banner_image_msg" value="<?php echo lang('top_banner_image_msg'); ?>">
<input type="hidden" class="bottom_left_right_banner_image_msg" value="<?php echo lang('bottom_left_right_banner_image_msg'); ?>">

<section class="content-header">
  <h1>
    <?php echo lang('edit_product_category'); ?>
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
        <?php echo form_open(base_url() . 'Category/addEditItemCategory/' . $encrypted_id, $arrayName = array('id' => 'edit_category', 'enctype' => 'multipart/form-data')) ?>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3">

              <div class="form-group">
                <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                <input tabindex="1" autocomplete="off" type="text" name="name" class="form-control" placeholder="<?php echo lang('name'); ?>" value="<?php echo escape_output($category_information->name); ?>">
              </div>
              <?php if (form_error('name')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('name'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('SpecialCategory'); ?></label>
                <?php
                $options = ['No' => 'No', 'Yes' => 'Yes', 'Both' => 'Both'];
                echo form_dropdown('special_category', $options, $category_information->special_category, ['class' => 'form-control select2 width_100_p']);
                ?>
                <?php if (form_error('special_category')) { ?>
                  <div class="alert alert-error txt-uh-21">
                    <p><?php echo form_error('special_category'); ?></p>
                  </div>
                <?php } ?>
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('Icon'); ?> (Width: 50px, Height:50px, Max Size: 100kb)</label><a data-file_path="<?php echo escape_output($category_information->icon); ?>" data-id="2" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="file" accept="image/*" name="icon" class="form-control" id="icon" placeholder="<?php echo lang('icon'); ?>">
              </div>
              <?php if (form_error('icon')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('icon'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('top_banner'); ?> (Width: 1170px, Height:150px, Max Size: 200kb)</label><a data-file_path="<?php echo escape_output($category_information->top_banner); ?>" data-id="2" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="file" accept="image/*" name="top_banner" class="form-control" id="top_banner" placeholder="<?php echo lang('top_banner'); ?>">
                <input type="hidden" name="old_icon" value="<?php echo escape_output($category_information->icon); ?>">
                <input type="hidden" name="old_top_banner" value="<?php echo escape_output($category_information->top_banner); ?>">
                <input type="hidden" name="old_bottom_left_banner" value="<?php echo escape_output($category_information->bottom_left_banner); ?>">
                <input type="hidden" name="old_bottom_top_banner" value="<?php echo escape_output($category_information->bottom_top_banner); ?>">
                <input type="hidden" name="old_bottom_right_banner" value="<?php echo escape_output($category_information->bottom_right_banner); ?>">
              </div>
              <?php if (form_error('top_banner')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('top_banner'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <label> Left sidebar banner (Width: 300px, Height:417px, Max Size: 200kb)</label>
                <a data-file_path="<?php echo escape_output($category_information->bottom_left_banner); ?>" data-id="2" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="file" accept="image/*" name="bottom_left_banner" class="form-control" id="bottom_left_banner" placeholder="<?php echo lang('bottom_left_banner'); ?>">
              </div>
              <?php if (form_error('bottom_left_banner')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('bottom_left_banner'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="col-md-10">
              <div class="form-group">
                <label><?php echo lang('description'); ?></label>
                <textarea name="description" class="form-control editor" rows="5" placeholder="<?= lang('description'); ?>"><?= set_value('description', html_entity_decode($category_information->description)); ?></textarea>
              </div>
            </div>

            <div class="clearfix"></div>
            <!-- <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('bottom_top_banner'); ?> (Width: 690px, Height:280px, Max Size: 200kb)</label><a data-file_path="<?php echo escape_output($category_information->bottom_top_banner); ?>" data-id="2" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="file" accept="image/*" name="bottom_top_banner" class="form-control" id="bottom_top_banner" placeholder="<?php echo lang('bottom_top_banner'); ?>">
              </div>
              <?php if (form_error('bottom_top_banner')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('bottom_top_banner'); ?></p>
                </div>
              <?php } ?>
            </div> -->
            <div class="clearfix"></div>
            <!-- <div class="col-md-6">
              <div class="form-group">
                <label> <?php echo lang('bottom_right_banner'); ?> (Width: 690px, Height:280px, Max Size: 200kb)</label><a data-file_path="<?php echo escape_output($category_information->bottom_right_banner); ?>" data-id="2" class="btn btn-xs btn-primary pull-right show_preview" href="#"><?php echo lang('Show'); ?></a>
                <input type="file" accept="image/*" name="bottom_right_banner" class="form-control" id="bottom_right_banner" placeholder="<?php echo lang('bottom_right_banner'); ?>">
              </div>
              <?php if (form_error('bottom_right_banner')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('bottom_right_banner'); ?></p>
                </div>
              <?php } ?>
            </div> -->

          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
          <a href="<?php echo base_url() ?>Category/productCategories">
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

<script src="<?= base_url('assets/plugins/tinymce/jquery.tinymce.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/tinymce/editor-helper.js'); ?>"></script>

<script>
  $(function() {
    small_editor('.editor', 300);
  });
</script>