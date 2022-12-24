<section class="content-header">
    <h1>
        <?php echo lang('add').' '. lang('deposit_or_withdraw'); ?>
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
                <?php echo form_open(base_url() . 'Deposit/addEditDeposit', $arrayName = array('id' => 'deposit_form')) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('ref_no'); ?></label>
                                <input tabindex="1" autocomplete="off" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo escape_output($deposit_ref_no) ?>">
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

						<div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('amount'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" autocomplete="off"  type="text" id="amount" name="amount" class="form-control integerchk" placeholder="<?php echo lang('amount'); ?>" value="">
                            </div>
                            <?php if (form_error('amount')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('amount'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg amount_err_msg_contnr txt-uh-21">
                                <p id="amount_err_msg"></p>
                            </div>
                        </div>


                        <div class="clearfix"></div>


                        <div class="hidden-lg hidden-sm">&nbsp;</div>
                    </div>




                    <div class="row">


						 <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('deposit_or_withdraw'); ?> <span class="required_star">*</span></label>
                                <select tabindex="4" class="form-control select2 select2-hidden-accessible width_100_p" name="type" id="type">
                                    <option value=""><?php echo lang('select'); ?></option>
				    <option  <?php echo set_select('type', "Deposit"); ?> value="Deposit"><?php echo lang('Deposit'); ?></option>
				    <option  <?php echo set_select('type', "Withdraw"); ?>  value="Withdraw"><?php echo lang('Withdraw'); ?></option>

                                </select>
                            </div>
                            <?php if (form_error('type')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('type'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg type_err_msg_contnr txt-uh-21">
                                <p id="type_err_msg"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('note'); ?></label>
                                <textarea tabindex="3" class="form-control" rows="2" id="note" name="note" placeholder="<?php echo lang('Enter...'); ?>"></textarea>
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
                        <input  class="form-control" readonly type="hidden" name="subtotal" id="subtotal" <?php //echo set_value('subtotal');     ?>>

                    </div>
                </div>
                <input type="hidden" name="suffix_hidden_field" id="suffix_hidden_field"/>
                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>Deposit/deposits"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>
