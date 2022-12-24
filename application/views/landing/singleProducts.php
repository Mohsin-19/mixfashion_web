<<<<<<< HEAD
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">

<?php
$getShopSetting = getShopSetting();
$getSiteSetting = getSiteSetting();
$current_stock = 2000; // #TODO make default current stock
$tax_info = json_decode($product->tax_information);
$total_tax_p = 0;
$collect_tax = $getShopSetting->collect_tax;

$currency = "$";
if (isset($getSiteSetting->currency) && $getSiteSetting->currency) {
  $currency = $getSiteSetting->currency;
}

$category_id = $product->category_id;
$subcategory_id = $product->subcategory_id;

if (isset($collect_tax) && $collect_tax == "Yes") {
  foreach ($tax_info as $tax) {
    $total_tax_p += $tax->tax_field_percentage;
  }
}

$percentage = 0;
$tmp_total = 0;
if ((int)$product->discount_price) {
  $sale_price = $product->sale_price;
  $discount_price = $product->discount_price;
  $tmp_total = $sale_price - $discount_price;
  $percentage = ($tmp_total / $product->sale_price) * 100;
}


$txt_p = 0;
if ($percentage && $product->has_offer == "Yes") {
  $txt_p = number_format($percentage, 0);
}


$img_size = "images/product/{$product->photo}";
$image_path = file_exists($img_size) && $product->photo !== '' ? base_url($img_size) : base_url('assets/images/no_image_thumb.png');

$lowerName = str_replace("'", "", strtolower($product->name));
$name = str_replace("'", "", ucfirst(htmlspecialchars_decode($lowerName)));

$params = [
  'actual_del_charge' => (int)$product->delivery_charge,
  'id' => (int)$product->id,
  'name' => $name,
  'price' => (int)$product->sale_price,
  'current_stock' => (int)$current_stock,
  'manage_stock' => (int)$product->manage_stock,
  'tax_percentage' => (int)$total_tax_p,
  'sale_price' => (int)$product->sale_price,
  'discount_price' => (int)$product->discount_price,
  'delivery_charge' => $product->delivery_charge,
  'has_offer' => $product->has_offer,
  'order_limit' => (int)$product->order_limit,
  'image' => $image_path,
  'category_id' => (int)$product->category_id,
  'subcategory_id' => (int)$product->subcategory_id,
];


if ($product->discount_price && $product->has_offer == "Yes") {
  $discount_price = $product->sale_price;
  $card_price = $product->discount_price;
} else {
  $card_price = $product->sale_price;
  $discount_price = 0;
}


$dataParams = htmlspecialchars(json_encode($params), ENT_QUOTES, 'UTF-8');
$attrData = get_product_attributes($product->id);
$attributes = htmlspecialchars(json_encode($attrData), ENT_QUOTES, 'UTF-8');


?>

<script>
  var contents = [{
    id: `SKU-<?= $product->id ?>`,
    quantity: 1
  }];
  var content_name = '<?= $name ?>';
  var content_category = 'Clothing';
  var price = parseInt('<?= $card_price ?>');

  setTimeout(() => {
    fb_pixel_ViewContent(contents, content_name, content_category, price);
  }, 3000);
</script>

<span id="single_page_name" class="d-none">product</span>
<span style="display: none;" id="productParameters"><?= $dataParams ?></span>
<span style="display: none;" id="productAttributesData"><?= $attributes ?></span>


<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">
    <div class="row align-items-center">

      <div class="col-md-12">
        <ol class="breadcrumb justify-content-md-start">
          <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
          <?php
          if (isset($product->cat_name)) {
            echo '<li class="breadcrumb-item"><a href="' . site_url($product->cat_slug) . '">' . $product->cat_name . '</a></li>';
          }
          if (isset($product->subcat_name)) {
            echo '<li class="breadcrumb-item"><a href="' . site_url($product->subcat_slug) . '">' . $product->subcat_name . '</a></li>';
          }
          ?>

        </ol>
      </div>


    </div>
  </div>
