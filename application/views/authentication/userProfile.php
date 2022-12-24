<?php
$getSiteSetting =  getSiteSetting();
$base_color = "#6ab04c";
if (isset($getSiteSetting->base_color) && $getSiteSetting->base_color) {
  $base_color = $getSiteSetting->base_color;
}
?>
<!-- Main content -->
<section class="content">
  <!-- general form elements -->
  <div class="box box-primary">

    <div class="box-body">
      <div class="row">
        <div class="col-md-4">

          <svg id="userAvatar" class="txt-uh-29" enable-background="new 0 0 480.105 480.105" viewBox="0 0 480.105 480.105" xmlns="http://www.w3.org/2000/svg">
            <path d="m319.551 342.226c-11.782-.008-22.467-6.016-28.583-16.07-2.295-3.774-7.216-4.974-10.992-2.678-3.775 2.296-4.974 7.218-2.678 10.992 4.253 6.993 10.014 12.641 16.721 16.684l-8.316 37.622-19.973-23.03c3.639-4.182 2.752-9.051-.364-11.765-3.332-2.899-8.385-2.554-11.287.779l-14.077 16.167-35.411-39.4c2.962-5.689 4.844-12.028 5.382-18.754 68.333 20.155 136.671-31.131 137.219-101.808.005-.179.003-30.535.003-30.714 0-4.418-3.582-8-8-8s-8 3.582-8 8v29.875c0 50.178-40.822 91-91 91s-91-40.822-91-91v-64.891c.067-13.642 15.558-19.924 25.271-11.549 22.577 19.467 50.444 29.925 78.333 31.305 6.903.338 10.962-7.683 6.6-13.041-4.077-5.008-6.534-11.563-6.276-18.456 26.19 17.396 56.721 24.738 86.673 22.484 4.405-.331 7.708-4.172 7.377-8.578-.332-4.404-4.172-7.705-8.578-7.377-30.128 2.269-60.562-6.395-85.401-26.27-4.094-3.275-10.184-1.785-12.31 2.999-4.181 9.414-5.052 20.266-1.8 30.593-20.165-3.638-38.756-12.486-54.17-25.777-20.152-17.373-51.46-3.4-51.717 23.145 0 .271-.004 32.715 0 52.385-5.345-2.771-9.002-8.288-9.002-14.637v-97.461c0-10.477 8.523-19 19-19 3.271 0 6.213-1.991 7.428-5.029 10.927-27.319 37-44.971 66.423-44.971h68.148c39.701 0 72 32.299 72 72v94.46c0 4.418 3.582 8 8 8s8-3.582 8-8v-94.46c0-48.523-39.477-88-88-88h-68.148c-34.32 0-64.917 19.63-79.285 50.421-16.727 2.619-29.566 17.128-29.566 34.579v97.46c0 15.303 10.707 28.165 25.077 31.62 1.494 40.853 25.997 75.936 60.908 92.635-.046 7.341-.996 16.857-9.835 25.658-6.174 6.148-14.478 9.744-23.706 9.744-45.641 0-82.537 36.922-82.569 82.515l-.032 47.257c-.003 4.419 3.576 8.003 7.994 8.006 4.436 0 8.003-3.59 8.006-7.994l.032-47.257c.026-36.704 29.681-66.526 66.655-66.526 3.575 0 7.057-.387 10.416-1.104l11.128 50.668c1.406 6.405 9.539 8.491 13.851 3.534l28.808-33.127 7.169 7.976-.033 47.93c-.003 4.421 3.579 8.006 8 8.006 4.416 0 7.997-3.578 8-7.994l.033-48.009 7.024-8.066 28.918 33.345c4.302 4.962 12.44 2.89 13.855-3.515l11.197-50.655c3.388.723 6.883 1.117 10.451 1.12 36.798.024 66.554 29.825 66.527 66.617l-.032 47.257c-.003 4.419 3.576 8.003 7.994 8.006 4.436 0 8.003-3.59 8.006-7.994l.032-47.257c.032-45.645-36.882-82.6-82.518-82.63zm-125.068 46.487-8.268-37.645c3.094-1.86 5.958-4.057 8.561-6.527l19.373 21.556z" /></svg>

        </div>
        <div class="hidden-lg">&nbsp;</div>
        <div class="col-md-8">
          <h1 class="user_info_header" style="background-color: <?php echo escape_output($base_color) ?>"><?php echo escape_output($this->session->userdata('full_name')); ?></h1>
          <div class="user_detail_container" style="color: <?php echo escape_output($base_color) ?>">
            <?php if ($this->session->userdata('role') != 'Admin') { ?>
              <p class="user_information">
                <i class="fa fa-shopping-cart"></i> <?php echo escape_output($this->session->userdata('outlet_name')); ?> <br />
              </p>
            <?php } ?>
            <p class="user_information">
              <i class="fa fa-users"></i> <?php echo escape_output($this->session->userdata('role')); ?><br />
            </p>
            <p class="user_information">
              <i class="fa fa-phone"></i> <?php echo escape_output($this->session->userdata('phone')); ?> <br />
            </p>
            <?php if ($this->session->userdata('email_address') != '') { ?>
              <p class="user_information">
                <i class="fa fa-envelope"></i> <?php echo escape_output($this->session->userdata('email_address')); ?><br />
              </p>
            <?php } ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>