<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo lang('SalaryFor')?>: <?php echo escape_output($getSelectedRow->month); ?> - <?php echo escape_output($getSelectedRow->year); ?></title>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
    <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/salary_print.css" type="text/css" />
</head>
<body>
<div id="wrapper">
    <div id="receiptData">
        <div id="receipt-data">
            <div id="receipt-data">
                <div class="logo_header">
                    <table class="width_100_p">
                        <tr>
                            <td>
                                <h1 class="s_p_1"><?php echo escape_output($this->session->userdata('outlet_name')); ?></h1>
                                <h4 class="s_p_2"><?php echo escape_output($this->session->userdata('address')); ?></h4>
                                <h3 class="s_p_3"><?php echo escape_output($this->session->userdata('phone')); ?></h3>
                                <p class="inv_black"><?php echo lang('SalaryFor')?>: <?php echo escape_output($getSelectedRow->month); ?> - <?php echo escape_output($getSelectedRow->year); ?></p>
                            </td>
                        </tr>
                    </table>
<br>
                    <table class="tbl width_100_p">
                        <tr class="s_p_4 p_txt_7">
                            <td  class="s_p_4 p_txt_8">#</td>
                            <td  class="s_p_4 p_txt_9"><?php echo lang('name'); ?></td>
                            <td  class="s_p_4 p_txt_11"><?php echo lang('salary'); ?></td>
                            <td  class="s_p_4 p_txt_11"><?php echo lang('additional'); ?></td>
                            <td  class="s_p_4 p_txt_11"><?php echo lang('subtraction'); ?></td>
                            <td  class="s_p_4 p_txt_11"><?php echo lang('total'); ?></td>
                            <td class="s_p_4"><?php echo lang('note'); ?></td>
                        </tr>
                        <?php
                        $getData = json_decode($getSelectedRow->details_info);
                        $total = 0;
                        $i = 1;
                        foreach ($getData as $usrs) {
                            if($usrs->p_status==1):
                            $total+=$usrs->total;
                            ?>
                            <tr class="row_counter" data-id="<?php echo escape_output($usrs->user_id); ?>">
                                <td class="c_center">
                                    <?php echo escape_output($i++); ?>
                                </td>
                                <td><?php echo escape_output($usrs->name); ?> </td>
                                <td  class="c_txt_right"><?php echo isset($usrs->salary) && $usrs->salary?$usrs->salary:'0.00'?></td>
                                <td  class="c_txt_right"><?php echo isset($usrs->additional) && $usrs->additional?$usrs->additional:'0.00'?></td>
                                <td  class="c_txt_right"><?php echo isset($usrs->subtraction) && $usrs->subtraction?$usrs->subtraction:'0.00'?></td>
                                <td  class="c_txt_right"><?php echo isset($usrs->total) && $usrs->total?$usrs->total:'0.00'?></td>
                                <td><?php echo isset($usrs->notes) && $usrs->notes?$usrs->notes:''?></td>
                            </tr>
                        <?php
                        endif;
                        }
                        ?>
                    </table>
                    <br>

                </div>

            </div>
        </div>
        <div  class="clear_both"></div>
    </div>
    <footer>
        <div  class="p_txt_12">
            <div class="p_txt_13">

            </div>
            <div class="p_txt_13">
                <p>&nbsp;</p>
            </div>
            <div class="p_txt_13">
                <p>&nbsp;</p>
            </div>
            <div class="p_txt_15">
                <p class="p_txt_14"><?php echo lang('authorized_signature'); ?></p>
            </div>
    </footer>
    <div class="p_txt_16 no_print">
        <hr>
        <span class="pull-right col-xs-12">
        <button onclick="window.print();" class="btn btn-block btn-primary"><?php echo lang('print'); ?></button> </span>
        <div  class="clear_both"></div>
        <div class="p_txt_17">
            <div class="p_txt_18">
                Please follow these steps before you print for first tiem:
            </div>
            <p class="p_txt_19">
                1. Disable Header and Footer in browser's print setting<br>
                For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Make all --blank--<br>
                For Chrome: Menu &gt; Print &gt; Uncheck Header/Footer in More Options
            </p>
            <p class="p_txt_19">
                2. Set margin 0.5<br>
                For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Margins (inches) &gt; set all margins 0.5<br>
                For Chrome: Menu &gt; Print &gt; Set Margins to Default
            </p>
        </div>
        <div  class="clear_both"></div>
    </div>
<script src="<?php echo base_url(); ?>assets/dist/js/print/jquery-2.0.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/print/custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/onload_print.js"></script>
</body>
</html>
