<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">

<!-- <div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="page-title">
          <h1><?= $category->name ?></h1>
        </div>
      </div>
      <div class="col-md-6">
        <ol class="breadcrumb justify-content-md-end">
          <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item active"><?= $category->name ?></li>
        </ol>
      </div>
    </div>
  </div>
</div> -->



<!-- END MAIN CONTENT -->
<div class="main_content">
  <!-- START SECTION SHOP -->
  <div class="section small_pb pt-4">
    <div class="custom-container">
      <?php if ($category->top_banner) :
      ?>
        <div class="row">
          <div class="col-md-12 mb-5 text-center">
            <img src="<?= base_url('images/' . $category->top_banner) ?>" class="img-fluid">
          </div>
        </div>
      <?php endif  ?>

      <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6">
        <?php if (isset($subcategory) && $subcategory) :
          foreach ($subcategory as $value) : ?>
            <div class="col px-2">
              <a href="<?= site_url($value->slug) ?>" class="item category" title="<?= $value->name ?>">
                <div class="product">
                  <div class="product_img">
                    <?php $cat_image = $value->icon ? 'images/' . $value->icon : 'assets/images/no-image.png'; ?>
                    <img src="<?= base_url($cat_image) ?>" style="width: 156px;" alt="<?= $value->name ?>">
                  </div>
                  <div class="product_info">
                    <h6 class="product_title"><?= $value->name ?></h6>
                  </div>
                </div>
              </a>
            </div>
        <?php
          endforeach;
        endif;
        ?>
      </div>
    </div>
  </div>
  <!-- END SECTION SHOP -->

  <?php if (isset($products) && !empty($products)) : ?>
    <div class="section main_div_product mb-5">
      <div class="custom-container">
        <div class="row bg-white">
          <div class="col-md-12">
            <h1 class="py-3 m-0" style="font-size: 1.8rem;">Related Products</h1>
          </div>
          <div class="col-md-12">
            <div class="cat_slider py-3 carousel_slider owl-carousel owl-theme nav_style5" data-loop="false" data-dots="false" data-nav="true" data-margin="15" data-responsive='{"0":{"items": "2"}, "650":{"items": "4"}, "1199":{"items": "4"}}'>
              <?php $this->load->view('landing/ajax/products', ['products' => $products, 'landing' => true]); ?>

            </div> <!-- cat_slider -->
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>


  <?php if ($category->bottom_left_banner || $category->bottom_top_banner || $category->bottom_top_banner) : ?>

    <!-- START SECTION BANNER -->
    <!-- <div class="section pb_20 small_pt">
      <div class="custom-container px-2">
        <div class="row no-gutters">
          <div class="col-md-4">
            <?php if ($category->bottom_left_banner) : ?>
              <div class="sale_banner">
                <a class="hover_effect1" href="#">
                  <img src="<?= base_url('images/' . $category->bottom_left_banner) ?>" alt="<?= $category->name ?>">
                </a>
              </div>
            <?php endif ?>
          </div>
          <div class="col-md-4">
            <?php if ($category->bottom_top_banner) : ?>
              <div class="sale_banner">
                <a class="hover_effect1" href="#">
                  <img src="<?= base_url('images/' . $category->bottom_top_banner) ?>" alt="<?= $category->name ?>">
                </a>
              </div>
            <?php endif ?>
          </div>
          <div class="col-md-4">
            <?php if ($category->bottom_right_banner) : ?>
              <div class="sale_banner">
                <a class="hover_effect1" href="#">
                  <img src="<?= base_url('images/' . $category->bottom_right_banner) ?>" alt="<?= $category->name ?>">
                </a>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div> -->
    <!-- END SECTION BANNER -->

  <?php endif ?>



</div>