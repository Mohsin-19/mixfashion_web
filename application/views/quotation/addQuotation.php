<!--hidden filed use in javascript-->
<input type="hidden" class="supplier_field_required" value="<?php echo lang('supplier_field_required'); ?>">
<input type="hidden" class="account_field_required" value="<?php echo lang('account_field_required'); ?>">
<input type="hidden" class="date_field_required" value="<?php echo lang('date_field_required'); ?>">
<input type="hidden" class="at_least_product" value="<?php echo lang('at_least_product'); ?>">
<input type="hidden" class="paid_field_required" value="<?php echo lang('paid_field_required'); ?>">
<input type="hidden" class="product_already_remain" value="<?php echo lang('product_already_remain'); ?>">
<input type="hidden" class="customer_field_required" value="<?php echo lang('customer_field_required'); ?>">
<input type="hidden" class="description" value="<?php echo lang('description'); ?>">

<section class="content-header">
    <h1>
        <?php echo lang('add_quotation'); ?>
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
                <?php echo form_open(base_url() . 'Quotation/addEditQuotation', $arrayName = array('id' => 'quotation_form')) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label><?php echo lang('ref_no'); ?></label>
                                <input tabindex="1" autocomplete="off" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo escape_output($pur_ref_no) ?>">
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
                                <label><?php echo lang('customer'); ?> <span class="required_star">*</span></label>
                                <select tabindex="2" class="form-control select2 width_100_p" id="customer_id" name="customer_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php
                                    foreach ($customers as $splrs) {
                                        ?>
                                        <option value="<?php echo escape_output($splrs->id) ?>" <?php echo set_select('customer_id', $splrs->id); ?>><?php echo escape_output($splrs->name) ?> (<?php echo escape_output($splrs->phone) ?>) </option>
                                    <?php } ?>
                                </select>

                            </div> 
                            <?php if (form_error('customer_id')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('customer_id'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg customer_id_err_msg_contnr txt-uh-21">
                                <p id="customer_id_err_msg"></p>
                            </div>
                        </div>

                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" autocomplete="off" readonly type="text" id="date" name="date" class="form-control" placeholder="<?php echo lang('date'); ?>" value="<?php echo date('d-m-Y',strtotime('today'))?>">
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
                                <label><?php echo lang('products'); ?> <span class="required_star">*</span></label>
                                <select tabindex="4" class="form-control select2 select2-hidden-accessible width_100_p" name="product_id" id="product_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($products as $value) { ?>
                                        <option value="<?php echo escape_output($value->id) . "|" . $value->name . " (" . $value->code . ")|" . $value->unit_name . "|" . $value->sale_price ?>" <?php echo set_select('unit_id', $value->id); ?>><?php echo escape_output($value->name) . "(" . $value->code . ")" ?></option>
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
                        <div class="col-md-3">
                            <div class="hidden-xs hidden-sm">&nbsp;</div>
                        </div>
                        <div class="hidden-lg hidden-sm">&nbsp;</div>
                    </div>  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="quotation_cart">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="1%"><?php echo lang('sn'); ?></th>
                                            <th width="15%"><?php echo lang('product'); ?>(<?php echo lang('code'); ?>)</th>
                                            <th width="20%"><?php echo lang('unit_price'); ?> <span class="txt-uh-40">fdf</span></th>
                                            <th width="20%"><?php echo lang('quantity_amount'); ?></th>
                                            <th width="20%"><?php echo lang('total'); ?> <span class="txt-uh-40">Hiddentext</span></th>
                                            <th width="20%"><?php echo lang('description'); ?> <span class="txt-uh-40">Hiddentext</span></th>
                                            <th class="not-export-col" width="20%"><?php echo lang('actions'); ?></th>
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
                                <label><?php echo lang('sub_total'); ?> <span class="required_star">*</span></label>
                                <table class="width_100_p">
                                    <tr>
                                        <td><input  class="form-control" readonly type="text" name="subtotal" id="subtotal" <?php echo set_value('grand_total'); ?>></td>
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
                                <label><?php echo lang('discount'); ?></label>
                                <table class="width_100_p">
                                    <tr>
                                        <td><input tabindex="3" autocomplete="off" class="form-control discount" type="text" name="discount" id="discount" onfocus="this.select();" onkeyup="return calculateAll()" <?php echo set_value('discount'); ?>></td>
                                        <td class="width_5_p c_txt_right"> <span class="label_aligning_total_loss">
                                                <?php echo escape_output($this->session->userdata('currency')); ?>

                                            </span></td>
                                    </tr>
                                </table>
                            </div>
                            <?php if (form_error('discount')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('discount'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg discount_err_msg_contnr txt-uh-21">
                                <p id="discount_err_msg"></p>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="clearfix"></div>
                        <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('other'); ?></label>
                                <table class="width_100_p">
                                    <tr>
                                        <td><input  class="form-control integerchk" type="text" onfocus="select()"   name="other" onkeyup="return calculateAll()"  id="other" <?php echo set_value('other'); ?>></td>
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
                                <label><?php echo lang('g_total'); ?></label>
                                <table class="width_100_p">
                                    <tr>
                                        <td><input  class="form-control" type="text" name="grand_total" id="grand_total" readonly <?php echo set_value('grand_total'); ?>></td>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('Remark'); ?></label>
                                <textarea tabindex="3" class="form-control" rows="2" id="note" name="note" placeholder="<?php echo lang('Enter...'); ?>"><?php  echo escape_output($this->input->post('note'));  ?></textarea>
                            </div>
                        <?php  if (form_error('note')) {  ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php  echo form_error('note');  ?></p>
                                </div>
                        <?php  }  ?>
                            <div class="alert alert-error error-msg note_err_msg_contnr txt-uh-21">
                                <p id="note_err_msg"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="suffix_hidden_field" id="suffix_hidden_field"/>
                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>Quotation/quotations"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?> 
            </div> 
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>assets/js/quotation.js"></script>