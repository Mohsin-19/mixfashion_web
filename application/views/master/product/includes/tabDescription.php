<div class="row">
  <div class="form-group col-md-12">
    <label>Product Description</label>
    <textarea name="full_description" id="full_description" rows="10" class="form-control editor"><?= set_value('full_description', $product_details->full_description)  ?></textarea>
    <?= show_field_error('full_description'); ?>
  </div> <!-- form-group -->
</div> <!-- row -->



<hr style="margin: 0 0 15px 0;">
<a href="#vat_tax" class="btn btn-linkedin btn-continue" data-toggle="tab">Prev</a>
<a href="#specification" class="btn btn-primary btn-continue" data-toggle="tab">Next</a>
<input type="submit" name="submit" value="Update and Finish" class="btn btn-success">