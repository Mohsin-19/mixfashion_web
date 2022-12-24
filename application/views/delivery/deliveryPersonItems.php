<!--hidden filed use in javascript-->
<input type="hidden" class="expense" value="<?php echo lang('expense'); ?>">
<input type="hidden" class="purchase" value="<?php echo lang('purchase'); ?>">
<input type="hidden" class="Delivery" value="<?php echo lang('Delivery'); ?>">
<input type="hidden" class="OpeningCash" value="<?php echo lang('OpeningCash'); ?>">
<input type="hidden" class="role_" value="<?php echo lang('role'); ?>">

<select class="form-control order_numbers_hidden" id="">
    <option value=""><?php echo lang('None'); ?></option>
    <?php
    foreach ($orders as $value):
        ?>
        <option value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->order_number); ?></option>
        <?php
    endforeach;
    ?>
</select>
<section class="content-header">
    <h1>
        <?php echo lang('AddDeliveryPersonCash'); ?>
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

                <div class="box-body">
                    <?php echo form_open(base_url() . 'deliveryPerson/addDeliveryPersonItems/'.$encrypted_id, $arrayName = array('id' => 'add_dpitems','enctype'=>'multipart/form-data')) ?>
                    <div class="row">
                        <?php
                        $role = $this->session->userdata('role');
                        ?>
                        <input type="hidden" name="opening_amount" id="opening_amount" value="">
                        <div class="col-md-2">
                            <label><?php echo lang('DeliveryPerson'); ?></label>
                            <select <?php echo ($role && $role=="Delivery Person"?'disabled':'')?> class="form-control select2 width_100_p" id="delivery_person_id" name="delivery_person_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                    <?php
                                        foreach ($delivery_persons as $value):
                                    ?>
                                            <option <?php echo isset($delivery_person) && $delivery_person->delivery_person_id && $delivery_person->delivery_person_id==$value->id?'selected':''?> value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->full_name); ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <?php
                            $old_date = set_value('date');
                            ?>
                            <label><?php echo lang('date'); ?></label>
                            <input type="text"  <?php echo ($role && $role=="Delivery Person"?'disabled':'')?>  name="date" readonly id="" class="form-control customDatepicker" value="<?php echo isset($delivery_person) && $delivery_person->date?$delivery_person->date:(isset($old_date) && $old_date?$old_date:date("Y-m-d",strtotime('today')))?>">
                        </div>
                        <div class="col-md-2">
                            <label><?php echo lang('OpeningTime'); ?></label>
                            <?php
                            $opening_time = set_value('opening_time');
                            ?>
                            <input type="text"  <?php echo ($role && $role=="Delivery Person"?'disabled':'')?>  name="opening_time" id="" class="form-control customDatepicker_time" placeholder="<?php echo lang('OpeningTime'); ?>" value="<?php echo isset($delivery_person) && $delivery_person->opening_time?$delivery_person->opening_time:(isset($opening_time) && $opening_time?$opening_time:date('h:i A'))?>">
                        </div>
                        <?php
                         $role = $this->session->userdata('role');
                         $close_status = isset($delivery_person->close_status) && $delivery_person->close_status?$delivery_person->close_status:'';
                        ?>
                            <div class="col-md-2" style="display:  <?php echo ($role && $role=="Delivery Person"?'none':'')?> ">
                                <label>&nbsp;</label>
                                <a href="<?php echo base_url()?>deliveryPerson/closeCash/<?php echo escape_output($encrypted_id)?>" style="display: <?php echo escape_output($encrypted_id)?'':'none'?>;" class="check_row btn btn-block btn-danger pull-left"><?php echo lang('CloseThisCash'); ?></a>
                            </div>
                    </div>
                    <p></p>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="box-body table-responsive txt-uh-32">
                                <table class="table">

                                <tr>
                                    <th><?php echo lang('Item'); ?></th>
                                    <th><?php echo lang('OrderNumber'); ?></th>
                                    <th><?php echo lang('amount'); ?></th>
                                    <th><?php echo lang('description'); ?></th>
                                    <th></th>
                                </tr>

                                <tbody class="added_row">
                                <?php
                                if(isset($items) && $items):
                                    $j = 1;
                                    foreach ($items as $value):
                                        ?>
                                        <tr class="row_counter">
                                            <td>
                                                <!--delete row id-->
                                                <?php
                                                    if($role && $role=="Delivery Person"  && $value->item_name!="Opening Cash"):
                                                ?>
                                                        <input type="hidden" name="delete_id[]" value="<?php echo escape_output($value->id); ?>">
                                                <?php
                                                else:
                                                ?>


                                                <?php
                                                endif;
                                                ?>
                                                <table class="width_100_p">
                                                    <tr>
                                                        <td  class="width_1_p">
                                                            <input type="hidden" value="" class="value_row" name="value_row[]">
                                                            <span class="counter_row"><?php echo escape_output($j)?>. </span></td>
                                                        <td>
                                                            <select <?php echo ($role && $role=="Delivery Person"  && $value->item_name=="Opening Cash"?'disabled':'')?>  class="width_100_p form-control select2 c_item" name="items[]" id="">
                                                                <?php
                                                                if($role=="Delivery Person" && $value->item_name=="Opening Cash"):
                                                                    ?>
                                                                    <option <?php echo isset($value->item_name) && $value->item_name && $value->item_name=="Opening Cash"?'selected':''?> value="Opening Cash">Opening Cash</option>
                                                                    <?php
                                                                else:
                                                                    if($role!="Delivery Person"):
                                                                        ?>
                                                                        <option <?php echo isset($value->item_name) && $value->item_name && $value->item_name=="Opening Cash"?'selected':''?> value="Opening Cash">Opening Cash</option>
                                                                        <?php
                                                                    endif;
                                                                endif;
                                                                ?>
                                                                <option <?php echo isset($value->item_name) && $value->item_name && $value->item_name=="Expense"?'selected':''?> value="Expense">Expense</option>
                                                                <option <?php echo isset($value->item_name) && $value->item_name && $value->item_name=="Purchase"?'selected':''?> value="Purchase">Purchase</option>
                                                                <option <?php echo isset($value->item_name) && $value->item_name && $value->item_name=="Delivery"?'selected':''?> value="Delivery">Delivery</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="c_td">
                                                <select <?php echo ($role && $role=="Delivery Person"  && $value->item_name=="Opening Cash"?'disabled':'')?>  <?php echo isset($value->item_name) && $value->item_name && ($value->item_name=="Opening Cash" || $value->item_name=="Expense")?'disabled':''?>  class="width_100_p form-control select2 c_order" id="">
                                                    <option value="">None</option>
                                                    <?php
                                                        foreach ($orders as $value1):
                                                            ?>
                                                            <option  <?php echo isset($value->order_id) && $value->order_id && $value->order_id==$value1->id?'selected':''?> value="<?php echo escape_output($value1->id); ?>"><?php echo escape_output($value1->order_number); ?></option>
                                                            <?php
                                                        endforeach;
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <table class="width_100_p">
                                                    <tr>
                                                        <td>
                                                            <i  class="<?php echo isset($value->item_name) && $value->item_name && ($value->item_name=="Opening Cash" || $value->item_name=="Delivery")?'fa fa-plus':'fa fa-minus'?>  c_status"></i>
                                                        </td>
                                                        <td class="width_83_p">
                                                            <input <?php echo ($role && $role=="Delivery Person"  && $value->item_name=="Opening Cash"?'disabled':'')?>  type="text" name="amounts[]" onfocus="select()" class="form-control integerchk c_amount" value="<?php echo escape_output($value->amount); ?>">
                                                        </td>
                                                    </tr>
                                                </table>

                                            </td>
                                            <td class="txt-uh-34"><input <?php echo ($role && $role=="Delivery Person"  && $value->item_name=="Opening Cash"?'disabled':'')?>  type="text" class="form-control c_description" name="descriptions[]" value="<?php echo escape_output($value->description); ?>"></td>
                                            <td class="txt-uh-35" style="display:  <?php echo ($role && $role=="Delivery Person"?'none':'')?> "><a href="#" class="delete_row"><i class="txt-uh-24 fa fa-trash"></i> </a> </td>
                                        </tr>
                                        <?php
                                        $j++;
                                    endforeach;
                                else:
                                    ?>
                                    <tr class="row_counter">
                                        <td>
                                            <table class="width_100_p">
                                                <tr>
                                                    <td class="width_1_p">
                                                        <input type="hidden" value="" class="value_row" name="value_row[]">
                                                        <span class="counter_row">1. </span></td>
                                                    <td>
                                                        <select  class="width_100_p form-control select2 c_item" name="items[]" id="">
                                                            <?php
                                                            if($role=="Delivery Person"):
                                                                ?>

                                                                <?php
                                                            else:
                                                                    ?>
                                                                    <option value="Opening Cash"><?php echo lang('OpeningCash'); ?></option>
                                                                    <?php
                                                            endif;
                                                            ?>
                                                            <option value="Expense"><?php echo lang('expense'); ?></option>
                                                            <option value="Purchase"><?php echo lang('purchase'); ?></option>
                                                            <option value="Delivery"><?php echo lang('Delivery'); ?></option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="c_td">
                                            <select  disabled class="width_100_p form-control select2 c_order" id="">
                                                <option value=""><?php echo lang('None'); ?></option>
                                                <?php
                                                foreach ($orders as $value):
                                                    ?>
                                                    <option value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->order_number); ?></option>
                                                    <?php
                                                endforeach;
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <table class="width_100_p">
                                                <tr>
                                                    <td>
                                                        <i  class="fa fa-plus c_status"></i>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="amounts[]" onfocus="select()" class="form-control integerchk c_amount" value="">
                                                    </td>
                                                </tr>
                                            </table>

                                        </td>
                                        <td><input type="text" class="form-control c_description" name="descriptions[]" value=""></td>
                                        <td class="txt-uh-35"><a href="#" class="delete_row"><i class="txt-uh-24 fa fa-trash"></i> </a> </td>
                                    </tr>
                                    <?php
                                endif;
                                ?>
                                </tbody>

                            </table>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <p class="error_item txt-uh-36"><?php echo lang('please_add_at_least_one_item'); ?></p>
                            <button type="button" name="button" value="submit" class="btn btn-primary add_more"><?php echo lang('AddMore'); ?></button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-10">
                            <h3 class="c_center"> <?php echo lang('total'); ?> = $<span class="total_amount">0.00</span></h3>
                        </div>
                        <input type="hidden" value="" id="current_balance" name="current_balance" class="current_balance">
                    </div>
                    <div class="box-footer txt-uh-32">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                        <a href="<?php echo base_url() ?>deliveryPerson/deliveryPersonItems"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                    </div>
                    <?php echo form_close(); ?>
                </div>

            </div>
        </div>
</section>

<script src="<?php echo base_url(); ?>assets/js/delivery_person_items.js"></script>