</div>


<div class="main_content">


  <!-- START SECTION SHOP -->
  <div class="section">
    <div class="custom-container">
      <div class="row">
        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
          <div class="product-image vertical_gallery">
            <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-vertical="true" data-vertical-swiping="true" data-slides-to-show="5" data-slides-to-scroll="1" data-infinite="false">
              <div class="item">
                <a href="#" class="product_gallery_item active" data-image="<?= base_url('images/product/' . $product->photo) ?>" data-zoom-image="<?= base_url('images/product/' . $product->photo) ?>">
                  <img src="<?= base_url('images/product/' . $product->photo) ?>" alt="product_small_img1" />
                </a>
              </div>
              <?php if ($product->galary_image_1) : ?>
                <div class="item">
                  <a href="#" class="product_gallery_item" data-image="<?= base_url('images/product/' . $product->galary_image_1) ?>" data-zoom-image="<?= base_url('images/product/' . $product->galary_image_1) ?>">
                    <img src="<?= base_url('images/product/' . $product->galary_image_1) ?>" alt="product_small_img2" />
                  </a>
                </div>
              <?php endif; ?>
              <?php if ($product->galary_image_2) : ?>
                <div class="item">
                  <a href="#" class="product_gallery_item" data-image="<?= base_url('images/product/' . $product->galary_image_2) ?>" data-zoom-image="<?= base_url('images/product/' . $product->galary_image_2) ?>">
                    <img src="<?= base_url('images/product/' . $product->galary_image_2) ?>" alt="product_small_img2" />
                  </a>
                </div>
              <?php endif; ?>
              <?php if ($product->galary_image_3) : ?>
                <div class="item">
                  <a href="#" class="product_gallery_item" data-image="<?= base_url('images/product/' . $product->galary_image_3) ?>" data-zoom-image="<?= base_url('images/product/' . $product->galary_image_3) ?>">
                    <img src="<?= base_url('images/product/' . $product->galary_image_3) ?>" alt="product_small_img2" />
                  </a>
                </div>
              <?php endif; ?>
              <?php if ($product->galary_image_4) : ?>
                <div class="item">
                  <a href="#" class="product_gallery_item" data-image="<?= base_url('images/product/' . $product->galary_image_4) ?>" data-zoom-image="<?= base_url('images/product/' . $product->galary_image_4) ?>">
                    <img src="<?= base_url('images/product/' . $product->galary_image_4) ?>" alt="product_small_img2" />
                  </a>
                </div>
              <?php endif; ?>
            </div>
            <div class="product_img_box">
              <img id="product_img" src='<?= base_url('images/product/' . $product->photo) ?>' data-zoom-image="<?= base_url('images/product/' . $product->photo) ?>" alt="product_img1" />
              <a href="#" class="product_img_zoom" title="Zoom">
                <span class="linearicons-zoom-in"></span>
              </a>
            </div>
          </div>
        </div> <!-- col-lg-6 -->

        <div class="col-lg-6 col-md-6 bg-white p-4">
          <div class="pr_detail">
            <div class="product_description">
              <h3 class="product_title"><a href="<?= site_url("product/{$product->id}") ?>"><?= $name ?></a></h3>
              <div class="clearfix">
                <div class="product_price">
                  <span class="price" id="amount_<?= $product->id ?>"><?= floating($card_price) ?></span>
                  <?php if ($discount_price) : ?>
                    <del><?= floating($discount_price) ?></del>
                    <div class="on_sale">
                      <span><?= $txt_p ?>% Off</span>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="rating_wrap">
                  <div class="rating">
                    <div class="product_rate" style="width:0%"></div>
                  </div>
                  <span class="rating_num">(0)</span>
                </div>
              </div>

              <div class="pr_desc mb-3 d-block clearfix">
                <?= escape_output($product->description) ?>
              </div>

              <?php
              $attr = get_product_attributes($product->id);
              $order_attr = get_product_ordered_attributes($product->id);


              $count = count($order_attr);
              $result = [];

              foreach ($attr as $key => $value) {
                if ($count > $key) {
                  if ($value['color_id'] == $order_attr[$key]['color_id'] || $value['size_id'] == $order_attr[$key]['size_id']) {
                    $result[] = array_unique(array_merge($value, $order_attr[$key]));
                  } else {
                    $result[] = $value;
                  }
                } else {
                  $result[] = $value;
                }
              }

              ?>

              <?php if (!empty($result)) : ?>
                <div class="pr_switch_wrap">
                  <table class="table attrTable table-sm table-bordered text-center " style="max-width: 350px;">
                    <tbody>
                      <?php
                      foreach ($result as $key => $attrItem) :
                        $color_id = $attrItem['color_id'] ?? 0;
                        $color_name = $attrItem['color_name'] ?? "";
                        $size_id = $attrItem['size_id'] ?? 0;
                        $product_price = $attrItem['product_price'] ?? "";
                        $color_code = $attrItem['color_code'] ?? "";
                        $size_name = $attrItem['size_name'] ?? "";
                        $qty = $attrItem['product_qty'] ?? 0;

                      ?>
                        <?php if ($key == 0) : ?>
                          <tr>
                            <td>Select</td>
                            <?php if ($color_code) : ?>
                              <td>Color</td>
                            <?php endif; ?>
                            <?php if ($size_name) : ?>
                              <td>Size</td>
                            <?php endif; ?>
                          </tr>
                        <?php endif; ?>

                        <?php if ($qty > 0) { ?>
                          <tr>
                            <td class="align-middle">
                              <input type="radio" name="activeAttribute" class="AttrProduct<?= $color_id + $size_id ?>" data-color-id="<?= $color_id ?>" data-color-name="<?= $color_name ?>" data-size-id="<?= $size_id ?>" data-size-name="<?= $size_name ?>" data-qty="<?= $qty ?>" data-price="<?= $product_price ?>" value="<?= $product->id ?>" id="attr-<?= $key ?>" <?= $key == 0 ? 'checked="checked"' : '' ?>>
                            </td>
                            <?php if ($color_code) : ?>
                              <td class="align-middle">
                                <label class="d-block m-0" for="attr-<?= $key ?>">
                                  <span class="attr-color" style="background-color: <?= $color_code ?>"></span>
                                </label>
                              </td>
                            <?php endif; ?>
                            <?php if ($size_name) : ?>
                              <td class="align-middle">
                                <label class="d-block m-0" for="attr-<?= $key ?>">
                                  <span class="attr-size"><?= $size_name ?></span>
                                </label>
                              </td>
                            <?php endif; ?>
                          </tr>
                        <?php } else { ?>
                          <!-- <tr>
                            <td class="align-middle">
                              <span class="text-danger">Not In stock</span>
                            </td>
                            <?php if ($color_code) : ?>
                              <td class="align-middle">
                                <label class="d-block m-0" for="attr-<?= $key ?>">
                                  <span class="attr-color" style="background-color: <?= $color_code ?>"></span>
                                </label>
                              </td>
                            <?php endif; ?>
                            <?php if ($size_name) : ?>
                              <td class="align-middle">
                                <label class="d-block m-0" for="attr-<?= $key ?>">
                                  <span class="attr-size"><?= $size_name ?></span>
                                </label>
                              </td>
                            <?php endif; ?>
                          </tr> -->
                        <?php } ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php endif ?>

            </div> <!-- product_description -->

            <div class="product_sort_info mb-0">
              <ul class="p-0">
                <?php if ($product->delivery_charge == 'free') : ?>
                  <li><i class="fas fa-truck"></i> Free Delivery</li>
                <?php elseif ((int)$product->delivery_charge > 0) : ?>
                  <li><i class="fas fa-truck"></i> <span class="ml-2">Delivery Charge: <?= $product->delivery_charge ?></span></li>
                <?php endif ?>
                <li><i class="icon-ok-circled"></i> <span class="ml-2" id="stock-status">In Stock</span></li>
              </ul>
            </div> <!-- product_sort_info -->
            <hr />
            <div class="cart_extra">
              <div class="cart-product-quantity">
                <div class="input-group plus-minus-group mb-2 mb-sm-0">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn_m" data-id="<?= $product->id ?>"><i class="icon-minus"></i></button>
                  </div>
                  <input type="text" id="pro_qty" class="qty qty_<?= $product->id ?> form-control text-center" value="0" readonly="readonly">
                  <div class="input-group-append">
                    <button type="button" class="btn btn_p" data-id="<?= $product->id ?>"><i class="icon-plus"></i></button>
                  </div>
                </div> <!-- input-group -->
              </div>
              <div class="cart_btn">
                <button type="button" class="btnCart btnCart_<?= $product->id ?> btn btn-warning btn-addtocart" data-id="<?= $product->id ?>"><i class="icon-basket-loaded"></i> Add to cart
                </button>
                <a href="<?= site_url('checkout') ?>" class="btnBuy btnBuy_<?= $product->id ?> btn btn-success" data-id="<?= $product->id ?>">Buy
                  now</a>
                <a href="<?= $product->id ?>" class="btn btn-danger" id="addToWishlist">
                  <i class="icon-heart"></i>
                </a>
              </div>
            </div> <!-- cart_extra -->
            <hr />
          </div> <!-- pr_detail -->
        </div> <!-- col-lg-6 -->
      </div> <!-- row -->

      <div class="row">
        <div class="col-12">
          <div class="medium_divider clearfix"></div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="tab-style2">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Description</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="Additional-info-tab" data-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">Specification</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">Reviews (0)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="delivery-return-policy-tab" data-toggle="tab" href="#delivery-return-policy" role="tab" aria-controls="delivery-return-policy" aria-selected="false">Delivery & Return policy</a>
              </li>
            </ul>
            <div class="tab-content shop_info_tab">
              <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                <?= $product->full_description ?>
              </div>
              <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                <?= $product->specification ?>
              </div>
              <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                <div class="comments">
                  <h5 class="product_tab_title">No Review For <span><?= $name ?></span></h5>
                </div>
                <div class="review_form field_form">
                  <h5>Add a review</h5>
                  <form action="#" class="row mt-3">
                    <div class="form-group col-12">
                      <div class="star_rating">
                        <span data-value="1"><i class="far fa-star"></i></span>
                        <span data-value="2"><i class="far fa-star"></i></span>
                        <span data-value="3"><i class="far fa-star"></i></span>
                        <span data-value="4"><i class="far fa-star"></i></span>
                        <span data-value="5"><i class="far fa-star"></i></span>
                      </div>
                    </div>
                    <div class="form-group col-12">
                      <textarea required="required" placeholder="Your review *" class="form-control" name="message" rows="4"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                      <input required="required" placeholder="Enter Name *" class="form-control" name="name" type="text">
                    </div>
                    <div class="form-group col-md-6">
                      <input required="required" placeholder="Enter Email *" class="form-control" name="email" type="email">
                    </div>

                    <div class="form-group col-12">
                      <button type="submit" class="btn btn-fill-out" name="submit" value="Submit">Submit Review</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane fade" id="delivery-return-policy" role="tabpanel" aria-labelledby="delivery-return-policy-tab">
                <?php
                $returnPage = get_page_by_slug('return-and-refund-policy');
                echo $returnPage->menu_content ?? '';
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="small_divider"></div>
          <div class="divider"></div>
          <div class="medium_divider"></div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="heading_s1">
            <h1>Related Products</h1>
          </div>

          <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "2"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
            <?php $this->load->view('landing/ajax/products', ['products' => $related_products, 'landing' => true]); ?>
          </div>

        </div>
      </div>

    </div>
  </div>
  <!-- END SECTION SHOP -->

