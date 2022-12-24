<?php
$collect_tax = $this->session->userdata('collect_tax');
$tax_information = isset($product_details) ?  json_decode($product_details->tax_information) : [];

if ($collect_tax == "Yes") :
?>

  <div class="row">
    <?php foreach ($tax_fields as $tax_field) : ?>

      <div class="form-group col-md-3">

        <?php
        if (count($tax_information) > 0) :
          foreach ($tax_information as $single_tax) :
            if ($tax_field->id == $single_tax->tax_field_id) :
        ?>
              <label><?= escape_output($tax_field->tax); ?></label>
              <table class="width_100_p">
                <tr>
                  <td>
                    <input tabindex="1" type="hidden" name="tax_field_id[]" value="<?= escape_output($single_tax->tax_field_id); ?>">
                    <input tabindex="1" type="hidden" name="tax_field_outlet_id[]" value="<?= escape_output($single_tax->tax_field_outlet_id); ?>">
                    <input tabindex="1" type="hidden" name="tax_field_company_id[]" value="<?= escape_output($single_tax->tax_field_company_id); ?>">
                    <input tabindex="1" type="hidden" name="tax_field_name[]" value="<?= escape_output($single_tax->tax_field_name); ?>">
                    <input tabindex="1" type="text" name="tax_field_percentage[]" class="form-control integerchk" placeholder="" value="<?= escape_output($single_tax->tax_field_percentage); ?>">
                  </td>
                  <td class="c_txt_right"> %</td>
                </tr>
              </table>
          <?php
            endif;
          endforeach;
        else :
          ?>
          <label><?= escape_output($tax_field->tax); ?></label>
          <table class="width_100_p">
            <tr>
              <td>
                <input tabindex="1" type="hidden" name="tax_field_id[]" value="<?= escape_output($tax_field->id); ?>">
                <input tabindex="1" type="hidden" name="tax_field_outlet_id[]" value="<?= escape_output($tax_field->outlet_id); ?>">
                <input tabindex="1" type="hidden" name="tax_field_company_id[]" value="<?= escape_output($tax_field->company_id); ?>">
                <input tabindex="1" type="hidden" name="tax_field_name[]" value="<?= escape_output($tax_field->tax); ?>">
                <input tabindex="1" type="text" name="tax_field_percentage[]" class="form-control integerchk" placeholder="<?= escape_output($tax_field->tax); ?>" value="0">
              </td>
              <td class="c_txt_right"> %</td>
            </tr>
          </table>
        <?php endif; ?>

      </div> <!-- form-group -->

    <?php endforeach; ?>
  </div> <!-- row -->

<?php else : ?>

  <p class="text-danger">Collect tax is not enable</p>

<?php endif; ?>

<hr style="margin: 0 0 15px 0;">
<a href="#gallery" class="btn btn-linkedin btn-continue" data-toggle="tab">Prev</a>
<a href="#productDescription" class="btn btn-primary btn-continue" data-toggle="tab">Nex</a>
<input type="submit" name="submit" value="Update and Finish" class="btn btn-success">