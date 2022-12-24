<section class="content-header">
    <h1>
       <?php echo lang('details_purchase'); ?>
    </h1>  
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <h3><?php echo lang('ref_no'); ?></h3>
                                <p class=""><?php echo escape_output($purchase_details->reference_no); ?></p>
                            </div> 
                        </div>

                        <div class="col-md-4"> 
                            <div class="form-group"> 
                                <h3><?php echo lang('supplier'); ?></h3>
                                <?php echo getSupplierNameById($purchase_details->supplier_id); ?>
                            </div>  
                        </div>

                        <div class="col-md-4"> 
                            <div class="form-group">
                                <h3><?php echo lang('date'); ?></h3>
                                <p class=""><?php echo date($this->session->userdata('date_format'), strtotime($purchase_details->date)); ?></p>
                            </div> 
                        </div>
                        <div class="col-md-4"> 
                            <div class="form-group">
                                <h3><?php echo lang('invoice_no'); ?></h3>
                                <p class=""><?php echo escape_output($purchase_details->invoice_no); ?></p>
                            </div> 
                        </div>
                        <div class="col-md-4"> 
                            <div class="form-group"> 
                                <h3><?php //echo lang('products'); ?></h3> 
                            </div> 
                        </div> 
                    </div>  
                    <div class="row">
                        <div class="col-md-12"> 
                            <div class="table-responsive" id="purchase_cart">          
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="10%"><?php echo lang('sn'); ?></th>
                                            <th width="20%"><?php echo lang('product'); ?>(<?php echo lang('code'); ?>)</th>
                                            <th width="15%"><?php echo lang('unit_price'); ?></th>
                                            <th width="15%"><?php echo lang('quantity_amount'); ?></th>
                                            <th width="20%"><?php echo lang('total'); ?></th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        if ($purchase_products && !empty($purchase_products)) {
                                            foreach ($purchase_products as $pi) {
                                                $i++;
                                                echo '<tr id="row_' . $i . '">' .
                                                '<td class="txt-uh-67"><p>' . $i . '</p></td>' .
                                                '<td class="width_20_p"><span class="txt-uh-62">' . getItemNameById($pi->product_id) . ' (' . getItemCodeById($pi->product_id) . ')</span></td>' .
                                                '<td class="width_15_p">' . $this->session->userdata('currency') . " " . $pi->unit_price . '</td>' .
                                                '<td class="width_15_p">' . $pi->quantity_amount . ' ' . unitName(getUnitIdByIgId($pi->product_id)) . '</td>' .
                                                '<td class="width_20_p">' . $this->session->userdata('currency') . " " . $pi->total . '</td>' .
                                                '</tr>'
                                                ;
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div> 
                        </div> 
                    </div> 

                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-offset-2 col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('g_total'); ?></h3>
                                <p class=""><?php echo escape_output($this->session->userdata('currency') . " ") . $purchase_details->grand_total ?></p>
                            </div>
                            <div class="form-group">
                                <h3><?php echo lang('paid'); ?></h3>
                                <p class=""><?php echo escape_output($this->session->userdata('currency') . " ") . $purchase_details->paid ?></p>
                            </div>
                           
                            <div class="form-group"> 
                                <h3><?php echo lang('payment_methods'); ?></h3>
                                <?php echo getPaymentName($purchase_details->payment_method_id); ?>
                            </div>  
                     
                            
                            
                            <div class="form-group">
                                <h3><?php echo lang('due'); ?></h3>
                                <p class=""><?php echo escape_output($this->session->userdata('currency') . " ") . $purchase_details->due ; ?></p>

                            </div>
                        </div> 
                        <div class="col-md-3">

                        </div> 
                    </div>

                    <div class="row"> 
                        <div class="col-md-offset-6 col-md-3">

                        </div>  
                        <div class="col-md-3">

                        </div> 
                    </div>

                </div> 
                <div class="box-footer"> 
                    <a href="<?php echo base_url() ?>Purchase/addEditPurchase/<?php echo escape_output($encrypted_id); ?>"><button type="button" class="btn btn-primary"><?php echo lang('edit'); ?></button></a>
                    <a href="<?php echo base_url() ?>Purchase/purchases"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?> 
            </div> 
        </div>
    </div> 
</section>