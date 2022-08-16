<div class="row">
  <div class="form-group col-md-12">
    <label>Product Specification</label>
    <textarea name="specification" id="specification" rows="10" class="form-control editor"><?= set_value('specification', $product_details->specification)  ?></textarea>
    <?= show_field_error('specification'); ?>
  </div> <!-- form-group -->
</div> <!-- row -->



<hr style="margin: 0 0 15px 0;">
<a href="#productDescription" class="btn btn-linkedin btn-continue" data-toggle="tab">Prev</a>
<input type="submit" name="submit" value="Update and Finish" class="btn btn-success">