<div class="row">
  <div class="form-group col-md-3">
    <div style="display:block;" class="clearfix">
      <label for="galary_image_1" class="float-left">Gallery Image 1 (W-600xH-600)</label>
      <a href="#" class="float-right text-danger removeGallery">Remove</a>
    </div>
    <label for="galary_image_1" style="border: 1px solid #ddd;border-radius: 2px;">
      <?php
      $image_one = $product_details->galary_image_1;
      $image_one =  $image_one ? "images/product/{$image_one}"  : 'assets/images/no_image_thumb.png';
      ?>
      <img src="<?= base_url($image_one) ?>" class="img-responsive border s_photo">
    </label>
    <input type="file" id="galary_image_1" name="galary_image_1" class="image" style=" display: none;">
    <input type="hidden" name="galary_image_1_old" id="" value="<?= escape_output($product_details->galary_image_1); ?>">
    <?= show_field_error('galary_image_1'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <div style="display:block;" class="clearfix">
      <label for="galary_image_2" class="float-left">Gallery Image 2 (W-600xH-600)</label>
      <a href="#" class="float-right text-danger removeGallery">Remove</a>
    </div>
    <label for="galary_image_2" style="border: 1px solid #ddd;border-radius: 2px;">
      <?php
      $image_two = $product_details->galary_image_2;
      $image_two =  $image_two ? "images/product/{$image_two}"  : 'assets/images/no_image_thumb.png';
      ?>
      <img src="<?= base_url($image_two) ?>" class="img-responsive border s_photo">
    </label>
    <input type="file" id="galary_image_2" name="galary_image_2" class="image" style=" display: none;">
    <input type="hidden" name="galary_image_2_old" id="" value="<?= escape_output($product_details->galary_image_2); ?>">
    <?= show_field_error('galary_image_2'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <div style="display:block;" class="clearfix">
      <label for="galary_image_3" class="float-left">Gallery Image 3 (W-600xH-600)</label>
      <a href="#" class="float-right text-danger removeGallery">Remove</a>
    </div>
    <label for="galary_image_3" style="border: 1px solid #ddd;border-radius: 2px;">
      <?php
      $image_three = $product_details->galary_image_3;
      $image_three =  $image_three ? "images/product/{$image_three}"  : 'assets/images/no_image_thumb.png';
      ?>
      <img src="<?= base_url($image_three) ?>" class="img-responsive border s_photo">
    </label>
    <input type="file" id="galary_image_3" name="galary_image_3" class="image" style=" display: none;">
    <input type="hidden" name="galary_image_3_old" value="<?= escape_output($product_details->galary_image_3); ?>">
    <?= show_field_error('galary_image_3'); ?>
  </div> <!-- form-group -->

  <div class="form-group col-md-3">
    <div style="display:block;" class="clearfix">
      <label for="galary_image_4" class="float-left">Gallery Image 4 (W-600xH-600)</label>
      <a href="#" class="float-right text-danger removeGallery">Remove</a>
    </div>
    <label for="galary_image_4" style="border: 1px solid #ddd;border-radius: 2px;">
      <?php
      $image_four = $product_details->galary_image_4;
      $image_four =  $image_four ? "images/product/{$image_four}"  : 'assets/images/no_image_thumb.png';
      ?>
      <img src="<?= base_url($image_four) ?>" class="img-responsive border s_photo">
    </label>
    <input type="file" id="galary_image_4" name="galary_image_4" class="image" style=" display: none;">
    <input type="hidden" name="galary_image_4_old" id="" value="<?= escape_output($product_details->galary_image_4); ?>">
    <?= show_field_error('galary_image_4'); ?>
  </div> <!-- form-group -->

</div> <!-- row -->

<div class="row">
  <div class="form-group col-md-3">
    <div style="display:block;" class="clearfix">
      <label for="photo" class="float-left">Default Image (W-600xH-600) <span class="text-danger">*</span></label>
    </div>
    <label for="photo" style="border: 1px solid #ddd;border-radius: 2px;">
      <?php
      $photo = $product_details->photo;
      $photo =  $photo ? "images/product/{$photo}"  : 'assets/images/no_image_thumb.png';
      ?>
      <img src="<?= base_url($photo) ?>" class="img-responsive border s_photo">
    </label>
    <input type="file" id="photo" name="photo" class="image" style=" display: none;">
    <input type="hidden" name="photo_old" id="" value="<?= escape_output($product_details->photo); ?>">
    <?= show_field_error('photo'); ?>
  </div> <!-- form-group -->
</div> <!-- row -->
<hr style="margin: 0 0 15px 0;">
<a href="#pricing" class="btn btn-linkedin btn-continue" data-toggle="tab">Prev</a>
<a href="#vat_tax" class="btn btn-primary btn-continue" data-toggle="tab">Next</a>
<input type="submit" name="submit" value="Update and Finish" class="btn btn-success">