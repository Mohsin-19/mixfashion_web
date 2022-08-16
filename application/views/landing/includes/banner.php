<div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap">
  <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-ride="carousel">

    <div class="carousel-inner">
      <?php foreach ($all_slides as $key => $value) : ?>
        <a href="<?= $value->btn_url ?>" class="carousel-item <?= $key == 0 ? 'active' : null; ?> background_bg" data-img-src="<?= base_url('slide-images/' . $value->photo); ?>">
          <div class="banner_slide_content banner_content_inner">
            <div class="col-lg-7 col-10">
              <div class="banner_content3 overflow-hidden">
              </div>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"><i class="icon-left-open-1"></i></a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"><i class="icon-right-open-1"></i></a>
  </div>
</div>