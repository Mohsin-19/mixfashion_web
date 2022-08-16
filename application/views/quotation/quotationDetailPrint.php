<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/quotation_print.css">
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
                        <table class="tb width_100_p">
                            <tr>
                                <td>  <h3>
                                        <?php echo escape_output($this->session->userdata('outlet_name')); ?>

                                    </h3>
                                    <?php echo escape_output($this->session->userdata('address')); ?>
                                    <br>
                                    Tel: <?php echo escape_output($this->session->userdata('phone')); ?>
                                </td>
                            </tr>
                        </table>
                        <h3 class="c_center"><?php echo lang('quotation'); ?></h3>
                        <div  class="p_txt_12">
                            <div class="p_txt_13">
                                <p class="txt-uh-69">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo lang('date'); ?> : <?php echo date($this->session->userdata('date_format'), strtotime($quotation_details->date)); ?></p>
                            </div>
                            <div class="p_txt_13">
                                <p>&nbsp;</p>
                            </div>
                            <div class="p_txt_13">
                                <p>&nbsp;</p>
                            </div>
                            <p class="p_txt_15">
                                <p class="txt-uh-70"><?php echo lang('ref_no'); ?>: <?php echo escape_output($quotation_details->reference_no); ?></p>
                            </div>

                            <?php
                            $customer = getCustomer($quotation_details->customer_id);
                            ?>
                            <?php echo lang('customer'); ?>: <?php echo escape_output($customer->name); ?> <?php echo lang('phone'); ?>: <?php echo escape_output($customer->phone); ?> <?php echo lang('address'); ?>: <?php echo escape_output($customer->address); ?>
                        </div>
<p><br>&nbsp;</p>
<div class="clearfix"></div>
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
                                            <th width="20%"><?php echo lang('total'); ?> <?php echo lang('price'); ?></th>
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
                                                    '<td class="width_20_p"><span class="txt-uh-62">' . $pi->name . ' (' . $pi->code. ')</span></td>' .
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
                        <table class="width_100_p">
                            <tr>
                                <td class="txt-uh-68">
                                    <h3><?php echo lang('Remark'); ?></h3>
                                    <p class=""><?php echo escape_output($quotation_details->note) ?></p>
                                </td>
                                <td class="width_20_p">

                                    <h3><?php echo lang('sub_total'); ?></h3>
                                    <p class=""><?php echo escape_output($this->session->userdata('currency') . " ") . $quotation_details->subtotal ?></p>

                                    <h3><?php echo lang('discount'); ?></h3>
                                    <p class=""><?php echo escape_output($this->session->userdata('currency') . " ") .(isset($quotation_details->discount) && $quotation_details->discount?$quotation_details->discount:'0.00') ?></p>

                                    <h3><?php echo lang('other'); ?></h3>
                                    <p class=""><?php echo escape_output($this->session->userdata('currency') . " ") . $quotation_details->other ; ?></p>

                                    <h3><?php echo lang('g_total'); ?></h3>
                                    <p class=""><?php echo escape_output($this->session->userdata('currency') . " ") . $quotation_details->grand_total ; ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer no_print">
                        <a href="<?php echo base_url() ?>Quotation/quotations"><button type="button" class="btn btn-primary"><?php echo lang('back'); ?></button></a>
                    </div>
                </div>
    </div>
</section>

<script src="<?php echo base_url(); ?>assets/js/quotation_print.js"></script>