<!DOCTYPE html>
<?php
//site setting
$getSiteSetting = getSiteSetting();
$currency = "$";
if (isset($getSiteSetting->currency) && $getSiteSetting->currency) {
  $currency = $getSiteSetting->currency;
}
//default base color
$base_color = "#6ab04c";
//dynamic base color from database
if (isset($getSiteSetting->base_color) && $getSiteSetting->base_color) {
  $base_color = $getSiteSetting->base_color;
}
?>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo isset($getSiteSetting->site_title) && $getSiteSetting->site_title ? $getSiteSetting->site_title : '' ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- jQuery 3 -->
  <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/square/blue.css">
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/branding/favicon.ico" type="image/x-icon">
  <!-- Sweet alert -->
  <script src="<?php echo base_url(); ?>assets/bower_components/sweetalert2/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/sweetalert2/dist/sweetalert.min.css">
  <!-- custom login page css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css">
  <!-- Favicon -->

  <?php
  if (isset($getSiteSetting) && $getSiteSetting->favicon) :
  ?>
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/<?php echo escape_output($getSiteSetting->favicon); ?>" type="image/x-icon">
  <?php
  else :
  ?>
    <link rel="icon" href="<?php echo base_url(); ?>assets/branding/favicon.ico" type="image/x-icon">
  <?php
  endif;
  ?>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="<?php echo base_url(); ?>assets/plugins/local/html5shiv.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/local/respond.min.js"></script>
        <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/google_font.css">
  <?php
  $s_bg = base_url() . 'assets/branding/login_page_background.png';
  if (isset($getSiteSetting) && $getSiteSetting->login_page_bg) :
    $s_bg = base_url() . 'assets/images/' . $getSiteSetting->login_page_bg;
  endif;
  ?>
  <style type="text/css">
    .secondbg {
      left: 0;
      position: fixed;
      top: 0;
      width: 100%;
      background-image: url('<?php echo escape_output($s_bg) ?>');
      background-size: cover;
      background-position: top center;
      height: 100%;
      margin-left: 0px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /*======== Sweet Alert ==========*/
    .sa-confirm-button-container .confirm {
      background-color: <?php echo escape_output($base_color) ?> !important;
    }

    .preloader .preloader-container .animated-preloader {
      background-color: <?php echo escape_output($base_color) ?> !important;
    }

    .preloader .preloader-container .animated-preloader:before {
      background-color: <?php echo escape_output($base_color) ?> !important;
      opacity: 0.6;
    }
  </style>
</head>
<?php
//site setting helper function
$getSiteSetting = getSiteSetting();
?>

<body class="hold-transition login-page secondbg">
  <!--for javascript uses-->
  <input type="hidden" id="thischaracterisnotallowed" class="thischaracterisnotallowed" value="<?php echo lang('This character is not allowed'); ?>">
  <input type="hidden" name="hidden_alert" id="hidden_alert" class="hidden_alert" value="<?php echo lang('alert'); ?>!">
  <input type="hidden" name="hidden_ok" id="hidden_ok" class="hidden_ok" value="<?php echo lang('ok'); ?>">
  <input type="hidden" name="hidden_cancel" id="hidden_cancel" class="hidden_cancel" value="<?php echo lang('cancel'); ?>">

  <div class="login-box">
    <div class="login-logo" style="border-radius: 5px; background-color: <?php echo escape_output($getSiteSetting->base_color); ?>; padding: 10px; box-shadow: 0 0 15px lightgreen;">
      <a href="#">
        <?php
        if (isset($getSiteSetting) && $getSiteSetting->site_logo) :
        ?>
          <img src="<?php echo base_url() . 'assets/images/'; ?><?php echo escape_output($getSiteSetting->site_logo); ?>">
        <?php
        else :
        ?>
          <img src="<?php echo base_url() . 'assets/branding/logo.png'; ?>">
        <?php
        endif;
        ?>
      </a>
    </div>
    <?php
    if ($this->session->flashdata('exception_1')) {
      echo '<div class="alert alert-danger alert-dismissible"> 
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p><i class="icon fa fa-check"></i>';
      echo escape_output($this->session->flashdata('exception_1'));
      echo '</p></div>';
    }
    ?>
    <!-- /.login-logo -->
    <div class="login-box-body txt-1">

      <p class="login-box-msg"><?php echo lang('please_login'); ?></p>
      <?php echo form_open(base_url() . 'Authentication/loginCheck', $arrayName = array('autocomplete' => 'off')) ?>

      <div class="form-group has-feedback">

        <?php if (APPLICATION_MODE == 'demo') {
          $demo =  "admin@admin.com";
        } else {
          $demo = '';
        } ?>

        <input type="text" autocomplete="off" class="form-control" name="email" placeholder="<?= lang('email'); ?>" value="<?= $demo ?>">
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div>

      <?php if (form_error('email')) : ?>
        <div class="alert alert-error txt-2">
          <p><?= form_error('email'); ?></p>
        </div>
      <?php endif; ?>

      <div class="form-group has-feedback">
        <?php if (APPLICATION_MODE == 'demo') {
          $password = "123456";
        } else {
          $password = "";
        } ?>
        <input type="password" autocomplete="off" name="password" class="form-control" placeholder="<?= lang('password'); ?>" value="<?= $password ?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <?php if (form_error('password')) : ?>
        <div class="alert alert-error txt-2">
          <p><?= form_error('password'); ?></p>
        </div>
      <?php endif; ?>

      <div class="form-group">
        <div class="checkbox">
          <label>
            <input type="checkbox" name="remember_me" value="1" checked="true"> Remember Me
          </label>
        </div>
      </div>

      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button style="background-color: <?= escape_output($getSiteSetting->base_color); ?>;border-color:<?= escape_output($getSiteSetting->base_color); ?>" type="submit" name="submit" value="submit" class="btn btn-primary btn-block btn-flat">
            <?= lang('login'); ?>
          </button>
        </div>
        <!-- /.col -->
      </div>
      <?php echo form_close(); ?>

    </div>
    <a href="<?= site_url('Authentication/forgotPassword') ?>" class="pull-right"><?php echo lang('ForgotPassword'); ?>?</a>
  </div>

  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
  <!-- custom login page js -->
  <script src="<?php echo base_url(); ?>assets/js/login.js"></script>
</body>

</html>