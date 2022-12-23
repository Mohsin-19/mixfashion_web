<script src="<?= base_url('assets/bower_components/crop/croppie.js'); ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/bower_components/crop/croppie.css'); ?>">
<input type="hidden" name="base_url_ajax" id="base_url_ajax" class="base_url_ajax" value="<?= site_url() ?>">


<section class="content">


  <h2 class="page-header"><?= lang('edit_product'); ?></h2>

  <div class="row">
    <div class="col-md-12">
      <?php if ($this->session->flashdata('flashExists')) : ?>
        <div class="alert alert-danger" role="alert">
          <?= $this->session->flashdata('flashExists') ?>
        </div>
      <?php endif; ?>
      <?= validation_errors('<div class="alert alert-danger" style="padding: 12px;margin-bottom: 8px;">', '</div>'); ?>
    </div>
  </div>

  <div class="row">

    <div class="col-md-12">

      <?= form_open("Item/addEditItem/{$encrypted_id}", ['id' => 'product_form', 'enctype' => 'multipart/form-data']) ?>

      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#general" data-toggle="tab">General</a></li>
          <li><a href="#category_and_unit" data-toggle="tab">Category & Unit</a></li>
          <li><a href="#pricing" data-toggle="tab">Price & Attributes</a></li>
          <li><a href="#gallery" data-toggle="tab">Gallery</a></li>
          <li><a href="#vat_tax" data-toggle="tab">Vat & Tax</a></li>
          <li><a href="#productDescription" data-toggle="tab">Description</a></li>
          <li><a href="#specification" data-toggle="tab">Specification</a></li>
          <li class="pull-right">
            <a href="<?= site_url('Item/products') ?>" class="text-danger"><i class="fa fa-arrow-left"></i> Back</a>
          </li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="general">
            <?php $this->load->view('master/product/includes/tabGeneral'); ?>
          </div> <!-- /.general -->

          <div class="tab-pane" id="category_and_unit">
            <?php $this->load->view('master/product/includes/tabCategory'); ?>
          </div> <!-- /.category_and_unit -->

          <div class="tab-pane" id="pricing">
            <?php $this->load->view('master/product/includes/tabPricing'); ?>
          </div> <!-- /.pricing -->

          <div class="tab-pane" id="gallery">
            <?php $this->load->view('master/product/includes/tabGallery'); ?>
          </div> <!-- /.gallery -->

          <div class="tab-pane" id="vat_tax">
            <?php $this->load->view('master/product/includes/tabVatTax'); ?>
          </div> <!-- /.vat_tax -->

          <div class="tab-pane" id="productDescription">
            <?php $this->load->view('master/product/includes/tabDescription'); ?>
          </div> <!-- /.description -->

          <div class="tab-pane" id="specification">
            <?php $this->load->view('master/product/includes/tabSpecification'); ?>
          </div> <!-- /.specification -->

        </div> <!-- /.tab-content -->
      </div> <!-- nav-tabs-custom -->

      <?= form_close(); ?>

    </div> <!-- /.col -->
  </div> <!-- /.row -->

</section>

<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square-o txt-uh-48"></i> <?php echo lang('add_product_category'); ?>
        </h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="add_category_form">
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('name'); ?><span class="txt-uh-24"> *</span></label>
            <div class="col-sm-7">
              <input type="text" autocomplete="off" class="form-control" name="name" id="name_cat" placeholder="<?php echo lang('name'); ?>" value="">
              <div class="alert alert-error error-msg name_err_msg_contnr txt-uh-21">
                <p class="name_err_msg"></p>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('description'); ?></label>
            <div class="col-sm-7">
              <input tabindex="2" autocomplete="off" type="text" id="description_cat" name="description" class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?php echo set_value('description'); ?>">
              <div class="alert alert-error error-msg sdescription_err_msg_contnr txt-uh-21">
                <p class="description_err_msg"></p>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
        <button type="button" class="btn btn-primary" id="addCategory">
          <i class="fa fa-save"></i> <?php echo lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>
<!-- suppliers modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square-o txt-uh-48"></i> <?php echo lang('add_supplier'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="add_supplier_form">
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('supplier_name'); ?><span class="txt-uh-24"> *</span></label>
            <div class="col-sm-7">
              <input type="text" autocomplete="off" class="form-control" name="name" id="name_supplier" placeholder="<?php echo lang('supplier_name'); ?>" value="">
              <div class="alert alert-error error-msg name_err_msg_contnr txt-uh-21">
                <p class="name_err_msg"></p>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('contact_person'); ?><span class="txt-uh-24"> *</span></label>
            <div class="col-sm-7">
              <input autocomplete="off" type="text" id="contact_person" name="contact_person" class="form-control" placeholder="<?php echo lang('contact_person'); ?>" value="<?php echo set_value('contact_person'); ?>">
              <div class="alert alert-error error-msg sdescription_err_msg_contnr txt-uh-21">
                <p class="contact_person_err_msg"></p>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('phone'); ?><span class="txt-uh-24"> *</span></label>
            <div class="col-sm-7">
              <input autocomplete="off" type="text" id="phone" name="phone" class="form-control" placeholder="<?php echo lang('phone'); ?>" value="<?php echo set_value('phone'); ?>">
              <div class="alert alert-error error-msg sdescription_err_msg_contnr txt-uh-21">
                <p class="phone_err_msg"></p>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
        <button type="button" class="btn btn-primary" id="addSupplier">
          <i class="fa fa-save"></i> <?php echo lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>
