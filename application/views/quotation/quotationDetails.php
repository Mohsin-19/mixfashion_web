<section class="content-header">
    <h1>
       <?php echo lang('details_quotation'); ?>
    </h1>  
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                <div class="box-body">
                    <div id="printableArea">
                        <div class="row">
                            <div class="col-md-12">
                            <table class="width_100_p">
                                <tr>
                                    <td>  <h3>
                                            <?php echo escape_output($this->session->userdata('outlet_name')); ?>

                                        </h3>
                                        <?php echo escape_output($this->session->userdata('address')); ?>
                                        <br>
                                        Tel: <?php echo escape_output($this->session->userdata('phone')); ?>
                                    </td>
                                    <td></td>
                                    <?php
                                        $customer = getCustomer($quotation_details->customer_id);
                                    ?>
                                    <td class="txt-uh-68 width_30_p"><h3><?php echo lang('ref'); ?>: <span class=""><?php echo escape_output($quotation_details->reference_no); ?></span> &nbsp;&nbsp;&nbsp;<?php echo lang('date'); ?>: <span class=""><?php echo date($this->session->userdata('date_format'), strtotime($quotation_details->date)); ?></span> </h3>
                                        <span class="txt-uh-71"><?php echo escape_output($customer->name); ?></span>
                                        <br>
                                        Tel: <?php echo escape_output($customer->phone); ?>


                                    </td>
                                </tr>
                            </table>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <h3><?php echo lang('products'); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="quotation_cart">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="10%"><?php echo lang('sn'); ?></th>
                                                <th width="20%"><?php echo lang('product'); ?>(<?php echo lang('code'); ?>)</th>
                                                <th width="15%"><?php echo lang('unit_price'); ?></th>
                                                <th width="15%"><?php echo lang('quantity_amount'); ?></th>
                                                <th width="20%"><?php echo lang('total'); ?></th>
                                                <th width="20%"><?php echo lang('description'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            if ($quotation_products && !empty($quotation_products)) {
                                                foreach ($quotation_products as $pi) {
                                                    $i++;
                                                    echo '<tr id="row_' . $i . '">' .
                                                    '<td class="txt-uh-67"><p>' . $i . '</p></td>' .
                                                    '<td class="width_20_p"><span class="txt-uh-62">' . getItemNameById($pi->product_id) . ' (' . getItemCodeById($pi->product_id) . ')</span></td>' .
                                                    '<td class="width_15_p">' . $this->session->userdata('currency') . " " . $pi->unit_price . '</td>' .
                                                    '<td class="width_15_p">' . $pi->quantity_amount . ' ' . unitName(getUnitIdByIgId($pi->product_id)) . '</td>' .
                                                    '<td class="width_20_p">' . $this->session->userdata('currency') . " " . $pi->total . '</td>' .
                                                        '<td class="width_15_p">' . $pi->description.'</td>' .
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
                            <div class="form-group">
                                <h3><?php echo lang('Remark'); ?></h3>
                                <p class=""><?php echo escape_output($quotation_details->note) ?></p>
                            </div>
                        </div>
                        <div class="col-md-offset-2 col-md-3">
                            <div class="form-group">
                                <h3><?php echo lang('sub_total'); ?></h3>
                                <p class=""><?php echo escape_output($this->session->userdata('currency') . " ") . $quotation_details->subtotal ?></p>
                            </div>
                            <div class="form-group">
                                <h3><?php echo lang('discount'); ?></h3>
                                <p class=""><?php echo escape_output($this->session->userdata('currency') . " ") . $quotation_details->discount ?></p>
                            </div>
                            <div class="form-group">
                                <h3><?php echo lang('other'); ?></h3>
                                <p class=""><?php echo escape_output($this->session->userdata('currency') . " ") . $quotation_details->other ; ?></p>

                            </div>
                            <div class="form-group">
                                <h3><?php echo lang('g_total'); ?></h3>
                                <p class=""><?php echo escape_output($this->session->userdata('currency') . " ") . $quotation_details->grand_total ; ?></p>

                            </div>
                        </div> 
                        <div class="col-md-3">

                        </div> 
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

                    <a href="<?php echo base_url() ?>Quotation/quotationDetails/<?php echo escape_output($encrypted_id); ?>/print"><button type="button" class="btn btn-primary"><?php echo lang('print'); ?></button></a>
                    <a href="<?php echo base_url() ?>Quotation/addEditQuotation/<?php echo escape_output($encrypted_id); ?>"><button type="button" class="btn btn-primary"><?php echo lang('edit'); ?></button></a>
                    <a href="<?php echo base_url() ?>Quotation/quotations"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                </div>
                <?php echo form_close(); ?> 
            </div> 
        </div>
    </div> 
</section>
