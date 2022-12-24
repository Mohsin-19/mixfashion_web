<div class="row">
  <div class="form-group col-md-3 hidden">
    <label><?= lang('type'); ?></label>
    <select tabindex="100" class="form-control select2 check_type width_100_p" id="type" name="type">
      <option value="1" <?= set_select('type', 1); ?>><?= lang('product'); ?></option>
      <option value="2" <?= set_select('type', 2); ?>><?= lang('service'); ?></option>
    </select>
    <?= show_field_error('type'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <label><?= lang('name'); ?> <span class="required_star">*</span></label>
    <input tabindex="1" autocomplete="off" type="text" id="name" name="name" class="form-control" placeholder="<?= lang('name_placeholder_1'); ?>" value="<?= escape_output($product_details->name); ?>">
    <?= show_field_error('name'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <label><?= lang('NameinYourLanguage'); ?></label>
    <input tabindex="2" autocomplete="off" type="text" id="name_for_your" name="name_for_your" class="form-control" placeholder="<?= lang('name_placeholder_2'); ?>" value="<?= escape_output($product_details->name_for_your); ?>">
    <?= show_field_error('name_for_your'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <label><?= lang('NameinPeopleLanguage'); ?></label>
    <input tabindex="3" autocomplete="off" type="text" id="name_for_people" name="name_for_people" class="form-control" placeholder="<?= lang('name_placeholder_3'); ?>" value="<?= escape_output($product_details->name_for_people); ?>">
    <?= show_field_error('name_for_people'); ?>
  </div> <!-- form-group -->

</div> <!-- form-row -->

<hr style="margin: 0 0 15px 0;">
<a href="#category_and_unit" class="btn btn-primary btn-continue" data-toggle="tab">Next</a>
<input type="submit" name="submit" value="Update and Finish" class="btn btn-success">