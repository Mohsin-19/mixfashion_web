
<section class="content">
  <div class="row" style="justify-content: center!important;display: flex;">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= lang('edit_user'); ?></h3>
        </div> <!-- /.box-header -->

        <?= form_open_multipart("admin/user/{$user->id}/update", ['role' => 'form']); ?>
        <div class="box-body">

          <div class="form-group">
            <div class="checkbox">
              <label style="margin-right: 15px">
                <?= form_checkbox(['name' => 'will_login', 'value' => 'Yes', 'checked' => $user->will_login == true]) ?>
                User Login Enable
              </label>
              <label>
                <?= form_checkbox(['name' => 'active_status', 'value' => 'Active', 'checked' => $user->active_status == 'Active']) ?>
                User Active Status
              </label>
            </div>
          </div> <!-- form-group -->

          <div class="form-group">
            <label for="full_name"> User Full Name <span class="required_star">*</span> </label>
            <?= form_input(['name' => 'full_name', 'value' => $user->full_name, 'id' => 'full_name', 'class' => 'form-control', 'placeholder' => 'Full Name', 'required' => true, 'autocomplete' => true, 'autofocus' => true]) ?>
            <?php if (form_error('full_name')): ?>
              <div class="alert alert-error txt-uh-21">
                <p><?= form_error('full_name'); ?></p>
              </div>
            <?php endif; ?>
          </div> <!-- form-group -->

          <div class="form-group">
            <label for="phone"> User Phone </label>
            <?= form_input(['name' => 'phone', 'value' => $user->phone, 'id' => 'phone', 'class' => 'form-control', 'placeholder' => 'Phone', 'autocomplete' => true]) ?>
            <?php if (form_error('phone')): ?>
              <div class="alert alert-error txt-uh-21">
                <p><?= form_error('phone'); ?></p>
              </div>
            <?php endif; ?>
          </div> <!-- form-group -->

          <div class="form-group">
            <label for="email_address"> User Email <span class="required_star">*</span> </label>
            <?= form_input(['name' => 'email_address', 'value' => $user->email_address, 'type' => 'email', 'id' => 'email_address', 'class' => 'form-control', 'placeholder' => 'Email', 'required' => true, 'autocomplete' => true]) ?>
            <?php if (form_error('email_address')): ?>
              <div class="alert alert-error txt-uh-21">
                <p><?= form_error('email_address'); ?></p>
              </div>
            <?php endif; ?>
          </div> <!-- form-group -->

          <div class="form-group">
            <label for="role"> User Role <span class="required_star">*</span> </label>
            <?= form_dropdown('role', $roles, [$user->role], ['class' => 'form-control select2']) ?>
            <?php if (form_error('role')): ?>
              <div class="alert alert-error txt-uh-21">
                <p><?= form_error('role'); ?></p>
              </div>
            <?php endif; ?>
          </div> <!-- form-group -->



          <div class="form-group">
            <div class="checkbox">
              <label style="margin-right: 15px">
                <?= form_checkbox(['name' => 'change_password', 'value' => '1', 'id' => 'change_password']) ?>
                Change Password
              </label>
            </div>
          </div> <!-- form-group -->

          <div class="row hidden passwordFields">
            <div class="form-group col-sm-6">
              <label for="password"> Password <span class="required_star">*</span> </label>
              <?= form_password(['name' => 'password', 'id' => 'password', 'class' => 'form-control', 'placeholder' => 'password']) ?>
              <?php if (form_error('password')): ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?= form_error('password'); ?></p>
                </div>
              <?php endif; ?>
            </div> <!-- form-group -->

            <div class="form-group col-sm-6">
              <label for="confirm_password">Confirm Password <span class="required_star">*</span> </label>
              <?= form_password(['name' => 'confirm_password', 'id' => 'password_confirm', 'class' => 'form-control', 'placeholder' => 'confirm']) ?>
              <?php if (form_error('confirm_password')): ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?= form_error('confirm_password'); ?></p>
                </div>
              <?php endif; ?>
            </div> <!-- form-group -->
          </div> <!-- row -->

          <div class="row">
            <div class="form-group col-sm-4">
              <label for="photo">User Photo </label>
              <?= form_upload(['name' => 'photo', 'id' => 'photo']) ?>
              <?php if (form_error('photo')): ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?= form_error('photo'); ?></p>
                </div>
              <?php endif; ?>
            </div> <!-- form-group -->
          </div>

        </div> <!-- /.box-body -->

        <div class="box-footer">
          <div class="form-group">
            <?= form_submit('submit', lang('update'), ['class' => 'btn btn-primary']); ?>
            <a href="<?= site_url("admin/user") ?>" class="btn btn-danger">
              <?= lang('back'); ?>
            </a>
          </div>
        </div>
        <?= form_close(); ?>
      </div> <!-- box-primary -->
    </div>
  </div>
</section>

<script>
  $(document).on('click','#change_password', function(){
     var passwordFields = $('.passwordFields')
     if($(this).is(":checked")){
        passwordFields.removeClass('hidden');
     }else{
        passwordFields.addClass('hidden');
     }
  })

</script>
