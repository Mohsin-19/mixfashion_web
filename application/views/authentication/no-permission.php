<?php
$getSiteSetting = getSiteSetting();
$base_color = "#6ab04c";
if (isset($getSiteSetting->base_color) && $getSiteSetting->base_color) {
  $base_color = $getSiteSetting->base_color;
}
?>
<!-- Main content -->
<section class="content">
  <div class="row" style="justify-content: center!important;display: flex;">
    <div class="col-sm-4">
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h2>401 Unauthorized</h2>
          <p>
            You Don't Have permission for this Operation!
          </p>
        </div> <!-- alert -->
    </div>
  </div>
</section>