=======
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">

<?php
$getShopSetting = getShopSetting();
$getSiteSetting = getSiteSetting();
$current_stock = 2000; // #TODO make default current stock
$tax_info = json_decode($product->tax_information);
$total_tax_p = 0;
$collect_tax = $getShopSetting->collect_tax;

$currency = "$";
if (isset($getSiteSetting->currency) && $getSiteSetting->currency) {
  $currency = $getSiteSetting->currency;
}

$category_id = $product->category_id;
$subcategory_id = $product->subcategory_id;

if (isset($collect_tax) && $collect_tax == "Yes") {
  foreach ($tax_info as $tax) {
    $total_tax_p += $tax->tax_field_percentage;
  }
}

$percentage = 0;
$tmp_total = 0;
if ((int)$product->discount_price) {
  $sale_price = $product->sale_price;
  $discount_price = $product->discount_price;
  $tmp_total = $sale_price - $discount_price;
  $percentage = ($tmp_total / $product->sale_price) * 100;
}


$txt_p = 0;
if ($percentage && $product->has_offer == "Yes") {
  $txt_p = number_format($percentage, 0);
}


$img_size = "images/product/{$product->photo}";
$image_path = file_exists($img_size) && $product->photo !== '' ? base_url($img_size) : base_url('assets/images/no_image_thumb.png');

