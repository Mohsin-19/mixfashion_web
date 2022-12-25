<div class="row">
  <div class="form-group col-md-3">
    <label><?= lang('sale_price'); ?> <span class="required_star">*</span></label>
    <table class="width_100_p">
      <tr>
        <td><input tabindex="4" autocomplete="off" type="text" onfocus="this.select();" id="sale_price" name="sale_price" class="form-control integerchk" placeholder="<?php echo lang('sale_price'); ?>" value="<?php echo escape_output($product_details->sale_price); ?>"></td>
        <td class="width_1_p c_txt_right"> <span class="label_aligning_total_loss">
            <?= escape_output($this->session->userdata('currency')); ?>
          </span></td>
        <td class="txt-uh-43"><i data-toggle="tooltip" data-placement="bottom" title="<?= lang('guide_sale_price'); ?>" data-feather="info" class="width_18_px"></i></td>
      </tr>
    </table>
    <?= show_field_error('sale_price'); ?>
  </div> <!-- form-group -->
  <div class="form-group col-md-3">
    <label><?= lang('purchase_price'); ?> <span class="required_star">*</span></label>
    <table class="width_100_p">
      <tr>
        <td><input tabindex="5" autocomplete="off" type="text" onfocus="this.select();" id="purchase_price" name="purchase_price" class="form-control integerchk disable_service" placeholder="<?= lang('purchase_price'); ?>" value="<?= escape_output($product_details->purchase_price); ?>"></td>
        <td class="width_1_p c_txt_right"> <span class="label_aligning_total_loss">
            <?= escape_output($this->session->userdata('currency')); ?>
          </span></td>
        <td class="txt-uh-43"><i data-toggle="tooltip" data-placement="bottom" title="<?= lang('guide_purchase_price'); ?>" data-feather="info" class="width_18_px"></i></td>
      </tr>
    </table>
    <?= show_field_error('purchase_price'); ?>
  </div> <!-- form-group -->

  <!-- <div class="form-group col-md-3">
    <label><?= lang('opening_stock'); ?></label>
    <table class="width_100_p">
      <tr>
        <td><input tabindex="6" autocomplete="off" type="number" id="opening_stock" name="opening_stock" class="form-control disable_service " placeholder="<?= lang('opening_stock'); ?>" value="<?= escape_output($product_details->opening_stock); ?>"></td>
        <td class="width_1_p c_txt_right"> <span class="label_aligning_total_loss">
            <?= escape_output($this->session->userdata('currency')); ?>
          </span></td>
        <td class="txt-uh-43"><i data-toggle="tooltip" data-placement="bottom" title="<?= lang('in_sale_unit'); ?>" class="fa fa-info-circle"></i></td>
      </tr>
    </table>
    <?= show_field_error('opening_stock'); ?>
  </div>  -->

  <!-- form-group -->
  <div class="form-group col-md-3">
    <label><?= lang('code'); ?> <span class="required_star">*</span></label>
    <input tabindex="7" autocomplete="off" type="text" onfocus="select();" id="code_" name="code" class="form-control" placeholder="<?= lang('code'); ?>" value="<?= escape_output($product_details->code); ?>">
    <?= show_field_error('code'); ?>
  </div> <!-- form-group -->
  <div class="form-group col-md-3">
    <label><?= lang('supplier'); ?></label>
    <table class="width_100_p">
      <tr>
        <td width="95.5%">
          <select tabindex="8" class="form-control disable_service select2 width_100_p" id="supplier_id" name="supplier_id">
            <option value=""><?= lang('select'); ?></option>
            <?php
            $supplier_id = isset($product_details) ? $product_details->supplier_id : '';
            foreach ($suppliers as $supplier) :
            ?>
              <option value="<?= escape_output($supplier->id) ?>" <?= set_select('supplier_id', $supplier->id, ($supplier_id == $supplier->id)); ?>><?= escape_output($supplier->name) ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td class="txt-uh-44"><i class="fa fa-plus add_supplier_by_ajax"></i></td>
      </tr>
    </table>
    <?= show_field_error('supplier_id'); ?>
  </div> <!-- form-group -->


  <div class="form-group col-md-3">
    <label><?= lang('conversion_rate'); ?> <span class="required_star">*</span></label>
    <table width="100%">
      <tr>
        <td>
          <input tabindex="13" type="text" id="conversion_rate" autocomplete="off" name="conversion_rate" class="form-control integerchk disable_service check_sale_purchase_unit" placeholder="<?= lang('conversion_rate'); ?>" value="<?= escape_output($product_details->conversion_rate); ?>">
        </td>
        <td class="txt-uh-43"><i data-toggle="tooltip" data-placement="bottom" title="<?= lang('guide_conversion_rate'); ?>" data-feather="info" class="width_18_px"></i></td>
      </tr>
    </table>
    <?= show_field_error('conversion_rate'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <label><?= lang('alert_quantity'); ?> <span class="required_star">*</span></label>
    <table class="width_100_p">
      <tr>
        <td><input tabindex="14" autocomplete="off" type="text" id="alert_quantity" name="alert_quantity" class="form-control disable_service" placeholder="<?= lang('alert_quantity'); ?>" value="<?= escape_output($product_details->alert_quantity); ?>"></td>
        <td class="width_1_p c_txt_right"></td>
        <td class="txt-uh-45"><i data-toggle="tooltip" data-placement="bottom" title="<?= lang('in_sale_unit'); ?>" data-feather="info" class="width_18_px"></i></td>
      </tr>
    </table>
    <?= show_field_error('alert_quantity'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <label><?= lang('available'); ?></label>
    <select tabindex="16" class="form-control select2 width_100_p" id="available" name="available">
      <option value="Yes" <?= set_select('available', "Yes"); ?> <?= isset($product_details->available) && $product_details->available && $product_details->available == "Yes" ? 'selected' : '' ?>><?php echo lang('Yes'); ?></option>
      <option value="No" <?= set_select('available', "No"); ?> <?= isset($product_details->available) && $product_details->available && $product_details->available == "No" ? 'selected' : '' ?>><?= lang('No'); ?></option>
    </select>
    <?= show_field_error('available'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <label><?= lang('discount_price'); ?></label>
    <input tabindex="17" autocomplete="off" type="text" onfocus="this.select();" id="discount_price" name="discount_price" class="form-control integerchk discount_price" placeholder="<?= lang('discount_price'); ?>" value="<?= escape_output($product_details->discount_price); ?>">
    <?= show_field_error('discount_price'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <label><?= lang('has_offer'); ?></label>
    <table class="width_100_p">
      <tr>
        <td>
          <select tabindex="18" class="form-control select2 width_100_p" id="has_offer" name="has_offer">
            <option value="No" <?= set_select('has_offer', "No"); ?> <?= isset($product_details->has_offer) && $product_details->has_offer && $product_details->has_offer == "No" ? 'selected' : '' ?>><?php echo lang('No'); ?></option>
            <option value="Yes" <?= set_select('has_offer', "Yes"); ?> <?= isset($product_details->has_offer) && $product_details->has_offer && $product_details->has_offer == "Yes" ? 'selected' : '' ?>><?= lang('Yes'); ?></option>
          </select>
        </td>
        <td class="width_1_p c_txt_right"></td>
        <td class="txt-uh-45" data-toggle="tooltip" data-placement="bottom" title="<?= lang('tooltip_has_offer'); ?>"><i data-feather="info" class="width_18_px"></i></td>
      </tr>
    </table>
    <?= show_field_error('has_offer'); ?>
  </div> <!-- form-group -->
  <?php
  $has_offer = isset($product_details) ? $product_details->has_offer : 'No';
  $set_value = set_value('has_offer', $has_offer);
  ?>
  <div class="form-group offer_div col-md-3" style="display: <?= $set_value == "Yes" ? '' : 'none' ?>">
    <label><?= lang('details_modal_image'); ?></label>
    <input tabindex="18" autocomplete="off" accept="image/*" type="file" id="details_modal_image" name="details_modal_image" class="form-control">
    <input type="hidden" name="details_modal_image_old" id="" value="<?= escape_output($product_details->details_modal_image); ?>">
    <?= show_field_error('details_modal_image'); ?>
  </div> <!-- form-group -->
  <div class="form-group col-md-3" style="display: <?= $set_value == "Yes" ? '' : 'none' ?>">
    <label><?= lang('offer'); ?></label>
    <textarea tabindex="19" autocomplete="off" type="text" id="offer" name="offer" class="form-control" placeholder="<?= lang('offer'); ?>"><?= escape_output($product_details->offer); ?></textarea>
    <?= show_field_error('offer'); ?>
  </div> <!-- form-group -->
  <div class="form-group col-md-3">
    <label><?= lang('ManageStock'); ?></label>
    <table class="width_100_p">
      <tr>
        <td>
          <select tabindex="18" class="form-control select2 width_100_p" id="manage_stock" name="manage_stock">
            <option value="Yes" <?= set_select('manage_stock', "Yes"); ?>><?= lang('No'); ?></option>
            <option value="No" <?= set_select('manage_stock', "No"); ?>><?= lang('Yes'); ?></option>
          </select>
        </td>
        <td class="width_1_p c_txt_right"></td>
        <td class="txt-uh-45" data-toggle="tooltip" data-placement="bottom" title="<?= lang('tooltip_manage_stock'); ?>">
          <i data-feather="info" class="width_18_px"></i>
        </td>
      </tr>
    </table>
    <?= show_field_error('manage_stock'); ?>
  </div> <!-- form-group -->
  <div class="form-group col-md-3">
    <label for="order_limit">Order Limit <span class="required_star">*</span></label>
    <table class="width_100_p">
      <tr>
        <td>
          <?= form_input([
            'type'  => 'number',
            'name'  => 'order_limit',
            'id'    => 'order_limit',
            'min' => 0,
            'max' => 1000,
            'value' => $product_details->order_limit,
            'class' => 'form-control'
          ]);
          ?>
        </td>
        <td class="width_1_p c_txt_right"> </td>
        <td class="txt-uh-45" data-toggle="tooltip" data-placement="bottom" title="<?= lang('tooltip_manage_stock'); ?>"><i data-feather="info" class="width_18_px"></i> </td>
      </tr>
    </table>
    <?= show_field_error('order_limit'); ?>
  </div> <!-- form-group -->
  <div class="form-group col-md-6">
    <label><?= lang('description'); ?></label>
    <textarea id="description" name="description" rows="3" class="form-control" placeholder="<?= lang('description_placeholder'); ?>"><?= $product_details->description ?></textarea>
    <?= show_field_error('description'); ?>
  </div> <!-- form-group -->
</div> <!-- row -->

<div class="row">
  <div class="col-md-6">
    <div class="card attribute-card">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center" style="width: 20%;">Color</th>
            <th class="text-center" style="width: 20%;">Size</th>
            <th class="text-center" style="width: 20%;">Price</th>
            <th class="text-center" style="width: 20%;">Qty</th>
            <th class="text-center" style="width: 20%;">Option</th>
          </tr>
        </thead>
        <tbody id="attributeTableTbody">
          <?php
          $result = get_product_attributes($product_details->id);
          ?>

          <?php if (count($result) > 0) : ?>
            <?php foreach ($result as $key => $att) : ?>
              <tr <?= $key == 0 ? 'id="firstAttributeRow"' : '' ?>>
                <td class="text-center">
                  <select name="attribute[<?= $key ?>][color]" class="color form-control">
                    <option value="">No Color</option>
                    <?php foreach ($colors as $data) : ?>
                      <option value="<?= $data->id ?>" <?= $data->id == $att['color_id'] ? 'selected' : '' ?>><?= $data->name ?></option>
                    <?php endforeach ?>
                  </select>
                </td>
                <td class="text-center">
                  <select name="attribute[<?= $key ?>][size]" class="size form-control">
                    <option value="">No Size</option>
                    <?php foreach ($sizes as $size) : ?>
                      <option value="<?= $size->id ?>" <?= $size->id == $att['size_id'] ? 'selected' : '' ?>><?= $size->name ?></option>
                    <?php endforeach ?>
                  </select>
                </td>
                <td class="text-center">
                  <input type="number" name="attribute[<?= $key ?>][price]" value="<?= $att['product_price'] ?>" class="price form-control" min="0">
                </td>
                <td class="text-center">
                  <input type="number" name="attribute[<?= $key ?>][qty]" value="<?= $att['product_qty'] ?>" class="qty form-control" min="0">
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-danger remveItemAttr">Remove</button>
                </td>
              </tr>
            <?php endforeach ?>
          <?php endif; ?>
        </tbody>
        <tfoot>
          <tr>
            <td>
              <button type="button" class="btn btn-sm btn-primary addItemAttr">Add new</button>
            </td>
            <td colspan="3"></td>
          </tr>
          <!-- <tr id="firstAttributeRow" class="hidden">
            <td class="text-center">
              <select name="attribute[0]['color']" class="color form-control">
                <option value="">No Color</option>
                <?php foreach ($colors as $data) : ?>
                  <option value="<?= $data->id ?>"><?= $data->name ?></option>
                <?php endforeach ?>
              </select>
            </td>

            <td class="text-center">
              <select name="attribute[0]['size']" class="size form-control">
                <option value="">No Size</option>
                <?php foreach ($sizes as $data) : ?>
                  <option value="<?= $data->id ?>"><?= $data->name ?></option>
                <?php endforeach ?>
              </select>
            </td>
            <td class="text-center">
              <input type="number" name="attribute[0]['price']" class="price form-control" min="0">
            </td>
            <td class="text-center">
              <input type="number" name="attribute[0][qty]" class="qty form-control" min="0">
            </td>
            <td class="text-center">
              <button type="button" class="btn btn-sm btn-danger remveItemAttr">Remove</button>
            </td>
          </tr> -->
        </tfoot>
      </table>
    </div> <!-- card -->
  </div> <!-- col -->
</div>


<hr style="margin: 0 0 15px 0;">
<a href="#category_and_unit" class="btn btn-linkedin btn-continue" data-toggle="tab">Prev</a>
<a href="#gallery" class="btn btn-primary btn-continue" data-toggle="tab">Next</a>
<input type="submit" name="submit" value="Update and Finish" class="btn btn-success">