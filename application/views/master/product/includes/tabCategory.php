<div class="row">
  <div class="form-group col-md-3">
    <label><?= lang('category'); ?> <span class="required_star">*</span></label>
    <select tabindex="9" class="form-control select2 width_100_p" id="category_id" name="category_id">
      <option value=""><?= lang('select'); ?></option>
      <?php
      $cat_id = isset($product_details) ? $product_details->category_id : 0;
      $subcat_id = isset($product_details) ? $product_details->subcategory_id : 0;
      ?>
      <?php foreach ($categories as $category) : ?>
        <option <?= $cat_id == $category->id ? 'data-subcategory_id="' . $subcat_id . '"' : '' ?> value="<?= $category->id ?>" <?= set_select('category_id', $category->id, ($cat_id == $category->id)); ?>><?= $category->name ?></option>
      <?php endforeach; ?>
    </select>
    <?= show_field_error('category_id'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <label><?= lang('Subcategory'); ?></label>
    <select tabindex="10" class="form-control select2 width_100_p" id="subcategory_id" name="subcategory_id">
      <option value=""><?= lang('select'); ?></option>
    </select>
    <?= show_field_error('subcategory_id'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <label><?= lang('purchase_unit'); ?> <span class="required_star">*</span></label>
    <table style="width: 100%;">
      <tr>
        <td>
          <select tabindex="11" class="form-control select2 disable_service width_100_p" id="purchase_unit_id" name="purchase_unit_id">
            <option value=""><?= lang('select'); ?></option>
            <?php
            $unit_id = isset($product_details) ? $product_details->purchase_unit_id : set_value('purchase_unit_id', 0);
            ?>
            <?php foreach ($units as $value) : ?>
              <option value="<?= $value->id ?>" <?= set_select('purchase_unit_id', $value->id, ($unit_id == $value->id)); ?>><?= $value->unit_name ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td class="txt-uh-44"><i class="fa fa-plus add_purchase_unit_by_ajax"></i></td>
        <td class="txt-uh-43"><i data-toggle="tooltip" data-placement="bottom" title="<?= lang('guide_purchase_unit'); ?>" data-feather="info" class="width_18_px"></i>
        </td>
      </tr>
    </table>
    <?= show_field_error('purchase_unit_id'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <label><?= lang('sale_unit'); ?> <span class="required_star">*</span></label>
    <table style="width: 100%;">
      <tr>
        <td>
          <select tabindex="11" class="form-control select2 disable_service width_100_p" id="sale_unit_id" name="sale_unit_id">
            <option value=""><?= lang('select'); ?></option>
            <?php
            $sale_unit_id = isset($product_details) ? $product_details->sale_unit_id : set_value('sale_unit_id', 0);
            ?>
            <?php foreach ($units as $value) : ?>
              <option value="<?= $value->id ?>" <?= set_select('sale_unit_id', $value->id, ($unit_id == $value->id)); ?>><?= $value->unit_name ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td class="txt-uh-44"><i class="fa fa-plus add_sale_unit_by_ajax"></i></td>
        <td class="txt-uh-43"><i data-toggle="tooltip" data-placement="bottom" title="<?= lang('guide_purchase_unit'); ?>" data-feather="info" class="width_18_px"></i>
        </td>
      </tr>
    </table>
    <?= show_field_error('sale_unit_id'); ?>
  </div> <!-- form-group -->

</div> <!-- row -->
<hr style="margin: 0 0 15px 0;">
<a href="#general" class="btn btn-linkedin btn-continue" data-toggle="tab">Prev</a>
<a href="#pricing" class="btn btn-primary btn-continue" data-toggle="tab">Next</a>
<input type="submit" name="submit" value="Update and Finish" class="btn btn-success">