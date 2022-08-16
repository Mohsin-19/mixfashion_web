<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">

<span class="page_options d-none"><?= json_encode(['page' => 'products', 'cat_id' => $category->id, 'parent_id' =>   $category->parent_id ?? 0]) ?></span>

<!-- <div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">

    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="page-title">
          <h1><?php //echo $category->name  
              ?></h1>
        </div>
      </div>
      <div class="col-md-6">
        <ol class="breadcrumb justify-content-md-end">
          <li class="breadcrumb-item">
            <a href="<?php //echo site_url('/') 
                      ?>">Home</a>
          </li>
          <?php //if (isset($category->parent_name)) :
          ?>
            <li class="breadcrumb-item">
              <a href="<?php // echo site_url($category->parent_slug) 
                        ?>">
                <?php // echo $category->parent_name 
                ?>
              </a>
            </li>
          <?php // endif;  
          ?>
          <li class="breadcrumb-item active">
            <?php // echo $category->name 
            ?>
          </li>
        </ol>
      </div>
    </div>
  </div>
</div> -->


<div class="main_content">

  <div class="section p-0 mb-2">
    <div class="custom-container">

      <?php if (isset($category->top_banner) && $category->top_banner) :
      ?>
        <div class="row">
          <div class="col-md-12 my-4 text-center">
            <img src="<?= base_url('images/' . $category->top_banner) ?>" class="img-fluid">
          </div>
        </div>
      <?php endif  ?>


      <?php if (isset($category->description) && $category->description) : ?>
        <div class="row">
          <div class="col-md-12">
            <div class="my-3">
              <?php echo  html_entity_decode($category->description)  ?>
            </div>
          </div>
        </div>
      <?php endif; ?>


      <div class="row row-cols-2 row-cols-lg-5  row-cols-md-4 row-cols-sm-3 products_container">

        <?php $this->load->view('landing/ajax/products', ['products' => $products, 'landing' => false]); ?>

      </div>
    </div>
  </div>


</div>