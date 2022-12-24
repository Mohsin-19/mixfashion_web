<section class="content-header">
    <h1>
       <?php echo lang('edit_expense'); ?>
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
                <?php echo form_open(base_url('Expense/addEditExpense/' . $encrypted_id)); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" id="date" name="date" readonly class="form-control" placeholder="<?php echo lang('date'); ?>" value="<?php echo date("d-m-Y", strtotime($expense_information->date)); ?>">
                            </div>
                            <?php if (form_error('date')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('date'); ?></p>
                                </div>
                            <?php } ?>
                        </div>   
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('amount'); ?> <span class="required_star">*</span></label>
                                <input id="amount" tabindex="2" autocomplete="off" type="text" name="amount" onfocus="this.select();"  class="form-control integerchk" placeholder="<?php echo lang('amount'); ?>" value="<?php echo escape_output($expense_information->amount); ?>">
                            </div>
                            <?php if (form_error('amount')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('amount'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                      
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo lang('category'); ?> <span class="required_star">*</span></label>
                                    <select tabindex="3" class="form-control select2 width_100_p" name="category_id">
                                        <option value=""><?php echo lang('select'); ?></option>
                                        <?php foreach ($expense_categories as $ec) { ?>
                                            <option value="<?php echo escape_output($ec->id) ?>" 
                                            <?php
                                            if ($expense_information->category_id == $ec->id) {
                                                echo "selected";
                                            }
                                            ?>>
                                                <?php echo escape_output($ec->name) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php if (form_error('category_id')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('category_id'); ?></p>
                                    </div>
                                <?php } ?>

                        </div>
                        
                        
                    </div>    
                    <div class="row">
                            
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <label><?php echo lang('responsible_person'); ?> <span class="required_star">*</span></label>
                                <select tabindex="4" class="form-control select2 width_100_p" name="employee_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($employees as $empls) { ?>
                                        <option value="<?php echo escape_output($empls->id) ?>" 
                                        <?php
                                        if ($expense_information->employee_id == $empls->id) {
                                            echo "selected";
                                        }
                                        ?>>
                                            <?php echo escape_output($empls->full_name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (form_error('employee_id')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('employee_id'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                        
                        
                         <div class="col-md-4">
                                <div class="form-group">
                                   <label><?php echo lang('payment_methods'); ?> <span class="required_star">*</span></label>
                                   <select tabindex="3" class="form-control select2 width_100_p" id="payment_method_id" name="payment_method_id">
                                       <option value=""><?php echo lang('select'); ?></option>
                                       <?php foreach ($paymentMethods as $ec) { ?>
                                          <option value="<?php echo escape_output($ec->id) ?>" 
                                            <?php
                                            if ($expense_information->payment_method_id == $ec->id) {
                                                echo "selected";
                                            }
                                            ?>>
                                              <?php echo escape_output($ec->name) ?></option>
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
                                <textarea tabindex="5" class="form-control" rows="4" name="note" placeholder="<?php echo lang('enter'); ?> ..."><?php echo escape_output($expense_information->note); ?></textarea>
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
                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo base_url() ?>Expense/expenses"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
</section>
<script src="<?php echo base_url(); ?>assets/js/edit_expense.js"></script>