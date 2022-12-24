<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">

<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="page-title">
          <h1><?= $page->menu_name ?? 'Error page' ?></h1>
        </div>
      </div>
      <div class="col-md-6">
        <ol class="breadcrumb justify-content-md-end">
          <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item active"><?= $page->menu_name ?? 'Error page' ?></li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="main_content">

  <div class="section py-3">
    <div class="custom-container">
      <div class="row">
        <div class="col-12">
          <div class="term_conditions">
            <?= $page->menu_content ?>
          </div>
        </div>
      </div>
    </div>
  </div>

</div> <!-- main_content -->