$lowerName = str_replace("'", "", strtolower($product->name));
$name = str_replace("'", "", ucfirst(htmlspecialchars_decode($lowerName)));

$params = [
  'actual_del_charge' => (int)$product->delivery_charge,
  'id' => (int)$product->id,
  'name' => $name,
  'price' => (int)$product->sale_price,
  'current_stock' => (int)$current_stock,
  'manage_stock' => (int)$product->manage_stock,
  'tax_percentage' => (int)$total_tax_p,
  'sale_price' => (int)$product->sale_price,
  'discount_price' => (int)$product->discount_price,
  'delivery_charge' => $product->delivery_charge,
  'has_offer' => $product->has_offer,
  'order_limit' => (int)$product->order_limit,
  'image' => $image_path,
  'category_id' => (int)$product->category_id,
  'subcategory_id' => (int)$product->subcategory_id,
];


if ($product->discount_price && $product->has_offer == "Yes") {
  $discount_price = $product->sale_price;
  $card_price = $product->discount_price;
} else {
  $card_price = $product->sale_price;
  $discount_price = 0;
}


$dataParams = htmlspecialchars(json_encode($params), ENT_QUOTES, 'UTF-8');
$attrData = get_product_attributes($product->id);
$attributes = htmlspecialchars(json_encode($attrData), ENT_QUOTES, 'UTF-8');


