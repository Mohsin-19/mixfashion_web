<?php

$edit = isset($address) ? true : false;
$title = isset($address) ? 'Edit your' : 'Add new';
$address_id = isset($address) && $address ? $address->id : '';
$name = isset($address) && $address ? $address->name : customer('name');

$customer_phone = strlen(customer('phone')) > 10 ? customer('phone') : '';

$phone_one = isset($address) && $address ? $address->phone_one : $customer_phone;
$phone_two = isset($address) && $address ? $address->phone_two : '';
$phone_three = isset($address) && $address ? $address->phone_three : '';
$area = isset($address) && $address ? $address->area : '';
$address = isset($address) && $address ? $address->address : customer('address');

?>


<fieldset class="uk-fieldset">
  <legend class="uk-legend"><?= $title ?> shipping address</legend>
  <div class="uk-margin">
    <label for="p_c_name">Name <span class="uk-text-danger">*</span></label>
    <input class="uk-input" placeholder="<?= lang('name'); ?>" type="text" value="<?= $name ?>"
           id="p_c_name" autocomplete="off">
  </div>
  <div class="uk-margin">
    <label for="p_c_phone">Phone <span class="uk-text-danger">*</span></label>
    <input class="uk-input" value="<?= $phone_one ?>" placeholder="Phone" type="text" id="Address_phone1" required>
    <input type="hidden" value="<?= $phone_one ?>" id="p_c_phone">
    <span id="error-msg" class="d-none"></span>
    <span id="valid-msg" class="d-none"></span>
  </div>
  <div class="uk-margin">
    <label for="p_c_phone2">Another phone</label>
    <input class="uk-input" value="<?= $phone_two ?>" placeholder="Another phone" type="text" id="Address_phone2">
    <input type="hidden" value="<?= $phone_two ?>" id="p_c_phone2">
  </div>
  <div class="uk-margin">
    <label for="p_area">Area <span class="uk-text-danger">*</span></label>
    <select class="uk-select" id="p_area">
      <?php
      foreach ($areas as $value) :
        $selected = strtolower($area) == strtolower($value->name) ? 'selected' : '';
        ?>
        <option value="<?= ucfirst($value->name) ?>" <?= $selected ?>> <?= ucfirst($value->name) ?> </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="uk-margin">
    <label for="p_address">Address <span class="uk-text-danger">*</span></label>
    <textarea class="uk-textarea" rows="3" id="p_address" placeholder="Address"><?= $address ?></textarea>
  </div>

  <input type="hidden" name="address_id" id="address_id" value="<?= $address_id ?>">

</fieldset>
<p class="uk-text-left">
  <button class="uk-button uk-button-primary saveShippingAddress" type="button">
    <?= $edit ? 'Update' : 'Save' ?>
  </button>
  <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
</p>






