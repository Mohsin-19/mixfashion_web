<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/shatkahon.css">

<div class="breadcrumb_section bg_gray page-title-mini">
  <div class="custom-container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="page-title">
          <h1><?= $page->menu_name ?? 'Error page' ?></h1>
        </div>
      </div>
      <div class="col-md-6">
        <ol class="breadcrumb justify-content-md-end">
          <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
          <li class="breadcrumb-item active"><?= $page->menu_name ?? 'Error page' ?></li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="main_content">

  <div class="section py-3">
    <div class="custom-container">
      <div class="row">
        <div class="col-md-6">
          <div class="term_conditions">
            <?= $page->menu_content ?>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="heading_s1">
            <h2>Get In touch</h2>
          </div>
          <div class="field_form">
            <form method="post" name="enq">
              <div class="row">
                <div class="col-md-12">
                  <div id="alert-msg" class="alert-msg text-center p-3"></div>
                </div>
                <div class="form-group col-md-6">
                  <input required="required" placeholder="Enter Name *" id="first-name" class="form-control" name="name" type="text">
                </div>
                <div class="form-group col-md-6">
                  <input required="required" placeholder="Enter Email *" id="email" class="form-control" name="email" type="email">
                </div>
                <div class="form-group col-md-6">
                  <input required="required" placeholder="Enter Phone No. *" id="phone" class="form-control" name="phone">
                </div>
                <div class="form-group col-md-6">
                  <input placeholder="Enter Subject" id="subject" class="form-control" name="subject">
                </div>
                <div class="form-group col-md-12">
                  <textarea required="required" placeholder="Message *" id="description" class="form-control" name="message" rows="4"></textarea>
                </div>
                <div class="col-md-12">
                  <button type="submit" title="Submit Your Message!" class="btn btn-fill-out" id="submitButton" name="submit" value="Submit">Send Message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</div> <!-- main_content -->