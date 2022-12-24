<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">
<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="page-title">
          <h1>Page Not Found</h1>
        </div>
      </div>
      <div class="col-md-6">
        <ol class="breadcrumb justify-content-md-end">
          <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item active">404 page not found</li>
        </ol>
      </div>
    </div>
  </div>
</div>


<div class="main_content">
  <div class="section pb_85">
    <div class="error_wrap">
      <div class="custom-container">
        <div class="row align-items-center justify-content-center">
          <div class="col-lg-6 col-md-10 order-lg-first">
            <div class="text-center">
              <div class="error_txt">404</div>
              <h5 class="mb-2 mb-sm-3">oops! The page you requested was not found!</h5>
              <p>The page you are looking for was moved, removed, renamed or might never existed.</p>
              <!-- <div class="search_form pb-3 pb-md-4">
              <form method="post">
                <input name="text" id="text" type="text" placeholder="Search" class="form-control">
                <button type="submit" class="btn icon_search"><i class="ion-ios-search-strong"></i></button>
              </form>
            </div> -->
              <a href="<?= site_url('/') ?>" class="btn btn-fill-out">Back To Home</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>