<!-- suppliers modal end -->
<div class="modal fade" id="addPurchaseUnitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square-o txt-uh-48"></i> <?php echo lang('add_unit'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="add_purchase_unit_form">
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('unit_name'); ?><span class="txt-uh-24"> *</span></label>
            <div class="col-sm-7">
              <input type="text" autocomplete="off" class="form-control" name="unit_name" id="unit_name_p" placeholder="<?php echo lang('name'); ?>" value="">
              <div class="alert alert-error error-msg unit_name_err_msg_contnr txt-uh-21">
                <p class="unit_name_err_msg"></p>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('description'); ?></label>
            <div class="col-sm-7">
              <input tabindex="2" autocomplete="off" type="text" name="description" id="description_p" class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?php echo set_value('description'); ?>">
              <div class="alert alert-error error-msg sdescription_err_msg_contnr txt-uh-21">
                <p class="description_err_msg"></p>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
        <button type="button" class="btn btn-primary" id="addPurchaseUnit">
          <i class="fa fa-save"></i> <?php echo lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addSaleUnitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square-o txt-uh-48"></i> <?php echo lang('add_unit'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="add_sale_unit_form">
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('unit_name'); ?><span class="txt-uh-24"> *</span></label>
            <div class="col-sm-7">
              <input type="text" autocomplete="off" class="form-control" name="unit_name" id="unit_name_sale" placeholder="<?php echo lang('name'); ?>" value="">
              <div class="alert alert-error error-msg unit_name_err_msg_contnr txt-uh-21">
                <p class="unit_name_err_msg"></p>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label"><?php echo lang('description'); ?></label>
            <div class="col-sm-7">
              <input tabindex="2" autocomplete="off" type="text" name="description" id="description_s" class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?php echo set_value('description'); ?>">
              <div class="alert alert-error error-msg sdescription_err_msg_contnr txt-uh-21">
                <p class="description_err_msg"></p>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
        <button type="button" class="btn btn-primary" id="addSaleUnit">
          <i class="fa fa-save"></i> <?php echo lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="AddItemImageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog txt-uh-49" style="" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <strong><?php echo lang('select_image'); ?></strong>
        <br />
        <input type="file" id="upload">
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-7 text-center">
            <div id="upload-demo"></div>
          </div>
          <div class="col-md-5 txt-uh-50 text-right">

          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
        <button type="button" class="btn btn-primary upload-result" id="">
          <i class="fa fa-save "></i> <?php echo lang('crop'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="guideModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <p class="show_guide_text"></p>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary">
          <?= lang('cancel'); ?></button>
      </div>
    </div>

  </div>
</div>

<script src="<?= base_url('assets/js/add_item.js'); ?>"></script>

<script src="<?= base_url('assets/plugins/tinymce/jquery.tinymce.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/tinymce/editor-helper.js'); ?>"></script>


<script>
  function readURL(input, selector) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        selector.attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

  $(function() {

    default_editor('#description', 200);
    simple_editor('.editor', 450);


    $(".image").change(function() {
      var s_photo = $(this).closest('.form-group').find('.s_photo');
      readURL(this, s_photo);
    });

    $('body').on('click', '.btn-continue', function() {
      var href = $(this).attr('href');
      console.log(href)
      $(".nav-tabs").find('li').removeClass('active');
      $(".nav-tabs").find('[href="' + href + '"]').closest('li').addClass('active');

    }).on('click', '.nav-tabs a', function(e) {
      window.location.hash = e.target.hash;

    }).on('click', '.removeGallery', function(e) {
      e.preventDefault();
      var formGroup = $(this).closest('.form-group');
      var demoImag = '/assets/images/no_image_thumb.png';
      formGroup.find('img').attr('src', demoImag);
      formGroup.find('input[type="hidden"]').val('');

    });

    // Javascript to enable link to tab
    var hash = location.hash.replace(/^#/, ''); // ^ means starting, meaning only match the first hash
    if (hash) {
      $('.nav-tabs a[href="#' + hash + '"]').tab('show');
    }

  });
</script>