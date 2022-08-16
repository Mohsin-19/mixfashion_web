<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print_daily_summary_report.css">
<section class="content-header">
    <h3 class="c_center"><?php echo lang('daily_summary_report'); ?></h3>
    <hr class="txt-uh-83">
    <div class="row">
        <div class="col-md-2">
            <?php echo form_open(base_url() . 'Report/dailySummaryReport') ?>
            <div class="form-group"> 
                <input tabindex="1" autocomplete="off" type="text" id="date" name="date" readonly class="form-control" placeholder="<?php echo lang('date'); ?>" value="<?php echo set_value('date'); ?>">
            </div> 
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <button type="submit" name="submit" value="submit" class="btn btn-block btn-primary pull-left"><?php echo lang('submit'); ?></button>
            </div>
        </div>
        <div class="hidden-lg">
            <div class="clearfix"></div>
        </div> 
        <div class="col-md-offset-8 col-md-1">
            <div class="form-group"> 
                <a class="btn btn-block btn-primary pull-left" href="<?php echo base_url(); ?>Report/printDailySummaryReport/<?php echo escape_output($selectedDate) ?>"><?php echo lang('print'); ?></a>
            </div>
        </div>
    </div> 
</section>
<section class="content"> 
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">  


                <!-- /.box-header -->
                <div class="box-body table-responsive"> 
                    <h1><?php echo escape_output($this->session->userdata('outlet_name')); ?></h1>
                    <hr>
                    <h3 class="c_center"><?php echo lang('daily_summary_report'); ?></h3>
                    <h4><?php echo isset($selectedDate) && $selectedDate ? lang(   'date').": " . date($this->session->userdata('date_format'), strtotime($selectedDate)) : '' ?></h4>
                    <hr>
                    <h4 class="txt_p_d"><?php echo lang('purchases'); ?></h4>
                    <hr>
                    <table class="tbl width_100_p">
                        <tr>
                            <th class="txt_p_d_1"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('ref_no'); ?></th>
                            <th><?php echo lang('supplier'); ?></th> 
                            <th><?php echo lang('g_total'); ?></th>
                            <th><?php echo lang('paid'); ?></th>
                            <th><?php echo lang('due'); ?></th> 
                        </tr> 
                        <?php  
                            $sum_of_gtotal = 0;
                            $sum_of_paid = 0;
                            $sum_of_due = 0;
                            if (!empty($result['purchases']) && isset($result['purchases'])):
                                foreach ($result['purchases'] as $key => $value): 
                                    $sum_of_gtotal += $value->grand_total; 
                                    $sum_of_paid += $value->paid;  
                                    $sum_of_due += $value->due;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td class="c_center"><?php echo escape_output($key) ?></td>
                                        <td><?php echo escape_output($value->reference_no);?></td>
                                        <td><?php echo getSupplierNameById($value->supplier_id) ?></td>
                                        <td><?php echo escape_output($value->grand_total) ?></td>
                                        <td><?php echo escape_output($value->paid) ?></td>
                                        <td><?php echo escape_output($value->due) ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tr> 
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td> 
                            <td class="txt_p_d_1"><?php echo lang('sum'); ?></td>
                            <td><?php echo number_format($sum_of_gtotal,2) ?></td>
                            <td><?php echo number_format($sum_of_paid,2) ?></td>
                            <td><?php echo number_format($sum_of_due,2) ?></td>
                        </tr>
                    </table> 

                    <hr>
                    <h4 class="txt_p_d"><?php echo lang('orders'); ?></h4>
                    <hr>
                    <table class="tbl width_100_p">
                        <tr>
                            <th class="txt_p_d_1"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('OrderNumber'); ?></th>
                            <th><?php echo lang('customer'); ?></th>
                            <th><?php echo lang('total'); ?> <?php echo lang('amount'); ?></th>
                            <th><?php echo lang('Tax'); ?></th>
                            <th><?php echo lang('DeliveryCharge'); ?></th>

                        </tr>
                        <?php
                            $sum_of_total = 0;
                            $sum_of_tax = 0;
                            $sum_of_dl_charge = 0;
                            if (!empty($result['orders']) && isset($result['orders'])):
                                foreach ($result['orders'] as $key => $value):
                                    $sum_of_total += $value->total_amount;
                                    $sum_of_tax += $value->total_tax;
                                    $sum_of_dl_charge += $value->delivery_charge;
                                    $key++;
                                    ?>
                                    <tr>
                                        <td class="c_center"><?php echo escape_output($key) ?></td>
                                        <td><?php echo escape_output($value->order_number);?></td>
                                        <td><?php echo getCustomerName($value->customer_id) ?></td>
                                        <td><?php echo escape_output($value->total_amount)?></td>
                                        <td><?php echo number_format($value->total_tax,2) ?></td>
                                        <td><?php echo escape_output($value->delivery_charge) ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="txt_p_d_1"><?php echo lang('sum'); ?></td>
                            <td><?php echo number_format($sum_of_total,2) ?></td>
                            <td><?php echo number_format($sum_of_tax,2) ?></td>
                            <td><?php echo number_format($sum_of_dl_charge,2) ?></td>
                        </tr>
                    </table>


                    <hr>
                    <h4 class="txt_p_d"><?php echo lang('expenses'); ?></h4>
                    <hr>
                    <table class="tbl width_100_p">
                        <tr>
                            <th class="txt_p_d_1"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('amount'); ?></th>
                            <th><?php echo lang('category'); ?></th>
                            <th><?php echo lang('responsible_person'); ?></th>
                            <th><?php echo lang('note'); ?></th> 
                        </tr> 
                        <?php  
                            $sum_of_eamount = 0; 
                            if (!empty($result['expenses']) && isset($result['expenses'])):
                                foreach ($result['expenses'] as $key => $value): 
                                    $sum_of_eamount += $value->amount;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td class="c_center"><?php echo escape_output($key) ?></td>
                                        <td><?php echo number_format($value->amount,2) ?></td>
                                        <td><?php echo expenseItemName($value->category_id); ?></td>  
                                        <td><?php echo employeeName($value->employee_id); ?></td>
                                        <td><?php echo escape_output($value->note) ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tr>   
                            <td class="txt_p_d_1"><?php echo lang('sum'); ?></td>
                            <td><?php echo number_format($sum_of_eamount,2) ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table> 

                    <hr>
                    <h4 class="txt_p_d"><?php echo lang('supplier_due_payments'); ?></h4>
                    <hr>
                    <table class="tbl width_100_p">
                        <tr>
                            <th class="txt_p_d_1"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('amount'); ?></th>
                            <th><?php echo lang('supplier'); ?></th> 
                            <th><?php echo lang('note'); ?></th> 
                        </tr> 
                        <?php  
                            $sum_of_samount = 0; 
                            if (!empty($result['supplier_due_payments']) && isset($result['supplier_due_payments'])):
                                foreach ($result['supplier_due_payments'] as $key => $value): 
                                    $sum_of_samount += $value->amount;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td class="c_center"><?php echo escape_output($key) ?></td>
                                        <td><?php echo number_format($value->amount,2); ?></td>
                                        <td><?php echo getSupplierNameById($value->supplier_id); ?></td>
                                        <td><?php echo escape_output($value->note) ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tr>   
                            <td class="txt_p_d_1"><?php echo lang('sum'); ?></td>
                            <td>&nbsp;<?php echo number_format($sum_of_samount,2) ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>                            
                        </tr>
                    </table> 

                    <hr>
                    <h4 class="txt_p_d"><?php echo lang('damages'); ?></h4>
                    <hr>
                    <table class="tbl width_100_p">
                        <tr>
                            <th class="txt_p_d_1"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('ref_no'); ?></th>
                            <th><?php echo lang('loss_amount'); ?></th> 
                            <th><?php echo lang('responsible_person'); ?></th> 
                            <th><?php echo lang('note'); ?></th> 
                        </tr> 
                        <?php  
                            $sum_of_wamount = 0; 
                            if (!empty($result['wastes']) && isset($result['wastes'])):
                                foreach ($result['wastes'] as $key => $value): 
                                    $sum_of_wamount += $value->total_loss;  
                                    $key++;
                                    ?>
                                    <tr>
                                        <td class="c_center"><?php echo escape_output($key) ?></td>
                                        <td><?php echo escape_output($value->reference_no);?></td>
                                        <td><?php echo number_format($value->total_loss,2); ?></td>
                                        <td><?php echo employeeName($value->employee_id); ?></td>
                                        <td><?php echo escape_output($value->note) ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                        <tr>   
                            <td>&nbsp;</td>
                            <td class="txt_p_d_1"><?php echo lang('sum'); ?></td>
                            <td>&nbsp;<?php echo number_format($sum_of_wamount,2) ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
					
					
					
                </div>
                <!-- /.box-body -->
            </div> 
        </div> 
    </div> 
</section>  