<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">


<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">
    <div class="row">
      <div class="col-md-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item active">Wishlist</li>
        </ol>
      </div>
    </div>
  </div>
</div>


<div class="main_content">

  <div class="section py-3 mb-5">
    <div class="custom-container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="table-responsive wishlist_table">
            <table class="table">
              <thead>
                <tr>
                  <th class="product-thumbnail">&nbsp;</th>
                  <th class="product-name">Product</th>
                  <th class="product-price">Price</th>
                  <th class="product-remove">Remove</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($wishlists as $item) : ?>
                  <?php
                  $photo = $item['photo'] ?? '';
                  $name = $item['name'] ?? '';
                  $id = $item['id'] ?? '';
                  $sale_price = $item['sale_price'] ?? '0';
                  ?>
                  <tr>
                    <td class="product-thumbnail">
                      <a href="<?= site_url("product/{$id}") ?>">
                        <img src="<?= base_url('images/product/' . $photo) ?>" alt="product1">
                      </a>
                    </td>
                    <td class="product-name" data-title="Product">
                      <a href="<?= site_url("product/{$id}") ?>"><?= $name ?></a>
                    </td>
                    <td class="product-price" data-title="Price">৳ <?= $sale_price ?></td>
                    <td class="product-remove" data-title="Remove">
                      <a href="<?= $id ?>" class="removeFromWishlist"><i class="ti-close"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div> <!-- row -->
    </div>
  </div>

</div> <!-- main_content -->