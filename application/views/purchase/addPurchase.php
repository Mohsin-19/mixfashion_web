<!--hidden filed use in javascript-->
<input type="hidden" class="supplier_field_required" value="<?php echo lang('supplier_field_required'); ?>">
<input type="hidden" class="account_field_required" value="<?php echo lang('account_field_required'); ?>">
<input type="hidden" class="date_field_required" value="<?php echo lang('date_field_required'); ?>">
<input type="hidden" class="at_least_product" value="<?php echo lang('at_least_product'); ?>">
<input type="hidden" class="paid_field_required" value="<?php echo lang('paid_field_required'); ?>">

<script type="text/javascript" src="<?php echo base_url('assets/js/hidden_filed_value.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/supplier.js'); ?>"></script>


<section class="content-header">
  <h1>
    <?php echo lang('add_purchase'); ?>
  </h1>
</section>

<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">

        <!-- /.box-header -->
        <!-- form start -->
        <?php echo form_open(base_url() . 'Purchase/addEditPurchase', $arrayName = array('id' => 'purchase_form')) ?>
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label><?php echo lang('ref_no'); ?></label>
                <input tabindex="1" autocomplete="off" type="text" id="reference_no" readonly name="reference_no" class="form-control"
                       placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo escape_output($pur_ref_no) ?>">
              </div>
              <?php if (form_error('reference_no')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('reference_no'); ?></p>
                </div>
              <?php } ?>
              <div class="alert alert-error error-msg name_err_msg_contnr txt-uh-21">
                <p id="name_err_msg"></p>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label><?php echo lang('supplier'); ?> <span class="required_star">*</span></label>
                <table class="width_100_p">
                  <tr>
                    <td width="95.5%">
                      <select tabindex="2" class="form-control select2 width_100_p" id="supplier_id" name="supplier_id">
                        <option value=""><?php echo lang('select'); ?></option>
                        <?php
                        foreach ($suppliers as $splrs) {
                          ?>
                          <option
                              value="<?php echo escape_output($splrs->id) ?>" <?php echo set_select('supplier_id', $splrs->id); ?>><?php echo escape_output($splrs->name) ?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td> <span class="plus-custom txt-uh-65" data-toggle="modal" data-target="#supplierModal">
                                                <i class="fa fa-plus"></i></span></td>
                  </tr>
                </table>

              </div>
              <?php if (form_error('supplier_id')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('supplier_id'); ?></p>
                </div>
              <?php } ?>
              <div class="alert alert-error error-msg supplier_id_err_msg_contnr txt-uh-21">
                <p id="supplier_id_err_msg"></p>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                <input tabindex="3" autocomplete="off" readonly type="text" id="date" name="date" class="form-control"
                       placeholder="<?php echo lang('date'); ?>" value="<?php echo date('d-m-Y', strtotime('today')) ?>">
              </div>
              <?php if (form_error('date')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('date'); ?></p>
                </div>
              <?php } ?>
              <div class="alert alert-error error-msg date_err_msg_contnr txt-uh-21">
                <p id="date_err_msg"></p>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4">
              <div class="form-group">
                <label><?php echo lang('invoice_no'); ?></label>
                <input tabindex="1" autocomplete="off" type="text" id="invoice_no" name="invoice_no" class="form-control"
                       placeholder="<?php echo lang('invoice_no'); ?>" value="">
              </div>
              <?php if (form_error('invoice_no')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('invoice_no'); ?></p>
                </div>
              <?php } ?>

            </div>
            <div class="clearfix"></div>
            <div class="col-md-4">

              <div class="form-group">
                <label><?php echo lang('products'); ?> <span class="required_star">*</span></label>
                <select tabindex="4" class="form-control select2 select2-hidden-accessible width_100_p" name="product_id" id="product_id">
                  <option value=""><?php echo lang('select'); ?></option>
                  <?php foreach ($products as $value) { ?>
                    <option
                        value="<?php echo escape_output($value->id) . "|" . $value->name . " (" . $value->code . ")|" . $value->unit_name . "|" . $value->purchase_price . "|" . $value->conversion_rate ?>" <?php echo set_select('unit_id', $value->id); ?>><?php echo escape_output($value->name) . "(" . $value->code . ")" ?></option>
                  <?php } ?>
                </select>
              </div>
              <?php if (form_error('product_id')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('product_id'); ?></p>
                </div>
              <?php } ?>
              <div class="alert alert-error error-msg product_id_err_msg_contnr txt-uh-21">
                <p id="product_id_err_msg"></p>
              </div>
            </div>
            <div class="hidden-lg hidden-sm">&nbsp;</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive" id="purchase_cart">
                <table class="table">
                  <thead>
                  <tr>
                    <th width="1%"><?php echo lang('sn'); ?></th>
                    <th width="15%"><?php echo lang('product'); ?>(<?php echo lang('code'); ?>)</th>
                    <th width="20%"><?php echo lang('unit_price'); ?> <span class="txt-uh-40">fdf</span></th>
                    <th width="20%"><?php echo lang('quantity_amount'); ?></th>
                    <th width="20%"><?php echo lang('total'); ?> <span class="txt-uh-40">Hiddentext</span></th>
                    <th width="5%" class="not-export-col"><?php echo lang('actions'); ?></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('g_total'); ?> <span class="required_star">*</span></label>
                <table class="width_100_p">
                  <tr>
                    <td><input class="form-control integerchk1" readonly type="text" name="grand_total"
                               id="grand_total" <?php echo set_value('grand_total'); ?>></td>
                    <td class="width_5_p c_txt_right"> <span class="label_aligning_total_loss">
                                                <?php echo escape_output($this->session->userdata('currency')); ?>

                                            </span></td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col-md-1"></div>
            <div class="clearfix"></div>
            <div class="col-md-8"></div>
            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('paid'); ?> <span class="required_star">*</span></label>
                <table class="width_100_p">
                  <tr>
                    <td><input tabindex="3" autocomplete="off" class="form-control integerchk" type="text" name="paid" id="paid"
                               onfocus="this.select();" onkeyup="return calculateAll()" <?php echo set_value('paid'); ?>></td>
                    <td class="width_5_p c_txt_right"> <span class="label_aligning_total_loss">
                                                <?php echo escape_output($this->session->userdata('currency')); ?>

                                            </span></td>
                  </tr>
                </table>
              </div>
              <?php if (form_error('paid')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('paid'); ?></p>
                </div>
              <?php } ?>
              <div class="alert alert-error error-msg paid_err_msg_contnr txt-uh-21">
                <p id="paid_err_msg"></p>
              </div>
            </div>
            <div class="col-md-1"></div>
            <div class="clearfix"></div>
            <div class="col-md-8"></div>

            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('payment_methods'); ?> <span class="required_star">*</span></label>
                <select tabindex="3" class="form-control select2 width_100_p" id="payment_method_id" name="payment_method_id">
                  <option value=""><?php echo lang('select'); ?></option>
                  <?php foreach ($paymentMethods as $ec) { ?>
                    <option
                        value="<?php echo escape_output($ec->id) ?>" <?php echo set_select('payment_method_id', $ec->id); ?>><?php echo escape_output($ec->name) ?></option>
                  <?php } ?>
                </select>
              </div>
              <?php if (form_error('payment_method_id')) { ?>
                <div class="alert alert-error txt-uh-21">
                  <p><?php echo form_error('payment_method_id'); ?></p>
                </div>
              <?php } ?>
              <div class="alert alert-error error-msg payment_method_id_err_msg_contnr txt-uh-21">
                <p id="payment_method_id_err_msg"></p>
              </div>
            </div>
            <div class="col-md-1"></div>
            <div class="clearfix"></div>
            <div class="col-md-8"></div>
            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo lang('due'); ?></label>
                <table class="width_100_p">
                  <tr>
                    <td><input class="form-control integerchk" type="text" name="due" id="due" readonly <?php echo set_value('due'); ?>>
                    </td>
                    <td class="width_5_p c_txt_right"> <span class="label_aligning_total_loss">
                                                <?php echo escape_output($this->session->userdata('currency')); ?>

                                            </span></td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col-md-1"></div>
          </div>

          <div class="row">

            <input class="form-control" readonly type="hidden" name="subtotal" id="subtotal" <?php //echo set_value('subtotal');     ?>>

          </div>
        </div>
        <input type="hidden" name="suffix_hidden_field" id="suffix_hidden_field"/>
        <div class="box-footer">
          <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
          <a href="<?php echo base_url() ?>Purchase/purchases">
            <button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button>
          </a>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>

  <div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                  class="fa fa-2x">×</i></span></button>
          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square-o txt-uh-48"></i> <?php echo lang('add_supplier'); ?></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <div class="form-group">
              <label class="col-sm-4 control-label"><?php echo lang('supplier_name'); ?><span class="txt-uh-24">  *</span></label>
              <div class="col-sm-7">
                <input type="text" autocomplete="off" class="form-control" name="name" id="name"
                       placeholder="<?php echo lang('supplier_name'); ?>" value="">
                <div class="alert alert-error error-msg supplier_err_msg_contnr txt-uh-21">
                  <p class="supplier_err_msg"></p>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label"><?php echo lang('contact_person'); ?><span class="txt-uh-24">  *</span></label>
              <div class="col-sm-7">
                <input type="text" autocomplete="off" class="form-control" name="contact_person" id="contact_person"
                       placeholder="<?php echo lang('contact_person'); ?>" value="">
                <div class="alert alert-error error-msg customer_err_msg_contnr txt-uh-21">
                  <p class="customer_err_msg"></p>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label"><?php echo lang('phone'); ?> <span class="txt-uh-24">  *</span></label>
              <div class="col-sm-7">
                <input type="text" autocomplete="off" class="form-control integerchk1" id="phone" name="phone"
                       placeholder="<?php echo lang('phone'); ?>" value="">
                <div class="alert alert-error error-msg customer_phone_err_msg_contnr txt-uh-21">
                  <p class="customer_phone_err_msg"></p>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label"><?php echo lang('email'); ?></label>
              <div class="col-sm-7">
                <input type="text" autocomplete="off" class="form-control" id="emailAddress" name="emailAddress"
                       placeholder="<?php echo lang('email'); ?>" value="">
                <div class="alert alert-error error-msg supplier_email_err_msg_contnr txt-uh-21">
                  <p class="supplier_email_err_msg"></p>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label"><?php echo lang('previous_due'); ?></label>
              <div class="col-sm-7">
                <input type="text" autocomplete="off" class="form-control" id="previous_due" name="previous_due"
                       placeholder="<?php echo lang('previous_due'); ?>" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label"><?php echo lang('address'); ?></label>
              <div class="col-sm-7">
                <textarea tabindex="4" class="form-control" rows="3" name="supAddress"
                          placeholder="<?php echo lang('address'); ?>"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label"><?php echo lang('description'); ?></label>
              <div class="col-sm-7">
                <textarea tabindex="4" class="form-control" rows="4" name="description"
                          placeholder="<?php echo lang('enter'); ?> ..."></textarea>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="addSupplier">
            <i class="fa fa-save"></i> <?php echo lang('submit'); ?></button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="cartPreviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                  class="fa fa-2x">×</i></span></button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <div class="form-group">
              <label class="col-sm-4 control-label"><?php echo lang('unit_price'); ?><span class="txt-uh-24">  *</span></label>
              <div class="col-sm-7">
                <input type="text" autocomplete="off" class="form-control integerchk1" onfocus="select();" name="unit_price_modal"
                       id="unit_price_modal" placeholder="<?php echo lang('unit_price'); ?>" value="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label"><?php echo lang('quantity_amount'); ?><span class="txt-uh-24">  *</span></label>
              <div class="col-sm-7">
                <input type="number" autocomplete="off" min="1" class="form-control integerchk1" onfocus="select();" name="qty_modal"
                       id="qty_modal" placeholder="<?php echo lang('quantity_amount'); ?>" value="1">
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="addToCart">
            <i class="fa fa-plus"></i> <?php echo lang('add_to_cart'); ?></button>
        </div>
      </div>
    </div>
  </div>

  <input type="hidden" name="populate_click" id="populate_click" value="">

</section>

<script src="<?php echo base_url(); ?>assets/js/add_purchase.js"></script>