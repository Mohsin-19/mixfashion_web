<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">
<?php
$getSiteSetting = getSiteSetting();
$currency = $getSiteSetting->currency;
$frontend_offer_banner_image = ("assets/images/" . $getSiteSetting->frontend_offer_banner_image) ?? "assets/frontend/images/offer-banner.jpg";
$frontend_offer_banner_url = $getSiteSetting->frontend_offer_banner_url ?? null;

?>


<div class="main_content">

  <?php if (isset($all_categories)) : ?>

    <div class="section small_pt">
      <div class="custom-container">
        <div class="row justify-content-center">
          <div class="col-md-12 ">
            <div class="heading_s4">
              <h1 class="text-center pb-4">Popular Categories</h1>
            </div>
          </div>
        </div>
        <div class="row row-cols-2 row-cols-sm-4 row-cols-md-5 p-4">
          <?php
          foreach ($all_categories as $key => $value) :
          ?>
            <div class="col px-2 mb-3 mb-md-0">
              <a href="<?= site_url($value->slug) ?>" class="item category" title="<?= $value->name ?>">
                <div class="product p-0 py-md-3">
                  <div class="product_img">
                    <?php $cat_image = $value->icon ? 'images/' . $value->icon : 'assets/images/no-image.png'; ?>
                    <img src="<?= base_url($cat_image) ?>" style="width:160px" alt="<?= $value->name ?>">
                  </div>
                  <div class="product_info">
                    <h6 class="product_title"><?= $value->name ?></h6>
                  </div>
                </div>
              </a>
            </div>
          <?php
          endforeach;
          ?>
        </div> <!-- row -->

      </div>
    </div>

  <?php endif; ?>


  <!-- START SECTION Flash Sale-->
  <?php if (isset($offer_products) && !empty($offer_products)) : ?>
    <div class="section main_div_product">
      <div class="custom-container">
        <div class="row justify-content-center">
          <div class="col-md-12 ">
            <div class="heading_s4 py-1">
              <h1 class="text-danger py-2">Flash sale</h1>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="cat_slider py-3 carousel_slider owl-carousel owl-theme nav_style5" data-loop="false" data-dots="false" data-nav="true" data-margin="15" data-responsive='{"0":{"items": "2"}, "650":{"items": "4"}, "1199":{"items": "4"}}'>
              <?php $this->load->view('landing/ajax/products', ['products' => $offer_products, 'landing' => true]); ?>

            </div> <!-- cat_slider -->
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <!-- End SECTION Flash Sale-->

  <!-- START SECTION DAILY DISCOVER-->
  <?php if (isset($category_new_products)) : ?>
    <div class="section main_div_product">
      <div class="custom-container">
        <div class="row justify-content-center">
          <div class="col-md-12 ">
            <div class="heading_s4 py-1">
              <h1 class="py-2">What's New</h1>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="cat_slider py-3 carousel_slider owl-carousel owl-theme nav_style5" data-loop="false" data-dots="false" data-nav="true" data-margin="15" data-responsive='{"0":{"items": "2"}, "650":{"items": "4"}, "1199":{"items": "4"}}'>

              <?php $this->load->view('landing/ajax/products', ['products' => $category_new_products, 'landing' => true]); ?>

            </div>
            <!-- End cat_slider -->
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <!-- END SECTION DAILY DISCOVER -->

  <!-- START SECTION BANNER -->
  <div class="section background_bg main_div_product my-5" data-img-src="<?= base_url($frontend_offer_banner_image) ?>">
    <?php if ($frontend_offer_banner_url) : ?>
      <a href="<? echo $frontend_offer_banner_url ?>" class="d-block">
      <?php endif; ?>
      <div class="container slideheight">
      </div>
      <?php if ($frontend_offer_banner_url) : ?>
      </a>
    <?php endif; ?>
  </div>
  <!-- END SECTION BANNER -->


  <!-- Start Men -->
  <?php
  if (isset($category_men)) :
    $men_products = is_array($category_men) ? $category_men : [];
    $men_cat = array_key_exists('category', $category_men) ? $category_men['category'] : [];
    $men_products = array_key_exists('products', $category_men) ? $category_men['products'] : [];
  ?>
    <div class="section small_pt ">
      <div class="custom-container">
        <div class="row">
          <div class="col-xl-3 d-none d-xl-block">
            <div class="sale-banner">
              <a class="hover_effect1" href="<?= site_url($men_cat->slug) ?>">
                <img src="<?= base_url("images/{$men_cat->bottom_left_banner}") ?>" alt="<?= $men_cat->name ?>">
              </a>
            </div>
          </div>
          <div class="col-xl-9">
            <div class="row">
              <div class="col-12">
                <div class="heading_tab_header">
                  <div class="heading_s2">
                    <h1><?= $men_cat->name ?></h1>
                  </div>
                  <div class="view_all">
                    <a href="<?= site_url($men_cat->slug) ?>" class="text_default"><i class="linearicons-power"></i>
                      <span>View all</span></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="product_slider carousel_slider owl-carousel owl-theme nav_style5  py-3" data-loop="false" data-dots="false" data-nav="true" data-margin="15" data-responsive='{"0":{"items": "2"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>


                  <?php $this->load->view('landing/ajax/products', ['products' => $men_products, 'landing' => true]); ?>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <!-- End Men -->
  <?php
  if (isset($category_women)) :
    $women_products = is_array($category_women) ? $category_women : [];
    $women_cat = array_key_exists('category', $category_women) ? $category_women['category'] : [];
    $women_products = array_key_exists('products', $category_women) ? $category_women['products'] : [];
  ?>
    <div class="section small_pt ">
      <div class="custom-container">
        <div class="row">
          <div class="col-xl-3 d-none d-xl-block">
            <div class="sale-banner">
              <a class="hover_effect1" href="<?= site_url($women_cat->slug) ?>">
                <img src="<?= base_url("images/{$women_cat->bottom_left_banner}") ?>" alt="<?= $women_cat->name ?>">
              </a>
            </div>
          </div>
          <div class="col-xl-9">
            <div class="row">
              <div class="col-12">
                <div class="heading_tab_header">
                  <div class="heading_s2">
                    <h1><?= $women_cat->name ?></h1>
                  </div>
                  <div class="view_all">
                    <a href="<?= site_url($women_cat->slug) ?>" class="text_default"><i class="linearicons-power"></i>
                      <span>View All</span></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="product_slider carousel_slider owl-carousel owl-theme nav_style5  py-3" data-loop="false" data-dots="false" data-nav="true" data-margin="15" data-responsive='{"0":{"items": "2"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>


                  <?php $this->load->view('landing/ajax/products', ['products' => $women_products, 'landing' => true]); ?>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Start Jewellery -->
  <?php
  if (isset($category_jewellery)) :
    $category_jewellery = is_array($category_jewellery) ? $category_jewellery : [];
    $jewellery_cat = array_key_exists('category', $category_jewellery) ? $category_jewellery['category'] : [];
    $jewellery_products = array_key_exists('products', $category_jewellery) ? $category_jewellery['products'] : [];
    if (count($jewellery_products)) :
  ?>
      <!-- <div class="section small_pt small_pb">
        <div class="custom-container">
          <div class="row">
            <div class="col-xl-3 d-none d-xl-block">
              <div class="sale-banner">
                <a class="hover_effect1" href="<?= site_url($jewellery_cat->slug) ?>">
                  <img src="<?= base_url("images/{$jewellery_cat->bottom_left_banner}") ?>" alt="<?= $jewellery_cat->name ?>">
                </a>
              </div>
            </div>
            <div class="col-xl-9">
              <div class="row">
                <div class="col-12">
                  <div class="heading_tab_header">
                    <div class="heading_s2">
                      <h1><?= $jewellery_cat->name ?></h1>
                    </div>
                    <div class="view_all">
                      <a href="<?= site_url($jewellery_cat->slug) ?>" class="text_default"><i class="linearicons-power"></i>
                        <span>View All</span></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="product_slider carousel_slider owl-carousel owl-theme nav_style5  py-3" data-loop="false" data-dots="false" data-nav="true" data-margin="15" data-responsive='{"0":{"items": "2"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>

                    <?php $this->load->view('landing/ajax/products', ['products' => $jewellery_products, 'landing' => true]); ?>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
    <?php endif; ?>
  <?php endif; ?>
  <!-- End Jewellery -->

  <? php //$this->load->view('landing/includes/sectionStories');
  ?>

</div>