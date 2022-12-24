<script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.js"></script>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div id="printableArea">
                    <?php
                    for($i=0;$i<sizeof($products);$i++):
                    for ($j=0;$j<$products[$i]['qty'];$j++):
                        ?>
                        <table class="txt-uh-52">
                            <tr>
                                <td class="txt-uh-53"> <span><?php echo escape_output($products[$i]['product_name'])?></span></td>
                            </tr>
                            <tr>
                                <td class="txt-uh-54"> <span><?php echo escape_output($products[$i]['code'])?></span></td>
                            </tr>
                            <tr>
                                <td> <img class="txt-uh-55" id="barcode<?php echo escape_output($products[$i]['id'])?><?php echo escape_output($j)?>"/></td>
                            </tr>
                            <tr>
                                <td class="txt-uh-56"><span><?php echo escape_output($this->session->userdata('currency')); ?><?php echo escape_output($products[$i]['sale_price'])?></span></td>
                            </tr>
                        </table>
                    <?php
                    endfor;
                    ?>
                    <?php for ($j=0;$j<$products[$i]['qty'];$j++):
                    ?>
                        <script>JsBarcode("#barcode<?php echo escape_output($products[$i]['id'])?><?php echo escape_output($j)?>", "<?php echo escape_output($products[$i]['code'])?>", {  width: 1,
                                height: 30,
                                fontSize:12,
                                textMargin:-18,
                                margin:0,
                                marginTop:0,
                                marginLeft:10,
                                marginRight:10,
                                marginBottom:0,
                                displayValue: false
                            });
                        </script>
                        <?php
                    endfor;
                    endfor;
                    ?>
                </div>
                <br><br><br><br><br><br><br><br><br>
                <div class="clearfix"></div>
                <div class="col-md-2">
                    <div class="form-group">
                        <a href="<?php echo base_url() ?>Item/productBarcodeGenerator"><button type="button" class="btn btn-block btn-primary pull-right"><?php echo lang('back'); ?></button></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <a onclick="printDiv('printableArea')" class="btn btn-block btn-primary pull-left"><?php echo lang('Print'); ?></a>
                    </div>
                </div>
                <br><br>

            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>assets/js/barcode_print.js"></script>