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
  <!-- Select2 -->
  <script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
  <!-- iCheck -->
  <script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/all.css">
  <!-- Sweet alert -->
  <script src="<?php echo base_url(); ?>assets/bower_components/sweetalert2/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/sweetalert2/dist/sweetalert.min.css">
  <!-- Include a polyfill for ES6 Promises (optional) for IE11 and Android browser -->
  <script src="<?php echo base_url(); ?>assets/plugins/local/core.js"></script>

  <!-- Numpad -->
  <script src="<?php echo base_url(); ?>assets/bower_components/numpad/jquery.numpad.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/numpad/jquery.numpad.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/numpad/theme.css">
  <!--datepicker-->
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datepicker/datepicker.css">

  <!-- bootstrap datepicker -->
  <script src="<?php echo base_url(); ?>assets/bower_components/datepicker/bootstrap-datepicker.js"></script>

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/jquery.mCustomScrollbar.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.css">
  <!-- iCheck -->
  <link href="<?php echo base_url(); ?>asset/plugins/iCheck/minimal/color-scheme.css" rel="stylesheet">
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/branding/favicon.ico" type="image/x-icon">

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datetimepicker/css/bootstrap-datetimepicker.css">
  <script src="<?php echo base_url(); ?>assets/bower_components/datetimepicker/js/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/bower_components/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>


  <!-- custom css -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/user_home.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin_.css">

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

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/google_font.css">

  <style type="text/css">
    .skin-blue .main-header .logo,
    .btn-default,
    table:not(.table-condensed) thead,
    .pagination>.active>a,
    .btn-default:hover,
    .btn-default:active,
    .btn-default.hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
      background-color: <?php echo escape_output($base_color) ?> !important;
    }

    #userAvatar {
      fill: <?php echo escape_output($base_color) ?> !important;
    }

    .btn-primary,
    #datatable_wrapper .dt-buttons button {
      background-color: <?php echo escape_output($base_color) ?> !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: <?php echo escape_output($base_color) ?> !important;
      border-color: <?php echo escape_output($base_color) ?> !important;
      padding: 1px 10px;
      color: #fff;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
      background-color: <?php echo escape_output($base_color) ?> !important;
      color: white;
    }

    .form-control:focus {
      border-color: <?php echo escape_output($base_color) ?> !important;
      outline: none;
      box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, .25);
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
//get second segment of url
$uri = $this->uri->segment(2);
?>
<div class="loader"></div>
<!-- ADD THE CLASS sidebar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->