?>

<script>
  var contents = [{
    id: `SKU-<?= $product->id ?>`,
    quantity: 1
  }];
  var content_name = '<?= $name ?>';
  var content_category = 'Clothing';
  var price = parseInt('<?= $card_price ?>');

  setTimeout(() => {
    fb_pixel_ViewContent(contents, content_name, content_category, price);
  }, 3000);
</script>

<span id="single_page_name" class="d-none">product</span>
<span style="display: none;" id="productParameters"><?= $dataParams ?></span>
<span style="display: none;" id="productAttributesData"><?= $attributes ?></span>


<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">
    <div class="row align-items-center">

      <div class="col-md-12">
        <ol class="breadcrumb justify-content-md-start">
          <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
          <?php
          if (isset($product->cat_name)) {
            echo '<li class="breadcrumb-item"><a href="' . site_url($product->cat_slug) . '">' . $product->cat_name . '</a></li>';
          }
          if (isset($product->subcat_name)) {
            echo '<li class="breadcrumb-item"><a href="' . site_url($product->subcat_slug) . '">' . $product->subcat_name . '</a></li>';
          }
          ?>

        </ol>
      </div>


    </div>
  </div>
</div>


<div class="main_content">


  <!-- START SECTION SHOP -->
  <div class="section">
    <div class="custom-container">
      <div class="row">
        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
          <div class="product-image vertical_gallery">
            <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-vertical="true" data-vertical-swiping="true" data-slides-to-show="5" data-slides-to-scroll="1" data-infinite="false">
              <div class="item">
                <a href="#" class="product_gallery_item active" data-image="<?= base_url('images/product/' . $product->photo) ?>" data-zoom-image="<?= base_url('images/product/' . $product->photo) ?>">
                  <img src="<?= base_url('images/product/' . $product->photo) ?>" alt="product_small_img1" />
                </a>
              </div>
              <?php if ($product->galary_image_1) : ?>
                <div class="item">
                  <a href="#" class="product_gallery_item" data-image="<?= base_url('images/product/' . $product->galary_image_1) ?>" data-zoom-image="<?= base_url('images/product/' . $product->galary_image_1) ?>">
                    <img src="<?= base_url('images/product/' . $product->galary_image_1) ?>" alt="product_small_img2" />
                  </a>
                </div>
              <?php endif; ?>
              <?php if ($product->galary_image_2) : ?>
                <div class="item">
                  <a href="#" class="product_gallery_item" data-image="<?= base_url('images/product/' . $product->galary_image_2) ?>" data-zoom-image="<?= base_url('images/product/' . $product->galary_image_2) ?>">
                    <img src="<?= base_url('images/product/' . $product->galary_image_2) ?>" alt="product_small_img2" />
                  </a>
                </div>
              <?php endif; ?>
              <?php if ($product->galary_image_3) : ?>
                <div class="item">
                  <a href="#" class="product_gallery_item" data-image="<?= base_url('images/product/' . $product->galary_image_3) ?>" data-zoom-image="<?= base_url('images/product/' . $product->galary_image_3) ?>">
                    <img src="<?= base_url('images/product/' . $product->galary_image_3) ?>" alt="product_small_img2" />
                  </a>
                </div>
              <?php endif; ?>
              <?php if ($product->galary_image_4) : ?>
                <div class="item">
                  <a href="#" class="product_gallery_item" data-image="<?= base_url('images/product/' . $product->galary_image_4) ?>" data-zoom-image="<?= base_url('images/product/' . $product->galary_image_4) ?>">
                    <img src="<?= base_url('images/product/' . $product->galary_image_4) ?>" alt="product_small_img2" />
                  </a>
                </div>
              <?php endif; ?>
            </div>
            <div class="product_img_box">
              <img id="product_img" src='<?= base_url('images/product/' . $product->photo) ?>' data-zoom-image="<?= base_url('images/product/' . $product->photo) ?>" alt="product_img1" />
              <a href="#" class="product_img_zoom" title="Zoom">
                <span class="linearicons-zoom-in"></span>
              </a>
            </div>
          </div>
        </div> <!-- col-lg-6 -->

        <div class="col-lg-6 col-md-6 bg-white p-4">
          <div class="pr_detail">
            <div class="product_description">
              <h3 class="product_title"><a href="<?= site_url("product/{$product->id}") ?>"><?= $name ?></a></h3>
              <div class="clearfix">
                <div class="product_price">
                  <span class="price" id="amount_<?= $product->id ?>"><?= floating($card_price) ?></span>
                  <?php if ($discount_price) : ?>
                    <del><?= floating($discount_price) ?></del>
                    <div class="on_sale">
                      <span><?= $txt_p ?>% Off</span>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="rating_wrap">
                  <div class="rating">
                    <div class="product_rate" style="width:0%"></div>
                  </div>
                  <span class="rating_num">(0)</span>
                </div>
              </div>

              <div class="pr_desc mb-3 d-block clearfix">
                <?= escape_output($product->description) ?>
              </div>

              <?php
              $attr = get_product_attributes($product->id);
              $order_attr = get_product_ordered_attributes($product->id);


              $count = count($order_attr);
              $result = [];

              foreach ($attr as $key => $value) {
                if ($count > $key) {
                  if ($value['color_id'] == $order_attr[$key]['color_id'] || $value['size_id'] == $order_attr[$key]['size_id']) {
                    $result[] = array_unique(array_merge($value, $order_attr[$key]));
                  } else {
                    $result[] = $value;
                  }
                } else {
                  $result[] = $value;
                }
              }

              ?>

              <?php if (!empty($result)) : ?>
                <div class="pr_switch_wrap">
                  <table class="table attrTable table-sm table-bordered text-center " style="max-width: 350px;">
                    <tbody>
                      <?php
                      foreach ($result as $key => $attrItem) :
                        $color_id = $attrItem['color_id'] ?? 0;
                        $color_name = $attrItem['color_name'] ?? "";
                        $size_id = $attrItem['size_id'] ?? 0;
                        $product_price = $attrItem['product_price'] ?? "";
                        $color_code = $attrItem['color_code'] ?? "";
                        $size_name = $attrItem['size_name'] ?? "";
                        $qty = $attrItem['product_qty'] ?? 0;

                      ?>
                        <?php if ($key == 0) : ?>
                          <tr>
                            <td>Select</td>
                            <?php if ($color_code) : ?>
                              <td>Color</td>
                            <?php endif; ?>
                            <?php if ($size_name) : ?>
                              <td>Size</td>
                            <?php endif; ?>
                          </tr>
                        <?php endif; ?>

                        <?php if ($qty > 0) { ?>
                          <tr>
                            <td class="align-middle">
                              <input type="radio" name="activeAttribute" class="AttrProduct<?= $color_id + $size_id ?>" data-color-id="<?= $color_id ?>" data-color-name="<?= $color_name ?>" data-size-id="<?= $size_id ?>" data-size-name="<?= $size_name ?>" data-qty="<?= $qty ?>" data-price="<?= $product_price ?>" value="<?= $product->id ?>" id="attr-<?= $key ?>" <?= $key == 0 ? 'checked="checked"' : '' ?>>
                            </td>
                            <?php if ($color_code) : ?>
                              <td class="align-middle">
                                <label class="d-block m-0" for="attr-<?= $key ?>">
                                  <span class="attr-color" style="background-color: <?= $color_code ?>"></span>
                                </label>
                              </td>
                            <?php endif; ?>
                            <?php if ($size_name) : ?>
                              <td class="align-middle">
                                <label class="d-block m-0" for="attr-<?= $key ?>">
                                  <span class="attr-size"><?= $size_name ?></span>
                                </label>
                              </td>
                            <?php endif; ?>
                          </tr>
                        <?php } else { ?>
                          <!-- <tr>
                            <td class="align-middle">
                              <span class="text-danger">Not In stock</span>
                            </td>
                            <?php if ($color_code) : ?>
                              <td class="align-middle">
                                <label class="d-block m-0" for="attr-<?= $key ?>">
                                  <span class="attr-color" style="background-color: <?= $color_code ?>"></span>
                                </label>
                              </td>
                            <?php endif; ?>
                            <?php if ($size_name) : ?>
                              <td class="align-middle">
                                <label class="d-block m-0" for="attr-<?= $key ?>">
                                  <span class="attr-size"><?= $size_name ?></span>
                                </label>
                              </td>
                            <?php endif; ?>
                          </tr> -->
                        <?php } ?>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php endif ?>

            </div> <!-- product_description -->

            <div class="product_sort_info mb-0">
              <ul class="p-0">
                <?php if ($product->delivery_charge == 'free') : ?>
                  <li><i class="fas fa-truck"></i> Free Delivery</li>
                <?php elseif ((int)$product->delivery_charge > 0) : ?>
                  <li><i class="fas fa-truck"></i> <span class="ml-2">Delivery Charge: <?= $product->delivery_charge ?></span></li>
                <?php endif ?>
                <li><i class="icon-ok-circled"></i> <span class="ml-2" id="stock-status">In Stock</span></li>
              </ul>
            </div> <!-- product_sort_info -->
            <hr />
            <div class="cart_extra">
              <div class="cart-product-quantity">
                <div class="input-group plus-minus-group mb-2 mb-sm-0">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn_m" data-id="<?= $product->id ?>"><i class="icon-minus"></i></button>
                  </div>
                  <input type="text" id="pro_qty" class="qty qty_<?= $product->id ?> form-control text-center" value="0" readonly="readonly">
                  <div class="input-group-append">
                    <button type="button" class="btn btn_p" data-id="<?= $product->id ?>"><i class="icon-plus"></i></button>
                  </div>
                </div> <!-- input-group -->
              </div>
              <div class="cart_btn">
                <button type="button" class="btnCart btnCart_<?= $product->id ?> btn btn-warning btn-addtocart" data-id="<?= $product->id ?>"><i class="icon-basket-loaded"></i> Add to cart
                </button>
                <a href="<?= site_url('checkout') ?>" class="btnBuy btnBuy_<?= $product->id ?> btn btn-success" data-id="<?= $product->id ?>">Buy
                  now</a>
                <a href="<?= $product->id ?>" class="btn btn-danger" id="addToWishlist">
                  <i class="icon-heart"></i>
                </a>
              </div>
            </div> <!-- cart_extra -->
            <hr />
          </div> <!-- pr_detail -->
        </div> <!-- col-lg-6 -->
      </div> <!-- row -->

      <div class="row">
        <div class="col-12">
          <div class="medium_divider clearfix"></div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="tab-style2">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Description</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="Additional-info-tab" data-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">Specification</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">Reviews (0)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="delivery-return-policy-tab" data-toggle="tab" href="#delivery-return-policy" role="tab" aria-controls="delivery-return-policy" aria-selected="false">Delivery & Return policy</a>
              </li>
            </ul>
            <div class="tab-content shop_info_tab">
              <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                <?= $product->full_description ?>
              </div>
              <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                <?= $product->specification ?>
              </div>
              <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                <div class="comments">
                  <h5 class="product_tab_title">No Review For <span><?= $name ?></span></h5>
                </div>
                <div class="review_form field_form">
                  <h5>Add a review</h5>
                  <form action="#" class="row mt-3">
                    <div class="form-group col-12">
                      <div class="star_rating">
                        <span data-value="1"><i class="far fa-star"></i></span>
                        <span data-value="2"><i class="far fa-star"></i></span>
                        <span data-value="3"><i class="far fa-star"></i></span>
                        <span data-value="4"><i class="far fa-star"></i></span>
                        <span data-value="5"><i class="far fa-star"></i></span>
                      </div>
                    </div>
                    <div class="form-group col-12">
                      <textarea required="required" placeholder="Your review *" class="form-control" name="message" rows="4"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                      <input required="required" placeholder="Enter Name *" class="form-control" name="name" type="text">
                    </div>
                    <div class="form-group col-md-6">
                      <input required="required" placeholder="Enter Email *" class="form-control" name="email" type="email">
                    </div>

                    <div class="form-group col-12">
                      <button type="submit" class="btn btn-fill-out" name="submit" value="Submit">Submit Review</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane fade" id="delivery-return-policy" role="tabpanel" aria-labelledby="delivery-return-policy-tab">
                <?php
                $returnPage = get_page_by_slug('return-and-refund-policy');
                echo $returnPage->menu_content ?? '';
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="small_divider"></div>
          <div class="divider"></div>
          <div class="medium_divider"></div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="heading_s1">
            <h1>Related Products</h1>
          </div>

          <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "2"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
            <?php $this->load->view('landing/ajax/products', ['products' => $related_products, 'landing' => true]); ?>
          </div>

        </div>
      </div>

    </div>
  </div>
  <!-- END SECTION SHOP -->

>>>>>>> adbefaf043be75c61ed9e18f26d6ac137f29d784
</div>