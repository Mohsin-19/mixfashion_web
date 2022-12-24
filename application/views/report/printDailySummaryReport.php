<a href="<?php echo base_url() . 'Report/dailySummaryReport' ?>" class="btn btn-block btn-primary pull-left no_print"><strong><?php echo lang('back'); ?></strong></a>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print_daily_summary_report.css">
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
                    <h4><?php echo isset($selectedDate) && $selectedDate ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($selectedDate)) : '' ?></h4>
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
                                        <td><?php echo number_format($value->amount,2) ?>; ?></td>
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
<script src="<?php echo base_url(); ?>assets/dist/js/print/jquery-2.0.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/onload_print.js"></script>