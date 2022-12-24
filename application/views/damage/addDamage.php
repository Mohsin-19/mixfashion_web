<!--hidden filed use in javascript-->
<input type="hidden" class="product_already_remain" value="<?php echo lang('product_already_remain'); ?>">
<input type="hidden" class="damage_amt" value="<?php echo lang('damage_amt'); ?>">
<input type="hidden" class="loss_amt" value="<?php echo lang('loss_amt'); ?>">
<input type="hidden" class="responsible_person_field_required" value="<?php echo lang('responsible_person_field_required'); ?>">
<input type="hidden" class="date_field_required" value="<?php echo lang('date_field_required'); ?>">
<input type="hidden" class="total_loss_field_required" value="<?php echo lang('total_loss_field_required'); ?>">
<input type="hidden" class="at_least_product" value="<?php echo lang('at_least_product'); ?>">
<input type="hidden" class="note_field_cannot" value="<?php echo lang('note_field_cannot'); ?>">

<script src="<?php echo base_url(); ?>assets/js/add_damage.js"></script>
<section class="content-header">
    <h1>
        <?php echo lang('add_damage'); ?>
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
                <?php echo form_open(base_url() . 'Damage/addEditDamage', $arrayName = array('id' => 'damage_form')) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('ref_no'); ?></label>
                                <input tabindex="1" autocomplete="off" type="text" id="reference_no" readonly name="reference_no" class="form-control" placeholder="<?php echo lang('ref_no'); ?>" value="<?php echo escape_output($pur_ref_no)?>">
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
                                <input tabindex="3" autocomplete="off" type="text" id="date" name="date" readonly class="form-control" placeholder="<?php echo lang('date'); ?>" value="<?php echo date('d-m-Y',strtotime('today'))?>">
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
                                <label><?php echo lang('responsible_person'); ?> <span class="required_star">*</span></label>
                                <select tabindex="4" class="form-control select2 select2-hidden-accessible width_100_p" name="employee_id" id="employee_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($employees as $empls) { ?>
                                        <option value="<?php echo escape_output($empls->id); ?>" <?php echo set_select('unit_id', $empls->id); ?>><?php echo escape_output($empls->full_name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (form_error('employee_id')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('employee_id'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg employee_id_err_msg_contnr txt-uh-21">
                                <p id="employee_id_err_msg"></p>
                            </div>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('products'); ?> <span class="required_star">*</span></label>
                                <select tabindex="4" class="form-control select2 width_100_p" name="product_id" id="product_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php
                                    $ignoreID = array();
                                    foreach ($products as $ingnts) {
                                        if (!in_array($ingnts->id, $ignoreID)) {
                                            $ignoreID[] = $ingnts->id;
                                            ?>
                                            <option value="<?php echo escape_output($ingnts->id) . "|" . $ingnts->name . " (" . $ingnts->code . ")|" . $ingnts->unit_name . "|" . $ingnts->sale_price ?>" <?php echo set_select('unit_id', $ingnts->id); ?>><?php echo escape_output($ingnts->name) . " (" . $ingnts->code . ")" ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
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
                        <div class="clearfix"></div>
                        <div class="hidden-lg hidden-sm">&nbsp;</div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="damage_cart">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th width="10%"><?php echo lang('sn'); ?></th>
                                        <th width="25%"><?php echo lang('product'); ?>(<?php echo lang('code'); ?>)</th>
                                        <th width="25%"><?php echo lang('quantity_amount'); ?></th>
                                        <th width="25%"><?php echo lang('loss_amount'); ?></th>
                                        <th width="15%" class="not-export-col"><?php echo lang('actions'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('total_loss'); ?></label>
                                <table class="width_100_p">
                                    <tr>
                                        <td><input  class="form-control aligning_total_loss width_100_p" placeholder="<?php echo lang('total_loss'); ?>" type="text" name="total_loss" id="total_loss"></td>
                                        <td class="width_11_p c_txt_right"> <span class="label_aligning_total_loss">
<?php echo escape_output($this->session->userdata('currency')); ?>
                                            </span></td>
                                    </tr>
                                </table>
                            </div>
                            <?php if (form_error('total_loss')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('total_loss'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg total_loss_err_msg_contnr txt-uh-21">
                                <p id="total_loss_err_msg"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('note'); ?></label>
                                <textarea tabindex="3" class="form-control" rows="2" id="note" name="note" placeholder="<?php echo lang('enter'); ?> ..."><?php echo escape_output($this->input->post('note')); ?></textarea>
                            </div>
                            <?php if (form_error('note')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('note'); ?></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-error error-msg note_err_msg_contnr txt-uh-21">
                                <p id="note_err_msg"></p>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" name="suffix_hidden_field" id="suffix_hidden_field"/>
                    <div class="box-footer">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                        <a href="<?php echo base_url() ?>Damage/damages"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
</section>