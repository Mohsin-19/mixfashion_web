<!--hidden filed use in javascript-->
<input type="hidden" class="select_" value="<?php echo lang('select'); ?>">
<input type="hidden" class="img_select_error_msg" value="<?php echo lang('img_select_error_msg'); ?>">
<input type="hidden" name="base_url_ajax" id="base_url_ajax" class="base_url_ajax" value="<?php echo base_url() ?>">
<script src="<?php echo base_url(); ?>assets/bower_components/crop/croppie.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/crop/croppie.css">

<section class="content-header">
  <h1>
    <?php echo lang('add_product'); ?>
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
      <?= validation_errors('<div class="alert alert-danger" style="padding: 12px;margin-bottom: 8px;">', '</div>'); ?>
    </div>
  </div>
  <div class="row">
    <!-- general form elements -->
    <div class="box box-primary">
      <?php echo form_open(base_url() . 'Item/addEditItem', $arrayName = array('id' => 'product_form', 'enctype' => 'multipart/form-data')) ?>
      <div class="box-body">
        <div class="row">
          <div class="col-md-3 display_none">
            <div class="form-group">
              <label><?php echo lang('type'); ?></label>
              <select tabindex="100" class="form-control select2 check_type width_100_p" id="type" name="type">
                <option value="1" <?php echo set_select('type', 1); ?>><?php echo lang('product'); ?></option>
                <option value="2" <?php echo set_select('type', 2); ?>><?php echo lang('service'); ?></option>
              </select>
            </div>
            <?php if (form_error('type')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('type'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
              <input tabindex="1" autocomplete="off" type="text" id="name" name="name" class="form-control" placeholder="<?php echo lang('name_placeholder_1'); ?>" value="<?php echo set_value('name'); ?>">
            </div>
            <?php if (form_error('name')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('name'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('NameinYourLanguage'); ?> </label>
              <input tabindex="2" autocomplete="off" type="text" id="name_for_your" name="name_for_your" class="form-control" placeholder="<?php echo lang('name_placeholder_2'); ?>" value="<?php echo set_value('name_for_your'); ?>">
            </div>
            <?php if (form_error('name_for_your')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('name_for_your'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('NameinPeopleLanguage'); ?></label>
              <input tabindex="3" autocomplete="off" type="text" id="name_for_people" name="name_for_people" class="form-control" placeholder="<?php echo lang('name_placeholder_3'); ?>" value="<?php echo set_value('name_for_people'); ?>">
            </div>
            <?php if (form_error('name_for_people')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('name_for_people'); ?></p>
              </div>
            <?php } ?>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('sale_price'); ?> <span class="required_star">*</span></label>
              <table class="width_100_p">
                <tr>
                  <td><input tabindex="4" autocomplete="off" type="text" onfocus="this.select();" id="sale_price" name="sale_price" class="form-control integerchk" placeholder="<?= lang('sale_price'); ?>" value="<?php echo set_value('sale_price'); ?>"></td>
                  <td class="width_1_p c_txt_right"> <span class="label_aligning_total_loss">
                      <?= escape_output($this->session->userdata('currency')); ?>
                    </span></td>
                  <td class="txt-uh-43" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('guide_sale_price'); ?>">
                    <i data-feather="info" class="width_18_px"></i>
                  </td>
                </tr>
              </table>
            </div>
            <?php if (form_error('sale_price')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('sale_price'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('purchase_price'); ?> <span class="required_star">*</span></label>
              <table class="width_100_p">
                <tr>
                  <td><input tabindex="5" autocomplete="off" type="text" onfocus="this.select();" id="purchase_price" name="purchase_price" class="form-control integerchk disable_service" placeholder="<?php echo lang('purchase_price'); ?>" value="<?php echo set_value('purchase_price'); ?>"></td>
                  <td class="width_1_p c_txt_right"> <span class="label_aligning_total_loss">
                      <?php echo escape_output($this->session->userdata('currency')); ?>
                    </span></td>

                  <td data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('guide_purchase_price'); ?>" class="txt-uh-43">
                    <i data-feather="info" class="width_18_px"></i>
                  </td>
                </tr>
              </table>
            </div>
            <?php if (form_error('purchase_price')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('purchase_price'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('opening_stock'); ?> </label>
              <table class="width_100_p">
                <tr>
                  <td><input tabindex="6" autocomplete="off" type="text" onfocus="this.select();" id="opening_stock" name="opening_stock" class="form-control integerchk disable_service" placeholder="<?php echo lang('opening_stock'); ?>" value="<?php echo set_value('opening_stock'); ?>"></td>
                  <td class="width_1_p c_txt_right"> <span class="label_aligning_total_loss">
                      <?php echo escape_output($this->session->userdata('currency')); ?>
                    </span></td>

                  <td class="txt-uh-43" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('guide_opening_stock'); ?>">
                    <i data-feather="info" class="width_18_px"></i>
                  </td>
                </tr>
              </table>
            </div>
            <?php if (form_error('opening_stock')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('opening_stock'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('code'); ?> <span class="required_star">*</span></label>
              <input tabindex="7" autocomplete="off" type="text" onfocus="select();" id="code_" name="code" class="form-control" placeholder="<?php echo lang('code'); ?>" value="<?php echo escape_output($autoCode) ?>">
              <?php if (form_error('code')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('code'); ?></p>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('supplier'); ?></label>
              <table class="width_100_p">
                <tr>
                  <td width="95.5%">
                    <select tabindex="9" class="form-control disable_service select2 width_100_p" id="supplier_id" name="supplier_id">
                      <option value=""><?php echo lang('select'); ?></option>
                      <?php
                      foreach ($suppliers as $splrs) {
                      ?>
                        <option value="<?php echo escape_output($splrs->id) ?>" <?php echo set_select('supplier_id', $splrs->id); ?>><?php echo escape_output($splrs->name) ?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td class="txt-uh-44"><i class="fa fa-plus add_supplier_by_ajax"></i></td>
                </tr>
              </table>

            </div>
            <?php if (form_error('supplier_id')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('supplier_id'); ?></p>
              </div>
            <?php } ?>
            <div class="alert alert-error error-msg supplier_id_err_msg_contnr txt-uh-21">
              <p id="supplier_id_err_msg"></p>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('category'); ?> <span class="required_star">*</span></label>
              <select tabindex="8" class="form-control select2 width_100_p" id="category_id" name="category_id">
                <option value=""><?php echo lang('select'); ?></option>
                <?php foreach ($categories as $ctry) { ?>
                  <option value="<?php echo escape_output($ctry->id) ?>" <?php echo set_select('category_id', $ctry->id); ?>><?php echo escape_output($ctry->name) ?></option>
                <?php } ?>
              </select>

            </div>
            <?php if (form_error('category_id')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('category_id'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('Subcategory'); ?></label>
              <select tabindex="9" class="form-control select2 width_100_p" id="subcategory_id" name="subcategory_id">
                <option value=""><?php echo lang('select'); ?></option>
                <?php foreach ($subcategories as $ctry) { ?>
                  <option value="<?php echo escape_output($ctry->id) ?>" <?php echo set_select('subcategory_id', $ctry->id); ?>><?php echo escape_output($ctry->name) ?></option>
                <?php } ?>
              </select>
            </div>
            <?php if (form_error('subcategory_id')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('subcategory_id'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('purchase_unit'); ?> <span class="required_star">*</span></label>

              <table width="100%">
                <tr>
                  <td><select tabindex="10" class="form-control select2 disable_service width_100_p" id="purchase_unit_id" name="purchase_unit_id">
                      <option value=""><?php echo lang('select'); ?></option>
                      <?php foreach ($units as $value) { ?>
                        <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('purchase_unit_id', $value->id); ?>><?php echo escape_output($value->unit_name) ?></option>
                      <?php } ?>
                    </select></td>
                  <td class="txt-uh-44"><i class="fa fa-plus add_purchase_unit_by_ajax"></i></td>
                  <td class="txt-uh-43" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('guide_purchase_unit'); ?>"><i data-feather="info" class="width_18_px"></i></td>
                </tr>
              </table>
            </div>
            <?php if (form_error('purchase_unit_id')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('purchase_unit_id'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('sale_unit'); ?> <span class="required_star">*</span></label>
              <table width="100%">
                <tr>
                  <td>
                    <select tabindex="11" class="form-control select2 disable_service width_100_p" id="sale_unit_id" name="sale_unit_id">
                      <option value=""><?php echo lang('select'); ?></option>
                      <?php foreach ($units as $value) { ?>
                        <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('sale_unit_id', $value->id); ?>><?php echo escape_output($value->unit_name) ?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td class="txt-uh-44"><i class="fa fa-plus add_sale_unit_by_ajax"></i></td>
                  <td class="txt-uh-43" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('guide_sale_unit'); ?>"><i data-feather="info" class="width_18_px"></i></td>
                </tr>
              </table>
            </div>
            <?php if (form_error('sale_unit_id')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('sale_unit_id'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('conversion_rate'); ?> <span class="required_star">*</span></label>
              <table width="100%">
                <tr>
                  <td>
                    <input tabindex="12" type="text" id="conversion_rate" autocomplete="off" name="conversion_rate" class="form-control integerchk disable_service check_sale_purchase_unit" placeholder="<?php echo lang('conversion_rate'); ?>" value="<?php echo set_value('conversion_rate'); ?>">
                  </td>
                  <td class="txt-uh-43" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('guide_conversion_rate'); ?>">
                    <i data-feather="info" class="width_18_px"></i>
                  </td>
                </tr>
              </table>

            </div>
            <?php if (form_error('conversion_rate')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('conversion_rate'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('alert_quantity'); ?> <span class="required_star">*</span></label>

              <table class="width_100_p">
                <tr>
                  <td><input tabindex="13" autocomplete="off" type="text" id="alert_quantity" name="alert_quantity" class="form-control disable_service" placeholder="<?php echo lang('alert_quantity'); ?>" value="<?php echo set_value('alert_quantity'); ?>"></td>
                  <td class="width_1_p c_txt_right"></td>
                  <td class="txt-uh-45" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('in_sale_unit'); ?>"><i data-feather="info" class="width_18_px"></i></td>
                </tr>
              </table>
            </div>
            <?php if (form_error('alert_quantity')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('alert_quantity'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('description'); ?></label>
              <input tabindex="14" autocomplete="off" type="text" id="description" name="description" class="form-control" placeholder="<?php echo lang('description_placeholder'); ?>" value="<?php echo set_value('description'); ?>">
            </div>
            <?php if (form_error('description')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('description'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('available'); ?></label>
              <select tabindex="15" class="form-control select2 width_100_p" id="available" name="available">
                <option value="Yes" <?php echo set_select('available', "Yes"); ?>><?php echo lang('Yes'); ?></option>
                <option value="No" <?php echo set_select('available', "No"); ?>><?php echo lang('No'); ?></option>
              </select>
            </div>
            <?php if (form_error('available')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('available'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('discount_price'); ?></label>
              <input tabindex="16" autocomplete="off" type="text" onfocus="this.select();" id="discount_price" name="discount_price" class="form-control integerchk discount_price" placeholder="<?php echo lang('discount_price'); ?>" value="<?php echo set_value('discount_price'); ?>">

            </div>
            <?php if (form_error('discount_price')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('discount_price'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('has_offer'); ?></label>
              <table class="width_100_p">
                <tr>
                  <td>
                    <select tabindex="17" class="form-control select2 width_100_p" id="has_offer" name="has_offer">
                      <option value="No" <?php echo set_select('has_offer', "No"); ?>><?php echo lang('No'); ?></option>
                      <option value="Yes" <?php echo set_select('has_offer', "Yes"); ?>><?php echo lang('Yes'); ?></option>
                    </select>
                  </td>
                  <td class="width_1_p c_txt_right"></td>
                  <td class="txt-uh-45" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('tooltip_has_offer'); ?>"><i data-feather="info" class="width_18_px"></i></td>
                </tr>
              </table>


            </div>
            <?php if (form_error('has_offer')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('has_offer'); ?></p>
              </div>
            <?php } ?>
          </div>
          <?php
          $set_value = set_value('has_offer');
          ?>
          <div class="col-md-3 offer_div" style="display: <?php echo isset($set_value) && $set_value == "Yes" ? '' : 'none' ?>">
            <div class="form-group">
              <label><?php echo lang('details_modal_image'); ?></label>
              <input tabindex="18" autocomplete="off" accept="image/*" type="file" id="details_modal_image" name="details_modal_image" class="form-control">
            </div>
            <?php if (form_error('details_modal_image')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('details_modal_image'); ?></p>
              </div>
            <?php } ?>
          </div>
          <?php
          $set_value = set_value('has_offer');
          ?>
          <div class="col-md-3 offer_div" style="display: <?php echo isset($set_value) && $set_value == "Yes" ? '' : 'none' ?>">
            <div class="form-group">
              <label><?php echo lang('offer'); ?></label>
              <textarea tabindex="18" autocomplete="off" type="text" id="offer" name="offer" class="form-control" placeholder="<?php echo lang('offer'); ?>"><?php echo set_value('offer'); ?></textarea>
            </div>
            <?php if (form_error('offer')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('offer'); ?></p>
              </div>
            <?php } ?>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label><?php echo lang('ManageStock'); ?></label>

              <table class="width_100_p">
                <tr>
                  <td>
                    <select tabindex="19" class="form-control select2 width_100_p" id="manage_stock" name="manage_stock">
                      <option value="Yes" <?php echo set_select('manage_stock', "Yes"); ?> <?php echo isset($product_details->manage_stock) && $product_details->manage_stock && $product_details->manage_stock == "Yes" ? 'selected' : '' ?>><?php echo lang('Yes'); ?></option>
                      <option value="No" <?php echo set_select('manage_stock', "No"); ?> <?php echo isset($product_details->manage_stock) && $product_details->manage_stock && $product_details->manage_stock == "No" ? 'selected' : '' ?>><?php echo lang('No'); ?></option>
                    </select>
                  </td>
                  <td class="width_1_p c_txt_right"></td>
                  <td class="txt-uh-45" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('tooltip_manage_stock'); ?>"><i data-feather="info" class="width_18_px"></i></td>
                </tr>
              </table>
            </div>
            <?php if (form_error('manage_stock')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('manage_stock'); ?></p>
              </div>
            <?php } ?>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label for="order_limit">Order Limit <span class="required_star">*</span></label>

              <table class="width_100_p">
                <tr>
                  <td>
                    <?php
                    echo form_input([
                      'type' => 'number',
                      'name' => 'order_limit',
                      'id' => 'order_limit',
                      'min' => 0,
                      'max' => 1000,
                      'value' => 50,
                      'class' => 'form-control'
                    ]);
                    ?>
                  </td>
                  <td class="width_1_p c_txt_right"></td>
                  <td class="txt-uh-45" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('tooltip_manage_stock'); ?>"><i data-feather="info" class="width_18_px"></i></td>
                </tr>
              </table>
            </div>
            <?php if (form_error('order_limit')) { ?>
              <div class="alert alert-error txt-uh-21">
                <p><?php echo form_error('order_limit'); ?></p>
              </div>
            <?php } ?>
          </div>
          <div class="clearfix"></div>

          <div class="col-md-12">

            <div class="row">

              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-6">
                    <label for="galary_image_1">
                      <span type="button" class="btn btn-primary txt-uh-47" id="">
                        <i data-feather="plus" class="txt-uh-46"></i> galary_image_1</span>
                    </label>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <img src="" class="img-responsive border s_photo fas fa-file-photo-o fa-4x" style="width:50px; display: inline;">
                      <input type="file" accept="image/*" name="galary_image_1" class="image" id="galary_image_1" style=" display: none;">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-6">
                    <label for="galary_image_2">
                      <span type="button" class="btn btn-primary txt-uh-47" id="">
                        <i data-feather="plus" class="txt-uh-46"></i> galary_image_2</span>
                    </label>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <img src="" class="img-responsive border s_photo fas fa-file-photo-o fa-4x" style="width:50px; display: inline;">
                      <input type="file" accept="image/*" name="galary_image_2" class="image" id="galary_image_2" style=" display: none;">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-6">
                    <label for="galary_image_3">
                      <span type="button" class="btn btn-primary txt-uh-47" id="">
                        <i data-feather="plus" class="txt-uh-46"></i> galary_image_3</span>
                    </label>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <img src="" class="img-responsive border s_photo fas fa-file-photo-o fa-4x" style="width:50px; display: inline;">
                      <input type="file" accept="image/*" name="galary_image_3" class="image" id="galary_image_3" style=" display: none;">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-6">
                    <label for="galary_image_4">
                      <span type="button" class="btn btn-primary txt-uh-47" id="">
                        <i data-feather="plus" class="txt-uh-46"></i> Galary_image_4</span>
                    </label>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <img src="" class="img-responsive border s_photo fas fa-file-photo-o fa-4x" style="width:50px; display: inline;">
                      <input type="file" accept="image/*" name="galary_image_4" class="image" id="galary_image_4" style=" display: none;">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--  -->
          <div class="col-md-3">
            <div class="form-group">
              <label for="image">
                <span type="button" class="btn btn-primary txt-uh-47" id="">
                  <i data-feather="plus" class="txt-uh-46"></i> <?php echo lang('add_image'); ?></span>
              </label>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <img src="" class="img-responsive border s_photo fas fa-file-photo-o fa-4x" style="height:180px; display: inline;">
              <input type="file" accept="image/*" name="photo" class="image" id="image" style=" display: none;">
            </div>
          </div>
          <!--  -->
        </div>

        <?php $collect_tax = $this->session->userdata('collect_tax'); ?>
        <div class="row" style="display: <?php echo isset($collect_tax) && $collect_tax == "Yes" ? 'block' : 'none' ?>">
          <?php foreach ($tax_fields as $tax_field) { ?>

            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo escape_output($tax_field->tax); ?></label>
                <table class="width_100_p">
                  <tr>
                    <td>
                      <input tabindex="1" type="hidden" name="tax_field_id[]" value="<?php echo escape_output($tax_field->id); ?>">
                      <input tabindex="1" type="hidden" name="tax_field_outlet_id[]" value="<?php echo escape_output($tax_field->outlet_id); ?>">
                      <input tabindex="1" type="hidden" name="tax_field_company_id[]" value="<?php echo escape_output($tax_field->company_id); ?>">
                      <input tabindex="1" type="hidden" name="tax_field_name[]" value="<?php echo escape_output($tax_field->tax); ?>">
                      <input tabindex="1" type="text" name="tax_field_percentage[]" class="form-control integerchk" placeholder="<?php echo escape_output($tax_field->tax); ?>" value="0">
                    </td>
                    <td class="c_txt_right"> %</td>
                  </tr>
                </table>


              </div>
            </div>
          <?php } ?>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card attribute-card">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="text-center" style="width: 20%;">Color</th>
                    <th class="text-center" style="width: 20%;">Size</th>
                    <th class="text-center" style="width: 20%;">Price</th>
                    <th class="text-center" style="width: 20%;">Option</th>
                  </tr>
                </thead>
                <tbody id="attributeTableTbody">
                  <tr id="firstAttributeRow">
                    <td class="text-center">
                      <select name="attribute[0][color]" class="color form-control">
                        <option selected disabled>Select Color..</option>
                        <?php foreach ($colors as $data) { ?>
                          <option value="<?= $data->id ?>"><?= $data->name ?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td class="text-center">
                      <select name="attribute[0][size]" class="size form-control">
                        <option selected disabled>Select Size..</option>
                        <?php foreach ($sizes as $data) { ?>
                          <option value="<?= $data->id ?>"><?= $data->name ?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td class="text-center">
                      <input type="number" name="attribute[0][price]" class="price form-control" min="0">
                    </td>
                    <td class="text-center">
                      <input type="number" name="attribute[0][qty]" class="qty form-control" min="0">
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-danger remveItemAttr">Remove</button>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3"></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-primary addItemAttr">Add new</button>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div> <!-- card -->
          </div> <!-- col -->

        </div>

        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
          <a href="<?php echo base_url() ?>Item/products">
            <button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button>
          </a>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
  </div>
</section>

<!-- suppliers modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square-o txt-uh-48"></i> <?php echo lang('add_supplier'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="add_supplier_form">
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('supplier_name'); ?><span class="txt-uh-24"> *</span></label>
            <div class="col-sm-7">
              <input type="text" autocomplete="off" class="form-control" name="name" id="name_supplier" placeholder="<?php echo lang('supplier_name'); ?>" value="">
              <div class="alert alert-error error-msg name_err_msg_contnr txt-uh-21">
                <p class="name_err_msg"></p>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('contact_person'); ?><span class="txt-uh-24"> *</span></label>
            <div class="col-sm-7">
              <input autocomplete="off" type="text" id="contact_person" name="contact_person" class="form-control" placeholder="<?php echo lang('contact_person'); ?>" value="<?php echo set_value('contact_person'); ?>">
              <div class="alert alert-error error-msg sdescription_err_msg_contnr txt-uh-21">
                <p class="contact_person_err_msg"></p>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('phone'); ?><span class="txt-uh-24"> *</span></label>
            <div class="col-sm-7">
              <input autocomplete="off" type="text" id="phone" name="phone" class="form-control" placeholder="<?php echo lang('phone'); ?>" value="<?php echo set_value('phone'); ?>">
              <div class="alert alert-error error-msg sdescription_err_msg_contnr txt-uh-21">
                <p class="phone_err_msg"></p>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
        <button type="button" class="btn btn-primary" id="addSupplier">
          <i class="fa fa-save"></i> <?php echo lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>
<!-- suppliers modal end -->
<div class="modal fade" id="addPurchaseUnitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square-o txt-uh-48"></i> <?php echo lang('add_unit'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="add_purchase_unit_form">
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('unit_name'); ?><span class="txt-uh-24"> *</span></label>
            <div class="col-sm-7">
              <input type="text" autocomplete="off" class="form-control" name="unit_name" id="unit_name_p" placeholder="<?php echo lang('name'); ?>" value="">
              <div class="alert alert-error error-msg unit_name_err_msg_contnr txt-uh-21">
                <p class="unit_name_err_msg"></p>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('description'); ?></label>
            <div class="col-sm-7">
              <input autocomplete="off" type="text" name="description" id="description_p" class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?php echo set_value('description'); ?>">
              <div class="alert alert-error error-msg sdescription_err_msg_contnr txt-uh-21">
                <p class="description_err_msg"></p>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
        <button type="button" class="btn btn-primary" id="addPurchaseUnit">
          <i class="fa fa-save"></i> <?php echo lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addSaleUnitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square-o txt-uh-48"></i> <?php echo lang('add_unit'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="add_sale_unit_form">
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('unit_name'); ?><span class="txt-uh-24"> *</span></label>
            <div class="col-sm-7">
              <input type="text" autocomplete="off" class="form-control" name="unit_name" id="unit_name_sale" placeholder="<?php echo lang('name'); ?>" value="">
              <div class="alert alert-error error-msg unit_name_err_msg_contnr txt-uh-21">
                <p class="unit_name_err_msg"></p>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('description'); ?></label>
            <div class="col-sm-7">
              <input autocomplete="off" type="text" name="description" id="description_s" class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?php echo set_value('description'); ?>">
              <div class="alert alert-error error-msg sdescription_err_msg_contnr txt-uh-21">
                <p class="description_err_msg"></p>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
        <button type="button" class="btn btn-primary" id="addSaleUnit">
          <i class="fa fa-save"></i> <?php echo lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="guideModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <p class="show_guide_text"></p>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary">
          <?php echo lang('cancel'); ?></button>
      </div>
    </div>

  </div>
</div>
<script src="<?= base_url('assets/js/add_item.js'); ?>"></script>

<script>
  function readURL(input, selector) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        selector.attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

  $(function() {
    $(".image").change(function() {
      s_photo = $(this).closest('.form-group').find('.s_photo');
      readURL(this, s_photo);
    });
  })
</script>