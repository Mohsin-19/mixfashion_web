<script src="<?php echo base_url(); ?>assets/js/supplier_payment.js"></script>
<section class="content-header">
    <h1>
        <?php echo lang('add_supplier_due_payment'); ?>
    </h1>  
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open(base_url('SupplierPayment/addSupplierPayment')); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                                <?php
                                 $old_select = set_value('date');
                                ?>
                                <input tabindex="1" autocomplete="off" type="text" id="date" readonly name="date" class="form-control" placeholder="<?php echo lang('date'); ?>" value="<?php echo isset($old_select) && $old_select?$old_select:date('Y-m-d',strtotime('today'))?>">
                            </div>
                            <?php if (form_error('date')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('date'); ?></p>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label><?php echo lang('supplier'); ?> <span class="required_star">*</span></label>
                                <select tabindex="3" class="form-control select2 width_100_p" id="supplier_id" name="supplier_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($suppliers as $splrs) { ?>
                                        <option value="<?php echo escape_output($splrs->id) ?>" <?php echo set_select('supplier_id', $splrs->id); ?>><?php echo escape_output($splrs->name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="alert alert-info" id="remaining_due"></div>
                            <?php if (form_error('supplier_id')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('supplier_id'); ?></p>
                                </div>
                            <?php } ?>

                            <div class="form-group"> 
                                <label><?php echo lang('amount'); ?> <span class="required_star">*</span></label>
                                <input tabindex="2" autocomplete="off" type="text" id="amount" name="amount" onfocus="this.select();" class="form-control integerchk width_100_p" placeholder="<?php echo lang('amount'); ?>" value="<?php echo set_value('amount'); ?>">
                            </div>
                            <?php if (form_error('amount')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('amount'); ?></p>
                                </div>
                            <?php } ?>
                            
                           
                                <div class="form-group">
                                   <label><?php echo lang('payment_methods'); ?> <span class="required_star">*</span></label>
                                   <select tabindex="3" class="form-control select2 width_100_p" id="payment_method_id" name="payment_method_id">
                                       <option value=""><?php echo lang('select'); ?></option>
                                       <?php foreach ($paymentMethods as $ec) { ?>
                                           <option value="<?php echo escape_output($ec->id) ?>" <?php echo set_select('payment_method_id', $ec->id); ?>><?php echo escape_output($ec->name) ?></option>
                                       <?php } ?>
                                   </select>
                               </div>
                               <?php if (form_error('payment_method_id')) { ?>
                                   <div class="alert alert-error txt-uh-21">
                                       <p><?php echo form_error('payment_method_id'); ?></p>
                                   </div>
                               <?php } ?>
                           


                        </div>
                        <div class="col-md-6">   
                            <div class="form-group">
                                <label><?php echo lang('note'); ?></label>
                                <textarea tabindex="5" class="form-control" rows="7" name="note" placeholder="<?php echo lang('enter'); ?> ..."><?php echo escape_output($this->input->post('note')); ?></textarea>
                            </div> 
                            <?php if (form_error('note')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('note'); ?></p>
                                </div>
                            <?php } ?>  
                        </div> 

                    </div>
                    <!-- /.box-body -->
                </div> 
                <input type="hidden" name="<?php echo escape_output($this->security->get_csrf_token_name()); ?>" value="<?php echo escape_output($this->security->get_csrf_hash()); ?>" />
                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>SupplierPayment/supplierPayments"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>