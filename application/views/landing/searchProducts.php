<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">

<span class="search_options d-none"><?= json_encode(['page' => 'search']) ?></span>

<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">
    <div class="row align-items-center">
      <div class="col-md-12">
        <ol class="breadcrumb justify-content-start">
          <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item active">searching</li>
        </ol>
      </div>
    </div>
  </div>
</div>


<div class="main_content">

  <div class="section small_pt">
    <div class="custom-container">
      <div id="searching_product_load" class="row row-cols-2 row-cols-lg-5  row-cols-md-4 row-cols-sm-3 search_products_container">
        <?php if (isset($products)) : ?>
          <?php if (count($products)) : ?>
            <?php $this->load->view('landing/ajax/products', ['products' => $products, 'landing' => false]); ?>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>


</div>