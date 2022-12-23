<section class="content-header">
    <h1>
        <?php echo lang('product_details'); ?>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <?php echo form_open(base_url() . 'Item/addEditItem/' . $encrypted_id, $arrayName = array('id' => 'food_menu_form', 'enctype' => 'multipart/form-data')) ?>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('name'); ?></h3>
                                <p class=""><?php echo escape_output($product_details->name); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('NameinYourLanguage'); ?></h3>
                                <p class=""><?php echo escape_output($product_details->name_for_your); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('NameinPeopleLanguage'); ?></h3>
                                <p class=""><?php echo escape_output($product_details->name_for_people); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('sale_price'); ?></h3>
                                <p class=""> <?php echo escape_output($this->session->userdata('currency')); ?> <?php echo escape_output($product_details->sale_price); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('purchase_price'); ?></h3>
                                <p class=""> <?php echo escape_output($this->session->userdata('currency')); ?> <?php echo escape_output($product_details->purchase_price); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('opening_stock'); ?></h3>
                                <p class=""> <?php echo escape_output($product_details->opening_stock); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('code'); ?></h3>
                                <p class=""><?php echo escape_output($product_details->code); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('supplier'); ?></h3>
                                <p class=""><?php echo getSupplierName($product_details->supplier_id); ?></p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('category'); ?></h3>
                                <p class=""><?php echo getCategoryName($product_details->category_id); ?></p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('Subcategory'); ?></h3>
                                <p class=""><?php echo getSubCategoryName($product_details->subcategory_id); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('purchase_unit'); ?></h3>
                                <p class=""><?php echo unitName($product_details->purchase_unit_id); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('sale_unit'); ?></h3>
                                <p class=""><?php echo unitName($product_details->sale_unit_id); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('conversion_rate'); ?></h3>
                                <p class=""><?php echo escape_output($product_details->conversion_rate); ?></p>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('alert_quantity'); ?></h3>
                                <p class=""><?php echo escape_output($product_details->alert_quantity); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('description'); ?></h3>
                                <p class=""><?php echo escape_output($product_details->description); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('available'); ?></h3>
                                <p class=""><?php echo escape_output($product_details->available); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('discount_price'); ?></h3>
                                <p class=""><?php echo escape_output($this->session->userdata('currency')); ?> <?php echo escape_output($product_details->discount_price); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('has_offer'); ?></h3>
                                <p class=""><?php echo escape_output($product_details->has_offer); ?></p>
                            </div>
                        </div>
                        <div class="col-md-3" style="display: <?php echo isset($product_details->has_offer) && $product_details->has_offer == "Yes" ? '' : 'none' ?>">
                            <div class="form-group">
                                <h3><?php echo lang('offer'); ?></h3>
                                <p class=""><?php echo escape_output($product_details->offer); ?></p>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('ManageStock'); ?></h3>
                                <p class=""><?php echo escape_output($product_details->manage_stock); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('photo'); ?></h3>
                                <?php if (!empty($product_details->photo)) { ?>
                                    <img class="img-responsive txt-uh-58" src="<?php echo base_url() . "images/" . $product_details->photo ?>" alt="Photo">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php $collect_tax = $this->session->userdata('collect_tax'); ?>
                    <div class="row" style="display: <?php echo isset($collect_tax) && $collect_tax == "Yes" ? 'block' : 'none' ?>">
                        <?php
                        $tax_information = json_decode($product_details->tax_information);
                        ?>
                        <?php foreach ($tax_fields as $tax_field) { ?>

                            <?php
                            if (count($tax_information) > 0) {
                                foreach ($tax_information as $single_tax) {
                                    // echo escape_output($tax_field->id) ." ". $single_tax->tax_field_id."<br/>";
                                    if ($tax_field->id == $single_tax->tax_field_id) {

                            ?>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <h3><?php echo escape_output($tax_field->tax); ?></h3>
                                                <p class=""><?php echo escape_output($single_tax->tax_field_percentage); ?>%</p>
                                            </div>
                                        </div>
                                <?php   }
                                }
                            } else {

                                ?>

                            <?php
                            }
                            ?>

                        <?php } ?>
                    </div>

                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="<?php echo base_url() ?>Item/addEditItem/<?php echo escape_output($encrypted_id); ?>"><button type="button" class="btn btn-primary"><?php echo lang('edit'); ?></button></a>
                        <a href="<?php echo base_url() ?>Item/products"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>