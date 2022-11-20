<span id="single_page_name" class="d-none">login</span>
<div class="login_register_wrap section" style="padding-bottom: 50px">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-md-4">
        <div class="login_wrap loginSubmitCard">
          <div class="padding_eight_all bg-white">
            <div class="heading_s1 text-center">
              <img src="<?= base_url('assets/images/login-logo.png') ?>" class="login-logo" alt="mixfashion">
              <p class="login_continue">TO CONTINUE TO <span class="text-uppercase">Mix Fashion</span></p>
            </div>

            <!-- <a href="<?= $facebook_auth_url ?>" class="css-zqtbdk">
              <span class="css-1vqao0l">
                <span class="css-t5emrf">
                  <img src="<?= base_url("assets/landing/img/facebook-logo.svg") ?>" alt="" style="height: 18px; margin-right: 8px; width: 18px;"><span>Continue with Facebook</span>
                </span>
              </span>
            </a>

            <a href="<?= $google_auth_url ?>" class="css-zqtbdk">
              <span class="css-1vqao0l">
                <span class="css-t5emrf">
                  <img src="<?= base_url("assets/landing/img/google-logo.svg") ?>" alt="" style="height: 18px; margin-right: 8px; width: 18px;"><span>Continue with Google</span>
                </span>
              </span>
            </a> -->

            <!-- <div class="different_login">
              <span> or</span>
            </div> -->

            <div class="loginWithOtp">
              <form action="<?= site_url('login-submit') ?>" method="POST" id="customer_signin">
                <div class="form-group">
                  <div class="input-group mb-1">
                    <input type="text" name="phone" class="form-control phone_validation" id="phone_validation" maxlength="25" required="true" autofocus="true">
                    <div class="input-group-append">
                      <input name="l_phone" id="l_phone" type="hidden">
                      <span id="valid-msg" class="hide">✓ Success</span>
                      <span id="error-msg" class="hide"></span>
                    </div>
                  </div>
                  <small id="phone" class="error_l_phone error_msg">e.g: 01938235071</small>
                </div> <!-- form-group -->

                <input type="hidden" name="remember_me" id="remember_me" value="1">
                <input type="hidden" name="accept_terms" id="accept_terms" value="1">
                <div class="form-group">
                  <button type="submit" class="btn btn-fill-out btn-block">SIGN UP
                    / LOGIN</button>
                </div>
              </form>
            </div>

            <div class="login-instruction">
              <p class="text-center m-2">
                By proceeding, you agree to <a href="<?= site_url('terms-condition') ?>" target="_blank">Terms of Use</a> and
                <a href="<?= site_url('privacy-policy') ?>" target="_blank">Privacy Policy</a>
                of Mix Fashion
              </p>

            </div>

          </div>
        </div>

        <div class="login_wrap otpSubmitForm" style="display: none;">
          <div class="padding_eight_all bg-white">
            <div class="heading_s1">
              <h4 class="otpVerifiedTitle">
                <a href="<?= site_url('login') ?>" class="btn btn-default text-danger p-0 mr-2">
                  <i class="icon-arrow-left"></i> Back
                </a>
                <?= lang('otp_verified_txt') ?>
              </h4>
              </h2>
            </div>

            <div class="otp_submit_form">
              <p class="text-center mb-3"> We just sent you an SMS with an OTP code. To complete your phone number login, please enter the 4-digit OTP code below</p>
              <form action="<?= site_url('login-check-otp') ?>" id="otp_form_submit">
                <div class="form-group">
                  <input type="hidden" name="userPhone" class="userPhone" id="userPhone">
                  <input type="text" name="f_otpCode" id="f_otpCode" class="form-control text-center f_otpCode" placeholder="----" maxlength="4" required="true" autofocus="true">
                  <small class="error_msg" class="form-text text-muted text-center"><?= lang('TheEmailfiledisrequired'); ?>
                  </small>
                </div> <!-- form-group -->
                <div class="form-group">
                  <button type="submit" id="resentOtp" class="btn btn-fill-out btn-block" disabled="disabled">
                    <span class="otp_counter_txt"><?= lang('Resend Code'); ?></span>
                    <span class="otp_counter">30</span>
                  </button>
                </div>
              </form>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="loader loader_for_forgot display_none">
  <div class="preloader">
    <div class="preloader-container">
      <span class="animated-preloader"></span>
    </div>
  </div>
</div>