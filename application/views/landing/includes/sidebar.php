<?php

$sidebar_categories = sidebar_categories();

?>


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <div class="sidebar_header">
    <button type="button" class="btn btn-close sidebar_collapse">
      <i class="icon-cancel"></i>
    </button>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel d-flex">
      <?php if (isset($photo)): ?>
        <div class="image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
      <?php endif; ?>
      <div class="info w-100">
        <?php
        $c_id = $this->session->userdata("c_id");
        $c_name = $this->session->userdata("c_name");
        $c_photo = $this->session->userdata("c_photo");
        $c_phone = $this->session->userdata("c_phone");
        ?>
        <?php if ($c_id) : ?>
          <a href="<?= site_url('/') ?>" class="d-block p-1"><?= isset($c_name) && $c_name ? $c_name : 'Customer' ?></a>
          <a href="#change_profile" data-toggle="modal" class="d-block p-1"><?= lang('ChangeProfile'); ?></a>
          <a href="<?= site_url('my-orders') ?>" class="d-block p-1"><?= lang('MyOrders'); ?></a>
          <a href="<?= site_url('logout') ?>" class="d-block p-1"><?= lang('Logout'); ?></a>
        <?php else : ?>
          <a href="<?= site_url('login') ?>" class="d-block p-1"><i class="icon-user-female"></i> Login</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header"><?= lang('SpecialDeal'); ?></li>

        <?php

        foreach ($sidebar_categories as $key => $value) :

          $has_subcategories = count($value['subcategories']) ?? 0;

          if ($has_subcategories):

            ?>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <img src="<?= base_url("images/" . $value['icon']) ?>" width="25" alt="">
                <p>
                  <?= $value['name'] ?>
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview pl-3">
                <?php foreach ($value['subcategories'] as $key1 => $value1) : ?>
                  <li class="nav-item">
                    <a href="<?= site_url($value1['child_slug'] ?? '') ?>" class="nav-link">
                      <img src="<?= base_url("images/" . $value1['child_icon']) ?>" width="25" alt="">
                      <p><?= $value1['child_name'] ?? '' ?></p>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </li>

          <?php else : ?>

            <li class="nav-item">
              <a href="<?= site_url($value['slug'] ?? '') ?>" class="nav-link">
                <img src="<?= base_url("images/" . $value['icon']) ?>" width="25" alt="">
                <p><?= $value['name'] ?? '' ?></p>
              </a>
            </li>

          <?php endif; ?>

        <?php endforeach; ?>


      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>