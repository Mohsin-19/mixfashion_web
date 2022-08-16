<section class="content-header">
  <h1>
    <?php echo lang('add_coupon'); ?>
  </h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <!-- form start -->
        <?php echo form_open(base_url('Coupon/addEditCoupon')); ?>
        <div class="box-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('code'); ?> <span class="required_star">*</span> </label>
                <a style="float: right" class="btn btn-xs btn-primary generate_now pull-right"><?php echo lang('Generate'); ?></a>
                <input tabindex="1" autocomplete="off" type="text" id="code" name="code" class="form-control"
                       placeholder="<?php echo lang('code'); ?>" value="<?php echo set_value('code'); ?>">
              </div>
              <?php if (form_error('code')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('code'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('coupon_option'); ?> <span class="required_star">*</span></label>
                <?php
                $coupon_option = set_value('coupon_option');
                $options = [
                  'new_user' => 'New User Coupon',
                  '499_1999' => 'For 499-1,999 Total',
                  '2000' => 'For 1,999+ Total',
                  'emp_special_300' => 'Employee Special 300+ Order ',
                  'repeat_coupon' => 'Repeat Coupon',
                ];
                echo form_dropdown('coupon_option', $options, $coupon_option, ['id' => 'coupon_option', 'class' => 'form-control select2']);
                ?>
              </div>
              <?php if (form_error('coupon_option')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('coupon_option'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('amount'); ?> <span class="required_star">*</span></label>
                <?php
                $amount = set_value('amount');
                $options = [
                  'free_deliver' => 'Free Delivery',
                  '1' => '1% Flat Discount of Total Price',
                  '2' => '2% Flat Discount of Total Price',
                  '3' => '3% Flat Discount of Total Price',
                  '4' => '4% Flat Discount of Total Price',
                  '5' => '5% Flat Discount of Total Price',
                  '6' => '6% Flat Discount of Total Price',
                  '7' => '7% Flat Discount of Total Price',
                  '8' => '8% Flat Discount of Total Price',
                  '9' => '9% Flat Discount of Total Price',
                  '10' => '10% Flat Discount of Total Price',
                  '11' => '11% Flat Discount of Total Price',
                  '12' => '12% Flat Discount of Total Price',
                  '13' => '13% Flat Discount of Total Price',
                  '14' => '14% Flat Discount of Total Price',
                  '15' => '15% Flat Discount of Total Price',
                ];
                echo form_dropdown('amount', $options, $amount, ['id' => 'amount', 'class' => 'form-control select2']);
                ?>
              </div>
              <?php if (form_error('amount')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('amount'); ?></p>
                </div>
              <?php } ?>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('expired_date'); ?> <span class="required_star">*</span></label>
                <input tabindex="1" autocomplete="off" type="text" name="expired_date" class="form-control customDatepickerCustom1"
                       placeholder="<?php echo lang('expired_date'); ?>" value="<?php echo set_value('expired_date'); ?>">
              </div>
              <?php if (form_error('expired_date')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('expired_date'); ?></p>
                </div>
              <?php } ?>
            </div>

          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
          <a href="<?php echo base_url() ?>Coupon/coupons">
            <button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button>
          </a>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</section>

<script>
   function getRandomCode(length) {
      var result = '';
      var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      var charactersLength = characters.length;
      for (var i = 0; i < length; i++) {
         result += characters.charAt(Math.floor(Math.random() * charactersLength));
      }
      return result;
   }

   $('body').on('click', '.generate_now', function (e) {
      var code = getRandomCode(8);
      $("#code").val(code);
   });
</script>