<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
  <!--for javascript uses-->
  <input type="hidden" name="datatable_showing" id="datatable_showing" value="<?php echo lang('Showing') ?>">
  <input type="hidden" name="Showing_to" id="Showing_to" value="<?php echo lang('Showing_to') ?>">
  <input type="hidden" name="Showing_from" id="Showing_from" value="<?php echo lang('Showing_from') ?>">
  <input type="hidden" name="Showing_entries" id="Showing_entries" value="<?php echo lang('Showing_entries') ?>">
  <input type="hidden" name="First" id="show_First" value="<?php echo lang('First') ?>">
  <input type="hidden" name="Last" id="show_Last" value="<?php echo lang('Last') ?>">
  <input type="hidden" name="Next" id="show_Next" value="<?php echo lang('Next') ?>">
  <input type="hidden" name="Prev" id="show_Prev" value="<?php echo lang('Prev') ?>">
  <input type="hidden" name="no_data_in_table" id="no_data_in_table" value="<?php echo lang('no_data_in_table') ?>">
  <input type="hidden" name="no_match_data_in_table" id="no_match_data_in_table" value="<?php echo lang('no_match_data_in_table') ?>">
  <input type="hidden" name="hidden_currency" class="hidden_currency" id="hidden_currency" value="<?php echo escape_output($this->session->userdata('currency')) ?>">
  <input type="hidden" name="hidden_base_url" class="hidden_base_url" id="hidden_base_url" value="<?php echo base_url() ?>">
  <input type="hidden" id="thischaracterisnotallowed" class="thischaracterisnotallowed" value="<?php echo lang('This character is not allowed'); ?>">
  <input type="hidden" name="hidden_alert" id="hidden_alert" class="hidden_alert" value="<?php echo lang('alert'); ?>!">
  <input type="hidden" name="hidden_ok" id="hidden_ok" class="hidden_ok" value="<?php echo lang('ok'); ?>">
  <input type="hidden" name="hidden_cancel" id="hidden_cancel" class="hidden_cancel" value="<?php echo lang('cancel'); ?>">
  <input type="hidden" name="are_you_sure" id="are_you_sure" class="are_you_sure" value="<?php echo lang('are_you_sure'); ?>">
  <input type="hidden" name="delete_msg_dummy_data" id="delete_msg_dummy_data" class="delete_msg_dummy_data" value="<?php echo lang('delete_msg_dummy_data'); ?>">
  <input type="hidden" name="image_msg" id="image_msg" class="image_msg" value="<?php echo lang('image_msg'); ?>">
  <input type="hidden" name="favicon_size_check" id="favicon_size_check" class="favicon_size_check" value="<?php echo lang('favicon_size_check'); ?>">
  <input type="hidden" name="favicon_w_h_check" id="favicon_w_h_check" class="favicon_w_h_check" value="<?php echo lang('favicon_w_h_check'); ?>">
  <input type="hidden" name="login_size_check" id="login_size_check" class="login_size_check" value="<?php echo lang('login_size_check'); ?>">
  <input type="hidden" name="login_w_h_check" id="login_w_h_check" class="login_w_h_check" value="<?php echo lang('login_w_h_check'); ?>">
  <input type="hidden" name="site_size_check" id="site_size_check" class="site_size_check" value="<?php echo lang('site_size_check'); ?>">
  <input type="hidden" name="site_w_h_check" id="site_w_h_check" class="site_w_h_check" value="<?php echo lang('site_w_h_check'); ?>">
  <input type="hidden" name="site_w_h_check_middle" id="site_w_h_check_middle" class="site_w_h_check_middle" value="<?php echo lang('site_w_h_check_middle'); ?>">
  <input type="hidden" name="get_csrf_token_name" id="get_csrf_token_name" class="get_csrf_token_name" value="<?php echo escape_output($this->security->get_csrf_token_name()); ?>">
  <input type="hidden" name="get_csrf_hash" id="get_csrf_hash" class="get_csrf_hash" value="<?php echo escape_output($this->security->get_csrf_hash()); ?>">
  <input type="hidden" name="select_" id="select_" class="select_" value="<?php echo lang('select'); ?>">
  <!--<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">-->
  <!-- Site wrapper -->
  <div class="wrapper">

    <header class="main-header">

      <!-- Logo -->
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><?php echo isset($getSiteSetting->site_title) && $getSiteSetting->site_title ? substr(ucwords(strtolower($getSiteSetting->site_title)), 0, 1) : '' ?></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
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

        </span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu left-sdide">
          <ul class="nav navbar-nav">
            <?php if ($this->session->userdata('outlet_id')) { ?>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="<?php echo base_url(); ?>orderManagement/orders">
                  <i data-feather="shopping-cart"></i>
                  <span class="hidden-xs"><?php echo lang('orders'); ?></span>
                </a>
              </li>
              <li class="dropdown user user-menu">
                <a href="<?php echo base_url(); ?>Purchase/addEditPurchase">
                  <i data-feather="truck"></i>
                  <span class="hidden-xs"><?php echo lang('purchase'); ?></span>
                </a>
              </li>
              <li class="dropdown user user-menu">
                <a href="<?= base_url('/'); ?>" target="_blank">
                  <i data-feather="monitor"></i>
                  <span class="hidden-xs">Front Page</span>
                </a>
              </li>
              <?php
              $url = $this->uri->segment(2);
              if ($url == "addEditSale") :
              ?>
                <li class="dropdown user user-menu">
                  <a href="#" onclick="shortcut();" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-keyboard-o"></i><span class="hidden-xs"><?php echo lang('shortcut_keys'); ?></span>
                  </a>
                </li>
              <?php endif; ?>
            <?php } ?>
          </ul>
        </div>
        <div class="navbar-custom-menu dashboard-lang-nav">

          <ul class="nav navbar-nav">
            <li class="dropdown notifications-menu">
              <?php
              $notifications = $this->db->where('del_status', 'Live')->limit(50)->order_by('id', 'DESC')->get('tbl_notifications')->result();
              $notifications_read_count = $this->db->where('del_status', 'Live')->where('visible_status', '1')->get('tbl_notifications')->result();
              ?>
              <a data-value="1" aria-expanded="true" href="#" class="txt-a-1 dropdown-toggle notif_class" data-toggle="dropdown">
                <i data-feather="bell" class="txt-a-2"></i>
                <span id="totalNotifications" class="txt-uh-3 label label-danger"><?php echo sizeof($notifications_read_count) ?></span>
              </a>
              <ul class="dropdown-menu width_notification txt-uh-4">
                <div class="div txt-uh-5">
                  <span class="txt-uh-6"><b class="txt-uh-7"><?php echo lang('Notifications'); ?></b></span>
                  <span class="txt-uh-8">
                    <a data-id="" data-value="3" class="txt-uh-9 markAllAsRead changeStatus"><?php echo lang('MarkAllasRead'); ?></a>&nbsp;&nbsp;
                  </span>
                </div>
                <hr class="txt-uh-10">
                <table id="table" class="append_notification">
                  <?php foreach ($notifications as $notification) : ?>
                    <tr id="id_<?php echo escape_output($notification->id); ?>" class="delete_background" style="width:100%;<?php echo isset($notification->visible_status) && $notification->visible_status == "1" ? 'border-left: 10px solid #e74c3c;' : '' ?>">
                      <td class="txt-uh-11">
                        <a class="txt-uh-12">
                          <?= escape_output($notification->notifications_details); ?>
                        </a>
                      </td>
                      <td class="txt-uh-13 td">
                        <button class="changeStatus txt-uh-14" title="<?php echo lang('Markasread'); ?>" value="<?php echo escape_output($notification->id); ?>" data-id="<?php echo escape_output($notification->id); ?>" data-value="4"><i class="fa fa-eye"></i></button>
                        <button class="txt-uh-1" title="<?php echo lang('DeleteNotification'); ?>" value="<?php echo escape_output($notification->id); ?>" data-id="<?php echo escape_output($notification->id); ?>"><i class="delete_notification fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>

                </table>

                <li class="footer"><a href="#"><?php echo lang('SeeAllNotifications'); ?></a></li>
              </ul>
            </li>

            <li class="dropdown messages-menu translate-now open txt-uh-15">
              <?php $language = $this->session->userdata('language'); ?>
              <?php echo form_open(base_url() . 'Authentication/setlanguage', $arrayName = array('id' => 'language')) ?>
              <!-- <form action="<?php echo base_url(); ?>Authentication/setlanguage" method="POST"> -->
              <select tabindex="2" class="form-control select2 txt-uh-16" name="language" onchange='this.form.submit()'>
                <?php
                $dir = glob("application/language/*", GLOB_ONLYDIR);
                foreach ($dir as $value) :
                  $separete = explode("language/", $value);
                ?>
                  <option <?php echo isset($language) && $language == $separete[1] ? 'selected' : '' ?> value="<?php echo escape_output($separete[1]) ?>"><?php echo ucfirst($separete[1]) ?></option>
                <?php
                endforeach;
                ?>
              </select>
              </form>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="user user-menu logout">
              <a href="<?php echo base_url(); ?>Authentication/logOut">Logout
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <?php

            if ($this->session->userdata('photo') != '') {
              $photo = "images/" . $this->session->userdata('photo');
            } else {
              $photo = 'assets/images/chef.png';
            }

            ?>
            <img src="<?php echo base_url() . $photo; ?>" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo escape_output($this->session->userdata('outlet_name')); ?></p>
            <p><?php echo escape_output($this->session->userdata('full_name')); ?></p>
          </div>
        </div>
        <ul class="sidebar-menu">
          <li class="header"><?php echo lang('main_navigation'); ?></li>
        </ul>
        <div id="left_menu_to_scroll">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li>
              <a href="<?php echo base_url(); ?>Authentication/userProfile">
                <i data-feather="home"></i> <span><?php echo lang('home'); ?></span></a>
            </li>

            <?php if (has_permission('show_dashboard')) : ?>
              <li>
                <a href="<?= site_url('Dashboard/dashboard') ?>"><i data-feather="grid"></i>
                  <span><?= lang('dashboard'); ?></span></a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['site_setting', 'edit_setting', 'add_announcement', 'show_announcement', 'edit_announcement', 'delete_announcement'])) : ?>
              <li class="treeview">
                <a href="#">
                  <i data-feather="settings"></i> <span> Settings</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php if (has_permission(['add_announcement', 'show_announcement', 'edit_announcement', 'delete_announcement'])) : ?>
                    <li>
                      <a href="<?php echo base_url('Announcement/index'); ?>">
                        <i class="fa fa-angle-double-right"></i> Announcement
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if (has_permission(['site_setting', 'edit_setting'])) : ?>
                    <li>
                      <a href="<?php echo base_url('authentication/siteSetting'); ?>">
                        <i class="fa fa-angle-double-right"></i> <?php echo lang('site_setting'); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                </ul>
              </li>
            <?php endif; ?>


            <?php if (has_permission(['add_unit', 'show_unit', 'edit_unit', 'delete_unit', 'add_category', 'show_category', 'edit_category', 'sort_category', 'delete_category', 'add_sub_category', 'show_sub_category', 'edit_sub_category', 'sort_sub_category', 'delete_sub_category', 'add_product', 'show_product', 'edit_product', 'sort_product', 'barcode_product', 'upload_product', 'delete_product'])) : ?>
              <li class="treeview">
                <a href="#">
                  <i data-feather="database"></i> <span><?php echo lang('master'); ?></span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">

                  <?php if (has_permission(['add_product', 'show_product', 'edit_product', 'sort_product', 'upload_product', 'barcode_product', 'delete_product'])) : ?>
                    <li>
                      <a href="<?= site_url('Item/products') ?>">
                        <i class="fa fa-angle-double-right"></i><?= lang('products'); ?>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if (has_permission(['add_color', 'show_color', 'edit_color', 'delete_color'])) : ?>
                    <li>
                      <a href="<?= site_url('admin/color') ?>">
                        <i class="fa fa-angle-double-right"></i> Attibute colors
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if (has_permission(['add_size', 'show_size', 'edit_size', 'delete_size'])) : ?>
                    <li>
                      <a href="<?= site_url('admin/size') ?>">
                        <i class="fa fa-angle-double-right"></i> Attribute sizes
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if (has_permission(['add_category', 'show_category', 'edit_category', 'sort_category', 'delete_category'])) : ?>
                    <li>
                      <a href="<?= site_url('Category/productCategories') ?>">
                        <i class="fa fa-angle-double-right"></i><?= lang('product_categories'); ?>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if (has_permission(['add_sub_category', 'show_sub_category', 'edit_sub_category', 'sort_sub_category', 'delete_sub_category'])) : ?>
                    <li>
                      <a href="<?= site_url('SubCategory/productSubCategories') ?>">
                        <i class="fa fa-angle-double-right"></i><?= lang('product_subcategories'); ?>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if (has_permission(['add_unit', 'show_unit', 'edit_unit', 'delete_unit'])) : ?>
                    <li>
                      <a href="<?= site_url('Unit/Units') ?>">
                        <i class="fa fa-angle-double-right"></i><?= lang('product_units'); ?>
                      </a>
                    </li>
                  <?php endif; ?>

                </ul>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['add_coupon', 'show_coupon', 'edit_coupon', 'sort_coupon', 'delete_coupon', 'show_coupon_customer', 'add_customer', 'show_customer', 'edit_customer', 'delete_customer', 'show_order', 'print_invoice', 'print_package_slip', 'process_order', 'dispatch_order', 'complete_order', 'return_order', 'cancel_order', 'assign_delivery', 'add_note', 'product_purchase'])) : ?>
              <li class="treeview">
                <a href="#">
                  <i data-feather="shopping-cart"></i> <span><?php echo lang('order'); ?></span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php if (has_permission(['add_coupon', 'show_coupon', 'edit_coupon', 'sort_coupon', 'delete_coupon'])) : ?>
                    <li>
                      <a href="<?= site_url('Coupon/coupons'); ?>">
                        <i class="fa fa-angle-double-right"></i> <?= lang('coupons'); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if (has_permission('show_coupon_customer')) : ?>
                    <li>
                      <a href="<?= site_url('Coupon/couponsCustomers'); ?>">
                        <i class="fa fa-angle-double-right"></i> <?= lang('coupons_customer'); ?>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if (has_permission(['add_customer', 'show_customer', 'edit_customer', 'delete_customer'])) : ?>
                    <li>
                      <a href="<?= site_url('Customer/customers'); ?>">
                        <i class="fa fa-angle-double-right"></i> <?= lang('customers'); ?>
                      </a>
                    </li>
                  <?php endif; ?>

                  <?php if (has_permission(['show_order', 'print_invoice', 'print_package_slip', 'process_order', 'dispatch_order', 'complete_order', 'return_order', 'cancel_order', 'assign_delivery', 'add_note', 'product_purchase'])) : ?>
                    <li>
                      <a href="<?= site_url('orderManagement/orders'); ?>">
                        <i class="fa fa-angle-double-right"></i> <?= lang('orders'); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                </ul>
              </li>
            <?php endif; ?>

            <?php if (has_permission('show_cash')) : ?>
              <li>
                <a href="<?= site_url('deliveryPerson/deliveryPersonItems'); ?>">
                  <i data-feather="dollar-sign"></i> <span> <?= lang('MyCash') ?> </span>
                </a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['add_payment_method', 'show_payment_method', 'edit_payment_method', 'delete_payment_method'])) : ?>
              <li>
                <a href="<?= site_url('PaymentMethod/paymentMethods') ?>">
                  <i data-feather="credit-card"></i> <span><?= lang('payment_methods'); ?></span>
                </a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['show_stock', 'alert_stock_list'])) : ?>
              <li>
                <a href="<?= site_url('Inventory/inventory'); ?>">
                  <i data-feather="server"></i>
                  <span><?= lang('inventory'); ?></span>
                </a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['add_supplier', 'show_supplier', 'edit_supplier', 'delete_supplier', 'add_purchase', 'show_purchase', 'view_details', 'edit_purchase', 'delete_purchase'])) : ?>
              <li class="treeview">
                <a href="#">
                  <i data-feather="truck"></i> <span><?php echo lang('purchase'); ?></span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php if (has_permission(['add_supplier', 'show_supplier', 'edit_supplier', 'delete_supplier'])) : ?>
                    <li>
                      <a href="<?= site_url('Supplier/suppliers') ?>">
                        <i class="fa fa-angle-double-right"></i><?= lang('suppliers'); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if (has_permission(['add_purchase', 'show_purchase', 'view_details', 'edit_purchase', 'delete_purchase'])) : ?>
                    <li>
                      <a href="<?= site_url("Purchase/purchases") ?>"><i class="fa fa-angle-double-right"></i><?= lang('purchase'); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                </ul>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['show_bulk_price', 'update_bulk_price'])) : ?>
              <li>
                <a href="<?= site_url('bulkPriceUpdate/index'); ?>"><i data-feather="upload"></i>
                  <span><?= lang('BulkPriceUpdate'); ?></span></a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['add_expense_category', 'show_expense_category', 'edit_expense_category', 'delete_expense_category', 'add_expense', 'show_expense', 'edit_expense', 'delete_expense'])) : ?>
              <li class="treeview">
                <a href="#">
                  <i data-feather="dollar-sign"></i> <span><?php echo lang('expense'); ?></span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php if (has_permission(['add_expense_category', 'show_expense_category', 'edit_expense_category', 'delete_expense_category'])) : ?>
                    <li>
                      <a href="<?= site_url('ExpenseItem/expenseItems') ?>">
                        <i class="fa fa-angle-double-right"></i><?= lang('expense_category'); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if (has_permission(['add_expense', 'show_expense', 'edit_expense', 'delete_expense'])) : ?>
                    <li>
                      <a href="<?= site_url('Expense/expenses') ?>">
                        <i class="fa fa-angle-double-right"></i><?= lang('expense'); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                </ul>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['add_due_payment', 'show_due_payment', 'delete_due_payment'])) : ?>
              <li>
                <a href="<?= base_url('SupplierPayment/supplierPayments'); ?>"><i data-feather="minus-square"></i>
                  <span><?= lang('supplier_due_payment'); ?></span></a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['add_attendance', 'show_attendance', 'edit_attendance', 'delete_attendance'])) : ?>
              <li>
                <a href="<?php echo base_url(); ?>Attendance/attendances"><i data-feather="clock"></i>
                  <span><?php echo lang('attendance'); ?></span></a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['restaurant_setting'])) : ?>
              <li>
                <a href="<?php echo base_url(); ?>POS_setting/setting"><i data-feather="settings"></i>
                  <span><?php echo lang('restaurant_setting'); ?></span></a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['add_payroll', 'show_payroll', 'edit_payroll', 'delete_payroll'])) : ?>
              <li>
                <a href="<?php echo base_url(); ?>salary/generate"><i data-feather="folder"></i>
                  <span><?php echo lang('salary'); ?></span></a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['add_damage', 'show_damage', 'edit_damage', 'delete_damage'])) : ?>
              <li>
                <a href="<?php echo base_url(); ?>Damage/damages"><i data-feather="trash-2"></i>
                  <span><?php echo lang('damage'); ?></span></a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['add_quotation', 'show_quotation', 'edit_quotation', 'delete_quotation'])) : ?>
              <li>
                <a href="<?php echo base_url(); ?>Quotation/quotations"><i data-feather="file"></i><span><?php echo lang('quotation'); ?></span></a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['show_permission', 'edit_permission', 'add_user', 'show_user', 'edit_user', 'delete_user', 'add_role', 'show_role', 'edit_role', 'delete_role', 'add_employee', 'show_employee', 'edit_employee', 'delete_employee'])) : ?>
              <li class="treeview">
                <a href="#">
                  <i data-feather="cpu"></i> <span> <?= lang('accessControl'); ?></span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <?php if (has_permission(['show_permission', 'edit_permission'])) : ?>
                    <li>
                      <a href="<?= site_url('admin/permission'); ?>">
                        <i class="fa fa-circle-notch"></i> <?= lang('permission'); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if (has_permission(['add_user', 'show_user', 'edit_user', 'delete_user'])) : ?>
                    <li>
                      <a href="<?= site_url('admin/user'); ?>">
                        <i class="fa fa-user"></i> <?= lang('users'); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if (has_permission(['add_role', 'show_role', 'edit_role', 'delete_role'])) : ?>
                    <li>
                      <a href="<?= site_url('admin/role'); ?>">
                        <i class="fa fa-circle-notch"></i> <?= lang('role'); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if (has_permission(['add_employee', 'show_employee', 'edit_employee', 'delete_employee'])) : ?>
                    <li>
                      <a href="<?= site_url('User/users'); ?>">
                        <i class="fa fa-users"></i> <?= lang('employee'); ?>
                      </a>
                    </li>
                  <?php endif; ?>
                </ul>
              </li> <!-- access control -->
            <?php endif; ?>

            <?php if (has_permission(['add_deposit', 'show_deposit', 'edit_deposit', 'delete_deposit'])) : ?>
              <li>
                <a href="<?= site_url('Deposit/deposits') ?>"><i data-feather="briefcase"></i> <?php echo lang('deposit_or_withdraw'); ?>
                </a>
              </li>
            <?php endif; ?>

            <?php if (has_permission(['show_backup', 'take_backup'])) : ?>
              <li>
                <a href="<?php echo base_url(); ?>Authentication/databaseBackup">
                  <i data-feather="save"></i> <span><?php echo lang('database_backup'); ?></span>
                </a>
              </li>
            <?php endif; ?>

            <!--<li><a href="<?php /*echo base_url(); */ ?>Authentication/updateSoftware"><i data-feather="download-cloud"></i> <span><?php /*echo lang('update_software'); */ ?></span></a></li>-->
            <li class="treeview">
              <a href="#">
                <i data-feather="file-text"></i> <span><?php echo lang('report'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if (has_permission('sale_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/saleReport"><i class="fa fa-angle-double-right"></i><?php echo lang('productSaleReport'); ?></a></li>
                <?php endif; ?>
                <?php if (has_permission('order_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/orderReport"><i class="fa fa-angle-double-right"></i><?php echo lang('OrderReport'); ?></a></li>
                <?php endif; ?>
                <?php if (has_permission('customer_order_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/customerOrderReport"><i class="fa fa-angle-double-right"></i><?php echo lang('CustomerOrderReport'); ?></a></li>
                <?php endif; ?>
                <?php if (has_permission('product_order_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/productOrderReport"><i class="fa fa-angle-double-right"></i><?php echo lang('ProductOrderReport'); ?></a></li>
                <?php endif; ?>
                <?php if (has_permission('most_less_order_product_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/mostLessOrderReport"><i class="fa fa-angle-double-right"></i><?php echo lang('MostLessOrderProductsReport'); ?></a></li>
                <?php endif; ?>
                <?php if (has_permission('balance_sheet')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/balanceSheet"><i class="fa fa-angle-double-right"></i><?php echo lang('BalanceSheet'); ?></a></li>
                <?php endif; ?>
                <?php if (has_permission('daily_summary_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/dailySummaryReport"><i class="fa fa-angle-double-right"></i><?php echo lang('daily_summary_report'); ?></a></li>
                <?php endif; ?>
                <!--<li><a href="<?php /*echo base_url(); */ ?>Report/productSaleReport"><i class="fa fa-angle-double-right"></i><?php /*echo lang('productSaleReport'); */ ?></a></li>-->
                <?php if (has_permission('stock_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/inventoryReport"><i class="fa fa-angle-double-right"></i><?php echo lang('inventory_report'); ?></a></li>
                <?php endif; ?>
                <?php if (has_permission('low_stock_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Inventory/getInventoryAlertList"><i class="fa fa-angle-double-right"></i><?php echo lang('low_inventory_report'); ?></a></li>
                <?php endif; ?>
                <!--<li><a href="<?php /*echo base_url(); */ ?>Report/profitLossReport"><i class="fa fa-angle-double-right"></i><?php /*echo lang('profit_loss_report'); */ ?></a></li>-->
                <?php if (has_permission('supplier_ledger')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/supplierReport"><i class="fa fa-angle-double-right"></i><?php echo lang('supplier_ledger'); ?></a></li>
                <?php endif; ?>
                <?php if (has_permission('supplier_due_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/supplierDueReport"><i class="fa fa-angle-double-right"></i><?php echo lang('supplier_due_report'); ?></a></li>
                <?php endif; ?>
                <!--<li><a href="<?php /*echo base_url(); */ ?>Report/customerReport"><i class="fa fa-angle-double-right"></i><?php /*echo lang('customer_ledger'); */ ?></a></li>-->
                <?php if (has_permission('attendance_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/attendanceReport"><i class="fa fa-angle-double-right"></i><?php echo lang('attendance_report'); ?></a></li>
                <?php endif; ?>
                <!--<li><a href="<?php /*echo base_url(); */ ?>Report/saleReport"><i class="fa fa-angle-double-right"></i><?php /*echo lang('food_sale_report'); */ ?></a></li>-->
                <!--              <li>-->
                <!--                <a href="--><?php //echo base_url(); 
                                                ?>
                <!--Report/saleReportByDate">-->
                <!--                  <i class="fa fa-angle-double-right"></i>--><?php //echo lang('daily_sale_report'); 
                                                                                  ?>
                <!--                </a>-->
                <!--              </li>-->
                <!--<li><a href="<?php /*echo base_url(); */ ?>Report/detailedSaleReport"><i class="fa fa-angle-double-right"></i><?php /*echo lang('detailed_sale_report'); */ ?></a></li>-->
                <?php if (has_permission('purchase_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/purchaseReportByDate"><i class="fa fa-angle-double-right"></i><?php echo lang('purchase_report'); ?></a></li>
                <?php endif; ?>
                <?php if (has_permission('product_purchase_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/productPurchaseReport"><i class="fa fa-angle-double-right"></i><?php echo lang('productPurchaseReport'); ?></a></li>
                <?php endif; ?>
                <?php if (has_permission('expense_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/expenseReport"><i class="fa fa-angle-double-right"></i><?php echo lang('expense_report'); ?></a></li>
                <?php endif; ?>
                <?php if (has_permission('damage_report')) : ?>
                  <li><a href="<?php echo base_url(); ?>Report/damageReport"><i class="fa fa-angle-double-right"></i><?php echo lang('damage_report'); ?></a></li>
                <?php endif; ?>

                <?php if (has_permission('tax_report')) : ?>
                  <li style="display: <?php echo isset($collect_tax) && $collect_tax == "Yes" ? 'block' : 'none' ?>">
                    <a href="<?php echo base_url(); ?>Report/taxReport">
                      <i class="fa fa-angle-double-right"></i><?php echo lang('vat'); ?> <?php echo lang('report'); ?>
                    </a>
                  </li>
                <?php endif; ?>

              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i data-feather="user"></i> <span><?php echo lang('account'); ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url(); ?>Authentication/changeProfile"><i class="fa fa-angle-double-right"></i><?php echo lang('change_profile'); ?></a></li>
                <li><a href="<?php echo base_url(); ?>Authentication/changePassword"><i class="fa fa-angle-double-right"></i><?php echo lang('change_password'); ?></a></li>
                <li><a href="<?php echo base_url(); ?>Authentication/logOut"><i class="fa fa-angle-double-right"></i><?php echo lang('logout'); ?></a></li>
              </ul>
            </li>

          </ul>
        </div>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <?php if ($this->session->flashdata('exception')) : ?>
        <section class="content-header">
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>
              <i class="icon fa fa-check"></i>
              <?= escape_output($this->session->flashdata('exception')) ?>
            </p>
          </div>
        </section>
      <?php elseif ($this->session->flashdata('error')) : ?>
        <section class="content-header">
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p>
              <i class="icon fa fa-close"></i>
              <?= escape_output($this->session->flashdata('error')) ?>
            </p>
          </div>
        </section>
      <?php endif; ?>

      <!-- Main content -->
      <?php
      if (isset($main_content)) {
        echo $main_content; //This variable should not be escaped, because other view files is being parsed by this variable where all dynamic data are escaped in those view files
      } ?>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="row">
        <div class="col-md-12 no_print txt-uh-18">
          <?php
          if (isset($getSiteSetting) && $getSiteSetting->footer) :
            echo escape_output($getSiteSetting->footer);
          else :
          ?>

          <?php
          endif;
          ?>

          <div class="hidden-lg">

          </div>
        </div>
      </div>
    </footer>
  </div>

  <div class="modal fade" id="todaysSummary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="ShortCut">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
          <h2 class="txt-uh-19" id="myModalLabel"><?php echo lang('todays_summary'); ?></h2>
        </div>
        <div class="modal-body">
          <div class="box-body table-responsive">

            <table class="table">
              <tr>
                <td class="txt-uh-20"><?php echo lang('total'); ?> <?php echo lang('purchase'); ?>(<?php echo lang('only_paid_amount'); ?>)
                </td>
                <td><span id="purchase"></span></td>
              </tr>
              <tr>
                <td><?php echo lang('total'); ?> <?php echo lang('sale'); ?>(<?php echo lang('only_paid_amount'); ?>)</td>
                <td><span id="sale"></span></td>
              </tr>
              <tr>
                <td><?php echo lang('total'); ?><?php echo lang('expense'); ?></td>
                <td><span id="Expense"></span></td>
              </tr>
              <tr>
                <td><?php echo lang('total'); ?><?php echo lang('supplier_due_payment'); ?></td>
                <td><span id="supplierDuePayment"></span></td>
              </tr>
              <tr>
                <td><?php echo lang('total'); ?><?php echo lang('damage'); ?></td>
                <td><span id="waste"></span></td>
              </tr>
              <?php
              $txt = '';
              ?>

              <tr>
                <td>Balance = (<?php echo lang('sale'); ?>) - (<?php echo lang('purchase'); ?> + <?php echo lang('supplier_due_payment'); ?>
                  + <?php echo lang('expense'); ?>))
                </td>
                <td><span id="balance"></span></td>
              </tr>
            </table>

            <br>

            <div id="showCashStatus"></div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ./wrapper -->

  <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo lang('register_details'); ?> <span id="opening_closing_register_time">(<span id="opening_register_time"></span> <?php echo lang('to'); ?> <span id="closing_register_time"></span>)</span></h4>
        </div>
        <div class="modal-body" id="register_details_body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        </div>
      </div>

    </div>
  </div>

  <!-- require for tooltip -->
  <script src="<?php echo base_url(); ?>assets/dist/js/popper.min.js"></script>
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
  <!-- material icon -->
  <script src="<?php echo base_url(); ?>assets/dist/js/feather.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/howler.min.js"></script>
  <!-- hidden fields value -->
  <script src="<?php echo base_url(); ?>assets/js/hidden_filed_value.js"></script>
  <!-- custom js -->
  <script src="<?php echo base_url(); ?>assets/js/user_home.js"></script>
  <!-- custom js -->
  <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>



</body>

</html>