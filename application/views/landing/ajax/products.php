<?php
$getShopSetting = getShopSetting();

$category_id = '';
$subcategory_id = '';
$counter = 1;

foreach ($products as $key => $product) :
  $counter++;
  $img_size = "images/product/{$product->photo}";
  $image_path = file_exists($img_size) && $product->photo !== '' ? base_url($img_size) : base_url('assets/images/no_image_thumb.png');

  $tax_info = json_decode($product->tax_information);
  $total_tax_p = 0;
  $collect_tax = $getShopSetting->collect_tax;

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
  $lowerName = str_replace("'", "", strtolower($product->name));
  $name = str_replace("'", "", ucfirst(htmlspecialchars_decode($lowerName)));
  $category = str_replace("'", "", htmlspecialchars_decode($product->product_category_name));
  $subcategory = str_replace("'", "", (getSubCategoryName($product->subcategory_id)));
  $manage_stock = str_replace("'", "", $product->manage_stock);

  $txt_p = '';
  if ($percentage && $product->has_offer == "Yes") {
    $txt_p = number_format($percentage, 0);
  }

  if ($product->discount_price && $product->has_offer == "Yes") {
    $discount_price_txt = $product->sale_price;
    $card_price = $product->discount_price;
  } else {
    $card_price = $product->sale_price;
    $discount_price_txt = 0;
  }
?>




  <div class="itemWrapper <?= isset($landing) ? ($landing ? '' : 'col px-2') : '' ?>" data-details="<?= site_url("product/{$product->id}") ?>">
    <div class="innerBox" data-cat_id="<?= $category_id ?>" data-sub_cat_id="<?= $subcategory_id ?>" data-page="<?= isset($search) ? 'search' : 'products' ?>">
      <div class="itemInfo text-center" title="<?= $name ?>">
        <?php if ($txt_p) : ?>
          <span class="savings_text"><?= $txt_p ?>% off</span>
        <?php endif; ?>
        <img class="itemImg" src="<?= $image_path ?>" alt="<?= $name ?>">
        <h3 class="itemName"><?= character_limiter($name, 38) ?></h3>

        <?php if ($discount_price_txt) : ?>
          <div class="clearfix px-2 pb-2">
            <small class="float-left price_offer">
              <?= floating($card_price) ?>
            </small>
            <del class="small float-right price_del">
              <?= floating($discount_price_txt) ?>
            </del>
          </div>
        <?php else : ?>
          <div class="clearfix px-2 pb-2">
            <small class="text-center price_offer">
              <?= floating($card_price) ?>
            </small>
          </div>
        <?php endif ?>
        <div class="product-overlay" data-id="<?= $product->id ?>">
          <div class="overlay-item">
            <div class="overlay-txt">
              <p><i class="linearicons-cart"></i> Details</p>
            </div>
          </div>
        </div>
        <div class="cartBtnBox">
          <a href="<?= site_url("product/{$product->id}") ?>" class="btn-cart btn-block bg_dark  text-light" type="button">
            <i class="linearicons-cart"></i> Details
          </a>
        </div>
      </div>
    </div>
  </div>

<?php
endforeach;
?>


<?php

if ($counter > 1) :
  //echo '</div><div class="row autoScrollEventHandler w-100 my-5"><div class="col">';
?>


  <div class="autoScrollEventHandler col my-5 text-center w-100">
    <i class="fas fa-spinner fa-spin text-muted" style="font-size:26px"></i>
  </div>

<?php

// echo '</div>';

endif;

?>